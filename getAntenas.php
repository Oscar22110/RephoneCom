<?php
/*
 * El siguiente código localiza las antenas
 * OGR   Noviembre/2020
 */

$response = array();

$Cn = mysqli_connect("localhost","root","","rephonecom")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = mysqli_query($Cn,"SELECT CLAVEANT, NOMANTENA, MODELO, TIPOANTENA FROM antenas ORDER BY NOMANTENA");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {
            while ($res = mysqli_fetch_array($result)){
                $antenas = array();
                $antenas["success"] = 200;  
                $antenas["message"] = "Antenas Descargadas";
                $antenas["CLAVEANT"] = $res["CLAVEANT"];
                $antenas["NOMANTENA"] = $res["NOMANTENA"];
                $antenas["MODELO"] = $res["MODELO"];
                $antenas["TIPOANTENA"] = $res["TIPOANTENA"];
               
                array_push($response, $antenas);
            }
           echo json_encode($response);
        } else {
            $antenas = array();
            $antenas["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $antenas["message"] = "No se pudo realizar la descarga";
            array_push($response, $antenas);
            echo json_encode($response);
        }
    } else {
        $antenas = array();
        $antenas["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $antenas["message"] = "No se pudo realizar la descarga";
        array_push($response, $antenas);
        echo json_encode($response);
    }
} else {
    $antenas = array();
    $antenas["success"] = 400;
    $antenas["message"] = "Faltan Datos entrada";
    array_push($response, $antenas);
    echo json_encode($response);
}
mysqli_close($Cn);
?>

