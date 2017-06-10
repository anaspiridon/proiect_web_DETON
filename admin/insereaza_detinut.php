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
            <li> <a href="sterge_detinuti.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinut.php">Insereaza detinut </a></li>
        </ul>
    </li>
    <li class="nav-item"><a href="date.php">Statistici</a></li>
    <li class="nav-item"><a href="vizualizare_vizite.php">Lista Vizitelor</a></li>
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
function get_imput_admin($nume = '', $prenume = '', $nrDosar = '', $sPedeapsa = '' , $pedeapsa ='' ,$data_nastere='')
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
    {echo '<script language="javascript">';
      echo 'alert("Pentru adaugarea unui nou detinut este necesara completarea tuturor spatilor")';
      echo '</script>';
      get_imput_admin();
     }
 else 
 {
    get_imput_admin();

          $conn         = oci_connect("Student", "STUDENT", "localhost");
          $nume         = $_REQUEST['nume'];
          $prenume      = $_REQUEST['prenume'];
          $nrDosar      = $_REQUEST['nrDosar'];
          $sPedeapsa    = $_REQUEST['sPedeapsa'];
          $gen          = $_REQUEST['gen'];
          $pedeapsa     = $_REQUEST['pedeapsa'];
          $data_nastere = $_REQUEST['data_nastere'];
          $idInstitutie = $_SESSION['id_institutie'];


  
          $sql2         = "SELECT * FROM (SELECT ID_detinut FROM detinuti  WHERE ROWNUM <= (select count(*) from detinuti ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2";
          $stmt         = oci_parse($conn, $sql2);
          if (!$stmt) 
          {
            echo "An error occurred in parsing the sql string.\n";
            exit;
          }
      
          oci_execute($stmt);
          if (oci_fetch($stmt)) 
          {
           $id = ociresult($stmt, 1);
          }
          else 
           {
            echo "An error occurred in retrieving book id.\n";
            exit;
           }
      
          $id_detinut = $id + 1;
          $sPedeapsa = date("Y-m-d",strtotime(@$_REQUEST['sPedeapsa']));
          $sPedeapsa="'".$sPedeapsa."'";
          $data_nastere = date("Y-m-d", strtotime(@$_REQUEST['data_nastere']));
          $data_nastere="'".$data_nastere."'";
          echo $pedeapsa;
          $sql        = "INSERT INTO detinuti (ID_DETINUT,NUME,PRENUME,NR_DOSAR, GEN, ID_INSTITUTIE,START_PEDEAPSA, ID_PEDEAPSA, ADR_POZA, DATA_NASTERE, COMPORTAMENT_EXEMPLAR ) VALUES (:bind7, :bind1, :bind2, :bind3, :bind4, :bind5, date $sPedeapsa , :bind6, 'lalala', date $data_nastere, 1)";
          $sql2       = oci_parse($conn, $sql);
          if(!$sql2)
          {
              echo "something wrong";
          }

          oci_bind_by_name($sql2, ":bind1", $nume);
          oci_bind_by_name($sql2, ":bind2", $prenume);
          oci_bind_by_name($sql2, ":bind3", $nrDosar);
          oci_bind_by_name($sql2, ":bind5", $idInstitutie);
          oci_bind_by_name($sql2, ":bind4", $gen);
          oci_bind_by_name($sql2, ":bind7", $id_detinut);
          oci_bind_by_name($sql2, ":bind6", $pedeapsa);



          $r = oci_execute($sql2, OCI_NO_AUTO_COMMIT);
          if (!$r) 
          {
            $e = oci_error($sql2);
            oci_rollback($conn);
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
          }
      
          if (!$r) 
          {
            $e = oci_error($result);
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
          }
      
          $r = oci_commit($conn);
          if (!$r) 
          {
            $e = oci_error($conn);
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
          } 
          else 
          {
            echo "<p>Felicitari! Ati inserat cu succes! </p> <h3> Multumim! ";
          }
 }     
?>


</div>
</body>
</html>