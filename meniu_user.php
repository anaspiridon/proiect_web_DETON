<!DOCTYPE HTML >
<html>
<head>
  <title>WELCOME</title>

</head>
<div id="Form"> 

<form action="meniu_user.php" method="post">

  Nume: <input type="text" align="right" name="nume" value="">
  <br><br>
  Prenume: <input type="text" name="prenume" value="">
  <br><br>
  Email: <input type="text" name="email" value="">
  <br><br>
  Telefon: <input type="text" name="telefon" value="">
  <br><br>
  Adresa: <input type="text" name="adresa" value="">
  <br><br>
  Subiect: <input type="text" name="subiect" value="">
  <br><br>
  Continut: <input type="text" name="continut" value="">
  <br><br><br><br>
  <input type="submit">  
</form>
</div>
<style type="text/css">
#Form {
    position:relative;
    float:right;
    border: 2px solid #003B62;
    font-family: verdana;
    background-color: #FFE4C4;
    padding-left: 10px;
     height: 400px;
}

.container {
		font-weight: normal;
		color: #0088dd;

		text-align: center;
            }
</style>

<body bgcolor="#EEEEEE">
<h2 align="center">Meniu User </h2> <br><br>

<div class="container">
    <!-- other content -->
    
<p><a href="cauta_dupa_nume.php">Cauta detinut</a></p>
<p><a href="pedepse.php">Pedepse </a><p>
</div> 
</body>


</html>