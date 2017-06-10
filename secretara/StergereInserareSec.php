
<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC ">
<html>
<link href="meniu_secretara.css" type="text/css" rel="stylesheet">
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
 <h1> Detention Monitoring Tool </h1> 
 <br>
 <br>
 <h3>
 
 
 
 
<?php 



 $conn = oci_connect("Student","STUDENT", "localhost");
if (!$conn) {
  echo "An error occurred.\n";
  exit;
}
else{
$sql = "select count(*) from programare_vizita_tip1 where to_char(data_programarii,'MM') in (08)";

$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

if(oci_fetch($stmt))
    {
      $id=ociresult($stmt,1);
    }

}	

?>
	
 

 
 <div class="alert">
  <span class="closebtn"></span>  
  <strong>Remember!</strong> Astazi, ar trebui sa aiba loc <?php echo $id?> vizite.
 
  
  
  <?php

{
  $conn = oci_connect("Student","STUDENT", "localhost");
  $stid = oci_parse($conn, "select p.id_programare1 as id_programare, p.nume as n_vizitator, p.prenume as p_vizitator, d.nume as n_detinut, d.prenume as p_detinut, p.email as email, p.data_programarii, p.ora from programare_vizita_tip1 p join detinuti d  on p.id_detinut=d.id_detinut where to_char(data_programarii,'MM') in (08) order by p.id_programare1");
  oci_execute($stid);
  echo "<table PROGRAMARE>";
   echo  "<tr><th>ID_PROGRAMARE</th><th>DETINUT</th><th>NUME VIZITATOR</th><th>PRENUME VIZITATOR</th><th>EMAIL VIZITATOR</th><th>DATA_PROGRAMARII</th><th>ORA_PROGRAMARII</th></tr>";


  ?>
 <?php while (($row = oci_fetch_assoc($stid)) != false){ ?>

  <tr>
       <td> <?php echo $row['ID_PROGRAMARE']; ?> </td>
       <td> <?php  echo $row['N_DETINUT'].' '.$row['P_DETINUT']; ?> </td>
       <td> <?php echo $row['N_VIZITATOR']; ?> </td>
	   <td> <?php echo $row['P_VIZITATOR'] ; ?> </td>
       <td> <?php echo $row['EMAIL'] ; ?> </td>  	   
       <td> <?php echo $row['DATA_PROGRAMARII'] ; ?> </td>   
       <td> <?php echo $row['ORA'] ; ?> </td>
    <td>
      <form method="post" action="StergereInserareSec.php">
        
		<input type="submit" name="action" value="Insereaza"/>
        <input type="submit" name="action" value="Sterge"/>
        <input type="hidden" name="id_programare" value="<?php echo $row['ID_PROGRAMARE']; ?>"/>
		
      </form>
    </td>
  </tr>

 <?php }  ?>
  

  <?php
  echo "</table>";

  oci_free_statement($stid);
  oci_close($conn);
}


?>  
 

<?php 
 
  if (isset($_POST['action'])) {
	  if($_POST['action']== 'Sterge'){
	  $id_programare=$_POST['id_programare'];
	  echo  $id_programare;
	 
	$_SESSION['id_programare']=$id_programare;
	 
   $sql= "delete from programare_vizita_tip1 where id_programare1=:id_programare";
   
   $stmt = oci_parse($conn,  $sql);
	oci_bind_by_name($stmt, ":id_programare", $id_programare);	  
		    if (!$stmt) 
          {
            echo "eroare stergere";
            exit;
          }
      
          oci_execute($stmt);
     ?>
	 <strong>Confirmi stergerea programari? Apasa din nou butonul "Sterge" </strong>
	 <?php
	 
	  }elseif($_POST['action']== 'Insereaza')
	  {
		  
		   $id_programare=$_POST['id_programare'];
		   $_SESSION['id_programare']=$id_programare;
		   
		   $sqlD = "select nume||' '||prenume from programare_vizita_tip1 where id_programare1=$id_programare";

			$stmtD = oci_parse($conn, $sqlD);
			oci_execute($stmtD);

			if(oci_fetch($stmtD))
				{
				  $idD=ociresult($stmtD,1);
				}

				
				?>
		  <strong><?php echo $idD ?> a efectuat vizita? </strong><a button class="button" href="http://localhost/site/proiect_web_DETON/StergereDupaInserare.php">Completeaza detaliile vizitei</a>
		  <?php
				
				
			}
		   
	   
  
}

?>

</div>
 
 </h3>

</div>
</body>


<script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "http://localhost/site/proiect_web_DETON/inserareVizitaSec.php";
    };
</script>


<script>
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
    close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}
</script>
</html>