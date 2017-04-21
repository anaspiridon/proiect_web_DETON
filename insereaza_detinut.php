<!DOCTYPE HTML >
<html>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<head>
<title>DETON</title>
</head>
<body >
<h2>Insereaza detinut</h2>
<?php
function get_imput ($nume='', $prenume='',$nrDosar='', $sPedeapsa='',$varsta='')
{
echo <<<END
  <form action="insereaza_detinut.php" method="post">
  Nume:
  <br>
   <input type="text" name="nume" value="$nume">
  <p> 
  Prenume:
  <br>
   <input type="text" name="prenume" value="$prenume">
  <p>
  Nr Dosar:
  <br>
   <input type="text" name="nrDosar" value="$nrDosar"> 

  <p>
  Start pedeapsa:
  <br>
   <input type="text"  name="sPedeapsa" value="$sPedeapsa">
   <br>
   Format DATE: DD-MM-YYYY
  
   <br>
  <p>
  Varsta:
  <br>
   <input type="number" min="18" max="100" name="varsta" value="$varsta">
  <p>
   ID institutie:
 <select name="type">
      <option value=1>1</option>
      <option value=2>2</option>
      <option value=3>3</option>
      <option value=4>4</option>
      <option value=5>5</option>
</select>
  <input type="submit">
  </form>
END;

}
if(!isset($_REQUEST['nume']) )
{ 
  echo "Introduceti datele noului detinut!";
  get_imput();
  $conn = oci_connect("Student","STUDENT", "localhost");
 

  $stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,ID_INSTITUTIE,VARSTA,START_PEDEAPSA FROM DETINUTI order by ID_DETINUT');


  oci_execute($stid);
  echo "<table DETINUTI>";
  echo "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th><th>START_PEDEAPSA</th><th>VARSTA</th></tr>";

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
elseif ( empty($_REQUEST['nume']) or empty($_REQUEST['prenume']) or empty($_REQUEST['nrDosar']) 
  or empty($_REQUEST['sPedeapsa']) or empty($_REQUEST['varsta']) )
{
  echo "Pentru adaugarea unui nou detinut este necesara completarea tuturor spatilor";
 get_imput();
}
 else{
get_imput();
$conn = oci_connect("Student","STUDENT", "localhost");


$nume=$_REQUEST['nume'];
$prenume=$_REQUEST['prenume'];
$nrDosar=$_REQUEST['nrDosar'];
$sPedeapsa=$_REQUEST['sPedeapsa'];
$varsta=$_REQUEST['varsta'];
$idInstitutie=$_POST['type'];

$sql2 = "SELECT * FROM (SELECT ID_detinut FROM detinuti  WHERE ROWNUM <= (select count(*) from detinuti ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2";

$stmt = oci_parse($conn, $sql2);

if(!$stmt)
{
   echo "An error occurred in parsing the sql string.\n";
  exit;
}
 
 oci_execute($stmt);

 if(oci_fetch($stmt))
 {
  $id=ociresult($stmt,1);
 }
 else
 {
    echo "An error occurred in retrieving book id.\n";
  exit;
 }

$id_detinut=$id+1;

$sql ="INSERT INTO detinuti (ID_DETINUT,NUME,PRENUME,NR_DOSAR,VARSTA,ID_INSTITUTIE,START_PEDEAPSA )
        VALUES (:bind7, :bind1, :bind2, :bind3, :bind4, :bind5, to_date(TRIM(:bind6), 'DD/MM/YYYY'))";
      

$sql2 =oci_parse($conn,$sql);

oci_bind_by_name($sql2, ":bind1", $nume);
    oci_bind_by_name($sql2, ":bind2", $prenume);
    oci_bind_by_name($sql2, ":bind3", $nrDosar);
    oci_bind_by_name($sql2, ":bind4", $varsta);
    oci_bind_by_name($sql2, ":bind5", $idInstitutie);
    oci_bind_by_name($sql2, ":bind6", $sPedeapsa);
    oci_bind_by_name($sql2, ":bind7", $id_detinut);

$r = oci_execute($sql2, OCI_NO_AUTO_COMMIT);

 if (!$r) {    
    $e = oci_error($sql2);
    oci_rollback($conn);  
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

if (!$r) {    
    $e = oci_error($result);
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$r = oci_commit($conn);
if (!$r) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}else
{
echo"Felicitari! Ati inserat cu succes! <br>
    <h3> Multumim! ";
}
$stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,VARSTA,START_PEDEAPSA,ID_INSTITUTIE FROM DETINUTI order by ID_DETINUT');
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

?>
</body>
</html>