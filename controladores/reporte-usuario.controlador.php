<?php



class ControladorReporteUsuario {

    /*=============================================
    MOSTRAR REPORTES DE USUARIOS
    =============================================*/

    static public function ctrMostrarReportesUsuarios() {

        $tabla = "usuarios";

        $respuesta = ModeloReporteUsuario::mdlMostrarReportesUsuarios($tabla);

        return $respuesta;

    }

    /*=============================================
    DESCARGAR REPORTE DE VENTAS DE USUARIO ESPESIFICO
    =============================================*/

    static public function ctrDescargarReporteVentas($idVendedor) {

        $tabla = "ventas";

        $ventas = ModeloReporteUsuario::mdlDescargarReporteVentas($tabla, $idVendedor);

        /*=============================================
        CREAMOS EL ARCHIVO DE EXCEL
        =============================================*/

        $Name = 'reporte_ventas_usuario_'.$idVendedor.'.xls';

        header('Expires: 0');
        header('Cache-control: private');
        header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
        header("Cache-Control: cache, must-revalidate"); 
        header('Content-Description: File Transfer');
        header('Last-Modified: '.date('D, d M Y H:i:s'));
        header("Pragma: public"); 
        header('Content-Disposition: attachment; filename="'.$Name.'"');
        header("Content-Transfer-Encoding: binary");

        echo utf8_decode("<table border='0'> 

                <tr> 
                <td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
                <td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
                <td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
                <td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
                <td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
                <td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
                <td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
                <td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td>	
                <td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
                </tr>");

        $totalAcumulado = 0;
        foreach ($ventas as $item){

            $cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
            $vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

            echo utf8_decode("<tr>
                    <td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
                    <td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
                    <td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
                    <td style='border:1px solid #eee;'>");

            $productos =  json_decode($item["productos"], true);

            foreach ($productos as $key => $valueProductos) {
                    
                    echo utf8_decode($valueProductos["cantidad"]."<br>");
                }

            echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

            foreach ($productos as $key => $valueProductos) {
                    
                echo utf8_decode($valueProductos["descripcion"]."<br>");
            
            }

            echo utf8_decode("</td>
                <td style='border:1px solid #eee;'>".number_format($item["neto"],2)."</td>	
                <td style='border:1px solid #eee; mso-number-format:\"0\";'>".(int)$item["total"]."</td>
                <td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
                <td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
                </tr>");

            $totalAcumulado += (int)$item["total"];
        }

        // Agregar fila de total acumulado
        echo utf8_decode("<tr>
                <td style='border:1px solid #eee;' colspan='4'>Total Acumulado</td>
                <td style='border:1px solid #eee;' colspan='5'>".$totalAcumulado."</td>
                </tr>");

        echo "</table>";
    }

    /*=============================================
    DESCARGAR REPORTES DE VENTAS DE TODOS LOS USUARIOS
    =============================================*/

    static public function ctrDescargarReportesUsuarios() {

        $tabla = "ventas";

        $ventas = ModeloReporteUsuario::mdlDescargarReportesUsuarios($tabla);

        /*=============================================
        CREAMOS EL ARCHIVO DE EXCEL
        =============================================*/

        $Name = 'reporte_ventas_todos_usuarios.xls';

        header('Expires: 0');
        header('Cache-control: private');
        header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
        header("Cache-Control: cache, must-revalidate"); 
        header('Content-Description: File Transfer');
        header('Last-Modified: '.date('D, d M Y H:i:s'));
        header("Pragma: public"); 
        header('Content-Disposition:; filename="'.$Name.'"');
        header("Content-Transfer-Encoding: binary");

        echo utf8_decode("<table border='0'> 

                <tr> 
                <td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
                <td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
                <td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
                <td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
                <td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
                <td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
                <td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
                <td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td>	
                <td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
                </tr>");

        $totalAcumulado = 0;
        foreach ($ventas as $item){

            $cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
            $vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

            echo utf8_decode("<tr>
                    <td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
                    <td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
                    <td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
                    <td style='border:1px solid #eee;'>");

            $productos =  json_decode($item["productos"], true);

            foreach ($productos as $valueProductos) {
                    
                    echo utf8_decode($valueProductos["cantidad"]."<br>");
                }

            echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

            foreach ($productos as $valueProductos) {
                    
                echo utf8_decode($valueProductos["descripcion"]."<br>");
            
            }

            echo utf8_decode("</td>
                <td style='border:1px solid #eee;'>".number_format($item["neto"],2)."</td>	
                <td style='border:1px solid #eee; mso-number-format:\"0\";'>".(int)$item["total"]."</td>
                <td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
                <td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
                </tr>");

            $totalAcumulado += (int)$item["total"];
        }

        // Agregar fila de total acumulado
        echo utf8_decode("<tr>
                <td style='font-weight:bold; border:1px solid #eee;' colspan='4'>Total Acumulado</td>
                <td style='border:1px solid #eee;' colspan='5'>".$totalAcumulado."</td>
                </tr>");

        echo "</table>";
    }

}
?>
