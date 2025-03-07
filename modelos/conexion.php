<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=inventario_wsl",
			            "root",
			            "");

		$link->exec("set names utf8");

		return $link;

	}

}