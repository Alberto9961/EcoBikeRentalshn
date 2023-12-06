<?php
//require("conectar_bd.php");
session_start();
require_once 'includes/tools.php';

$conexion=new Conexion();
$conexionPDO=$conexion->conexionPDO();
    $usr = $_POST['user'];
    $pw = $_POST['pass'];
    //Obtengo la version encriptada del password
    $pw_enc = md5($pw);
    $sql="SELECT id_int,id_usuario,grupo,nombre,nombre2,apellido1,apellido2,tx_username,id_TipoUsuario,centro,estado FROM login.users where tx_username=:user and tx_password=:pass";
    $stmt=$conexionPDO->prepare($sql);   
    $stmt->bindParam(':user', $usr);
    $stmt->bindParam(':pass', $pw_enc);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if( $fila=$stmt->fetch())
    {      
        //Obtener el Id del usuario en la BD       
        $idUser = $fila['id_int'];
        $nombre=$fila['nombre']." ".$fila['apellido1'];
        $complete=$fila['nombre']." ".$fila['nombre2']." ".$fila['apellido1']." ".$fila['apellido2'];
        $usuario=$fila['tx_username'];
        $centro=$fila['centro'];
        $uid=$fila['id_TipoUsuario'];
        $_SESSION['centro']=$centro;
        $_SESSION['uid']=$uid;
        $_SESSION['id_int']=$idUser;
        $_SESSION['nombreUsuario']=$nombre;
        $_SESSION['nombreCompleto']=$complete;
        $_SESSION['login']=1;
        header("location:./index.php?page=inicio");
        $stmt->closeCursor();
  $stmt = null;
  $conexionPDO = null;

  }

    else {
        //En caso de que no exista una fila...
        //..Crear un formulario para redireccionar al usuario a la pagina de login
        //enviandole un codigo de error
?>
        <link rel="stylesheet" type="text/css" href="css/sweetalert.min.css">
        <script type="text/javascript" src="js/sweetalert.min.js"></script>
        <body onload="prueba();">
        </body>
        
<script type="text/javascript">
function prueba () {

swal({
    title: "Credenciales incorrectas",
    text: "Error en el usuario o contraseña",
    type: "error",
    allowOutsideClick: false,
    allowEscapeKey:false,
}).then(function() {
    window.location = "index.html";
});
}
 </script>
<?php
    }
?>
                     
<script type="text/javascript">
    //Redireccionar con el formulario creado
    document.formulario.submit();
</script>