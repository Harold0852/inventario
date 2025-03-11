<?php

require_once "conexion.php";

class ModeloReporteUsuario {

    /*=============================================
    MOSTRAR REPORTES DE USUARIOS
    =============================================*/

    static public function mdlMostrarReportesUsuarios($tabla) {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();

        $stmt = null;

    }

    /*=============================================
    DESCARGAR REPORTE DE VENTAS DE USUARIO ESPESIFICO
    =============================================*/

    static public function mdlDescargarReporteVentas($tabla, $idVendedor) {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_vendedor = :idVendedor");

        $stmt->bindParam(":idVendedor", $idVendedor, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();

        $stmt = null;

    }

    /*=============================================
    DESCARGAR REPORTES DE VENTAS DE TODOS LOS USUARIOS
    =============================================*/

    static public function mdlDescargarReportesUsuarios($tabla) {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();

        $stmt = null;

    }

}
?>
