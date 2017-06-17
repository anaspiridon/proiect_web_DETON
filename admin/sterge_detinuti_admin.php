
<!DOCTYPE HTML PUBLIC ">
<html>
<link href="meniu_admin.css" type="text/css" rel="stylesheet">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>DETON</title>
</head>
<body bgcolor="#EEEEEE">

<ul class="navigation">
    <li class="nav-item"><a href="meniu_admin.php">Acasa</a></li>
    <li class="nav-item"><a href="vizualizare_detinuti.php">Lista detinuti</a></li>
    <li class="nav-item"><a href="#">Optiuni detinuti <span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="sterge_detinuti_admin.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinuti_admin.php">Insereaza detinut </a></li>
        </ul>
    </li>
    <li class="nav-item"><a href="vizualizare_vizite.php">Lista Vizitelor</a></li>
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
  echo "<p>Introduceti numele si id-ul detinutului pe care doriti sa il stergeti!<p>";
  get_imput();
  $conn = oci_connect("Student","STUDENT", "localhost");
  $id_inst=$_SESSION['id_institutie'];
  $stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,START_PEDEAPSA,ID_INSTITUTIE FROM DETINUTI where id_institutie= :bind1 order by ID_DETINUT');
    oci_bind_by_name($stid,'bind1',$id_inst);
    oci_execute($stid);

    echo "<table DETINUTI>";
    echo  "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th><th>START_PEDEAPSA</th></tr>";
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

    <?php } ?>

    <?php
    echo "</table>";
}
 </div>
</body>
</html>
