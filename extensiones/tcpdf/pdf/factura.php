<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura {

    public $codigo;

    public function traerImpresionFactura() {
        // Iniciar captura de buffer de salida
        ob_start();

        // Verificación del código de venta
        if (empty($this->codigo)) {
            die("Error: Código de venta no válido.");
        }

        // TRAEMOS LA INFORMACIÓN DE LA VENTA
        $itemVenta = "codigo";
        $valorVenta = $this->codigo;

        $respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);
        if (!$respuestaVenta) {
            die("Error: No se encontró la venta.");
        }

        // Procesar la información de la venta
        $fecha = substr($respuestaVenta["fecha"], 0, -8);
        $productos = json_decode($respuestaVenta["productos"], true);
        $neto = number_format($respuestaVenta["neto"], 2);
        $impuesto = number_format($respuestaVenta["impuesto"], 2);
        $total = number_format($respuestaVenta["total"], 2);

        // TRAEMOS LA INFORMACIÓN DEL CLIENTE
        $itemCliente = "id";
        $valorCliente = $respuestaVenta["id_cliente"];
        $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
        if (!$respuestaCliente) {
            die("Error: No se encontró el cliente.");
        }

        // TRAEMOS LA INFORMACIÓN DEL VENDEDOR
        $itemVendedor = "id";
        $valorVendedor = $respuestaVenta["id_vendedor"];
        $respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);
        if (!$respuestaVendedor) {
            die("Error: No se encontró el vendedor.");
        }

        // REQUERIMOS LA CLASE TCPDF
        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();

        // Bloque 1
        $bloque1 = <<<EOF
        <table style="margin: 0 auto; border-collapse: collapse;">
            <tr>
                <td style="width:150px; text-align: center;">
                    <img src="extensiones\tcpdf\pdf\images\logopdf.jpg" style="max-width: 100%; height: auto;">
                </td>
                <td style="background-color:white; width:140px; text-align: right;">
                    <div style="font-size:8.5px; line-height:15px;">
                        <h1>CELULAR CENTER</h1>
                    </div>
                </td>
                <td style="background-color:white; width:110px; text-align:center; color:red;">
                    <br><br>FACTURA N. $valorVenta
                </td>
            </tr>
        </table>
        NIT: 3685346-1<br>
        Dirección: Calle Central 0-00 Zona 2<br>
        Sanarate, El Progreso<br>
        Teléfono: 4552-7756<br>
        celularcentersanarate@hotmail.com<br>
        EOF;

        $pdf->writeHTML($bloque1, true, false, true, false, '');

        // Bloque 2
        $bloque2 = <<<EOF
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:390px">
                    Cliente: {$respuestaCliente['nombre']}
                </td>
                <td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
                    Fecha: $fecha
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: {$respuestaVendedor['nombre']}</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
            </tr>
        </table>
        EOF;

        $pdf->writeHTML($bloque2, true, false, true, false, '');

        // Bloque 3 - Tabla de productos
        $bloque3 = <<<EOF
        <table style="font-size:10px; padding:5px 10px; border-collapse: collapse; border: 1px solid #666;">
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
                <td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Producto</td>
                <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit.</td>
                <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>
            </tr>
            
        EOF;

        $pdf->writeHTML($bloque3, true, false, true, false, '');

        // Mostrar productos
        foreach ($productos as $item) {
            $itemProducto = "descripcion";
            $valorProducto = $item["descripcion"];
            
            $respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

            if (!$respuestaProducto) {
                die("Error: No se encontró el producto.");
            }

            $valorUnitario = number_format($respuestaProducto["precio_venta"], 2);
            $precioTotal = number_format($item["total"], 2);

            $bloque4 = <<<EOF
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center; vertical-align:middle; padding: 10px">
                        {$item['cantidad']}
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
                        {$item['descripcion']}
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">Q 
                        $valorUnitario
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">Q
                        $precioTotal
                    </td>
                </tr>
            </table>
            EOF;

            $pdf->writeHTML($bloque4, true, false, true, false, '');
        }

        // Bloque 5 - Totales
        $bloque5 = <<<EOF
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
                    Impuesto:
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                    Q $impuesto
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
                    Total:
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                    Q $total
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin-top: 20px;">
            Gracias por su compra!
        </div>
        EOF;

        $pdf->writeHTML($bloque5, true, false, true, false, '');

        // Salida del archivo 
        ob_end_clean();
        $pdf->Output('factura.pdf', 'I');
    }
}

// Ejecutamos la clase para generar la factura
$factura = new imprimirFactura();
$factura->codigo = $_GET["codigo"];
$factura->traerImpresionFactura();

?>
