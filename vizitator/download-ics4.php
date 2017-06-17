
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

$ics = new ICS(array(
  'location' => "Intervalul orar: ".$_POST['type'],
  'description' =>"Aceasta programare a fost confirmata",
  'dtstart' =>$id,
  'dtend' => $id,
  'summary' =>"Programare online, confirmata",
  'url' => " "
));

echo $ics->to_string();

$tip_institutie=$_SESSION['tip'];





  $sql3="SELECT * FROM (SELECT ID_PROGRAMARE4 FROM programare_vizita_tip4  WHERE ROWNUM <= (select count(*) from programare_vizita_tip4 ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2";

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



$conn = oci_connect("Student","STUDENT", "localhost");

   if (!$conn)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }


    if (!empty($_POST['nume']) AND !empty($_POST['prenume']) AND !empty($_POST['email']) AND !empty($_POST['telefon'] AND !empty($_POST['type'])))

      { $data_corecta= $_POST['data_program'];

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
$seria=$_SESSION['seria'];
$nr=$_SESSION['nr'];

$sql4="select TO_CHAR(TO_DATE(CAST('$data_corecta' AS VARCHAR(15)),'DD-MON-YY'),'DD-MM-YYYY') from dual";

$stmt4 = oci_parse($conn, $sql4);



if (!$stmt4) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }
          oci_execute($stmt4, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt4)) 
          { $new_date = ociresult($stmt4,1);  
       
            
          } 
        $sql ="INSERT INTO programare_vizita_tip4 VALUES (:bind1, :bind2, :bind3, :bind4, :bind5 ,:bind6,:bind7,:bind8, :bind9,:bind10, :bind11)";
      
echo"I am here";
$sql2 =oci_parse($conn,$sql);


oci_bind_by_name($sql2, ":bind1", $id_programare);
oci_bind_by_name($sql2, ":bind2", $detinut);
oci_bind_by_name($sql2, ":bind3", $institutie);
oci_bind_by_name($sql2, ":bind4", $nume);
oci_bind_by_name($sql2, ":bind5", $prenume);
oci_bind_by_name($sql2, ":bind6", $email);
oci_bind_by_name($sql2, ":bind7", $telefon);
oci_bind_by_name($sql2, ":bind8", $seria);
oci_bind_by_name($sql2, ":bind9", $nr);

oci_bind_by_name($sql2, ":bind10", $data_corecta);
oci_bind_by_name($sql2, ":bind11", $type);

if (!$sql2) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }

oci_execute($sql2);
}

?>
