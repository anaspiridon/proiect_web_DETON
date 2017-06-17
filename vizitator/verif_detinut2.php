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
<p><h2> Aceasta programare se poate efectua doar pentru detinutii ce au cont. Va rugam sa introduceti username-ul acestuia.</h2></p><br><br><br><br></h2>
<?php 

function get_input($username = "") 
{
  echo <<<END
  <form action="verif_detinut2.php" method="post">
<p>
    <label for="Username">
    <span>Username detinut</span>
    <input type="text" name="username" value="$username">
  </label>
<br>
  <label for="Institutie detinut">
    <span>Institutie detinut</span>
   <select name="type">

  <option value="1interv">Alegeti o institutie</option>
  <option value="Scoala de corectie Iasi">Scoala de corectie Iasi</option>
  <option value="Scoala de corectie Bacau">Scoala de corectie Bacau</option>
   <option value="Scoala de corectie Timisoara">Scoala de corectie Timisoara</option>
  <option value="Scoala de corectie Brasov">Scoala de corectie Brasov</option>
   <option value="Scoala de corectie Vaslui">Scoala de corectie Vaslui</option>
  <option value="Scoala de corectie Cluj">Scoala de corectie Cluj</option>
   <option value="Inchisoare Bacau">Inchisoare Bacau</option>
  <option value="Inchisoare Timisoara">Inchisoare Timisoara</option>
   <option value="Inchisoare Brasov">Inchisoare Brasov</option>
  <option value="Inchisoare Vaslui">Inchisoare Vaslui</option>
   <option value="Inchisoarea Iasi">Inchisoarea Iasi</option>
  <option value="Inchisoarea Constanta">Inchisoarea Constanta</option>
   <option value="Penitenciar Bihor">Penitenciar Bihor</option>
  <option value="Penitenciar Braila">Penitenciar Braila</option>
   <option value="Penitenciar Botosani">Penitenciar Botosani</option>
  <option value="Penitenciar Constanta">Penitenciar Constanta</option>
   <option value="Penitenciar Iasi">Penitenciar Iasi</option>
  <option value="Penitenciar Vaslui">Penitenciar Vaslui</option>
   <option value="Inchisoare de maxima securitate Braila">Inchisoare de maxima securitate Braila</option>
  <option value="Inchisoare de maxima securitate Botosani">Inchisoare de maxima securitate Botosani</option>
   <option value="Inchisoare de maxima securitate Iasi">Inchisoare de maxima securitate Iasi</option>
  <option value="Inchisoare de maxima securitate Vaslui">Inchisoare de maxima securitate Vaslui</option>
   <option value="Inchisoare de maxima securitate Bihor">Inchisoare de maxima securitate Bihor</option>
  <option value="Inchisoare de maxima securitate Galati">Inchisoare de maxima securitate Galati</option>
   <option value="Inchisoare de maxima securitate Tulcea">Inchisoare de maxima securitate Tulcea</option>
  
</select>
  </label>
  
  <button class="button">Submit</button> 
  </p> <br><br>
</form>
END;



} 


if(!isset($_REQUEST['username'])) {
   
   get_input();

}elseif (empty($_REQUEST['username']) ) {
        echo '<script language="javascript">';
        echo 'alert("Nu ai introdus informatii in ambele campuri! Te rugam incerca din nou!")';
        echo '</script>';
        get_input($_REQUEST['username']);
}else {  
     $conn = oci_connect("Student", "STUDENT", "localhost");
        
        if (!$conn) {
            echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
            exit;
        }

  
    $username= $_REQUEST['username'];
    $type= $_REQUEST['type'];

      $sql  = " SELECT COUNT(*) FROM detinuti d JOIN institutie i ON i.id_institutie=d.id_institutie 
                JOIN userDetinutDeton u ON u.id_detinut=d.id_detinut
                WHERE TRIM(u.username)=TRIM(:bind1)AND TRIM(i.nume_institutie)=TRIM(:bind2) ";

      $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind1", $username);
          oci_bind_by_name($stmt, ":bind2", $type);
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
            echo '<script language="javascript">';
            echo 'alert("An error occurred data!")';
            echo '</script>';
            exit;
          }
    
    
    if($rezultat==1)
    { 
        

     $sql1= "SELECT id_detinut FROM userDetinutDeton WHERE TRIM(username)=TRIM(:bind1)"; 
     $sql2 = "SELECT id_institutie, id_tip_institutie, adresa FROM institutie where TRIM(nume_institutie)=TRIM(:bind2)"; 
      $stmt1= oci_parse($conn, $sql1);
      $stmt2 = oci_parse($conn, $sql2);
      oci_bind_by_name($stmt1,":bind1", $username);
      oci_bind_by_name($stmt2, ":bind2", $type);

      oci_execute($stmt1, OCI_NO_AUTO_COMMIT);
      oci_execute($stmt2, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt1)) 
          { $id_det=ociresult($stmt1,1);
            
           $_SESSION['id_detinut1']=$id_det;

          
           } 
          if (oci_fetch($stmt2)) 
        {  $variab=ociresult($stmt2,1);
        $tip=ociresult($stmt2,2);
        $adresa=ociresult($stmt2,3);
        // $_SESSION['adresa']=$adresa;
        $_SESSION['id_institutie']=$variab;
        $_SESSION['tip']=$tip;
        echo $tip;
           } 
 
          if($tip==114)
             { header('Location:http://localhost/testare/part2_tw/verif_detinut4.php');}
              elseif($tip==112)
                 {header('Location:http://localhost/testare/part2_tw/programare_tip2.php'); 
             }elseif($tip==111)
                 {header('Location:http://localhost/testare/part2_tw/programare_tip1.php'); 
             }elseif($tip==113)
                 {header('Location:http://localhost/testare/part2_tw/programare_tip3.php'); 
             }
    
}else {
     
    echo '<script language="javascript">';
    echo 'alert("Detinutul inserat nu exista!")';
    echo '</script>'; 
    get_input();
    }
}
?>

</div>
</body>
</html>
