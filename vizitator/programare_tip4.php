<?Php
session_start();
$start_year = 2017; // Starting year for dropdown list box
$end_year   = 2017; // Ending year for dropdown list box

?>

<!doctype html public >
<html>
<link href="calendar.css" type="text/css" rel="stylesheet">
<head>
<title>DETON</title>

<script langauge="javascript">
function post_value(mm,dt,yy){
opener.document.f1.p_name.value = mm + "/" + dt + "/" + yy;
// date format
self.close();
}

function reload(form){
var month_val=document.getElementById('month').value; // colecteaza lunile
var year_val=document.getElementById('year').value;      // colecteaza anii
self.location='programare_tip2.php?month=' + month_val + '&year=' + year_val ; // reia pagina
}

</script>

</head>
<body>

<ul class="navigation">
    <li class="nav-item"><a href="#">Acasa</a></li>
 
  
    <li class="nav-item"><a href="#">Contact</a></li>
   <li class="nav-item"><a href="verif_detinut2.php">Programare online</a></li>
        <li class="nav-item"><a href="#">Acces penitenciar <span class="sub-navigation"></span></span></a>
        <ul>

            <li> <a href="obiecte_permise.php">Obiecte permise la vizita</a></li>
            <li> <a href="obiecte_nepermise.php">Obiecte nepermise la vizita </a></li>
        </ul>
        <li class="nav-item"><a href="LoginCriptat.php">Log out</a></li>
    </li>
 
    
</ul>


<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>
<div class="site-wrap">

<h1>Bine ati venit la Programare Online!</h3> <br><br><br>
<h3>Acordarea dreptului la vizita pentru detinuti se efectueaza pe baza unei programari prealabile. Programarea se face inainte de data prezentarii in vederea acordarii vizitei.
Solicitarea unei programari se face astfel:
Apasati click pe una din zilele in care doriti sa va programati si urmati pasii indicati pentru
a completa formularul.  Ca urmare a intrarii in vigoare a Deciziei 470/13.06.2016 privind ,,Procedura de lucru pentru programarea prealabila a vizitei", incepand cu data de 01.07.2016:</h3> <br><br>
<h2>
<ol>
<li>In cazul in care persoanele vizitatoare intarzie fata de ora la care au fost programate, vizita nu se mai acorda, urmand să se solicite o alta programare la o dată ulterioara.</li>
 
<li>Intervalul de timp dintre momentul solicitarii unei programari și momentul acordarii efective a vizitei nu poate fi mai mare de 5 zile.</li>
</h2></ol><br><br>
<h2>Programul vizitelor: luni si marti intre orele 9:00-10:30 si 10:00-12:00</h2><br>



<?Php
@$month = $_GET['month'];
@$year = $_GET['year'];

if (!($month < 13 and $month > 0)) {
    $month = date("m"); // luna curenta as default
}

if (!($year <= $end_year and $year >= $start_year)) {
    $year = date("Y"); // seteaza anul ca default 
}

$d = 2; // pt a gasi data de azi

$no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year); //calculeaza numarul de zile intr-o luna

$j = date('w', mktime(0, 0, 0, $month, 1, $year)); // asta o sa calculeze prima zi din sapt din luna

$j = $j - 1;
if ($j < 0) {
    $j = 6;
}

$adj          = str_repeat("<td bgcolor='transparent'>&nbsp;</td>", $j); // casute libere
$blank_at_end = 42 - $j - $no_of_days; // zilele ramase dupa ultima zi din luna
if ($blank_at_end >= 7) {
    $blank_at_end = $blank_at_end - 7;
}
$adj2 = str_repeat("<td bgcolor='transparent'>&nbsp;</td>", $blank_at_end); // casute libere

//alege luna

echo "<table class='main'><td colspan=6 >

<select name=month value='' onchange=\"reload(this.form)\" id=\"month\">
<option value=''>Select Month</option>";
for ($p = 6; $p <= 12; $p++) {
    
    $dateObject = DateTime::createFromFormat('!m', $p);
    $monthName  = $dateObject->format('F');
    if ($month == $p) {
        echo "<option value=$p selected>$monthName</option>";
    } else {
        echo "<option value=$p>$monthName</option>";
    }
}
echo "</select>
<select name=year value='' onchange=\"reload(this.form)\" id=\"year\">Select Year</option>
";
for ($i = $start_year; $i <= $end_year; $i++) {
    if ($year == $i) {
        echo "<option value='$i' selected>$i</option>";
    } else {
        echo "<option value='$i'>$i</option>";
    }
}
echo "</select>";

echo " </td><td align='center'><a href=# onClick='self.close();'>X</a></td></tr>";

echo "<tr><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th></tr><tr>";

$contor=0;
for ($i = 1; $i <= $no_of_days; $i++) {
  $contor=$contor+1;
    $pv = "'$month'" . "," . "'$i'" . "," . "'$year'";

$tgl = "$i"."-"."$month"."-"."$year";

 
 // $time=strtotime($tgl);
 $my_date = date('d/F/y', strtotime($tgl));
 $string=$my_date;
 var_dump($string);
$new_date=date('d-m-y', strtotime($string));
echo $new_date."noua data";
var_dump($my_date);

$detinut=$_SESSION['id_detinut1'];
    $conn = oci_connect("Student","STUDENT", "localhost");

   if (!$conn)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

$sql = "SELECT verif_data_tip4 ('$my_date', '$detinut' ) from dual";
$stmt = oci_parse($conn, $sql);


if(!$stmt) {
  echo "An error occurred in parsing the sql string.\n";
  exit;
}
 
  oci_execute($stmt);


if(oci_fetch($stmt)) {
  $rez= OCIResult($stmt,1); 
}else {
  echo "An error occurred data \n";
  exit;
}

$verif=(int)$rez;
//  echo $_SESSION['tip'];
echo $_SESSION['id_detinut1'];
echo $_SESSION['id_institutie'];
          
    if($verif==0 )
   { echo $adj . "<td><div class=\"dropdown\">
  <span>$i</span>
  <div class=\"dropdown-content\">
    <p>Ziua aleasa nu este disponibila!</p>
  </div>
</div>"; // Zilele din interiorul calendarului
     echo " </td>";

  }elseif($verif==2){
    echo $adj . "<td><div class=\"dropdown\">
  <span>$i</span>
  <div class=\"dropdown-content\">
    <p>Ziua aleasa nu este disponibila!</p>
  </div>
</div>"; // Zilele din interiorul calendarului
     echo " </td>";



  }elseif($verif==1) {
     echo $adj . "<td><a href=\"#openModal?data=$my_date\">$i</a>"; // Zilele din interiorul calendarului
    echo " </td>";
    }

    $adj = '';
    $j++;
    if ($j == 7) {
        echo "</tr><tr>"; // incepe un rad nou
        $j = 0;
    }
    $all="openModal?data=".$my_date;
 ?> 
 <div id=<?php echo $all;?> class="modalDialog">
<div align="center">
    <a href="#close" title="Close" class="close">X</a>
    <h2>Programare online</h2> <br><br>
     <h3>Pentru programarea unei vizite va rugam sa completati acest formular cu datele dumneavoastra. </h3><br>



   <p><form  method="post" action="download-ics4.php">
<div>

<input type="hidden" name="data_program" value=<?php echo $my_date;?>

<label for="nume" >Nume:</label><br>
<input id="cc" name="nume" type="text" required />
<div class="input-validation"></div>
<br>


<label for="prenume" >Prenume:</label><br>
<input id="cc" name="prenume" type="text" required />
<div class="input-validation"></div>

<label for="email" >Email:</label><br>
<input id="cc" name="email" type="email" required />
<div class="input-validation"></div>

<br>
<label for="telefon" >Telefon:</label><br>
<input id="cc" name="telefon" type="tel" required>
<div class="input-validation"></div>
<br>    

  <label for="adresa" >Intervalul orar:</label><br>

 <select name="type">

  <option value="12:00-12:30">10:00-10:15</option>
  <option value="12:30-13:00">10:15-10:30</option>
   <option value="13:00-13:30">10:30-10:45</option>
  <option value="13:30-14:00">10:45-11:00</option>
   <option value="14:00-14:30">11:00-11:15</option>
  <option value="14:30-15:00<">11:15-11:30</option>
   <option value="15:00-15:30">11:30-11:45</option>
  <option value="15:30-16:00">11:45-12:00</option>

</select>
<br>
  <p> 
    <button> Trimite </button><br>
  <input type="checkbox" name="checkbox" value="check" id="agree" /> I have read and agree to the Terms and Conditions and Privacy Policy
</div>
</form>
</div>
</div>

</div>
<?php  
  }  

echo $adj2; // casute libere

echo "<tr><td colspan=7 align=center></td></tr>";
echo "</tr></table>";
echo "<center><a href=programare_tip2.php>Reset Calendar</a></center>";
$sql3="SELECT * FROM (SELECT ID_PROGRAMARE4 FROM programare_vizita_tip4  WHERE ROWNUM <= (select count(*) from programare_vizita_tip4 ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2";

$stmt3 = oci_parse($conn, $sql3);



if (!$stmt3) 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred in parsing the sql string!")';
            echo '</script>';
            exit;
          }
          oci_execute($stmt3, OCI_NO_AUTO_COMMIT);

          if (oci_fetch($stmt3)) 
          { $id = ociresult($stmt3,1);
       
            
          } 
           else 
          {
            echo '<script language="javascript">';
            echo 'alert("An error occurred data id programare!")';
            echo '</script>';
            exit;
          }

$id_programare=$id+1;
echo $id_programare;


?>


</div>


</body>
</html>


