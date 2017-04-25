<!DOCTYPE HTML PUBLIC ">
<html>
<head>
<title>Deton</title>
</head>
<body>
<h2>Cauta un detinut</h2>

<?php 

function get_input($prenume = "", $nume = "", $nrDosar="") 
{
  echo <<<END
  <form action="cauta_dupa_nume.php" method="post">

    <label for="Prenume">
    <span>Prenume*</span>
    <input type="text" name="prenume" value="$prenume">
  </label>

  <label for="Nume">
    <span>Nume*</span>
    <input type="text" name="nume" value="$nume">
  </label>

  <br> <br>
   SAU
   <br> <br>

   <label for="Nr. Dosar">
    <span>Nr. Dosar**</span>
    <input type="text" name="nrDosar" value="$nrDosar">
    <br> ex:358956/5/1997 <br>
   </label>
  <p> 

  <input type="submit">
</form>
END;
echo "*Puteti introduce numele complet sau o serie de caractere .
   <br> ** Numarul de dosar trebuie sa fie complet si corect.
   <p>"; 

} 

if(!isset($_REQUEST['prenume'])) {
   
   get_input();

}
// nu a fost completat nici un camp
elseif (empty($_REQUEST['prenume']) and empty($_REQUEST['nume']) and empty($_REQUEST['nrDosar']))  
  {
    echo "Trebuie sa completati prenumele si numele sau numarul de dosar.<p>"; 
    get_input($_REQUEST['prenume'],$_REQUEST['nume'],$_REQUEST['nrDosar']);
  }
  //cautare dupa nume si prenume
  elseif (isset($_REQUEST['prenume']) and isset($_REQUEST['nume']) and empty($_REQUEST['nrDosar']))
  {
    $conn = oci_connect("Student","STUDENT", "localhost");
    if(!$conn)
    {
      echo "An error occured connecting to the database.";
      get_input();
    }
    $prenume= $_REQUEST['prenume'];
    $nume=$_REQUEST['nume'];

    $sql ="select user_package.cautare_by_nume('$nume','$prenume') from dual";
    $stmt = oci_parse($conn , $sql);
    if(!$stmt) {
      echo "An error occurred in parsing the sql string.\n";
      exit;
    }
    oci_execute($stmt);    
    if(oci_fetch($stmt))
    { 
      $rezultat = ociresult($stmt,1);
      if($rezultat == 1 )
        echo "Aceasta persoana se afla intr-una din institutiile manageriate de noi!";
      else 
        echo "Aceasta persoana NU se afla intr-una din institutiile manageriate de noi!";
    }
    else {
      echo "An error occurred in retrieving book id.\n";
      exit;
    }
  }
  //cautare dupa dosar 
  elseif(empty($_REQUEST['prenume']) and empty($_REQUEST['nume']) and isset($_REQUEST['nrDosar']))
  {
    echo "Cautare dupa dosar ";
    $conn = oci_connect("Student","STUDENT", "localhost");
    if(!$conn)
    {
      echo "An error occured connecting to the database.";
      get_input();
    }
    $nrDosar = $_REQUEST['nrDosar'];

    $sql ="select user_package.cautare_by_dosar('$nrDosar') from dual";
    $stmt = oci_parse($conn , $sql);
    if(!$stmt) {
      echo "An error occurred in parsing the sql string.\n";
      exit;
    }
    oci_execute($stmt);    
    if(oci_fetch($stmt))
    { 
      $rezultat = ociresult($stmt,1);
      if($rezultat == 1 )
        echo "Persoana condamnata in dosarul cu nr ".$nrDosar." se afla intr-una din institutiile manageriate de noi!";
      else 
        echo "Persoana condamnata in dosarul cu nr ".$nrDosar." Nu se afla intr-una din institutiile manageriate de noi!";
    }
    else {
      echo "An error occurred in retrieving book id.\n";
      exit;
    }
  }  
  //toate campurile au fost completate
  elseif (isset($_REQUEST['prenume']) and isset($_REQUEST['nume']) and isset($_REQUEST['nrDosar'])) 
  {
    echo "Trebuie sa completati prenumele si numele sau numarul de dosar, nu toate campurile.<p>"; 
    get_input();
  }

?>
</body>
</html>