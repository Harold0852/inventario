<?php
require_once "modelos/productos.modelo.php";
require_once "modelos/categorias.modelo.php";

class ControladorReportes
{

    public static function ctrDescargarReporte($tipo)
    {
        $tabla = "productos";
        $productos = ModeloProductos::mdlObtenerDatosReporte($tabla);

        if ($tipo == "pdf") {
            require_once "extensiones/tcpdf/tcpdf.php";

            ob_end_clean();

            $pdf = new TCPDF();
            $pdf->SetAutoPageBreak(true, 15);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', 12);

            // Encabezado   
            function imprimirEncabezado($pdf) {
                $pdf->Cell(40, 10, 'Codigo', 1, 0, 'C');
                $pdf->Cell(90, 10, 'Descripcion', 1, 0, 'C');
                $pdf->Cell(40, 10, 'Categoria', 1, 0, 'C');
                $pdf->Cell(20, 10, 'Stock', 1, 0, 'C');
                $pdf->Ln();
            }

            imprimirEncabezado($pdf);

            $totalPrecio = 0;

            // Datos
            foreach ($productos as $producto) {
                if ($pdf->GetY() > 270) {
                    $pdf->AddPage();
                    imprimirEncabezado($pdf);
                }
                $categoria = ModeloCategorias::mdlMostrarCategorias("categorias", "id", $producto["id_categoria"]);
                $subtotal = $producto["stock"] * $producto["precio_compra"];
                $totalPrecio += $subtotal;
                
                $pdf->MultiCell(40, 10, $producto["codigo"], 1, 'C', 0, 0);
                $pdf->MultiCell(90, 10, $producto["descripcion"], 1, 'C', 0, 0);
                $pdf->Cell(40, 10, $categoria["categoria"], 1, 0, 'C');
                $pdf->Cell(20, 10, $producto["stock"], 1, 0, 'C');
                // $pdf->Cell(30, 10, number_format($producto["precio_compra"], 2), 1, 0, 'C');
                $pdf->Ln();
            }

            // Agregar línea de total
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(130, 10, 'TOTAL:', 1, 0, 'L');
            $pdf->Cell(60, 10, '$' . number_format($totalPrecio), 1, 0, 'C');
            $pdf->Ln();

            $pdf->Output('reporte_productos.pdf', 'I');
        } elseif ($tipo == "excel") {
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=reporte_productos.xls");

            // echo "Codigo\tDescripcion\tCategoria\tStock\tPrecio Compra\tSubtotal\n";
            echo "Codigo\tDescripcion\tCategoria\tStock\n";

            $totalPrecio = 0;

            foreach ($productos as $producto) {
                $categoria = ModeloCategorias::mdlMostrarCategorias("categorias", "id", $producto["id_categoria"]);
                $subtotal = $producto["stock"] * $producto["precio_compra"];
                $totalPrecio += $subtotal;

                // echo $producto["codigo"] . "\t" . $producto["descripcion"] . "\t" . $categoria["categoria"] . "\t" .
                    // $producto["stock"] . "\t" . number_format($producto["precio_compra"], 2) . "\t" .
                    // number_format($subtotal, 2) . "\n";
                echo $producto["codigo"] . "\t" . $producto["descripcion"] . "\t" . $categoria["categoria"] . "\t" . $producto["stock"] . "\n";
            }

            echo "\t\t\t\tTOTAL\t" . number_format($totalPrecio, 2) . "\n";
        }
    }
}
