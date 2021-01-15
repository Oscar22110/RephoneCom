<?php
/*
 * El siguiente código localiza los usuarios
 * OGR   Noviembre/2020
 */

$response = array();

$Cn = mysqli_connect("localhost","root","","rephonecom")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = mysqli_query($Cn,"SELECT corrUSR, nomUSR, contraUSR FROM usuarios ORDER BY nomUSR");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {
            while ($res = mysqli_fetch_array($result)){
                $usuarios = array();
                $usuarios["success"] = 200;  
                $usuarios["message"] = "Usuarios Descargados";
                $usuarios["corrUSR"] = $res["corrUSR"];
                $usuarios["nomUSR"] = $res["nomUSR"];
                $usuarios["contraUSR"] = $res["contraUSR"];
               
                array_push($response, $usuarios);
            }
           echo json_encode($response);
        } else {
            $usuarios = array();
            $usuarios["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $usuarios["message"] = "No se pudo realizar la descarga";
            array_push($response, $usuarios);
            echo json_encode($response);
        }
    } else {
        $usuarios = array();
        $usuarios["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $usuarios["message"] = "No se pudo realizar la descarga";
        array_push($response, $usuarios);
        echo json_encode($response);
    }
} else {
    $usuarios = array();
    $usuarios["success"] = 400;
    $usuarios["message"] = "Faltan Datos entrada";
    array_push($response, $usuarios);
    echo json_encode($response);
}
mysqli_close($Cn);
?>

