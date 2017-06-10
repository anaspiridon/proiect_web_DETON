<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC ">
<html>


<link href="StergereDupaInserare.css" type="text/css" rel="stylesheet">
<head>

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
<h1> Insereaza Vizita</h1>


<?php


 echo $_SESSION['id_programare'];


function get_imput( $numeMartor = '', $prenumeMartor= '', $stareSanatate= '',$stareSpirit = '', $rezumat= '',$obiecte= '')
{
    echo <<<END
  <form action="StergereDupaInserare.php" method="post">
 
  <div><p><label for="numeMartor">Nume martor:</label>
     <input type="text" name="numeMartor" value="$numeMartor" ></p><div>

	 
  <p><label for="prenumeMartor">Prenume martor:</label>
     <input type="text" name="prenumeMartor" value="$prenumeMartor"></p>

	 
  <p><label for="stareSanatate">Starea de sanatate:</label>
     <input type="text" name="stareSanatate" value="$stareSanatate"></p> 
  
  <p><label for="stareSpirit">Starea de spirit:</label>
     <input type="text" name="stareSpirit" value="$stareSpirit"></p> 
  
  <p><label for="rezumat">Rezumatul vizitei:</label>
     <input type="text" name="rezumat" value="$rezumat"></p> 
	
  <p><label for="obiecte">Obiecte aduse la vizita:</label>
     <input type="text" name="obiecte" value="$obiecte"></p> 	
	 
    <p><button class="button">Insereaza</button> 
    </p>
    <br />
    </div>
  </form>
  </p>
END;
}
   
	
	
          get_imput();

		  echo $_SESSION['id_programare'];
		  
		  $id_programare=$_SESSION['id_programare'];
		  
		  
		  if(isset($_REQUEST['numeMartor']))
		  {
		  if(empty($_REQUEST['numeMartor']) or empty($_REQUEST['prenumeMartor']) or empty($_REQUEST['stareSanatate']) or empty($_REQUEST['stareSpirit']) or empty($_REQUEST['rezumat']) or empty($_REQUEST['obiecte']))
		  { echo '<script language="javascript">';
				  echo 'alert("Pentru adaugarea unei vizite este necesara completarea tuturor spatilor")';
				  echo '</script>';}
		else{	  
		  
          $conn = oci_connect("Student", "STUDENT", "localhost");
		 
		 
		  $numeMartor = $_REQUEST['numeMartor'];
          $prenumeMartor = $_REQUEST['prenumeMartor'];
          
          $stareSanatate = $_REQUEST['stareSanatate'];
          $stareSpirit = $_REQUEST['stareSpirit'];
          $rezumat     = $_REQUEST['rezumat'];
		  $obiecte    = $_REQUEST['obiecte'];
          
  
          $sql2         = "SELECT count(*) from vizita";
          $stmt         = oci_parse($conn, $sql2);
          if (!$stmt) 
          {
            echo "An error occurred in parsing the sql string.\n";
            exit;
          }
      
          oci_execute($stmt);
          if (oci_fetch($stmt)) 
          {
           $id = ociresult($stmt, 1);
		   echo $id;
          }
          else 
           {
            echo "An error occurred in retrieving book id.\n";
            exit;
           }
      
          $id_vizita = $id + 1;
		  
		  $s_id_detinut="select id_detinut from programare_vizita_tip1 where id_programare1=$id_programare ";
		  $stmt1         = oci_parse($conn,  $s_id_detinut);
		  
		    if (!$stmt1) 
          {
            echo "eroare id_detinut";
            exit;
          }
      
          oci_execute($stmt1);
          if (oci_fetch($stmt1)) 
          {
           $id_detinut = ociresult($stmt1, 1);
		   echo  $id_detinut;
          }
          else 
           {
            echo "An error occurred in retrieving book id_detinut.\n";
            exit;
           }
		  
		  $s_id_vizitator="select id_vizitator from vizitatori v join programare_vizita_tip1 p on v.nume=p.nume where p.id_programare1=$id_programare";
		  
		  	  $stmt2         = oci_parse($conn,  $s_id_vizitator);
		  
		    if (!$stmt2) 
          {
            echo "eroare id_vizitator";
            exit;
          }
      
          oci_execute($stmt2);
          if (oci_fetch($stmt2)) 
          {
           $id_vizitator = ociresult($stmt2, 1);
		   echo $id_vizitator;
          }
          else 
           {
            echo "An error occurred in retrieving book id_vizitator.\n";
            exit;
           }
		  
		  $s_id_martor="select id_martor from martori where trim(nume) like '$numeMartor' and trim(prenume) like '$prenumeMartor' ";
		  
		  	  
		  	  $stmt3         = oci_parse($conn,  $s_id_martor);
		  
		    if (!$stmt3) 
          {
            echo "eroare id_martor";
            exit;
          }
      
          oci_execute($stmt3);
          if (oci_fetch($stmt3)) 
          {
           $id_martor = ociresult($stmt3, 1);
		   echo  $id_martor;
          }
          else 
           {
            echo "An error occurred in retrieving book id_martor.\n";
            exit;
           }
		  
		  $s_id_institutie="select id_institutie from detinuti d join programare_vizita_tip1 p on d.id_detinut=p.id_detinut where p.id_programare1=$id_programare ";
		  	  
		  	  
		  	  $stmt4 = oci_parse($conn,  $s_id_institutie);
		  
		    if (!$stmt4) 
          {
            echo "eroare id_institutie";
            exit;
          }
      
          oci_execute($stmt4);
          if (oci_fetch($stmt4)) 
          {
           $id_institutie = ociresult($stmt4, 1);
		   echo   $id_institutie;
          }
          else 
           {
            echo "An error occurred in retrieving book id_institutie.\n";
            exit;
           }
		  
		  $s_id_relatie="select id_relatie from vizitatori v join programare_vizita_tip1 p on v.nume=p.nume where p.id_programare1=$id_programare";
		  
		   
		  	  $stmt5 = oci_parse($conn,  $s_id_relatie);
		  
		    if (!$stmt5) 
          {
            echo "eroare id_institutie";
            exit;
          }
      
          oci_execute($stmt5);
          if (oci_fetch($stmt5)) 
          {
           $id_relatie = ociresult($stmt5, 1);
		   echo   $id_relatie;
          }
          else 
           {
            echo "An error occurred in retrieving book id_relatie.\n";
            exit;
           }

          $sql        = " INSERT INTO vizita ( id_vizita , 
                        id_detinut ,
                        id_vizitator ,
                        id_programare,
                        id_martor ,
                        id_institutie,
                        id_relatie,
                        stare_sanatate, 
                        stare_spirit,
                        rezumat,
                        obiecte)  VALUES (:bind1, :bind2, :bind11, :bind3, :bind4, :bind5, :bind6, :bind7,:bind8, :bind9, :bind10 )";
						
          $sql2       = oci_parse($conn, $sql);
          if(!$sql2)
          {
              echo "something wrong";
          }

          oci_bind_by_name($sql2, ":bind1", $id_vizita);
          oci_bind_by_name($sql2, ":bind2", $id_detinut);
		  oci_bind_by_name($sql2, ":bind11", $id_vizitator);
		  
          oci_bind_by_name($sql2, ":bind3", $id_programare);
          oci_bind_by_name($sql2, ":bind4", $id_martor);
          oci_bind_by_name($sql2, ":bind5", $id_institutie);
          oci_bind_by_name($sql2, ":bind6", $id_relatie);
          oci_bind_by_name($sql2, ":bind7", $stareSanatate);
		  oci_bind_by_name($sql2, ":bind8", $stareSpirit);
		  oci_bind_by_name($sql2, ":bind9", $rezumat);
		  oci_bind_by_name($sql2, ":bind10", $obiecte);


		  

oci_execute($sql2, OCI_DEFAULT);
//echo oci_num_rows($sql2) . " rows deletd<br />\n";

$sql_delete= "delete from programare_vizita_tip1 where id_programare1=:id_programare";

 $sql_d       = oci_parse($conn, $sql_delete);
          if(!$sql_d)
          {
              echo "something wrong";
          }
  oci_bind_by_name($sql_d, ":id_programare", $id_programare);
  
 oci_execute($sql_d);

 

oci_commit($conn);
oci_free_statement($sql2);

 header('Location: http://localhost/site/proiect_web_DETON/StergereInserareSec.php');

}

}
		  

?>



</div>
</body>
</html>
