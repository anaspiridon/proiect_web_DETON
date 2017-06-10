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
<h1><p>Cautare vizita<br></p><br><br>
<p><h2> Alegeti criteriul de cautare si introduceti datele necesare</h2></p><br><br><br><br></h2>
<?php 

function get_input($nume = "", $prenume="") 
{
  echo <<<END
  <form action="CautareVizitaSec6.php" method="post">
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


function get_input2($data="", $ora="") 
{
  echo <<<END
  <form action="CautareVizitaSec6.php" method="post">
<p>
    <label for="Data vizitei">
	<span>Data vizitei</span>
    <input type="date" name="data" value="$data">
  </label>
  
<label for="Ora">
<span>Intervalul orar</span>
   <select name="type">

  <option value="1interv">Alegeti intervalul orar</option>
  <option value="10:00-10:45">10:00-10:45</option>
  <option value="10:45-11:30">10:45-11:30</option>
  <option value="11:30-12:15">11:30-12:15</option>
  <option value="12:15-13:00">12:15-13:00</option>
  <option value="13:00-13:45">13:00-13:45</option>
  <option value="13:45-14:30">13:45-14:30</option>
  <option value="14:30-15:15">14:30-15:15</option>
  <option value="15:15-16:00">15:15-16:00</option>
  </select>
  </label>
<br>
  <button class="button">Cauta</button> 
  </p> <br><br>
</form>
END;

} 


function get_input3($nume = "", $prenume="") 
{
  echo <<<END
  <form action="CautareVizitaSec6.php" method="post">
<p>
    <label for="Nume">
    <span>Nume detinut</span>
    <input type="text" name="numed" value="$nume">
  </label>
      <label for="Prenume">
    <span>Prenume detinut</span>
    <input type="text" name="prenumed" value="$prenume">
  </label>

  <button class="button">Cauta</button> 
  </p> <br><br>
</form>
END;

} 


function get_input4($nume = "", $prenume="", $idr="") 
{
  echo <<<END
  <form action="CautareVizitaSec6.php" method="post">
<p>
    <label for="Nume">
    <span>Nume detinut</span>
    <input type="text" name="numer" value="$nume">
  </label>
      <label for="Prenume">
    <span>Prenume detinut</span>
    <input type="text" name="prenumer" value="$prenume">
  </label>
<br>
  <label for="Id_relatie">
<span>Relatia cu detinutul</span>
   <select name="idr">

  <option value="1interv">Alegeti tipul relatiei</option>
  <option value="1">avocat</option>
  <option value="2">prieten</option>
  <option value="3">sot/sotie</option>
  <option value="4">mama/tata</option>
  <option value="5">frate/sora</option>
  <option value="6">ruda gradul 2</option>
  </select>
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
    <p><?php echo 'Aceasta persoana a facut ';  echo $rezultat; echo ' vizite!';?></p><?php
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
 <p><input class="button" value="Inpoi" onClick="window.location.href = 'http://localhost/site/proiect_web_DETON/CautareVizitaSec6.php'"></p>
 <?php
  }else {
     
    echo '<script language="javascript">';
    echo 'alert("Nu exista nicio vizita pe numele acestui vizitator!")';
    echo '</script>'; 
    get_input();
    }

 
    oci_close($conn);
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(!isset($_REQUEST['data'])) {
   
   get_input2();

}elseif (empty($_REQUEST['data']) ) {
        echo '<script language="javascript">';
        echo 'alert("Nu ai selectat data! Te rugam incerca din nou!")';
        echo '</script>';
        get_input2();
}else {  
     $conn = oci_connect("Student", "STUDENT", "localhost");
        
        if (!$conn) {
            echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
            exit;
        }
 
	 if(isset($_REQUEST['data'])and(!isset($_REQUEST['ora'])))
	 {
		 $data= $_REQUEST['data'];
			 echo $data;
			
	   $sql  = " SELECT count(*) from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1 WHERE to_char(p.data_programarii,'YYYY-MM-DD')= trim(:bind1) " ;
	   
					   
						  $stmt = oci_parse($conn, $sql);
						  oci_bind_by_name($stmt, ":bind1", $data);
						 
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
						<p><?php echo 'S-au facut ';  echo $rezultat; echo ' vizite la aceasta data';?></p><?php 
					if($rezultat>0)
					{ 
						

					   $sql1  = " select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.obiecte as obiecte, p.data_programarii as data_vizitei from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1 join detinuti d  on v.id_detinut=d.id_detinut join martori m  on v.id_martor=m.id_martor join vizitatori vi on v.id_vizitator=vi.id_vizitator WHERE  to_char(p.data_programarii,'YYYY-MM-DD')= trim(:bind1) ";
					  $stid= oci_parse($conn, $sql1);
					  oci_bind_by_name($stid,":bind1", $data);

				  oci_execute($stid);

				echo "<table VIZITA>";
		echo"<tr><th>ID_VIZITA</th><th>DETINUT</th><th>MARTOR</th><th>VIZITATOR</th><th>STARE_SANATATE</th><th>STARE_SPIRIT</th><th>REZUMAT</th><th>OBIECTE</th><th>DATA_VIZITEI</th></tr>";

				  
				  
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
						<td> <?php echo $row['DATA_VIZITEI'] ; ?> </td>
					 <?php } 

				  echo "</table>";

				  oci_free_statement($stid);
				 ?> 
				 <p><input class="button" value="Inpoi" onClick="window.location.href = 'http://localhost/site/proiect_web_DETON/CautareVizitaSec6.php'"></p>
				 <?php
				  }else {
					 
					echo '<script language="javascript">';
					echo 'alert("Nu exista nicio vizita la aceasta data")';
					echo '</script>'; 
					get_input2();
					}

				 
					oci_close($conn);
				}
					  
	   
	 
	 }
	 
	 if((isset($_REQUEST['data']))and(isset($_REQUEST['ora'])))
     {
		    $data= $_REQUEST['data'];
			$ora=$_REQUEST['ora'];
			 echo $data;
			 echo $ora;
	    $sql  = "  SELECT count(*) from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1 WHERE to_char(p.data_programarii,'YYYY-MM-DD')= trim(:bind1) and p.ora=trim(:bind2)  "; 
		
		
		$stmt = oci_parse($conn, $sql);
						  oci_bind_by_name($stmt, ":bind1", $data);
						  oci_bind_by_name($stmt, ":bind2", $ora);
						 
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
						<p><?php echo 'S-au facut ';  echo $rezultat; echo ' vizite la aceasta data';?></p><?php 
					if($rezultat>0)
					{ 
						

					   $sql1  = " select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.obiecte as obiecte, p.data_programarii as data_vizitei from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1 join detinuti d  on v.id_detinut=d.id_detinut join martori m  on v.id_martor=m.id_martor join vizitatori vi on v.id_vizitator=vi.id_vizitator WHERE  to_char(p.data_programarii,'YYYY-MM-DD')= trim(:bind1) and p.ora=trim(:bind2)";
					  $stid= oci_parse($conn, $sql1);
					  oci_bind_by_name($stid,":bind1", $data);
					  oci_bind_by_name($stid, ":bind2", $ora);

				  oci_execute($stid);

				echo "<table VIZITA>";
echo"<tr><th>ID_VIZITA</th><th>DETINUT</th><th>MARTOR</th><th>VIZITATOR</th><th>STARE_SANATATE</th><th>STARE_SPIRIT</th><th>REZUMAT</th><th>OBIECTE</th><th>DATA_VIZITEI</th><th>ORA_VIZITEI</th></tr>";     

				  
				  
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
						<td> <?php echo $row['DATA_VIZITEI'] ; ?> </td>
						<td> <?php echo $row['ORA_VIZITEI'] ; ?> </td>
					 <?php } 

				  echo "</table>";

				  oci_free_statement($stid);
				 ?> 
				 <p><input class="button" value="Inpoi" onClick="window.location.href = 'http://localhost/site/proiect_web_DETON/CautareVizitaSec6.php'"></p>
				 <?php
				  }else {
					 
					echo '<script language="javascript">';
					echo 'alert("Nu exista nicio vizita la aceasta data")';
					echo '</script>'; 
					get_input2();
					}

				 
					oci_close($conn);
				}
	 
	 
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	 if(!isset($_REQUEST['numed'])) {
   
   get_input3();

}elseif (empty($_REQUEST['numed']) or empty($_REQUEST['prenumed']) ) {
        echo '<script language="javascript">';
        echo 'alert("Nu ai introdus informatii in ambele campuri! Te rugam incerca din nou!")';
        echo '</script>';
        get_input3();
}else {  
     $conn = oci_connect("Student", "STUDENT", "localhost");
        
        if (!$conn) {
            echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
            exit;
        }

  
    $nume= $_REQUEST['numed'];
    $prenume= $_REQUEST['prenumed'];

      $sql  = " SELECT count(*) from vizita v join detinuti d on v.id_detinut=d.id_detinut WHERE TRIM(d.nume)=TRIM(:bind1)AND TRIM(d.prenume)=TRIM(:bind2) ";

	  
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
    <p><?php echo 'Acest detinut a avut ';  echo $rezultat; echo ' vizite!';?></p><?php
    if($rezultat>0)
    { 
        

       $sql1  = " select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.obiecte as obiecte from vizita v join detinuti d  on v.id_detinut=d.id_detinut join martori m  on v.id_martor=m.id_martor join vizitatori vi on v.id_vizitator=vi.id_vizitator WHERE TRIM(d.nume)=TRIM(:bind1)AND TRIM(d.prenume)=TRIM(:bind2) ";
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
 <p><input class="button" value="Inpoi" onClick="window.location.href = 'http://localhost/site/proiect_web_DETON/CautareVizitaSec6.php'"></p>
 <?php
  }else {
     
    echo '<script language="javascript">';
    echo 'alert("Nu exista nicio vizita pe numele acestui detinut!")';
    echo '</script>'; 
    get_input3();
    }

 
    oci_close($conn);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
	  
	
	 if(!isset($_REQUEST['numer'])) {
   
   get_input4();

}elseif (empty($_REQUEST['numer']) or empty($_REQUEST['prenumer']) or empty($_REQUEST['idr'])) {
        echo '<script language="javascript">';
        echo 'alert("Nu ai introdus informatii in toate campurile! Te rugam incerca din nou!")';
        echo '</script>';
        get_input4();
}else {  
     $conn = oci_connect("Student", "STUDENT", "localhost");
        
        if (!$conn) {
            echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
            exit;
        }

  
    $nume= $_REQUEST['numer'];
    $prenume= $_REQUEST['prenumer'];
	$idr=$_REQUEST['idr'];

      $sql  = " SELECT count(*) from vizita v join vizitatori vi on v.id_vizitator=vi.id_vizitator join detinuti d on d.id_detinut=v.id_detinut WHERE TRIM(d.nume)=TRIM(:bind1)AND TRIM(d.prenume)=TRIM(:bind2) and v.id_relatie=TRIM(:bind3) ";

	  
      $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind1", $nume);
          oci_bind_by_name($stmt, ":bind2", $prenume);
		  oci_bind_by_name($stmt, ":bind3", $idr);
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
    <p><?php echo 'Acest detinut a avut ';  echo $rezultat; echo ' vizite!';?></p><?php
    if($rezultat>0)
    { 
        

       $sql1  = " select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.obiecte as obiecte, r.tip_relatie as relatie, r.natura_vizita as natura_vizitei from vizita v join detinuti d  on v.id_detinut=d.id_detinut join martori m  on v.id_martor=m.id_martor join vizitatori vi on v.id_vizitator=vi.id_vizitator join relatie r on vi.id_relatie=r.id_relatie WHERE TRIM(d.nume)=TRIM(:bind1)AND TRIM(d.prenume)=TRIM(:bind2) and v.id_relatie=TRIM(:bind3)";
      $stid= oci_parse($conn, $sql1);
      oci_bind_by_name($stid,":bind1", $nume);
      oci_bind_by_name($stid, ":bind2", $prenume);
	  oci_bind_by_name($stid, ":bind3", $idr);

   

  oci_execute($stid);

echo "<table VIZITA>";
   echo  "<tr><th>ID_VIZITA</th><th>DETINUT</th><th>MARTOR</th><th>VIZITATOR</th><th>RELATIE</th><th>NATURA_VIZITEI</th><th>STARE_SANATATE</th><th>STARE_SPIRIT</th><th>REZUMAT</th><th>OBIECTE</th></tr>";

  
  
  while (($row = oci_fetch_assoc($stid)) != false) 
    {	?>	  
	   <tr><td> <?php echo $row['ID_VIZITA']; ?> </td> 
	 <td> <?php  echo $row['N_DETINUT'].' '.$row['P_DETINUT']; ?> </td>
       <td> <?php echo $row['N_MARTOR'].' '.$row['P_MARTOR'] ; ?> </td>
	   <td> <?php echo $row['N_VIZITATOR'].' '.$row['P_VIZITATOR'] ; ?> </td>
	   <td> <?php echo $row['RELATIE'] ; ?> </td> 
	   <td> <?php echo $row['NATURA_VIZITEI'] ; ?> </td> 
       <td> <?php echo $row['STARE_SANATATE'] ; ?> </td>     
       <td> <?php echo $row['STARE_SPIRIT'] ; ?> </td>   
       <td> <?php echo $row['REZUMAT'] ; ?> </td>
	    <td> <?php echo $row['OBIECTE'] ; ?> </td>
     <?php } 

  echo "</table>";

  oci_free_statement($stid);
 ?> 
 <p><input class="button" value="Inpoi" onClick="window.location.href = 'http://localhost/site/proiect_web_DETON/CautareVizitaSec6.php'"></p>
 <?php
  }else {
     
    echo '<script language="javascript">';
    echo 'alert("Nu exista nicio vizita pe numele acestui detinut!")';
    echo '</script>'; 
    get_input4();
    }

 
    oci_close($conn);
}

	  


?>

</div>
</body>
</html>