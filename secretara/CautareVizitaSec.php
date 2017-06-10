<!DOCTYPE HTML PUBLIC ">
<html>
<link href="program.css" type="text/css" rel="stylesheet">
<head>
<title>Deton</title>
</head>
<body>
<?php

session_start();
?>

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

<div class="site-wrap">
<h1><p>Cautare<br></p><br><br>
<p><h2> Introduceti numele si prenumele vizitatorului pentru a verifica daca are programare</h2></p><br><br><br><br></h2>
<?php 

function get_input($nume = "", $prenume="") 
{
  echo <<<END
  <form action="CautareVizitaSec.php" method="post">
<p>
    <label for="Nume">
    <span>Nume vizitator</span>
    <input type="text" name="nume" value="$nume">
  </label>
      <label for="Prenume">
    <span>Prenume vizitator</span>
    <input type="text" name="prenume" value="$prenume">
  </label>

  <button class="button">Cauta</button> 
  </p> <br><br>
</form>
END;

} 


if(!isset($_REQUEST['nume'])) {
   
   get_input();

}elseif (empty($_REQUEST['nume']) or empty($_REQUEST['prenume']) ) {
        echo '<script language="javascript">';
        echo 'alert("Nu ai introdus informatii in ambele campuri! Te rugam incerca din nou!")';
        echo '</script>';
        get_input();
}else {  
     $conn = oci_connect("Student", "STUDENT", "localhost");
        
        if (!$conn) {
            echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
            exit;
        }

  
    $nume= $_REQUEST['nume'];
    $prenume= $_REQUEST['prenume'];

      $sql  = " SELECT count(*) from vizita v join vizitatori vi on v.id_vizitator=vi.id_vizitator WHERE TRIM(vi.nume)=TRIM(:bind1)AND TRIM(vi.prenume)=TRIM(:bind2) ";

	  
      $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind1", $nume);
          oci_bind_by_name($stmt, ":bind2", $prenume);
		   // echo $stmt;
          if (!$stmt) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }
          oci_execute($stmt, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt)) 
          { $rezultat = ociresult($stmt,1);
       
            
          } 
           else 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred data!")';
            echo '</script>';
            exit;
          }
    ?>
    <p><?php echo 'S-au facut ';  echo $rezultat; echo ' vizite cu acest nume';?></p><?php
    if($rezultat>0)
    { 
        

       $sql1  = " select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.obiecte as obiecte from vizita v join detinuti d  on v.id_detinut=d.id_detinut join martori m  on v.id_martor=m.id_martor join vizitatori vi on v.id_vizitator=vi.id_vizitator WHERE TRIM(vi.nume)=TRIM(:bind1)AND TRIM(vi.prenume)=TRIM(:bind2) ";
      $stid= oci_parse($conn, $sql1);
      oci_bind_by_name($stid,":bind1", $nume);
      oci_bind_by_name($stid, ":bind2", $prenume);

   

  oci_execute($stid);

echo "<table VIZITA>";
   echo  "<tr><th>ID_VIZITA</th><th>DETINUT</th><th>MARTOR</th><th>VIZITATOR</th><th>STARE_SANATATE</th><th>STARE_SPIRIT</th><th>REZUMAT</th><th>OBIECTE</th></tr>";

  
  
  while (($row = oci_fetch_assoc($stid)) != false) 
    {	?>	  
	   <tr><td> <?php echo $row['ID_VIZITA']; ?> </td> 
	 <td> <?php  echo $row['N_DETINUT'].' '.$row['P_DETINUT']; ?> </td>
       <td> <?php echo $row['N_MARTOR'].' '.$row['P_MARTOR'] ; ?> </td>
	   <td> <?php echo $row['N_VIZITATOR'].' '.$row['P_VIZITATOR'] ; ?> </td>
       <td> <?php echo $row['STARE_SANATATE'] ; ?> </td>     
       <td> <?php echo $row['STARE_SPIRIT'] ; ?> </td>   
       <td> <?php echo $row['REZUMAT'] ; ?> </td>
	    <td> <?php echo $row['OBIECTE'] ; ?> </td>
     <?php } 

  echo "</table>";

  oci_free_statement($stid);
 ?> 
 <p><input class="button" value="Inpoi" onClick="window.location.href = 'http://localhost/site/proiect_web_DETON/CautareVizitaSec.php'"></p>
 <?php
  }else {
     
    echo '<script language="javascript">';
    echo 'alert("Nu exista nicio vizita pe acest nume!")';
    echo '</script>'; 
    get_input();
    }

 
    oci_close($conn);
}
?>

</div>
</body>
</html>
