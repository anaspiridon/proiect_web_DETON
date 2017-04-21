<!DOCTYPE HTML PUBLIC >
<html>
<head>
  <h2>CREATE NEW ACCOUNT</h2>
</head>

<body >

<?php 

function get_input($username = "", $password = "", $nume = "") 
{
  echo <<<END
  <form action="new_account.php" method="post">
  Nume:<br>
  <input type="nume" name="nume" value="$nume">
  <br>
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

  <input type="submit">
  </form>
END;
} 

if(!isset($_REQUEST['nume'])) {
   echo "WELCOME!<h5> <break>
         Completeaza toate campurile daca doresti sa iti creezi un nou cont!! <h4><p>"; 
   get_input();
}
else {
 
  if (empty($_REQUEST['nume']) or empty($_REQUEST['username']) or empty($_REQUEST['password']) ) {
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

 $nume=$_REQUEST['nume'];
 $username=$_REQUEST['username'];
 $password=$_REQUEST['password'];
 $type = $_POST['type'];

  if($type=='user')
     { $sql="BEGIN login_package.signup_procedure_user('$nume','$username','$password'); END;";
      $stmt = oci_parse($conn, $sql);

   if(!$stmt) {
	  echo "An error occurred in parsing the sql string.\n";
	  exit;
}

  oci_execute($stmt);
  echo "Contul a fost creat cu succes!";
} 


  if($type=='admin')
 { $sql1="BEGIN login_package.signup_procedure_admin(:nume,:username,:password, :mesaj); END;";
   $stmt1 = oci_parse($conn, $sql1);


 

    if(!$stmt1) {
	  echo "An error occurred in parsing the sql string.\n";
	  exit;
}

		oci_bind_by_name($stmt1, ':nume', $nume);
		oci_bind_by_name($stmt1, ':username', $username);
		oci_bind_by_name($stmt1, ':password', $password);
		oci_bind_by_name($stmt1, ':mesaj', $mesaj, 40);

		 oci_execute($stmt1);
				   print "$mesaj\n";  
				oci_free_statement($stmt1);
				oci_close($conn);     

     } 
 
  }
}


?>

</body>
</html>