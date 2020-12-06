<?php
/*
 * El siguiente código localiza los productos
 * OGR   Noviembre/2020
 */

$response = array();

$Cn = mysqli_connect("localhost","root","","rephonecom")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = mysqli_query($Cn,"SELECT IDREPORT,EMPLEADO,CALIDAD,INTENCIDAD,CXQ,VELOCIDAD FROM reportes ORDER BY IDREPORT");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {
            while ($res = mysqli_fetch_array($result)){
                $reportes = array();
                $reportes["success"] = 200;  
                $reportes["message"] = "Reportes Descargados";
                $reportes["IDREPORT"] = $res["IDREPORT"];
                $reportes["EMPLEADO"] = $res["EMPLEADO"];
                $reportes["CALIDAD"] = $res["CALIDAD"];
                $reportes["INTENCIDAD"] = $res["INTENCIDAD"];
                $reportes["CXQ"] = $res["CXQ"];
                $reportes["VELOCIDAD"] = $res["VELOCIDAD"];
                array_push($response, $reportes);
            }
           echo json_encode($response);
        } else {
            $reportes = array();
            $reportes["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $reportes["message"] = "No se pudo realizar la descarga";
            array_push($response, $reportes);
            echo json_encode($response);
        }
    } else {
        $reportes = array();
        $reportes["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $reportes["message"] = "No se pudo realizar la descarga";
        array_push($response, $reportes);
        echo json_encode($response);
    }
} else {
    $reportes = array();
    $reportes["success"] = 400;
    $reportes["message"] = "Faltan Datos entrada";
    array_push($response, $reportes);
    echo json_encode($response);
}
mysqli_close($Cn);
?>

