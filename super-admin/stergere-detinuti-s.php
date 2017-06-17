<?php
$conDB = oci_connect("Student","STUDENT", "localhost");
if (!$conDB) {
 $m = oci_error();
 echo $m['message'], "\n";
 exit;
}


// Pagination Function
function pagination($query,$per_page=15,$page=1,$url='?'){   
    global $conDB; 
    $query = 'SELECT COUNT(*) as "num" FROM detinuti';
  $result=oci_parse($conDB,$query);
    oci_execute($result);
    $row = oci_fetch_assoc($result);
    $total = $row['num'];
    $adjacents = "2"; 
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);
      
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination'>";
        $pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
              
            if ($page > 1) $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
            if ($page < $counter - 1) {
                $pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";        
    }
      
    return $pagination;
}

?>


<!DOCTYPE HTML PUBLIC ">
<html>
<link href="meniu_admin.css" type="text/css" rel="stylesheet">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>DETON</title>
</head>
<body bgcolor="#EEEEEE">

<ul class="navigation">
    <li class="nav-item"><a href="meniu_superadmin.php">Acasa</a></li>
	  <li class="nav-item"><a href="vizualizare_detinuti.php">Lista detinuti</a></li>
    <li class="nav-item"><a href="#">Optiuni detinuti <span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="sterge_detinuti.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinut.php">Insereaza detinut </a></li>
        </ul>
    </li>
    <li class="nav-item"><a href="insereaza_institutie.php">Statistici</a></li>

    <li class="nav-item"><a href="vizualizare-poze.php">Vizualizare poze</a></li>
     <li class="nav-item"><a href="login.php">Log out</a></li>
</ul>


<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>


<div class="site-wrap" >
<h1>Sterge Detinut</h1>
<?php
session_start();
function get_imput ($nume='', $idDetinut='')
{
echo <<<END
  <div>

  <form action="sterge_detinuti.php" method="post">
  
  <label for="nume">Nume detinut:</label>
  <input type="text" name="nume" value="$nume">
  <label for="idDetinut">ID Detinut:</label>
  <input type="text" name="idDetinut" value="$idDetinut">
  <button class="button">Submit</button> 
  
  </form>
  </div>
END;
}
if(!isset($_REQUEST['nume']) and !isset($_REQUEST['idDetinut']))
{
    if($_SESSION['tip']=="superadmin")
  {

    $page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
    if ($page <= 0) $page = 1;
 
    $per_page = 10; // Set how many records do you want to display per page.
    $startpoint = ($page * $per_page) - $per_page;
    $endpoint =   $startpoint + $per_page;
    $statement = 'select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.data_vizita as data_vizita from  vizita v join detinuti d  on v.id_detinut=d.id_detinut join
    martori m  on v.id_martor=m.id_martor join
    vizitatori vi on v.id_vizitator=vi.id_vizitator order by v.id_vizita'; 


    $results = oci_parse($conDB,
    " SELECT * FROM (select rownum as rn, d.id_detinut as id_detinut, d.nume, d.prenume, d.id_institutie, pedepse.nume as CONDAMNARE ,d.start_pedeapsa from detinuti d join pedepse  on d.id_pedeapsa=pedepse.id_pedeapsa order by d.nume asc  ) where rn>=:startpoint and rn<=:endpoint");
    //$startpoint = (($page -1)* $per_page) + $page;
    oci_bind_by_name($results, ':startpoint', $startpoint);
    oci_bind_by_name($results, ':endpoint', $endpoint);
    oci_execute($results, OCI_NO_AUTO_COMMIT);
  
    echo "<table VIZITA>";
    echo  "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>ID_INSTITUTIE</th><th>CONDAMNARE</th><th>START_PEDEAPSA</th></tr>";

    if (!$results) 
    {
      $e = oci_error($conDB);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }

     while ($row = oci_fetch_array($results)) { ?>    
     <tr><td> <?php echo $row['ID_DETINUT']; ?> </td> 
      <td> <?php  echo $row['NUME']; ?> </td>
      <td> <?php echo $row['PRENUME'] ; ?> </td>
      <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td>
      <td> <?php echo $row['CONDAMNARE'] ; ?> </td>     
      <td> <?php echo $row['START_PEDEAPSA'] ; ?> </td></tr>
     <?php } 
      echo "</table>";
    
    // displaying paginaiton.
        echo pagination($statement,$per_page,$page,$url='?');
  } 
}
elseif( isset($_REQUEST['nume']) and isset($_REQUEST['idDetinut']))
{
  get_imput();
  $conn = oci_connect("Student","STUDENT", "localhost");

  $id_detinut= $_REQUEST['idDetinut'];
  $nume=$_REQUEST['nume'];

  $sql ='DELETE FROM DETINUTI where ID_DETINUT = '.$id_detinut.' and trim(NUME) = \''.$nume.'\'';
  $sql2 =oci_parse($conn,$sql);
  oci_execute($sql2);
if($_SESSION['tip']=="superadmin")
  {

    $page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
    if ($page <= 0) $page = 1;
 
    $per_page = 15; // Set how many records do you want to display per page.
    $startpoint = ($page * $per_page) - $per_page;
    $endpoint =   $startpoint + $per_page;
    $statement = 'select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.data_vizita as data_vizita from  vizita v join detinuti d  on v.id_detinut=d.id_detinut join
    martori m  on v.id_martor=m.id_martor join
    vizitatori vi on v.id_vizitator=vi.id_vizitator order by v.id_vizita'; 


    $results = oci_parse($conDB,
    " SELECT * FROM (select rownum as rn, d.id_detinut, d.nume, d.prenume, d.id_institutie, pedepse.nume as CONDAMNARE ,d.start_pedeapsa from detinuti d join pedepse  on d.id_pedeapsa=pedepse.id_pedeapsa order by d.id_detinut ) where rn>=:startpoint and rn<=:endpoint");
    //$startpoint = (($page -1)* $per_page) + $page;
    oci_bind_by_name($results, ':startpoint', $startpoint);
    oci_bind_by_name($results, ':endpoint', $endpoint);
    oci_execute($results, OCI_NO_AUTO_COMMIT);
  
    echo "<table VIZITA>";
    echo  "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>ID_INSTITUTIE</th><th>CONDAMNARE</th><th>START_PEDEAPSA</th></tr>";

    if (!$results) 
    {
      $e = oci_error($conDB);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }

     while ($row = oci_fetch_array($results)) { ?>    
     <tr><td> <?php echo $row['ID_DETINUT']; ?> </td> 
      <td> <?php  echo $row['NUME']; ?> </td>
      <td> <?php echo $row['PRENUME'] ; ?> </td>
      <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td>
      <td> <?php echo $row['CONDAMNARE'] ; ?> </td>     
      <td> <?php echo $row['START_PEDEAPSA'] ; ?> </td></tr>
     <?php } 
      echo "</table>";
    
    // displaying paginaiton.
        echo pagination($statement,$per_page,$page,$url='?');
  }
oci_free_statement($stid);
oci_close($conn);
}

?>
</div>
</body>
</html>
