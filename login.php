<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="login.css" type="text/css" rel="stylesheet">
<head>

</head>

<body>

<h1>DETON</h1>

<p>Bine ați venit pe Deton!</p>

<?php 

function get_input($username = "", $password = "") 
{
  echo <<<END
 <div> 
  <form action="login.php" method="post">
  <label for="username">Nume utilizator:</label>
  <br>
  <input type="text" name="username" value="$username" placeholder="Numele tău...">
  <br>
  <label for="password">Parolă</label>
  <br>
  <input type="password" name="password" value="$password" placeholder="Parola ta...">
  <br><br>

  
  <label for="type">Tip utilizator:</label>
  <select name="type">
      <option value="admin">admin</option>
      <option value="user">user</option>
</select>
  <p> 
 <button class="button">Conectează-te</button>
  </form>
 </div> 
END;

echo <<<HTML
<a href="new_account.php"> <button class="button">Creaza cont nou</button></a>
HTML;
} 

if(!isset($_REQUEST['username'])) {
   get_input();
}
else {
 
  if (empty($_REQUEST['username']) or empty($_REQUEST['password'])) {
       echo '<script language="javascript">';
            echo 'alert("Nu ai introdus informatii in ambele campuri! Te rugam incerca din nou!")';
            echo '</script>';
    get_input($_REQUEST['username'], $_REQUEST['password']);
  }
  

  else {
  

   $conn = oci_connect("Student","STUDENT", "localhost");

   if (!$conn)  {
       echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
    exit; 
  }

 $username=$_REQUEST['username'];
 $password=$_REQUEST['password'];
 $type = $_POST['type'];

      $sql = "select login_package.login_function('$username','$password') FROM dual";
      $stmt = oci_parse($conn, $sql);

    if(!$stmt) {
     echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
  exit;
}
 
  oci_execute($stmt);


if(oci_fetch($stmt)) {
  $verif= OCIResult($stmt,1); 
}else {
     echo '<script language="javascript">';
            echo 'alert("An error occurred data!")';
            echo '</script>';
  exit;
}

    if ($verif==1)
  {       echo '<script language="javascript">';
            echo 'alert("Te-ai logat!")';
            echo '</script>';

    if ($type=='user' AND $verif==1)
    {
      ob_start();
    require 'meniu_user.php';
    }elseif ($type=='admin' AND $verif==1) {
       ob_start();
    require 'meniu_admin.php';
    }
}
else {
           echo '<script language="javascript">';
            echo 'alert("User gresit!")';
            echo '</script>';
    exit;
    }

  }
 
}


?>


</body>
</html>
