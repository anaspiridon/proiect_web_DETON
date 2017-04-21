<!DOCTYPE HTML PUBLIC>
<html>
<head>
<h2>DETON</h2>
</head>
<body bgcolor="#EEEEEE">


<?php 

function get_input($username = "", $password = "") 
{
  echo <<<END
  <form action="login.php" method="post">
  Username:<br>
  <input type="text" name="username" value="$username">
  <br>
  Password:<br>
  <input type="password" name="password" value="$password">
  <br><br>

  Type:
  <select name="type">
      <option value="admin">admin</option>
      <option value="user">user</option>
</select>
  <p> 
  <input type="submit">
  </form>
END;

echo <<<HTML
<a href="new_account.php">Create new account</a>
HTML;
} 

if(!isset($_REQUEST['username'])) {
   echo "WELCOME!<h5> <break>
         LOG IN   <h4><p>"; 
   get_input();
}
else {
 
  if (empty($_REQUEST['username']) or empty($_REQUEST['password'])) {
    echo "You did not enter text in both 
          fields, please re-enter the information.<p>"; 
    get_input($_REQUEST['username'], $_REQUEST['password']);
  }
  

  else {
  

   $conn = oci_connect("Student","STUDENT", "localhost");

   if (!$conn)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

 $username=$_REQUEST['username'];
 $password=$_REQUEST['password'];
 $type = $_POST['type'];

      $sql = "select login_package.login_function('$username','$password') FROM dual";
      $stmt = oci_parse($conn, $sql);

    if(!$stmt) {
  echo "An error occurred in parsing the sql string.\n";
  exit;
}
 
  oci_execute($stmt);


if(oci_fetch($stmt)) {
  $verif= OCIResult($stmt,1); 
}else {
  echo "An error occurred data \n";
  exit;
}

    if ($verif==1)
  {   echo "te-ai logat!!!";

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
    echo "user gresit!!";
    exit;
    }

  }
 
 
}


?>

</body>
</html>