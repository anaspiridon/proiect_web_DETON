<html>
<link href="vizualizare_detinuti.css" type="text/css" rel="stylesheet">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>DETON</title>
</head>
<body>
<ul class="navigation">
    <li class="nav-item"><a href="meniu_admin.php">Acasa</a></li>
	  <li class="nav-item"><a href="vizualizare_detinuti.php">Lista detinuti</a></li>
    <li class="nav-item"><a href="#">Optiuni detinuti <span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="sterge_detinuti.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinut.php">Insereaza detinut </a></li>
        </ul>
    </li>
    <li class="nav-item"><a href="statistici.php">Statistici</a></li>
    <li class="nav-item"><a href="vizualizare_vizite.php">Lista Vizitelor</a></li>
     <li class="nav-item"><a href="login.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>



<div class="site-wrap" >
<h1> Lista Detinut</h1>
<?php
function get_imput ($ord='')
{
echo <<<END
  <form action="vizualizare_detinuti.php" method="post">
 <p> 
 Ordonare dupa:
    <select name="ord">
      <option value=1>nume</option>
      <option value=2>prenume</option>
      <option value=3>id_institutie</option>
      <option value=4>id_detinut</option>
    </select> 
  <button class="button">Submit</button>  
  </p>
  </form>
END;
}
?>

<?php
if(!isset($_POST['ord']))
{
  get_imput();
  $conn = oci_connect("Student","STUDENT", "localhost");
  $stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,ID_INSTITUTIE,VARSTA,START_PEDEAPSA FROM DETINUTI order by ID_DETINUT');
  oci_execute($stid);
  echo "<table DETINUTI>";
  echo  "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th><th>START_PEDEAPSA</th><th>VARSTA</th></tr>";

  ?>
  <?php
  while (($row = oci_fetch_assoc($stid)) != false) {
  ?>
       <tr><td> <?php echo $row['ID_DETINUT']; ?> </td> 
       <td> <?php  echo $row['NUME']; ?> </td>
       <td> <?php echo $row['PRENUME'] ; ?> </td>
       <td> <?php echo $row['NR_DOSAR'] ; ?> </td>     
       <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td>   
       <td> <?php echo $row['START_PEDEAPSA'] ; ?> </td>     
       <td> <?php echo $row['VARSTA'] ; ?> </td>          
  <?php } ?>

  <?php
  echo "</table>";

  oci_free_statement($stid);
  oci_close($conn);
}
else
{
  $conn = oci_connect("Student","STUDENT", "localhost");
  $type = $_POST['ord'];
  if($type==1)
    {$stid = oci_parse($conn, "SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,VARSTA,START_PEDEAPSA,ID_INSTITUTIE FROM DETINUTI order by NUME ");}
  elseif ($type==2)
    {$stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,VARSTA,START_PEDEAPSA,ID_INSTITUTIE FROM DETINUTI order by PRENUME');}
  elseif($type==4)
    {$stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,VARSTA,START_PEDEAPSA,ID_INSTITUTIE FROM DETINUTI order by ID_DETINUT');}
  elseif($type==3)
    {$stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,VARSTA,START_PEDEAPSA,ID_INSTITUTIE FROM DETINUTI order by ID_INSTITUTIE');}

  oci_execute($stid);
  get_imput();
  echo "<table DETINUTI>";
  echo  "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th><th>START_PEDEAPSA</th><th>VARSTA</th></tr>";
  ?>
  <?php
  while (($row = oci_fetch_assoc($stid)) != false) {
   ?>
       <tr><td> <?php echo $row['ID_DETINUT']; ?> </td> 
       <td> <?php  echo $row['NUME']; ?> </td>
       <td> <?php echo $row['PRENUME'] ; ?> </td>
       <td> <?php echo $row['NR_DOSAR'] ; ?> </td>     
       <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td>   
       <td> <?php echo $row['START_PEDEAPSA'] ; ?> </td>
       <td> <?php echo $row['VARSTA'] ; ?> </td>
  <?php } 

  echo "</table>";

  oci_free_statement($stid);
  oci_close($conn);
  }
?>  
</div>
</body>
</html>
