<!DOCTYPE HTML PUBLIC ">
<html>
<link href="insereaza_detinut.css" type="text/css" rel="stylesheet">
<head>

  <title>DETON</title>
</head>
<body bgcolor="#EEEEEE">

<ul class="navigation">
    <li class="nav-item"><a href="meniu_admin.php">Acasa</a></li>
    <li class="nav-item"><a href="optiuni_detinut.php">Optiuni detinuti <span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="sterge_detinuti.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinut.php">Insereaza detinut </a></li>
        </ul>
    </li>
    <li class="nav-item"><a href="functii.php">Statistici</a></li>
    <li class="nav-item"><a href="#">Lista Vizitelor</a></li>
     <li class="nav-item"><a href="login.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>


<div class="site-wrap" >
<h1> Insereaza Detinut</h1>
<h2>Completati toate campurile pentru a introduce un nou detinut!</h2><br><br>


<?php

$conn = oci_connect("Student", "STUDENT", "localhost");


$stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,ID_INSTITUTIE,VARSTA,START_PEDEAPSA FROM DETINUTI order by ID_DETINUT');


oci_execute($stid);
echo "<table DETINUTI>";
echo "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th><th>START_PEDEAPSA</th><th>VARSTA</th></tr>";
?>
<?php
while (($row = oci_fetch_assoc($stid)) != false) {
?>
      <tr><td> <?php
    echo $row['ID_DETINUT'];
?> </td> 
       <td> <?php
    echo $row['NUME'];
?> </td>
       <td> <?php
    echo $row['PRENUME'];
?> </td>
       <td> <?php
    echo $row['NR_DOSAR'];
?> </td>     
       <td> <?php
    echo $row['ID_INSTITUTIE'];
?> </td> 
       <td> <?php
    echo $row['START_PEDEAPSA'];
?> </td>  
       <td> <?php
    echo $row['VARSTA'];
?> </td>  
  <?php
}
?>

  <?php
echo "</table>";

oci_free_statement($stid);
oci_close($conn);

?>
</div>
</body>
</html>

       <tr><td> <?php
echo $row['ID_DETINUT'];
?> </td> 
       <td> <?php
echo $row['NUME'];
?> </td>
       <td> <?php
echo $row['PRENUME'];
?> </td>
       <td> <?php
echo $row['NR_DOSAR'];
?> </td>     
       <td> <?php
echo $row['ID_INSTITUTIE'];
?> </td> 
       <td> <?php
echo $row['START_PEDEAPSA'];
?> </td>  
       <td> <?php
echo $row['VARSTA'];
?> </td>  
}

  <?php
echo "</table>";

oci_free_statement($stid);
oci_close($conn);

?>
</div>
</body>
</html>
