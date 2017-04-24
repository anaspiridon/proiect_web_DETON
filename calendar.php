<?Php

$start_year = 2017; // Starting year for dropdown list box
$end_year   = 2018; // Ending year for dropdown list box

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
self.location='calendar.php?month=' + month_val + '&year=' + year_val ; // reia pagina
}


</script>
<style type="text/css">
table.main {
  height: 80%;
  width: 60%; 
  border: 3px solid black;
 background-color: transparent;
}
table.main td {

font-family: verdana,arial, helvetica,  sans-serif;
font-size: 34px;
}
table.main th {
    border-width: 1px 1px 1px 1px;
    padding: 0px 0px 0px 0px;
   background-color: #FF6600;
}

table.main a{TEXT-DECORATION: none;
            color:black;}

table,td{ border: 2px solid black}

tr:nth-child(even) {
   background-color: #FF6600;
}
</style>


</script>
<style type="text/css">
table.main {
  height: 80%;
  width: 60%; 
  border: 3px solid black;
 background-color: transparent;
 align-content: right;
}
table.main td {

font-family: verdana,arial, helvetica,  sans-serif;
font-size: 34px;
}

table.main th {
    border-width: 1px 1px 1px 1px;
    padding: 0px 0px 0px 0px;
   background-color: #FF6600;
}

table.main a{TEXT-DECORATION: none;
            color:black;}

table,td{ border: 2px solid black}
</style>


</head>
<body>



<ul class="navigation">
    <li class="nav-item"><a href="meniu_admin.php">Acasa</a></li>
    <li class="nav-item"><a href="test.php">Despre</a></li>
  
    <li class="nav-item"><a href="functii.php">Contact</a></li>
    <li class="nav-item"><a href="programare_online.php">Programare online</a></li>
    <li class="nav-item"><a href="#">Obiecte permise la vizita</a></li>
    <li class="nav-item"><a href="login.php">Log out</a></li>
</ul>

<input type="checkbox" id="nav-trigger" class="nav-trigger" />
<label for="nav-trigger"></label>
<div class="site-wrap">




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
for ($p = 1; $p <= 12; $p++) {
    
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


for ($i = 1; $i <= $no_of_days; $i++) {
    $pv = "'$month'" . "," . "'$i'" . "," . "'$year'";
    echo $adj . "<td><a href=\"#openModal1\">$i</a>"; // Zilele din interiorul calendarului
    echo " </td>";
    $adj = '';
    $j++;
    if ($j == 7) {
        echo "</tr><tr>"; // incepe un rad nou
        $j = 0;
    }
    
}
echo $adj2; // casute libere

echo "<tr><td colspan=7 align=center></td></tr>";
echo "</tr></table>";
echo "<center><a href=calendar.php>Reset Calendar</a></center>";

?>


<div id="openModal1" class="modalDialog">
<div>
    <a href="#close" title="Close" class="close">X</a>
    <h2>Programare online</h2> <br><br>
    <p> Pentru programarea unei vizite va rugam sa completati acest formular cu datele dumeavoastra
    din buletin. <br> <br>Daca doriti sa vizitati un detinut cu un vizitator ce si-a creat cont va rugam sa introduceti username-ul vizitatorului. </p><br>

    

    <p><form action="#openModal2" method="post">
<div>
<label for="username" >Seria:</label>
  <input type="text"  maxlength="2" style="text-transform:uppercase" 
  placeholder="Seria buletinului tau...">
  <label for="nr" >NR:</label>
 <input name="nr"
    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    type = "number"
    maxlength = "6"/>
<br><br>
 <label for="adresa" >Adresa de domiciliu:</label><br>
  <input type="adresa" name="adresa" placeholder="Adresa de domiciliu...">
  <br><br>

<label for="username" >Username vizitator invitat:</label><br>
  <input type="username" name="username" placeholder="Username-ul prietenului tau...">
  <br><br>

  <p> 
  <button> Trimite </button>

  </div>
  </form>
</div>
</div>

</div>

 <div id="openModal2" class="modalDialog">
<div>
    <a href="#close" title="Close" class="close">X</a>
    <h2>Programare online</h2><br><br>
    <h3>Va multumim!</h3><br>
    <p><strong>Veti primi confirmarea vizitei prin email!</strong></p>
    
</div>


</div>

</body>
</html>

</body>
</html>
