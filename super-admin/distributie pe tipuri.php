<!DOCTYPE html>
<html>
    <head>
        <title>Title of the document</title>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </head>
 
    <?php
      $conn = oci_connect("Student", "STUDENT", "localhost");

      $sql="select id_tip_institutie,count(id_detinut) as nnn from detinuti join institutie on detinuti.id_institutie=institutie.id_institutie group by id_tip_institutie ";
      $stmt=oci_parse($conn,$sql);
      oci_execute($stmt);
        $row = oci_fetch_array($stmt);
        $dataPoints = array( array("y" => $row['NNN'], "label" => "SCOLI DE CORECTIE"));
        $row=oci_fetch_array($stmt);
            array_push($dataPoints ,array("y" => $row['NNN'], "label" => "INCHISOARI"));
        $row=oci_fetch_array($stmt);    
            array_push($dataPoints ,array("y" => $row['NNN'], "label" => "INCHISORI DE MAXIMA SECURITATE"));
        $row=oci_fetch_array($stmt);    
            array_push($dataPoints ,array("y" => $row['NNN'], "label" => "PENITENCIARE"));
    ?>
 
    <body>
        <div id="chartContainer"></div>
 
        <script type="text/javascript">
 
            $(function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "theme2",
                    animationEnabled: true,
                    title: {
                        text: "DISTRIBUTIA DETINUTILOR PE TIPURI DE UNITATI "
                    },
                    data: [
                    {
                        type: "column",                
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }
                    ]
                });
                chart.render();
            });
        </script>
    </body>
 
</html>
 
 <?php
      $conn = oci_connect("Student", "STUDENT", "localhost");

      $sql="select id_tip_institutie,count(id_detinut) as nnn from detinuti join institutie on detinuti.id_institutie=institutie.id_institutie group by id_tip_institutie ";
      $stmt=oci_parse($conn,$sql);
      oci_execute($stmt);
        $row = oci_fetch_array($stmt);
        $dataPoints = array( array("y" => $row['NNN'], "label" => "SCOLI DE CORECTIE"));
        $row=oci_fetch_array($stmt);
            array_push($dataPoints ,array("y" => $row['NNN'], "label" => "INCHISOARI"));
        $row=oci_fetch_array($stmt);    
            array_push($dataPoints ,array("y" => $row['NNN'], "label" => "INCHISORI DE MAXIMA SECURITATE"));
        $row=oci_fetch_array($stmt);    
            array_push($dataPoints ,array("y" => $row['NNN'], "label" => "PENITENCIARE"));
    ?>

 
        <script type="text/javascript">
 
            $(function () {
                var chart = new CanvasJS.Chart("site-wrap", {
                    theme: "theme2",
                    animationEnabled: true,
                    title: {
                        text: "DISTRIBUTIA DETINUTILOR PE TIPURI DE UNITATI "
                    },
                    data: [
                    {
                        type: "column",                
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }
                    ]
                });
                chart.render();
            });
        </script>




</body>
</html>