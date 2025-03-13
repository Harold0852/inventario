<?php

// Desactivar la visualización de errores
ini_set('display_errors', 0);
error_reporting(0);

require_once "conexion.php";

class ModeloVentas
{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVenta($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_vendedor, productos, neto, total, metodo_pago, cliente_descripcion, precio_venta, fecha) VALUES (:codigo, :id_vendedor, :productos, :neto, :total, :metodo_pago, :cliente_descripcion, :precio_venta, :fecha)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente_descripcion", $datos["cliente_descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlEditarVenta($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_vendedor = :id_vendedor, productos = :productos, neto = :neto, total = :total, metodo_pago = :metodo_pago, clienTe_descripcion = :clienTe_descripcion, precio_venta = :precio_venta, fecha = :fecha WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":clienTe_descripcion", $datos["clienTe_descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function mdlEliminarVenta($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal)
	{

		if ($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();
		} else if ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();
		} else {

			$fechaActual = new DateTime();
			$fechaActual->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if ($fechaFinalMasUno == $fechaActualMasUno) {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY id DESC");
			} else {


				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY id DESC");
			}

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS
	=============================================*/

	static public function mdlSumaTotalVentas($tabla)
	{

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	OBTENER ÚLTIMO CÓDIGO DE FACTURA
	=============================================*/

	static public function mdlObtenerUltimoCodigo($tabla)
	{

		$stmt = Conexion::conectar()->prepare("SELECT MAX(codigo) as ultimo_codigo FROM $tabla");

		$stmt->execute();

		return $stmt->fetch()["ultimo_codigo"];

		$stmt->close();
		$stmt = null;
	}
}
