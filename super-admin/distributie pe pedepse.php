<!DOCTYPE html>
<html>
    <head>
        <title>Top Categories of New Year's Resolution</title>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </head>
 
    <?php
      $conn = oci_connect("Student", "STUDENT", "localhost");

      $sql="select count(id_detinut) as mister from detinuti group by id_pedeapsa ";
      $stmt=oci_parse($conn,$sql);
      oci_execute($stmt);
        $row = oci_fetch_array($stmt);    
        $dataPoints = array(
            array("y" => $row['MISTER'], "name" => "Crima"));
        $sum=0;
        $row=oci_fetch_array($stmt);
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "posesie")); $sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "prostitutie"));$sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "viol"));$sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "profanare"));$sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "furt"));$sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "frauda"));$sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "santaj"));$sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "trafic")); $sum=$sum+$row['MISTER'];
        $row=oci_fetch_array($stmt);        
            array_push($dataPoints,array("y" => $row['MISTER'], "name" => "fals")); $sum=$sum+$row['MISTER'];              
    ?>   
 
    <body>
        <div id="chartContainer"></div>
        <script type="text/javascript">
            $(function () {
                var chart = new CanvasJS.Chart("chartContainer",
                {
                    theme: "theme2",
                    title:{
                        text: "DISTRIBUTIA DETINUTLOR PE PEDEPSE"
                    },
                    exportFileName: "New Year Resolutions",
                    exportEnabled: true,
                    animationEnabled: true,		
                    data: [
                    {       
                        type: "pie",
                        showInLegend: true,
                        toolTipContent: "{name}: <strong>{y}</strong>",
                        indexLabel: "{name} {y}",
                        dataPoints: <?php file_put_contents("results.json", "");
                                          echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
            });
        </script>
    </body>
 
</html>