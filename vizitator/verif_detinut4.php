<!DOCTYPE HTML PUBLIC ">
<html>
<link href="program.css" type="text/css" rel="stylesheet">
<head>
<title>Deton</title>
</head>
<body>
<?php

session_start();
?>
<ul class="navigation">
    <li class="nav-item"><a href="meniu_admin.php">Acasa</a></li>
    <li class="nav-item"><a href="test.php">Despre</a></li>
  
    <li class="nav-item"><a href="functii.php">Contact</a></li>
    <li class="nav-item"><a href="programare_online.php">Programare online</a></li>
    <li class="nav-item"><a href="#">Obiecte permise la vizita</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>
<div class="site-wrap">
<h1><p>Programare Online<br></p><br><br>
<p><h2> Aceasta programare se poate efectua doar pentru detinutii ce au cont. Va puteti programa doar daca sunt ruda de gardul I cu acesta. Va rugam sa completati formularul cu datele dumneavoastra.</h2></p><br><br><br><br></h2>
<?php 

function get_input($seria = "", $nr="" ) 
{
  echo <<<END
  <form action="verif_detinut4.php" method="post">
<p>
    <label for="SERIE">
    <span>SERIE</span>
    <input type="text" name="seria" value="$seria">
  </label>
<br>
  <label for="Nr.">
    <span>Nr  </span>
  <input type="text" name="nr" value="$nr">
  </label><br>
  
  <button class="button">Submit</button> 
  </p> <br><br>
</form>
END;



} 


if(!isset($_REQUEST['seria'])) {
   
   get_input();

}else if (empty($_REQUEST['seria']) or empty($_REQUEST['nr'])) {
        echo '<script language="javascript">';
        echo 'alert("Nu ai introdus informatii in ambele campuri! Te rugam incerca din nou!")';
        echo '</script>';
        get_input($_REQUEST['seria'], $_REQUEST['nr']);
      }
     else
       {
        
        $conn = oci_connect("Student", "STUDENT", "localhost");
        
        if (!$conn) {
            echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
            exit;
        }

  
    $seria= $_REQUEST['seria'];
    $nr= $_REQUEST['nr'];
    $id=$_SESSION['id_detinut1'];

    $_SESSION['seria']=$seria;
     $_SESSION['nr']=$nr;

    echo $id;
      $sql  = " SELECT COUNT(*) FROM RELATII_MAXSECURITATE WHERE TRIM(ID_DETINUT)=TRIM(:bind) AND TRIM(SERIE)=TRIM(:bind1) AND TRIM(NR)=TRIM(:bind2)";

      $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind", $id);
          oci_bind_by_name($stmt, ":bind1", $seria);
          oci_bind_by_name($stmt, ":bind2", $nr);
          if (!$stmt) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }
          oci_execute($stmt, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt)) 
          { $rezultat = ociresult($stmt,1);
       
            
          } 
           else 
          {
            echo "nadaa";
            exit;
          }
    echo $rezultat;
    
    if($rezultat==1)
    { 
        

header('Location:http://localhost/testare/part2_tw/programare_tip4.php'); 

    }else {
     
    echo '<script language="javascript">';
    echo 'alert("Nu sunteti inregistrat in baza noastra de date ca fiind membrul al familiei!")';
    echo '</script>'; 
    get_input();
    }
}
?>

</div>
</body>
</html>