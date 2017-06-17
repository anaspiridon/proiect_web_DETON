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
      <li class="nav-item"><a href="vizualizare_detinuti_admin.php">Lista detinuti</a></li>
    <li class="nav-item"><a href="#">Optiuni detinuti <span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="sterge_detinuti_admin.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinuti_admin.php.php">Insereaza detinut </a></li>
        </ul>
    </li>
        <li class="nav-item"><a href="vizualizare_vizite.php">Lista Vizitelor</a></li>
     <li class="nav-item"><a href="index.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>


<div class="site-wrap" >
 <h1> Detention Monitoring Tool </h1> 
 <br>
 <br>
<?php

session_start();
function get_imput_admin($nume = '', $prenume = '', $nrDosar = '', $sPedeapsa = '', $pedeapsa = '', $data_nastere = '')
{
    echo <<<END
 <form action="insereaza_detinut.php" method="post">
 
  <div><p><label for="nume">Nume detinut:</label>
     <input type="text" name="nume" value="$nume"></p><div>

  <p><label for="prenume">Prenume detinut:</label>
     <input type="text" name="prenume" value="$prenume"></p>

  <p><label for="nrDosar">Nr. Dosar:</label>
     <input type="text" name="nrDosar" value="$nrDosar"></p> 
  
  <p><label for="sPedeapsa">Start Pedeapsa:</label>
        <input type="date"  name="sPedeapsa" id="data" value="$sPedeapsa"></p>
  
  <p><label for=data_nastere> Data nastere :</label>
        <input type="date"  name="data_nastere" id="data" value="$data_nastere"></p>

  <p><label for ="gen" > Sex: </label>
        <select name="gen" id="gen">
          <option value = M> M </option>
          <option value =F >F </option>
         </select> </p>

  <p><label for="pedeapsa">Pedeapsa:</label>
        <select name="pedeapsa" id="pedeapsa">
          <option value= 1 > crima </option>
          <option value= 2 > frauda </option>
          <option value= 3 > furt </option>
          <option value= 4 > viol </option>
          <option value= 5 > santaj </option>
          <option value= 6 > fals </option>
          <option value= 7 > trafic </option>
          <option value= 8 > posesie </option>
          <option value= 9 > prostitutie </option>
          <option value= 10 > profanare </option>
        </select>  </p>

    <p><button class="button">Insereaza</button> 
    </p>
    <br />
    </div>
  </form>
  </p>
END;
}
if (!isset($_REQUEST['nume']))
{
    get_imput_admin();
}
  elseif (empty($_REQUEST['nume']) or empty($_REQUEST['prenume']) or empty($_REQUEST['nrDosar']) or empty($_REQUEST['sPedeapsa']) or empty($_REQUEST['pedeapsa'])) 
{
    echo '<script language="javascript">';
    echo 'alert("Pentru adaugarea unui nou detinut este necesara completarea tuturor spatilor")';
    echo '</script>';
    get_imput_admin();
}
?>
</div>
</body>
</html>
