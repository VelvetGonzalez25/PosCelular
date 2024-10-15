<?php
// Asegúrate de que la sesión está iniciada
if (session_status() == PHP_SESSION_NONE) {
session_start(); // Asegúrate de tener esto si no está ya presente
}

// Redireccionar si el perfil es "Especial"
if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Especial") {
    echo '<script>
            window.location = "inicio";
          </script>';
    return;
}


?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrar ventas</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Administrar ventas</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <a href="crear-venta">
                    <button class="btn btn-primary">Agregar venta</button>
                </a>
                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                        <i class="fa fa-calendar"></i> 
                        <?php
                        // Manejo de fechas
                        if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {
                            echo htmlspecialchars($_GET["fechaInicial"]) . " - " . htmlspecialchars($_GET["fechaFinal"]);
                        } else {
                            echo 'Rango de fecha';
                        }
                        ?>
                    </span>
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Código factura</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Forma de pago</th>
                            <th>Neto</th>
                            <th>Total</th> 
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php
                        // Obtener fechas
                        $fechaInicial = $_GET["fechaInicial"] ?? null;
                        $fechaFinal = $_GET["fechaFinal"] ?? null;

                        // Asegúrate de que la respuesta es válida
                        $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);
                        if (is_array($respuesta)) {
                            foreach ($respuesta as $key => $value) {
                                echo '<tr>
                                        <td>' . ($key + 1) . '</td>
                                        <td>' . htmlspecialchars($value["codigo"]) . '</td>';

                                // Obtener cliente
                                $itemCliente = "id";
                                $valorCliente = $value["id_cliente"];
                                $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                                // Verifica si la respuesta es válida antes de acceder
                                if (is_array($respuestaCliente)) {
                                    echo '<td>' . htmlspecialchars($respuestaCliente["nombre"]) . '</td>';
                                } else {
                                    echo '<td>No se encontró el cliente.</td>'; // Manejo de error
                                }

                                // Obtener vendedor
                                $itemUsuario = "id";
                                $valorUsuario = $value["id_vendedor"];
                                $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                                // Verifica si la respuesta es válida antes de acceder
                                if (is_array($respuestaUsuario)) {
                                    echo '<td>' . htmlspecialchars($respuestaUsuario["nombre"]) . '</td>';
                                } else {
                                    echo '<td>No se encontró el vendedor.</td>'; // Manejo de error
                                }

                                echo '<td>' . htmlspecialchars($value["metodo_pago"]) . '</td>
                                      <td>Q ' . number_format($value["neto"], 2) . '</td>
                                      <td>Q ' . number_format($value["total"], 2) . '</td>
                                      <td>' . htmlspecialchars($value["fecha"]) . '</td>
                                      <td>
                                        <div class="btn-group">
                                          
                                          <button class="btn btn-info btnImprimirFactura" codigoVenta="' . htmlspecialchars($value["codigo"]) . '">
                                            <i class="fa fa-print"></i>
                                          </button>';

                                // Acciones para Administrador
                                if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Administrador") {
                                    echo '<button class="btn btn-warning btnEditarVenta" idVenta="' . htmlspecialchars($value["id"]) . '"><i class="fa fa-pencil"></i></button>
                                          <button class="btn btn-danger btnEliminarVenta" idVenta="' . htmlspecialchars($value["id"]) . '"><i class="fa fa-times"></i></button>';
                                }
                                echo '</div>  
                                      </td>
                                    </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="9">No se encontraron ventas.</td></tr>'; // Manejo de error
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                // Eliminar venta si se solicita
                $eliminarVenta = new ControladorVentas();
                $eliminarVenta->ctrEliminarVenta();
                ?>
            </div>
        </div>
    </section>
</div>
