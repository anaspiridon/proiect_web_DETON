<html>
<link href="statistici.css" type="text/css" rel="stylesheet">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>DETON</title>
</head>
<body bgcolor="#EEEEEE">

<ul class="navigation">
    <li class="nav-item"><a href="meniu_admin.php">Acasa</a></li>
	  <li class="nav-item"><a href="vizualizare_detinuti.php">Lista detinuti</a></li>
    <li class="nav-item"><a href="#">Optiuni detinuti <span class="sub-navigation"></span></span></a>
        <ul> 
            <li> <a href="sterge_detinuti.php">Sterge detinut</a></li>
            <li> <a href="insereaza_detinut.php">Insereaza detinut </a></li>
        </ul>
    </li>
    <li class="nav-item"><a href="statistici.php">Statistici</a></li>
    <li class="nav-item"><a href="vizualizare_vizite.php">Lista Vizitelor</a></li>
     <li class="nav-item"><a href="login.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>


<div class="site-wrap" >
<h1> Statistici</h1>
<?php 

function get_input($id_institutie = "") 
{
  echo <<<END
  <p>
  <form action="functii.php" method="post">
  <h2>Distributia detinutilor pe institutii:</h2>
  <select name="id_institutie">

      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <br>
      <input type="button" class="button" value="Input Button">
</select>
 </p>
  </form>
END;
}
function get_date_medie($ptMedie='')
{
    echo <<<END
    <p>
<form action="functii.php" method="post">
<h2> Doriti sa vizualizati media vizitelor in ultima luna? </h2>
 <select name="ptMedie">

      <option value="1">DA</option>
      <option value="2">NU</option>
 <\select>     
 <br>
 <input type="button" class="button" value="Input Button">
</form>
</p>
END;
}

function get_max_vizite ($ptMax='')
{
echo <<<END
<p>
<form action="functii.php" method="post">
<h2> Doriti sa vizualizati persoana cu cele mai multe vizite in ultimul an? </h2>
 <select name="ptMax">

      <option value="1">DA</option>
      <option value="2">NU</option>
 <\select>     
<br>
  <input type="button" class="button" value="Input Button">
</form>
</p>
END;
}

if(!isset($_REQUEST['id_institutie']) and !isset($_REQUEST['ptMedie']) and !isset($_REQUEST['ptMax'])) 
{
  get_input();
  get_date_medie();
  get_max_vizite();
}
elseif(isset($_REQUEST['id_institutie']) and empty($_REQUEST['ptMedie']) and empty($_REQUEST['ptMax']))
{
  $idinstitutie=$_REQUEST['id_institutie'];
  get_input();
  $conn = oci_connect("Student","STUDENT", "localhost");
  $sql = "select distributia_institutie($idinstitutie) from dual";
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
  if(oci_fetch($stmt))
  {
    $id=ociresult($stmt,1);
  }
  echo $id.'%';
  get_date_medie();
  get_max_vizite();
}
elseif(empty($_REQUEST['id_institutie']) and isset($_REQUEST['ptMedie']) and empty($_REQUEST['ptMax']))
{
  $vol=$_REQUEST['ptMedie'];
  if($vol==1)
  {
    get_input();
    get_date_medie();
    $conn = oci_connect("Student","STUDENT", "localhost");
    $sql = "select media_vizite from dual";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    if(oci_fetch($stmt))
    {
      $id=ociresult($stmt,1);
    }
    echo $id;
    get_max_vizite();
  }
  else 
  {
    get_input();
    get_date_medie();
    get_max_vizite();
  }
}
elseif(empty($_REQUEST['id_institutie']) and empty($_REQUEST['ptMedie']) and isset($_REQUEST['ptMax']))
{
  $vol1=$_REQUEST['ptMax'];
  if($vol1==1)
  {
    get_input();
    get_date_medie();
    get_max_vizite();
    $conn = oci_connect("Student","STUDENT", "localhost");
    $sql = "select max_vizite from dual";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    if(oci_fetch($stmt))
    {
      $id=ociresult($stmt,1);
    }
    echo $id;
   
  }
  else 
  {
    get_input();
    get_date_medie();
    get_max_vizite();
  }
}

?>
</div>
</body>
</html>