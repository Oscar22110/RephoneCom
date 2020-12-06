<?php
/*
 * El siguiente código Registra  un Usuario
 * OGR    Noviembre/2020
 */
$response = array();


$Cn = mysqli_connect("localhost","root","","rephonecom")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        $usuarios = array();
        $usuarios["success"] = 400;
        $usuarios["message"] = "Faltan datos de entrada";
        array_push($response,$usuarios);
    }
    else{
        $corr=$objArray["corrUSR"];
        $contra=$objArray["contraUSR"];
        $res = mysqli_query($Cn, "SELECT corrUSR, nomUSR, contraUSR FROM usuarios WHERE corrUSR = '$corr'");
        if (!empty($res)) {
            if(mysqli_num_rows($res) > 0){
               $secc = mysqli_fetch_array($res);
               if($contra == $secc["contraUSR"] ){
                 $result = mysqli_query($Cn, "SELECT corrUSR, nomUSR, contraUSR FROM usuarios WHERE corrUSR = '$corr'");
                 if(mysqli_num_rows($res) > 0){
                    while($registro = mysqli_fetch_array($result)){
                        $usuarios = array();
                        $usuarios["success"] = 200;
                        $usuarios["message"] = "Usuario Aceptado, Bienvenido(a) ";
                        $usuarios["nomUSR"] = $registro["nomUSR"];
                        array_push($response,$usuarios);

                    }
                 }
                 else{
                    $usuarios = array();
                    $usuarios["success"] = 200;
                    $usuarios["message"] = "El usuario ya se encuentra registrado";
                    $usuarios["corrUSR"] = [""];
                    $usuarios["nomUSR"] = [""];
                    $usuarios["contraUSR"] = [""];
                    array_push($response,$usuarios);
                 }
               }
               else{
                $usuarios = array();
                $usuarios["success"] = 404; //No se encuentra infromación, por lo tanto el success indica resultado no esitoso
                $usuarios["message"] = "La contraseña es incorrecta";
                array_push($response, $usuarios);
               }
            }//------------->else
            
        }//------------------->else
        
    }
}else{
    // required field is missing
    $usuarios = array();
    $usuarios["success"] = 400;
    $usuarios["message"] = "Faltan Datos entrada";
    array_push($response,$usuarios);
    
}
echo json_encode($response);
mysqli_close($Cn);
?>

