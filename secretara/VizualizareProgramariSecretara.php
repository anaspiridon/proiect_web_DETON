<?php
$conDB = oci_connect("Student","STUDENT", "localhost");
if (!$conDB) {
 $m = oci_error();
 echo $m['message'], "\n";
 exit;
}


// Pagination Function
function pagination($query,$per_page=10,$page=1,$url='?'){   
    global $conDB; 
    $query = 'SELECT COUNT(*) as "num" FROM programare_vizita_tip1';
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

<html>
<link href="vizualizare_vizite.css" type="text/css" rel="stylesheet">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>DETON</title>
</head>
<body bgcolor="#EEEEEE">

<ul class="navigation">
    <li class="nav-item"><a href="StergereInserareSec.php">Acasa</a></li>
	 
    <li class="nav-item"><a href="#">Vizualizari<span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="VizualizareProgramariSecretara.php">Lista programari</a></li>
            <li> <a href="lista_vizitelor.php">Lista vizitelor </a></li>
        </ul>
    </li>
    <li class="nav-item"><a href="CautareVizitaSec.php">Verifcare programare</a></li>
   <li class="nav-item"><a href="CautareVizitaSec6.php">Cautare vizita</a></li>
     <li class="nav-item"><a href="index.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>


<div class="site-wrap" >
<h1> Lista Programarilor</h1>

<?php


function get_imput ($ord='')
{
echo <<<END
  <form action="VizualizareProgramariSecretara.php" method="post">
  
   
  
 <p> 
  <label >Vizualizeaza in functie de:</label>
    <select name="ord">
      <option value=1>numele vizitatorului</option>
      <option value=2>prenume vizitatorului</option>
      <option value=3>numele detinutului</option>
       <option value=4>data_programarii</option>
    </select> 
  <button class="button">Vizualizeaza</button>  
  </p>
  </form>
END;
}
?>



<?php

	
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if ($page <= 0) $page = 1;
 
$per_page = 10; // Set how many records do you want to display per page.
   $startpoint = ($page * $per_page) - $per_page;
   $endpoint =   $startpoint + $per_page;
   
   
	  $statement = 'select p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by p.id_programare1'; 


  $results = oci_parse($conDB,
  'SELECT * FROM (select rownum as rn, p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut ) where rn>=:startpoint and rn<=:endpoint');
  //$startpoint = (($page -1)* $per_page) + $page;
  oci_bind_by_name($results, ':startpoint', $startpoint);
  oci_bind_by_name($results, ':endpoint', $endpoint);
  oci_execute($results);
  
  if(!isset($_POST['ord']))
{
    get_imput();
  echo "<table PROGRAMARE>";
   echo  "<tr><th>ID_PROGRAMARE</th><th>DETINUT</th><th>NUME VIZITATOR</th><th>PRENUME VIZITATOR</th><th>EMAIL VIZITATOR</th><th>DATA_PROGRAMARII</th><th>ORA_PROGRAMARII</th></tr>";

  ?>
  <?php
   if (!$results) {
    $e = oci_error($conDB);  // For oci_parse errors pass the connection handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

     while ($row = oci_fetch_array($results)) {
   ?>
        <tr><td> <?php echo $row['ID_PROGRAMARE']; ?> </td> 
	  <td> <?php  echo $row['N_DETINUT'].' '.$row['P_DETINUT']; ?> </td>
       <td> <?php echo $row['N_VIZITATOR']; ?> </td>
	   <td> <?php echo $row['P_VIZITATOR'] ; ?> </td>
       <td> <?php echo $row['EMAIL'] ; ?> </td>  	   
       <td> <?php echo $row['DATA_PROGRAMARII'] ; ?> </td>   
       <td> <?php echo $row['ORA'] ; ?> </td>
  <?php } 

  echo "</table>";

  
  echo pagination($statement,$per_page,$page,$url='?');
  
  }
  else
{
  $conn = oci_connect("Student","STUDENT", "localhost");
  $type = $_POST['ord'];
  if($type==1)
    {$stid = oci_parse($conn, 'SELECT * FROM (select rownum as rn, p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by p.nume) where rn>=:startpoint and rn<=:endpoint');

$statement = 'select p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by p.id_programare1'; 

	oci_bind_by_name($stid, ':startpoint', $startpoint);
	oci_bind_by_name($stid, ':endpoint', $endpoint);
	oci_execute($stid);
}

  elseif ($type==2)
    {$stid = oci_parse($conn, 'SELECT * FROM (select rownum as rn, p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by p.prenume) where rn>=:startpoint and rn<=:endpoint');
	
	$statement = 'select p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by p.prenume'; 
	
	oci_bind_by_name($stid, ':startpoint', $startpoint);
	oci_bind_by_name($stid, ':endpoint', $endpoint);
	oci_execute($stid);
	}
  elseif($type==3)
    {$stid = oci_parse($conn, 'SELECT * FROM (select rownum as rn, p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by d.nume) where rn>=:startpoint and rn<=:endpoint');
	
	$statement = 'select p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by d.nume'; 
	
	oci_bind_by_name($stid, ':startpoint', $startpoint);
	oci_bind_by_name($stid, ':endpoint', $endpoint);
	oci_execute($stid);
	}
   elseif($type==4)
    {$stid = oci_parse($conn, 'SELECT * FROM (select rownum as rn, p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by p.data_programarii ) where rn>=:startpoint and rn<=:endpoint');
	
	$statement = 'select p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut order by  p.data_programarii'; 
	
	oci_bind_by_name($stid, ':startpoint', $startpoint);
	oci_bind_by_name($stid, ':endpoint', $endpoint);
	oci_execute($stid);
	}

 

  
  
   get_imput();
  echo "<table PROGRAMARE>";
   echo  "<tr><th>ID_PROGRAMARE</th><th>DETINUT</th><th>NUME VIZITATOR</th><th>PRENUME VIZITATOR</th><th>EMAIL VIZITATOR</th><th>DATA_PROGRAMARII</th><th>ORA_PROGRAMARII</th></tr>";

  ?>
  <?php
   if (!$stid) {
    $e = oci_error($conDB);  // For oci_parse errors pass the connection handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

     while ($row = oci_fetch_array($stid)) {
   ?>
         <tr><td> <?php echo $row['ID_PROGRAMARE']; ?> </td> 
	  <td> <?php  echo $row['N_DETINUT'].' '.$row['P_DETINUT']; ?> </td>
       <td> <?php echo $row['N_VIZITATOR']; ?> </td>
	   <td> <?php echo $row['P_VIZITATOR'] ; ?> </td>
       <td> <?php echo $row['EMAIL'] ; ?> </td>  	   
       <td> <?php echo $row['DATA_PROGRAMARII'] ; ?> </td>   
       <td> <?php echo $row['ORA'] ; ?> </td>
  <?php } 

  echo "</table>";

  
  echo pagination($statement,$per_page,$page,$url='?');

  }
  
?> 
 

</div>



</body>
</html>
