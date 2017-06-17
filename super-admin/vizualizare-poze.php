<!doctype html public >
<html>
<link href="calendar.css" type="text/css" rel="stylesheet">
<head>
<title>DETON</title>
</head>
<body>
    
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
<div class="site-wrap">
<?Php
 session_start();
function schimba_poza( $nume='')
{
echo <<<END
    <form method="post" enctype="multipart/form-data" action="vizualizare-poze.php">
    <p>  <label for="nume">ID DETINUT:</label>
    <input type="text" name="id" value="$nume">
    <p>File name:<input type="file" name="imgfile" ><br>
    <input type="submit" name="submit" value="upload">
    </form>
END;
}
 
if($_SESSION['tip']=='admin')
  { schimba_poza();   
    $id_inst=$_SESSION['id_institutie'];
     $conn = oci_connect("Student","STUDENT", "localhost");
     $stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,START_PEDEAPSA,ADR_POZA,ID_INSTITUTIE FROM DETINUTI where id_institutie= :bind1 order by ID_DETINUT');
     oci_bind_by_name($stid,'bind1',$id_inst);
     oci_execute($stid);

     echo "<table DETINUTI>";
     echo  "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th><th>START_PEDEAPSA</th></tr>";
      ?>
      <?php

     while (($row = oci_fetch_assoc($stid)) != false) {
    
       $filename=$row['ADR_POZA'];
       ?>
       <tr><td><?php echo $row['ID_DETINUT']; ?> </td> 
       <td> <?php echo '<a href="uploads/'.$filename.'">' ;   echo $row['NUME']; ?> </td>
       <td> <?php echo '<a href="uploads/'.$filename.'">' ; echo $row['PRENUME'] ; ?> </td>
       <td> <?php echo $row['NR_DOSAR'] ; ?> </td>     
       <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td> 
       <td> <?php echo $row['START_PEDEAPSA'] ; ?> </td>  

     <?php } ?>

      <?php
      echo "</table>";
          if(isset($_REQUEST['submit']))
     {
          $filename=  $_FILES["imgfile"]["name"];
          if ((($_FILES["imgfile"]["type"] == "image/gif")|| ($_FILES["imgfile"]["type"] == "image/jpeg") || ($_FILES["imgfile"]["type"] == "image/png")  || ($_FILES["imgfile"]["type"] == "image/pjpeg")) && ($_FILES["imgfile"]["size"] < 20000000))
          {
             if(file_exists($_FILES["imgfile"]["name"]))
             {
                echo "File name exists.";
             }
             else
             {
              //echo $_FILES["imgfile"]["name"]; -- numele pozei 
               echo $_FILES["imgfile"]["tmp_name"];
               echo $filename;
               echo "***".$_REQUEST['id']."****";
               move_uploaded_file($_FILES["imgfile"]["tmp_name"],"uploads/$filename");
               echo "Upload Successful . <a href='uploads/$filename'>Click here</a> to view the uploaded image";

               $sql= "update detinuti set adr_poza = :bind1 where ID_DETINUT = :bind2"; 
               $stmt=oci_parse($conn, $sql);

               oci_bind_by_name($stmt, ':bind1', $filename);
               oci_bind_by_name($stmt,':bind2', $_REQUEST['id']);
               oci_execute($stmt); 
               oci_commit($conn);    
              }
          }

      }
     }
elseif ($_SESSION['tip']=='superadmin')
   {schimba_poza(); 
                  $conn = oci_connect("Student","STUDENT", "localhost");
     $stid = oci_parse($conn, 'SELECT ID_DETINUT, NUME, PRENUME,NR_DOSAR,START_PEDEAPSA,ADR_POZA,ID_INSTITUTIE FROM DETINUTI order by ID_DETINUT');

     oci_execute($stid);

     echo "<table DETINUTI>";
     echo  "<tr><th>ID_DETINUT</th><th>NUME</th><th>PRENUME</th><th>NR_DOSAR</th><th>ID_INSTITUTIE</th><th>START_PEDEAPSA</th></tr>";
      ?>
      <?php

     while (($row = oci_fetch_assoc($stid)) != false) {
    
       $filename=$row['ADR_POZA'];
       ?>
       <tr><td><?php echo $row['ID_DETINUT']; ?> </td> 
       <td> <?php echo '<a href="uploads/'.$filename.'" target="_blank">' ;   echo $row['NUME']; ?> </td>
       <td> <?php echo '<a href="uploads/'.$filename.'" target="_blank">' ; echo $row['PRENUME'] ; ?> </td>
       <td> <?php echo $row['NR_DOSAR'] ; ?> </td>     
       <td> <?php echo $row['ID_INSTITUTIE'] ; ?> </td> 
       <td> <?php echo $row['START_PEDEAPSA'] ; ?> </td>  

     <?php } ?>

      <?php
      echo "</table>";
  
          if(isset($_REQUEST['submit']))
          { $filename=  $_FILES["imgfile"]["name"];
            if ((($_FILES["imgfile"]["type"] == "image/gif")|| ($_FILES["imgfile"]["type"] == "image/jpeg") || ($_FILES["imgfile"]["type"] == "image/png")  || ($_FILES["imgfile"]["type"] == "image/pjpeg")) && ($_FILES["imgfile"]["size"] < 20000000))
              {
                if(file_exists($_FILES["imgfile"]["name"]))
                {
                   echo "File name exists.";
                }
                 else
                {
               //echo $_FILES["imgfile"]["name"]; -- numele pozei 
                echo $_FILES["imgfile"]["tmp_name"];
                echo $filename;

                move_uploaded_file($_FILES["imgfile"]["tmp_name"],"uploads/$filename");
                echo "Upload Successful . <a href='uploads/$filename'>Click here</a> to view the uploaded image";
                $sql= "update detinuti set adr_poza = :bind1 where ID_DETINUT = :bind2"; 
                $stmt=oci_parse($conn, $sql);
                echo $_REQUEST['id'];
                oci_bind_by_name($stmt, ':bind1', $filename);
                oci_bind_by_name($stmt,':bind2', $_REQUEST['id']);
                oci_execute($stmt);   
                oci_commit($conn); 
                header("Refresh:0");

              }
             }
          }
  }
?>




</div>

</body>
</html>


