<?php
require_once "modelos/productos.modelo.php";
require_once "modelos/categorias.modelo.php";

class ControladorReportes {

    public static function ctrDescargarReporte($tipo) {
        $tabla = "productos";
        $productos = ModeloProductos::mdlObtenerDatosReporte($tabla);

        if ($tipo == "pdf") {
            // Lógica para generar reporte en PDF usando TCPDF
            require_once "extensiones/tcpdf/tcpdf.php";

            // Desactivar la salida de búfer
            ob_end_clean();

            $pdf = new TCPDF();
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', 12);

            // Encabezado
            $pdf->Cell(40, 10, 'Codigo', 1, 0, 'C');
            $pdf->Cell(90, 10, 'Descripcion', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Categoria', 1, 0, 'C');
            $pdf->Cell(20, 10, 'Stock', 1, 0, 'C');
            $pdf->Ln();

            // Datos
            foreach ($productos as $producto) {
                $categoria = ModeloCategorias::mdlMostrarCategorias("categorias", "id", $producto["id_categoria"]);
                $pdf->Cell(40, 10, $producto["codigo"], 1, 0, 'C');
                $pdf->MultiCell(90, 10, $producto["descripcion"], 1, 'C', 0, 0);
                $pdf->Cell(40, 10, $categoria["categoria"], 1, 0, 'C');
                $pdf->Cell(20, 10, $producto["stock"], 1, 0, 'C');
                $pdf->Ln();
            }

            $pdf->Output('reporte_productos.pdf', 'I');
        } elseif ($tipo == "excel") {
            // Lógica para generar reporte en Excel
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=reporte_productos.xls");

            echo "Codigo\tDescripcion\tCategoria\tStock\n";

            foreach ($productos as $producto) {
                $categoria = ModeloCategorias::mdlMostrarCategorias("categorias", "id", $producto["id_categoria"]);
                echo $producto["codigo"] . "\t" . $producto["descripcion"] . "\t" . $categoria["categoria"] . "\t" . $producto["stock"] . "\n";
            }
        }
    }
}
?>
