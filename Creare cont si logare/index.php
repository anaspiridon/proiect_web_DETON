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
session_start();

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
      <option value="secretara">secretara</option>
      <option value="superadmin">super admin</option>
      <option value="detinut">detinut</option>
      <option value="vizitator">vizitator</option>
</select>
  <p>  
 <button class="button">Conectează-te</button>
  </form>
 </div> 
END;
    
}

if (!isset($_REQUEST['username']))
 {
    get_input();
} 
else {
    
     if (empty($_REQUEST['username']) or empty($_REQUEST['password'])) {
        echo '<script language="javascript">';
        echo 'alert("Nu ai introdus informatii in ambele campuri! Te rugam incerca din nou!")';
        echo '</script>';
        get_input($_REQUEST['username'], $_REQUEST['password']);
      }
     else
       {
        
        $conn = oci_connect("Student", "STUDENT", "localhost");
        
        if (!$conn) {
            echo '<script language="javascript">';
            echo 'alert("Eroare la conectarea la baza de date")';
            echo '</script>';
            get_input();
        }
        
        $username = $_REQUEST['username'];
       // $password = base64_decode($_REQUEST['password']);
	   $password = $_REQUEST['password'];
        $type     = $_POST['type'];
        $verif=0;
        if($type=="superadmin")
        {
          $sql  = "select id from utilizatorsuperadmindeton where username= :bind1 and password= :bind2 ";
          $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind1", $username);
          oci_bind_by_name($stmt, ":bind2", $password);
          if (!$stmt) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
           get_input();
          }
          oci_execute($stmt, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt)) 
          {
            $_SESSION['tip']=$type;;
            $verif=1;
            $_SESSION['tip']=$type;
            $_SESSION['id_detinut']=ociresult($stmt,1);
           
            
          } 
           else 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred data!")';
            echo '</script>';
            get_input();

          }
          header('Location:http://localhost/fisiere/DETON/meniu_admin.php');          
        }

        elseif($type=="admin" or $type=="secretara" )
        {
          $sql  = "select id_institutie from utilizatorideton where username= :bind1 and password= :bind2 and tip= :bind3";
          $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind1", $username);
          oci_bind_by_name($stmt, ":bind2", $password);
          oci_bind_by_name($stmt, ":bind3", $type);
          if (!$stmt) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            get_input();
          }
          oci_execute($stmt, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt)) 
          {
            $id_institutie = OCIResult($stmt, 1);
            $_SESSION['id_institutie']=$id_institutie;
            $_SESSION['tip']=$type;
            $verif=1;

          } 
          else 
          {
            echo '<script language="javascript">';
            echo 'alert("Datele introduse nu sunt corecte!")';
            echo '</script>';
            get_input();
          }
		  if($verif==1){
          if($type=='admin')
          {
            header('Location:http://localhost/fisiere/DETON/meniu_admin.php');
          }
		  else{
			  header('Location: http://localhost/site/proiectDeton/StergereInserareSec.php');
		  }
		  }
        }

        elseif($type=="vizitator")
        {
          echo "vizitator";
          $sql  = "select id_vizitator from userVizitatorDeton where username= :bind1 and password= :bind2 and tip = :bind3";
          $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind1", $username);
          oci_bind_by_name($stmt, ":bind2", $password);
          oci_bind_by_name($stmt,":bind3", $type);

          if (!$stmt) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            get_input();
          }

          oci_execute($stmt, OCI_NO_AUTO_COMMIT);

          if ( oci_fetch($stmt)) 
          {
            $_SESSION['id_vizitator']=ociresult($stmt,1);
            echo "am facut fetch";
            $_SESSION['tip']=$type;
            $verif=1;
            
          } 
          else 
          {
            echo '<script language="javascript">';
            echo 'alert("Datele intrduse nu sunt corecte!!")';
            echo '</script>';
            get_input();
			
          }
          header('Location:http://localhost/site/proiectDeton/verif_detinut2.php');
        }

        elseif($type=='detinut')
        {
          $sql  = "select id_detinut from userdetinutDeton where username= :bind1 and password= :bind2 ";
          $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":bind1", $username);
          oci_bind_by_name($stmt, ":bind2", $password);


          if (!$stmt) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            get_input();
          }

          oci_execute($stmt, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt)) 
          {
            $_SESSION['tip']=$type;
            $_SESSION['id_detinut']=ociresult($stmt,1);
			
            $verif=1;
          } 
          else 
          {
            echo '<script language="javascript">';
            echo 'alert("Datele intrduse nu sunt corecte!!")';
            echo '</script>';
            get_input();
          }
           header('Location:http://localhost/site/proiectDeton/check.php');
        }

        if($verif=0)
        {
            echo '<script language="javascript">';
            echo 'alert("User gresit!")';
            echo '</script>';
            get_input();

        }
      }
    }
?>


<button id="myBtn">Creaza cont nou</button>
<?php function get_imput($nume = '', $prenume = '', $parola = '', $tip = '', $tipe = ''){ ?>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
      <form method="post" >
    <label for="username" >Nume :</label>
    <input type="text" name="nume" placeholder="Numele tău...">

    <label for="username" >Prenume :</label>
    <input type="text" name="prenume" placeholder="Prenumele tău...">
    <br>

     <label for="password" >Parola</label>
    <input type="password" name="password" >
    <br>

    <label for="type">Tip utilizator:</label>
    <select name="type">
      <option value="admin">admin</option>
      <option value="secretara">secretara</option>
      <option value="superadmin">super admin</option>
      <option value="detinut">detinut</option>
      <option value="vizitator">vizitator</option>
  </select>
     </label> 
	  <label for="type">Institutie detinut</label> 
     <select name="typee">

  <option value="niciuna">-</option>
  <option value="1">Scoala de corectie Iasi</option>
  <option value="2">Scoala de corectie Bacau</option>
   <option value="3">Scoala de corectie Timisoara</option>
  <option value="4">Scoala de corectie Brasov</option>
   <option value="5">Scoala de corectie Vaslui</option>
  <option value="6">Scoala de corectie Cluj</option>
   <option value="7">Inchisoare Bacau</option>
  <option value="8">Inchisoare Timisoara</option>
   <option value="9">Inchisoare Brasov</option>
  <option value="10">Inchisoare Vaslui</option>
   <option value="11">Inchisoarea Iasi</option>
  <option value="12">Inchisoarea Constanta</option>
   <option value="13">Penitenciar Bihor</option>
  <option value="14">Penitenciar Braila</option>
   <option value="15">Penitenciar Botosani</option>
  <option value="16">Penitenciar Constanta</option>
   <option value="17">Penitenciar Iasi</option>
  <option value="18">Penitenciar Vaslui</option>
   <option value="19">Inchisoare de maxima securitate Braila</option>
  <option value="20">Inchisoare de maxima securitate Botosani</option>
   <option value="21">Inchisoare de maxima securitate Iasi</option>
  <option value="22">Inchisoare de maxima securitate Vaslui</option>
   <option value="23">Inchisoare de maxima securitate Bihor</option>
  <option value="24">Inchisoare de maxima securitate Galati</option>
   <option value="25">Inchisoare de maxima securitate Tulcea</option>
  
</select>
  </label>
	
    <button class="button">Creaza-ti cont</button>
   </div>
      </form>

  </div>

</div>
<?php } ?>
      <?php
	  
	  
   get_imput();
 
  if(isset($_REQUEST['nume']))
  {
				  if(empty($_REQUEST['nume']) or empty($_REQUEST['prenume']) or empty($_REQUEST['password']) or empty ($_REQUEST['type']) or empty ($_REQUEST['typee']) or ( !preg_match ("/^[a-zA-Z\s]+$/",$_REQUEST['nume'])) or ( !preg_match ("/^[a-zA-Z\s]+$/",$_REQUEST['nume'])))
				  { echo '<script language="javascript">';
						  echo 'alert("Pentru crearea unui cont nou este necesara completarea tuturor spatilor si este permisa doar folosirea literelor!")';
						  echo '</script>';} 
				    else{	  
				  
				  $conn = oci_connect("Student", "STUDENT", "localhost");
				 
					$nume = $_REQUEST['nume'];
					$prenume = $_REQUEST['prenume'];
					$parola = $_REQUEST['password'];
					$tip = $_REQUEST['type'];
					$tipe = $_REQUEST['typee'];
					
					if($tip=='vizitator')	
						{
						$sql = "SELECT count(*) from userVizitatorDeton";
						  $stmt         = oci_parse($conn, $sql);
						  if (!$stmt) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt);
						  if (oci_fetch($stmt)) 
						  {
						   $id = ociresult($stmt, 1);
						   echo $id;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
				 
				 
							$id_cont = $id + 1; 
							//$pass = md5($parola);
				 
				
							$sql3="select count(*) from userVizitatorDeton where trim(username)=trim(lower('$prenume')||'.'||lower('$nume'))";
							 $stmt2 = oci_parse($conn, $sql3);
				  
							
						  if (!$stmt2) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt2);
						  if (oci_fetch($stmt2)) 
						  {
						   $id2 = ociresult($stmt2, 1);
						   echo $id2;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
									 
						 if($id2==0){
				  $pass=base64_encode($parola);
				  $sqli ="insert into userVizitatorDeton(ID,id_vizitator, nume, prenume, username, password, tip) VALUES($id_cont, $id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume), :password, :type)";
				  
				  
				   $sqlin  = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}	

				
				 $pass=base64_encode($parola);
				if($id2!=0){
					$sqli ="insert into userVizitatorDeton(ID,id_vizitator, nume, prenume, username, password, tip) VALUES($id_cont, $id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume)||'$id_cont', :password, :type)";
				  
				  
				   $sqlin       = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}

						}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



				if($tip=='superadmin')	
						{
						$sql = "SELECT count(*) from utilizatorSuperAdminDeton";
						  $stmt         = oci_parse($conn, $sql);
						  if (!$stmt) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt);
						  if (oci_fetch($stmt)) 
						  {
						   $id = ociresult($stmt, 1);
						   echo $id;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
				 
				 
							$id_cont = $id + 1; 
							//$pass = md5($parola);
				 
				
							$sql3="select count(*) from utilizatorSuperAdminDeton where trim(username)=trim(lower('$prenume')||'.'||lower('$nume'))";
							 $stmt2 = oci_parse($conn, $sql3);
				  
							
						  if (!$stmt2) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt2);
						  if (oci_fetch($stmt2)) 
						  {
						   $id2 = ociresult($stmt2, 1);
						   echo $id2;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
									 
						 if($id2==0){
				  $pass=base64_encode($parola);
				  $sqli ="insert into utilizatorSuperAdminDeton(ID, nume, prenume, username, password, tip) VALUES($id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume), :password, :type)";
				  
				  
				   $sqlin  = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}	

				
				 $pass=base64_encode($parola);
				if($id2!=0){
					$sqli ="insert into utilizatorSuperAdminDeton(ID, nume, prenume, username, password, tip) VALUES($id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume)||'$id_cont', :password, :type)";
				  
				  
				   $sqlin       = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}

						}
			 
	 
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	 
	 
						if(($tip=='detinut') and ($tipe=='niciuna'))
						{
							echo '<script language="javascript">';
						  echo 'alert("Pentru crearea unui asemenea cont este necesara alegerea institutiei de care apartineti!")';
						  echo '</script>';
						}
							elseif(($tip=='detinut')	and ($tipe!='niciuna')){
								
								
								
								$verif="select count(*) from detinuti where trim(nume)=trim(lower('$nume')) and trim(prenume)=trim(lower('$prenume')) and id_institutie=$tipe ";
								
								$stmtv         = oci_parse($conn, $verif);
								  if (!$stmtv) 
								  {
									echo "An error occurred in parsing the sql string.\n";
									exit;
								  }
							  
								  oci_execute($stmtv);
								  if (oci_fetch($stmtv)) 
								  {
								   $idv = ociresult($stmtv, 1);
								   echo $idv;
								  }
								  else 
								   {
									echo "An error occurred in retrieving book id.\n";
									exit;
								   }	
								
								
								
								if($idv==0){
									
									echo '<script language="javascript">';
									  echo 'alert("Nu apari in baza de date a acestei institutii!")';
									  echo '</script>';
									
								}else{
								
	
							
						$sql = "SELECT count(*) from userDetinutDeton";
						  $stmt         = oci_parse($conn, $sql);
						  if (!$stmt) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt);
						  if (oci_fetch($stmt)) 
						  {
						   $id = ociresult($stmt, 1);
						   echo $id;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
				 
				 
							$id_cont = $id + 1; 
							//$pass = md5($parola);
				 
				
							$sql3="select count(*) from userDetinutDeton where trim(username)=trim(lower('$prenume')||'.'||lower('$nume'))";
							 $stmt2 = oci_parse($conn, $sql3);
				  
							
						  if (!$stmt2) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt2);
						  if (oci_fetch($stmt2)) 
						  {
						   $id2 = ociresult($stmt2, 1);
						   echo $id2;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
									 
						 if($id2==0){
				  $pass=base64_encode($parola);
				  $sqli ="insert into userDetinutDeton(ID,id_detinut, nume, prenume, username, password, tip, id_institutie) VALUES($id_cont,$id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume), :password, :type, :typee)";
				  
				  
				   $sqlin  = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  oci_bind_by_name($sqlin, ":typee", $tipe);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}	

				
				 $pass=base64_encode($parola);
				if($id2!=0){
					$sqli ="insert into userDetinutDeton(ID,id_detinut, nume, prenume, username, password, tip, id_institutie) VALUES($id_cont,$id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume)||'$id_cont', :password, :type, :typee)";
				  
				  
				   $sqlin       = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  oci_bind_by_name($sqlin, ":typee", $tipe);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}

						}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
						if((($tip=='admin') or ($tip=='secretara')) and ($tipe=='niciuna'))
						{
							echo '<script language="javascript">';
						  echo 'alert("Pentru crearea unui asemenea cont este necesara alegerea institutiei de care apartineti!")';
						  echo '</script>';
						}
							elseif((($tip=='admin') or ($tip=='secretara')) and ($tipe!='niciuna')){
							
						$sql = "SELECT count(*) from utilizatoriDeton";
						  $stmt         = oci_parse($conn, $sql);
						  if (!$stmt) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt);
						  if (oci_fetch($stmt)) 
						  {
						   $id = ociresult($stmt, 1);
						   echo $id;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
				 
				 
							$id_cont = $id + 1; 
							//$pass = md5($parola);
				 
				
							$sql3="select count(*) from utilizatoriDeton where trim(username)=trim(lower('$prenume')||'.'||lower('$nume'))";
							 $stmt2 = oci_parse($conn, $sql3);
				  
							
						  if (!$stmt2) 
						  {
							echo "An error occurred in parsing the sql string.\n";
							exit;
						  }
					  
						  oci_execute($stmt2);
						  if (oci_fetch($stmt2)) 
						  {
						   $id2 = ociresult($stmt2, 1);
						   echo $id2;
						  }
						  else 
						   {
							echo "An error occurred in retrieving book id.\n";
							exit;
						   }	
									 
						 if($id2==0){
				  $pass=base64_encode($parola);
				  $sqli ="insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) VALUES($id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume), :password, :type, :typee)";
				  
				  
				   $sqlin  = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  oci_bind_by_name($sqlin, ":typee", $tipe);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}	

				
				 $pass=base64_encode($parola);
				if($id2!=0){
					$sqli ="insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) VALUES($id_cont, :nume, :prenume, lower(:prenume)||'.'||lower(:nume)||'$id_cont', :password, :type, :typee)";
				  
				  
				   $sqlin       = oci_parse($conn, $sqli);
				  if(!$sqlin)
				  {
					  echo "something wrong";
				  }

				  oci_bind_by_name($sqlin, ":nume", $nume);
				  oci_bind_by_name($sqlin, ":prenume", $prenume);
				  oci_bind_by_name($sqlin, ":password", $pass);
				  oci_bind_by_name($sqlin, ":type", $tip);
				  oci_bind_by_name($sqlin, ":typee", $tipe);
				  
				  oci_execute($sqlin, OCI_DEFAULT);
				  
				  oci_commit($conn);
				  oci_free_statement($sqlin);
				}

						}

							}
}
	 
  } 
	 
	 
?>
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
