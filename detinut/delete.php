<?php
//delete.php
include "smsGateway.php";
$conn = oci_connect("Student","STUDENT", "localhost");

   if (!$conn)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

if(isset($_POST["id"]))
{
 foreach($_POST["id"] as $id)
 {

$sql3="SELECT TELEFON, ORA, DATA_PROGRAMARII FROM programare_vizita_tip2 WHERE id_programare2 = '".$id."'";
$stmt3 = oci_parse($conn, $sql3);
if(!$stmt3) {
  echo "An error occurred in parsing the sql string.\n";
  exit;
}
 
oci_execute($stmt3, OCI_DEFAULT);
while (($row = oci_fetch_assoc($stmt3)) != false) 
          { $tel = $row['TELEFON'];
            $ora = $row['ORA'];
            $data = $row['DATA_PROGRAMARII'];
            echo $tel;
            $smsGateway = new SmsGateway('lauraionita81@gmail.com', 'floridetei');

$deviceID = 50127;
$number = $tel;

$message = "Vizita din data de ".$data.", ora ".$ora." este validata!";

$result = $smsGateway->sendMessageToNumber("+".$number, $message, $deviceID);
            
          } 
  


oci_free_statement($stmt3);

$sql = "DELETE FROM programare_vizita_tip2 WHERE id_programare2 = '".$id."'";
 $stmt = oci_parse($conn, $sql);


if(!$stmt) {
  echo "An error occurred in parsing the sql string.\n";
  exit;
} 
 
oci_execute($stmt, OCI_DEFAULT);
echo oci_num_rows($stmt) . " rows deletd<br />\n";
$count=oci_num_rows($stmt);
echo $count;
oci_commit($conn);
oci_free_statement($stmt);

}
}

?>