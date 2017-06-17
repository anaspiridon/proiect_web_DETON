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
    <li class="nav-item"><a href="vizualizare_vizite.php">Lista Vizitelor</a></li>
    <li class="nav-item"><a href="vizualizare-poze.php">Vizualizare poze</a></li>
     <li class="nav-item"><a href="login.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>

<div class="site-wrap" >
<h1>Insereaza Institutie</h1>
 <br>
 <br>
<?php
session_start();
function get_imput($nume = '', $adr='',$telefon='',$capacitate='',$gen='')
{
    echo <<<END
  <form action="mediu_superadmin.php" method="post">
 
  <div><p><label for="nume">Nume institutie:</label>
     <input type="text" name="nume" value="$nume"></p><div>

  <p><label for="adresa">Adresa:</label>
     <input type="text" name="adr" value="$adr"></p> 
  
  <p><label for="telefon">Telefon:</label>
        <input type="text"  name="telefon" id="telefon" value="$telefon"></p>

  <p><label for="capacitate">Capacitate:</label>
        <input type="number"  name="capacitate" id="capacitate" value="$capacitate"></p>


  <p><label for ="tip" > Tip institutie: </label>
        <select name="gen" id="gen">
          <option value = 111> Scoala de corectie </option>
          <option value =112 >Inchisoare </option>
          <option value =113 >Penitenciar </option>
          <option value =114 >Inchisoare de maxima securitate </option>
         </select>  
  
    <p><button class="button">Insereaza</button> 
    </p>
    <br />
    </div>
  </form>
  </p>
END;
}
if(empty($_REQUEST['nume']))
{
  get_imput();
}
elseif(isset($_REQUEST['nume']) and isset($_REQUEST['gen']) and isset($_REQUEST['adr']) and isset($_REQUEST['telefon']) and isset($_REQUEST['capacitate']) )
{ 

        get_imput();

        $conn         = oci_connect("Student", "STUDENT", "localhost");
        $nume         = $_REQUEST['nume'];
        $gen          = $_REQUEST['gen'];
        $adr          = $_REQUEST['adr'];
        $telefon      = $_REQUEST['telefon'];
        $capacitate   = $_REQUEST['capacitate'];

        $sql2         = "SELECT * FROM (SELECT ID_INSTITUTIE FROM institutie  WHERE ROWNUM <= (select count(*) from institutie ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2";
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

          $id= $id + 1;
          $sql        = "INSERT INTO institutie (ID_INSTITUTIE,NUME_INSTITUTIE,ID_TIP_INSTITUTIE,ADRESA, NR_TELEFON, CAPACITATE ) VALUES 
                          (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6 )";
          $sql2       = oci_parse($conn, $sql);
          if(!$sql2)
          {
              echo "something wrong";
          }

          oci_bind_by_name($sql2, ":bind1", $id);
          oci_bind_by_name($sql2, ":bind2", $nume);
          oci_bind_by_name($sql2, ":bind3", $gen);
          oci_bind_by_name($sql2, ":bind4", $adr);
          oci_bind_by_name($sql2, ":bind5", $telefon);
          oci_bind_by_name($sql2, ":bind6", $capacitate);


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
        {      echo '<script language="javascript">';
               echo 'alert("Felicitari! Ati inserat cu succes! Multumim!")';
               echo '</script>';
        }
}
else {
  get_imput();
}
?>
 <h3>

 </h3>

</div>
</body>
</html>