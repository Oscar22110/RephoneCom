<?php
/*
 * El siguiente código localiza los usuarios
 * OGR   Noviembre/2020
 */

$response = array();

$Cn = mysqli_connect("localhost","root","","rephonecom")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = mysqli_query($Cn,"SELECT CLAVE, NOMCOMUNIDAD, ENCARGADO FROM comunidades ORDER BY NOMCOMUNIDAD");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {
            while ($res = mysqli_fetch_array($result)){
                $comunidades = array();
                $comunidades["success"] = 200;  
                $comunidades["message"] = "Usuarios Descargados";
                $comunidades["CLAVE"] = $res["CLAVE"];
                $comunidades["NOMCOMUNIDAD"] = $res["NOMCOMUNIDAD"];
                $comunidades["ENCARGADO"] = $res["ENCARGADO"];
               
                array_push($response, $comunidades);
            }
           echo json_encode($response);
        } else {
            $comunidades = array();
            $comunidades["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $comunidades["message"] = "No se pudo realizar la descarga";
            array_push($response, $comunidades);
            echo json_encode($response);
        }
    } else {
        $comunidades = array();
        $comunidades["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $comunidades["message"] = "No se pudo realizar la descarga";
        array_push($response, $comunidades);
        echo json_encode($response);
    }
} else {
    $comunidades = array();
    $comunidades["success"] = 400;
    $comunidades["message"] = "Faltan Datos entrada";
    array_push($response, $comunidades);
    echo json_encode($response);
}
mysqli_close($Cn);
?>

