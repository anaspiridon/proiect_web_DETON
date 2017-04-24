

<!DOCTYPE HTML PUBLIC ">
<html>
<link href="program_online.css" type="text/css" rel="stylesheet">
<head>
<title>Deton</title>
</head>
<body>

<ul class="navigation">
    <li class="nav-item"><a href="#">Acasa</a></li>
 
  
    <li class="nav-item"><a href="#">Contact</a></li>
   <li class="nav-item"><a href="program_online.php">Programare online</a></li>
        <li class="nav-item"><a href="#">Acces penitenciar <span class="sub-navigation"></span></span></a>
        <ul>

            <li> <a href="#">Obiecte permise la vizita</a></li>
            <li> <a href="#">Obiecte nepermise la vizita </a></li>
            
        </ul>
    </li>
 
    
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>
<div class="site-wrap">
<h2 align="center"><p>Introduceti numele detinutului <br> pe care doriti sa il vizitati</p><br></h2>
<?php

function get_input($prenume = "", $nume = "", $nrDosar = "")
{
    echo <<<END
 <form action="program_online.php" method="post">
<p>
    <label for="Prenume">
    <span>Prenume*</span>
    <input type="text" name="prenume" value="$prenume">
  </label>

  <label for="Nume">
    <span>Nume*</span>
    <input type="text" name="nume" value="$nume">
  </label>

  <br> <br>
   SAU
   <br> <br>

   <label for="Nr. Dosar">
    <span>Nr. Dosar**</span>
    <input type="text" name="nrDosar" value="$nrDosar">
    <br> ex:358956/5/1997 <br>
   </label> <br>
  

  <button class="button">Submit</button> 
  </p> <br><br>
</form>
END;
    
    echo "<p>*Puteti introduce numele complet sau o serie de caractere
   <br> ** Numarul de dosar trebuie sa fie complet si corect </p>";
    
}


if (!isset($_REQUEST['prenume'])) {
    
    get_input();
    
}
// nu a fost completat nici un camp
elseif (empty($_REQUEST['prenume']) and empty($_REQUEST['nume']) and empty($_REQUEST['nrDosar'])) {
    echo '<script language="javascript">';
    echo 'alert("Trebuie sa completati prenumele si numele sau numarul de dosar")';
    echo '</script>';
    
    get_input($_REQUEST['prenume'], $_REQUEST['nume'], $_REQUEST['nrDosar']);
}
//cautare dupa nume si prenume
    elseif (isset($_REQUEST['prenume']) and isset($_REQUEST['nume']) and empty($_REQUEST['nrDosar'])) {
    $conn = oci_connect("Student", "STUDENT", "localhost");
    if (!$conn) {
        echo "An error occured connecting to the database.";
        get_input();
    }
    $prenume = $_REQUEST['prenume'];
    $nume    = $_REQUEST['nume'];
    
    $sql  = "select user_package.cautare_by_nume('$nume','$prenume') from dual";
    $stmt = oci_parse($conn, $sql);
    if (!$stmt) {
        echo "An error occurred in parsing the sql string.\n";
        exit;
    }
    oci_execute($stmt);
    if (oci_fetch($stmt)) {
        $rezultat = ociresult($stmt, 1);
        if ($rezultat == 1) {
            ob_start();
            require 'calendar.php';
        } else {
            
            echo '<script language="javascript">';
            echo 'alert("Detinutul inserat nu exista!")';
            echo '</script>';
            
?>
<form action="program.php" method="post">
<p>
    <label for="Prenume">
    <span>Prenume*</span>
    <input type="text" name="prenume" value="">
  </label>

  <label for="Nume">
    <span>Nume*</span>
    <input type="text" name="nume" value="">
  </label>

  <br> <br>
   SAU
   <br> <br>

   <label for="Nr. Dosar">
    <span>Nr. Dosar**</span>
    <input type="text" name="nrDosar" value="">
    <br> ex:358956/5/1997 <br>
   </label> <br>
  

  <button class="button">Submit</button> 
  </p> <br><br>
</form>
<?php
            echo "<p>*Puteti introduce numele complet sau o serie de caractere .
   <br> ** Numarul de dosar trebuie sa fie complet si corect. </p>";
?>
   <?php
        }
?>
   <?php
    } else {
        echo "An error occurred in retrieving book id.\n";
        exit;
    }
}
//cautare dupa dosar 
    elseif (empty($_REQUEST['prenume']) and empty($_REQUEST['nume']) and isset($_REQUEST['nrDosar'])) {
    
    $conn = oci_connect("Student", "STUDENT", "localhost");
    if (!$conn) {
        echo "An error occured connecting to the database.";
        get_input();
    }
    $nrDosar = $_REQUEST['nrDosar'];
    
    $sql  = "select user_package.cautare_by_dosar('$nrDosar') from dual";
    $stmt = oci_parse($conn, $sql);
    if (!$stmt) {
        echo "An error occurred in parsing the sql string.\n";
        exit;
    }
    oci_execute($stmt);
    if (oci_fetch($stmt)) {
        $rezultat = ociresult($stmt, 1);
        if ($rezultat == 1)
            echo "Persoana condamnata in dosarul cu nr " . $nrDosar . " se afla intr-una din institutiile manageriate de noi!";
        else {
            echo '<script language="javascript">';
            echo 'alert("Persoana condamnata cu acest dosar nu se afla intr-una din institutiile manageriate de noi!")';
            echo '</script>';
?>
<form action="program.php" method="post">
<p>
    <label for="Prenume">
    <span>Prenume*</span>
    <input type="text" name="prenume" value="">
  </label>

  <label for="Nume">
    <span>Nume*</span>
    <input type="text" name="nume" value="">
  </label>

  <br> <br>
   SAU
   <br> <br>

   <label for="Nr. Dosar">
    <span>Nr. Dosar**</span>
    <input type="text" name="nrDosar" value="">
    <br> ex:358956/5/1997 <br>
   </label> <br>
  

 <button class="button">Submit</button> 
  </p> <br><br>
</form>
<?php
            echo "<p>*Puteti introduce numele complet sau o serie de caractere .
   <br> ** Numarul de dosar trebuie sa fie complet si corect. </p>";
?>
   <?php
        }
?>;
   
    <?php
    } else {
        echo "An error occurred in retrieving book id.\n";
        exit;
    }
}
//toate campurile au fost completate
    elseif (isset($_REQUEST['prenume']) and isset($_REQUEST['nume']) and isset($_REQUEST['nrDosar'])) {
    echo '<script language="javascript">';
    echo 'alert("Trebuie sa completati prenumele si numele sau numarul de dosar, nu toate campurile")';
    echo '</script>';
    
    get_input();
}

?>
</div>
</body>
</html>
 
