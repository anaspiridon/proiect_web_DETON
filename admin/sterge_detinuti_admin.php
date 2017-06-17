
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