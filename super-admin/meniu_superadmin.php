<!DOCTYPE HTML PUBLIC ">
<html>
<link href="meniu_admin.css" type="text/css" rel="stylesheet">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>DETON</title>
</head>
<body bgcolor="#EEEEEE">

<ul class="navigation">
    <li class="nav-item"><a href="meniu_superadmin.php">Acasa</a></li>
	  <li class="nav-item"><a href="vizualizare_detinuti.php">Lista detinuti</a></li>
    <li class="nav-item"><a href="#">Optiuni detinuti <span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="sterge_detinuti.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinut.php">Insereaza detinut </a></li>
        </ul>
    </li>
	<li class="nav-item"><a href="insereaza_institutie.php">Statistici</a></li>
    <li class="nav-item"><a href="vizualizare-poze.php">Vizualizare poze</a></li>
     <li class="nav-item"><a href="login.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>


<div class="site-wrap" >
 <h1> Detention Monitoring Tool </h1> 
 <br>
 <br>
<?php
session_start();
?>
 <h3>
 Acesta aplicatie ofera supor in gestiunea vizitelor de care beneficiaza persoanele condamnate la executarea unei pedepse intr-una dintre cele 5 institutii manageriate de noi!
 </h3>
 <h3>
 Sunteti un super-admin si puteti viziona si gestiona datele din toate institutiile!.
 </h3>
 <p><a href="linii.php">Distributia detinutilor pe tipuri de unitati</a>
<p><a href="distributie pe pedepse.php">Distributia detinutilor pe tipul de condamnare</a>

</div>
</body>
</html>
