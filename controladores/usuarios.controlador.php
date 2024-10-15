<?php

class ControladorUsuarios {

    /*=============================================
    INGRESO DE USUARIO
    =============================================*/

    static public function ctrIngresoUsuario() {

        if (isset($_POST["ingUsuario"])) {

            // Validar formato de usuario
            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])) {

                $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $tabla = "usuarios";
                $item = "usuario";
                $valor = $_POST["ingUsuario"];

                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

                if (is_array($respuesta) && $respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar) {

                    if ($respuesta["estado"] == 1) {

                        // Guardar sesión
                        $_SESSION["iniciarSesion"] = "ok";
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["nombre"] = $respuesta["nombre"];
                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["foto"] = $respuesta["foto"];
                        $_SESSION["perfil"] = $respuesta["perfil"];

                        /*=============================================
                        REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
                        =============================================*/

                        date_default_timezone_set('America/Bogota');
                        $fechaActual = date('Y-m-d H:i:s');

                        $item1 = "ultimo_login";
                        $valor1 = $fechaActual;
                        $item2 = "id";
                        $valor2 = $respuesta["id"];

                        $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

                        if ($ultimoLogin == "ok") {
                            echo '<script>window.location = "inicio";</script>';
                        }

                    } else {
                        echo '<br><div class="alert alert-danger">El usuario aún no está activado</div>';
                    }

                } else {
                    echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
                }

            }
        }
    }

    /*=============================================
    REGISTRO DE USUARIO
    =============================================*/

    static public function ctrCrearUsuario() {

        if (isset($_POST["nuevoUsuario"])) {

            // Validar formato de datos
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])) {

                /*=============================================
                VALIDAR IMAGEN
                =============================================*/

                $ruta = "";

                if (isset($_FILES["nuevaFoto"]["tmp_name"]) && !empty($_FILES["nuevaFoto"]["tmp_name"])) {

                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/

                    $directorio = "vistas/img/usuarios/" . $_POST["nuevoUsuario"];
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0755, true); // Agregado: true para crear directorios recursivamente
                    }

                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/

                    $aleatorio = mt_rand(100, 999);

                    if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {
                        // Guardamos la imagen en el directorio
                        $ruta = "$directorio/$aleatorio.jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                    } elseif ($_FILES["nuevaFoto"]["type"] == "image/png") {
                        // Guardamos la imagen en el directorio
                        $ruta = "$directorio/$aleatorio.png";
                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                    } else {
                        echo '<script>alert("Formato de imagen no válido.");</script>'; // Agregado: advertencia para formatos no soportados
                        return; // Salir si el formato no es válido
                    }

                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    // Guardar la imagen según su tipo
                    if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {
                        imagejpeg($destino, $ruta);
                    } else {
                        imagepng($destino, $ruta);
                    }
                }

                $tabla = "usuarios";
                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "usuario" => $_POST["nuevoUsuario"],
                    "password" => $encriptar,
                    "perfil" => $_POST["nuevoPerfil"],
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡El usuario ha sido guardado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result) {
                            if (result.value) {
                                window.location = "usuarios";
                            }
                        });
                    </script>';
                }

            } else {
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "usuarios";
                        }
                    });
                </script>';
            }
        }
    }

    /*=============================================
    MOSTRAR USUARIO
    =============================================*/

    static public function ctrMostrarUsuarios($item, $valor) {
        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
    EDITAR USUARIO
    =============================================*/

    static public function ctrEditarUsuario() {
        if (isset($_POST["editarUsuario"])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {

                /*=============================================
                VALIDAR IMAGEN
                =============================================*/

                $ruta = $_POST["fotoActual"]; // Preservar la foto actual

                if (isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])) {
                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/

                    $directorio = "vistas/img/usuarios/" . $_POST["editarUsuario"];
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0755, true); // Crear directorio si no existe
                    }

                    /*=============================================
                    PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
                    =============================================*/

                    if (!empty($_POST["fotoActual"])) {
                        unlink($_POST["fotoActual"]); // Borrar la foto actual
                    }

                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/

                    $aleatorio = mt_rand(100, 999);

                    if ($_FILES["editarFoto"]["type"] == "image/jpeg") {
                        $ruta = "$directorio/$aleatorio.jpg";
                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                    } elseif ($_FILES["editarFoto"]["type"] == "image/png") {
                        $ruta = "$directorio/$aleatorio.png";
                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                    } else {
                        echo '<script>alert("Formato de imagen no válido.");</script>'; // Advertencia para formatos no soportados
                        return; // Salir si el formato no es válido
                    }

                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    // Guardar la imagen según su tipo
                    if ($_FILES["editarFoto"]["type"] == "image/jpeg") {
                        imagejpeg($destino, $ruta);
                    } else {
                        imagepng($destino, $ruta);
                    }
                }

                $tabla = "usuarios";
                $datos = array(
                    "id" => $_POST["idUsuario"],
                    "nombre" => $_POST["editarNombre"],
                    "usuario" => $_POST["editarUsuario"],
                    "perfil" => $_POST["editarPerfil"],
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡El usuario ha sido editado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result) {
                            if (result.value) {
                                window.location = "usuarios";
                            }
                        });
                    </script>';
                }

            } else {
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "usuarios";
                        }
                    });
                </script>';
            }
        }
    }

    /*=============================================
    BORRAR USUARIO
    =============================================*/

    static public function ctrBorrarUsuario() {
        if (isset($_GET["idUsuario"])) {
            $tabla = "usuarios";
            $datos = $_GET["idUsuario"];

            // Verificar si el usuario tiene una foto y eliminarla
            $usuario = ModeloUsuarios::MdlMostrarUsuarios($tabla, "id", $datos);
            if (!empty($usuario["foto"])) {
                unlink($usuario["foto"]); // Borrar la foto del usuario
            }

            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
            if ($respuesta == "ok") {
                echo '<script>
                    swal({
                        type: "success",
                        title: "¡El usuario ha sido borrado correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "usuarios";
                        }
                    });
                </script>';
            }
        }
    }
}
