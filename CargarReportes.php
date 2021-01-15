<?php
/*
 * El siguiente código Inserta el reporte directamente en el servidor web
 * OGR    Noviembre/2020
 */

$response = array();
$reporte = array();

$Cn = mysqli_connect("localhost","root","","rephonecom")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

// Checa que le este llegando por el método POST el nomProd,existencia y precio

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        // required field is missing
        $reporte["success"] = 400;
        $reporte["message"] = "Faltan Datos entrada";
        array_push($response,$reporte);
        echo json_encode($response);
    }
    else{
        $idReport=$objArray['IDREPORT']; 
        $emple=$objArray['EMPLEADO'];
        $cali=$objArray['CALIDAD'];
        $inten=$objArray['INTENCIDAD'];
        $cxq=$objArray['CXQ'];
        $velo=$objArray['VELOCIDAD'];
        $estado= "Insertado";
        $result = mysqli_query($Cn,"INSERT INTO reportes(IDREPORT,EMPLEADO,CALIDAD,INTENCIDAD,CXQ,VELOCIDAD,ESTADO) values 
        ('$idReport','$emple','$cali','$inten','$cxq','$velo','$estado')");
        //$idprod = mysqli_insert_id($Cn);
        if ($result) {   
            $reporte["success"] = 200;   // El success=200 es que encontro eñ producto
            $reporte["message"] = "Reporte Cargado";

            array_push($response,$reporte);
            echo json_encode($response);
        } else {
                // 
                $reporte["success"] = 406;  
                $reporte["message"] = "Reporte no pudo cargar, intente tener conexión a internet";
                array_push($response,$reporte);
                echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $reporte["success"] = 400;
    $reporte["message"] = "Faltan Datos entrada";
    array_push($response,$reporte);
    echo json_encode($response);
}
mysqli_close($Cn);
?>
