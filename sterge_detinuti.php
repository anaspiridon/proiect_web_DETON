<!DOCTYPE HTML PUBLIC>
<html>
<link href="sterge_detinuti.css" type="text/css" rel="stylesheet">
<head>
  <title>DETON</title>
</head>
<body bgcolor="#EEEEEE">

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
 <h1> Sterge detinuti <h1>  

 
<?php
function get_imput ($nume='', $idDetinut='')
{
echo <<<END
  <form action="sterge_detinuti.php" method="post">
  <label for="nume" >Nume detinut:</label>
	  <input type="text" name="nume" placeholder="Numele..." value="$nume">
  <label for="id" >ID detinut:</label>
	  <input type="text" name="id" placeholder="ID-ul..." value="$idDetinut">
  <button class="button">Sterge</button>
  </form>
  <br><br>
END;

}
if(!isset($_REQUEST['nume']) or !isset($_REQUEST['idDetinut']))
{	?>
	<h3>Introduceti numele si id-ul detinutului pe care doriti sa il stergeti!</h3>
	
	<?php get_imput();
	$conn = oci_connect("Student","STUDENT", "localhost");
 

	$stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,ID_INSTITUTIE FROM DETINUTI order by ID_DETINUT');


	oci_execute($stid);
	echo "<table DETINUTI>";
	echo "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th></tr>";

	 ?>
 	<?php
	while (($row = oci_fetch_assoc($stid)) != false) {
	?>
       <tr><td> <?php echo $row['ID_DETINUT']; ?> </td> 
       <td> <?php  echo $row['NUME']; ?> </td>
       <td> <?php echo $row['PRENUME'] ; ?> </td>
       <td> <?php echo $row['NR_DOSAR'] ; ?> </td>     
       <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td>   
	<?php } ?>

	<?php
	echo "</table>";

	oci_free_statement($stid);
	oci_close($conn);

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

$stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,ID_INSTITUTIE FROM DETINUTI order by ID_DETINUT');
oci_execute($stid);

echo "<table DETINUTI>";
echo "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th></tr>";

?>
<?php
while (($row = oci_fetch_assoc($stid)) != false) {
	?>
       <tr><td> <?php echo $row['ID_DETINUT']; ?> </td> 
       <td> <?php  echo $row['NUME']; ?> </td>
       <td> <?php echo $row['PRENUME'] ; ?> </td>
       <td> <?php echo $row['NR_DOSAR'] ; ?> </td>     
       <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td>   
<?php } ?>

<?php
echo "</table>";

oci_free_statement($stid);
oci_close($conn);
}

?>
</div>
</body>
</html>