<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="login.css" type="text/css" rel="stylesheet">

<head>
<title>DETON</title>
</head>

<body>

<h1>DETON</h1>

<p>Bine ați venit pe Deton!</p>
<br><br>
<?php 

function get_input($username = "", $password = "") 
{
  echo <<<END
 <div> 
  <form action="login.php" method="post">
  <label for="username">Username:</label>
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
	}
	else
	{
		 echo '<script language="javascript">';
            echo 'alert("An error occurred data!")';
            echo '</script>';
		exit;
	}

    if ($verif==1)
  {      

    if ($type=='user' AND $verif==1)
    {
      ob_start();
    require 'meniu_user.php';
    }
	elseif ($type=='admin' AND $verif==1)
	{
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


<!-- Trigger/Open The Modal -->
<button id="myBtn">Creaza cont nou</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
      <form method="post" action="login.php">
	  <label for="username" >Nume complet:</label>
	  <input type="text" name="name" placeholder="Numele tău...">
	  
      <label for="username" >Username:</label>
	  <input type="text" name="username" placeholder="Username-ul tău...">
	   <label for="password" >Parolă</label>
	  <input type="password" name="password" >
	  <br><br>
	  <label for="username" >Email:</label>
	  <input type="email" name="email" placeholder="Email tău..." style="" >
	  <label for="username" >Numar de telefon:</label>
	  <input type="text" name="telefon" placeholder="Numarul tău...">
	  <br>
	   <label for="username" >Data de nastere:</label>
	  <input type="date" name="data_nastere" style=""  >
	  <br>
	   <label for="username" >Fotografie:</label>
	   <input type="file" name="foto" style="" >
	  <br><br>
	    <input type="radio" name="gender" value="male" />
		<label for="r1"><span></span>Masculin</label>
		<br>
		<input type="radio" name="gender" value="male" />
		<label for="r2"><span></span>Feminin</label>
		<br><br>
	  <label for="type">Tip utilizator:</label>
	  <select name="type">
		  <option value="admin">admin</option>
		  <option value="user">user</option>
	</select>
	  <p> 
	  <button class="button">Creaza-ti cont</button>
	 </div>
      </form>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>

</body>
</html>

