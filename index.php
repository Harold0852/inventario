<?php

/*=============================================
Mostrar errores
=============================================*/

ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log",  "D:/xampp/htdocs/pos/php_error_log");

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";

require_once "controladores/reporte-usuario.controlador.php";
require_once "modelos/reporte-usuario.modelo.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "extensiones/vendor/autoload.php";

if (isset($_GET["ruta"]) && $_GET["ruta"] == "reporte-usuario" && isset($_GET["descargar"]) && $_GET["descargar"] == "usuarios") {
    ControladorReporteUsuario::ctrDescargarReportesUsuarios();
    exit();
}

if (isset($_GET["ruta"]) && $_GET["ruta"] == "reporte-usuario" && isset($_GET["descargar"]) && $_GET["descargar"] == "ventas") {
    ControladorReporteUsuario::ctrDescargarReportesUsuarios();
    exit();
}

// Asegurarse de que esta condición esté correctamente configurada
if (isset($_GET["ruta"]) && $_GET["ruta"] == "reporte-usuario" && isset($_GET["idVendedor"])) {
    ControladorReporteUsuario::ctrDescargarReporteVentas($_GET["idVendedor"]);
    exit();
}

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();