
<html>
<link href="meniu_user.css" type="text/css" rel="stylesheet">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>DETON</title>
</head>
<body>
<ul class="navigation">
    <li class="nav-item"><a href="#">Acasa</a></li>
 
  
    <li class="nav-item"><a href="#">Contact</a></li>
   <li class="nav-item"><a href="check.php">Confirmare programari</a></li>
        <li class="nav-item"><a href="vizite_validate.php">Vizualizare vizite  </a></li>

</ul>
 
<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>
<div class="site-wrap">




<?php
session_start();
include "smsGateway.php";
//index.php
$conn = oci_connect("Student","STUDENT", "localhost");

   if (!$conn)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }


  $detinut=$_SESSION['id_detinut'];

$sql="SELECT data_programarii, ID_PROGRAMARE2, NUME, PRENUME, ORA FROM programare_vizita_tip2 WHERE id_detinut=$detinut";
$stmt = oci_parse($conn, $sql);


if(!$stmt) {
  echo "An error occurred in parsing the sql string.\n";
  exit;
}
 
  oci_execute($stmt);
 
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Webslesson Tutorial</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

  <style>
   #box
   {
    width:600px;
    background:gray;
    color:white;
    margin:0 auto;
    padding:10px;
    text-align:center;
   }
  </style>
 </head>
 <body>
  <div class="container">
   <br />
   <h2 align="center">Confirmare vizita</h3><br/><br>
   <h3>Va rugam sa bifati vizitele pe care ati dori sa le inregistrati.</h3><br><br>
   <?php

    if(oci_fetch_assoc($stmt) > 0)
   {
   ?>
   <div class="table-responsive">
    <table class="table table-bordered">
     <tr>
      <th>NUME</th>
      <th>DATA PROGRAMARII</th>
      <th>ORA</th>
     </tr>
   <?php
    while (($row = oci_fetch_assoc($stmt)) != false)
    {
   ?>
     <tr id="<?php echo $row['ID_PROGRAMARE2']; ?>" >
      <td><?php echo $row["NUME"]." ".$row["PRENUME"]; ?></td>
      <td><?php echo $row['DATA_PROGRAMARII']; ?></td>
      <td><?php echo $row["ORA"] ?></td>
      <td><input type="checkbox" name="programare_id[]" class="delete_customer" value="<?php echo $row['ID_PROGRAMARE2']; ?>" /></td>
     </tr>
   <?php
    }
   ?>
    </table>
   </div>
   <?php
   }
   ?>
   <div align="center">
    <button type="button" name="btn_confirm" id="btn_confirm" class="btn btn-success">Confirm</button>
   </div>

 </body>
</html>

<script>
$(document).ready(function(){
 
 $('#btn_confirm').click(function(){
  
  if(confirm("Daca doriti sa confirmati aceasta vizita apasati OK"))
  {
   var id = [];
   
   $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
   });
   
   if(id.length === 0) //tell you if the array is empty
   {
    alert("Please Select at least one checkbox");
   }
   else
   {
    $.ajax({
     url:'delete.php',
     method:'POST',
     data:{id:id},
     success:function()
     {
      for(var i=0; i<id.length; i++)
      {
       $('tr#'+id[i]+'').css('background-color', '#ccc');
       $('tr#'+id[i]+'').fadeOut('slow');
      }
     }
     
    });
   }
   
  }
  else
  {
   return false;
  }
 });
 
});
</script>
