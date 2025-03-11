<?php

// Desactivar la visualización de errores
ini_set('display_errors', 0);
error_reporting(0);

require_once "../modelos/ventas.modelo.php";
require_once "../extensiones/PHPExcel.php";

class ControladorExportarVentas {

    public function exportarVentas() {
        $ventas = ModeloVentas::mdlMostrarVentas("ventas", null, null);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Vendedor');
        $sheet->setCellValue('C1', 'Productos');
        $sheet->setCellValue('D1', 'Neto');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Método de Pago');
        $sheet->setCellValue('G1', 'Descripción del Cliente');
        $sheet->setCellValue('H1', 'Precio de Venta');
        $sheet->setCellValue('I1', 'Total Acumulado');

        // Datos
        $row = 2;
        $totalAcumulado = 0;
        foreach ($ventas as $venta) {
            $sheet->setCellValue('A' . $row, $venta['codigo']);
            $sheet->setCellValue('B' . $row, $venta['id_vendedor']);
            $sheet->setCellValue('C' . $row, $venta['productos']);
            $sheet->setCellValue('D' . $row, $venta['neto']);
            $sheet->setCellValue('E' . $row, (int)$venta['total']);
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $sheet->setCellValue('F' . $row, $venta['metodo_pago']);
            $sheet->setCellValue('G' . $row, $venta['cliente_descripcion']);
            $sheet->setCellValue('H' . $row, $venta['precio_venta']);
            $totalAcumulado += (int)$venta['total'];
            $sheet->setCellValue('I' . $row, $totalAcumulado);
            $row++;
        }

        // Agregar fila de total acumulado
        $sheet->setCellValue('A' . $row, 'Total Acumulado');
        $sheet->setCellValue('E' . $row, $totalAcumulado);
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

        // Configuración del archivo
        $filename = "Reporte_Ventas_" . date("Y-m-d_H-i-s") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}

$exportar = new ControladorExportarVentas();
$exportar->exportarVentas();
?>
