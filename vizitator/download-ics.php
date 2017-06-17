
<?php
session_start();
include 'ICS.php';

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=invite.ics');

$conn = oci_connect("Student","STUDENT", "localhost");

   if (!$conn)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }



$data_corecta= $_POST['data_program'];
$sql3="select TO_CHAR(TO_DATE(CAST('$data_corecta' AS VARCHAR(15)),'DD-MON-YY'),'MM/DD/YYYY') from dual";

$stmt3 = oci_parse($conn, $sql3);



if (!$stmt3) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }
          oci_execute($stmt3, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt3)) 
          { $id = ociresult($stmt3,1);	
       
            
          } 

// $date_second=date('d-m-Y', strtotime($data_corecta));
  $adresa=$_SESSION['adresa'];        

$ics = new ICS(array(
  'location' => "Intervalul orar: ".$_POST['type'],
  'description' =>"Daca detinutul va accepta solicitarea programarii veti primi confrirmarea prin SMS",
  'dtstart' =>$id,
  'dtend' => $id,
  'summary' =>"Programare online, confirmare prin SMS",
  'url' => ""
));

echo $ics->to_string();


$sql3="SELECT * FROM (SELECT ID_PROGRAMARE2 FROM PROGRAMARE_VIZITA_TIP2  WHERE ROWNUM <= (select count(*) from PROGRAMARE_VIZITA_TIP2 ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2";

$stmt3 = oci_parse($conn, $sql3);



if (!$stmt3) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }
          oci_execute($stmt3, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt3)) 
          { $id = ociresult($stmt3,1);
       
            
          } 
           else 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred data id programare!")';
            echo '</script>';
            exit;
          }

$id_programare=$id+1;
echo $id_programare;


 $data_corecta= $_POST['data_program'];

$id_programare=$id+1;
echo $id_programare;


 $data_corecta= $_POST['data_program'];

$nume=$_REQUEST['nume'];
$prenume=$_REQUEST['prenume'];
$email=$_REQUEST['email'];
$telefon=$_REQUEST['telefon'];
$type=$_REQUEST['type'];

if(!empty($_POST['nume'])){
$filename = $_POST['nume'];

echo $filename;
}


$detinut=$_SESSION['id_detinut1'];
$institutie=$_SESSION['id_institutie']; 
        $sql ="INSERT INTO programare_vizita_tip2 VALUES (:bind1, :bind2, :bind3, :bind4, :bind5 ,:bind6,:bind7,:bind8, :bind9)";
      
echo"I am here";
$sql2 =oci_parse($conn,$sql);


oci_bind_by_name($sql2, ":bind1", $id_programare);
oci_bind_by_name($sql2, ":bind2", $detinut);
oci_bind_by_name($sql2, ":bind3", $institutie);
oci_bind_by_name($sql2, ":bind4", $nume);
oci_bind_by_name($sql2, ":bind5", $prenume);
oci_bind_by_name($sql2, ":bind6", $email);
oci_bind_by_name($sql2, ":bind7", $telefon);
oci_bind_by_name($sql2, ":bind8", $data_corecta);
oci_bind_by_name($sql2, ":bind9", $type);

if (!$sql2) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }

oci_execute($sql2);
header("http://localhost/testare/part2_tw/programare_tip2.php");
location.reload();
?>

