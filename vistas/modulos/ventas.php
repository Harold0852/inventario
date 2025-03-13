<?php

if ($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor") {

  echo '<script>

    window.location = "inicio";

  </script>';

  return;
}

$xml = ControladorVentas::ctrDescargarXML();

if ($xml) {

  rename($_GET["xml"] . ".xml", "xml/" . $_GET["xml"] . ".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/' . $_GET["xml"] . '.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';
}

?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar ventas

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar ventas</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="crear-venta">

          <button class="btn btn-primary">

            Agregar venta

          </button>

        </a>

        <button type="button" class="btn btn-default pull-right" id="daterange-btn">

          <span>
            <i class="fa fa-calendar"></i>

            <?php

            if (isset($_GET["fechaInicial"])) {

              echo $_GET["fechaInicial"] . " - " . $_GET["fechaFinal"];
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
              <th>Cliente Descripción</th>
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

            if (isset($_GET["fechaInicial"])) {

              $fechaInicial = $_GET["fechaInicial"];
              $fechaFinal = $_GET["fechaFinal"];
            } else {

              $fechaInicial = null;
              $fechaFinal = null;
            }

            $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

            foreach ($respuesta["ventas"] as $key => $value) {
              echo '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $value["codigo"] . '</td>';

              // Verificar si cliente_descripcion está definido y no está vacío
              if (isset($value["clienTe_descripcion"]) && !empty($value["clienTe_descripcion"])) {
                echo '<td>' . $value["clienTe_descripcion"] . '</td>';
              } else {
                echo '<td>Vacío</td>';
              }

              $itemUsuario = "id";
              $valorUsuario = $value["id_vendedor"];
              $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

              if ($respuestaUsuario) {
                echo '<td>' . $respuestaUsuario["nombre"] . '</td>';
              } else {
                echo '<td>Vendedor no encontrado</td>';
              }

              echo '<td>' . $value["metodo_pago"] . '</td>
                  <td>$ ' . number_format($value["neto"], 2) . '</td>
                  <td>$ ' . number_format($value["total"], 2) . '</td>
                  <td>' . $value["fecha"] . '</td>
                  <td>
                      <div class="btn-group">
                        ' . /* '<a class="btn btn-success" href="index.php?ruta=ventas&xml=' . $value["codigo"] . '">xml</a>' */ '
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="' . $value["codigo"] . '">
                        <i class="fa fa-print"></i>
                      </button>';

              if ($_SESSION["perfil"] == "Administrador") {
                echo '<button class="btn btn-warning btnEditarVenta" idVenta="' . $value["id"] . '"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btnEliminarVenta" idVenta="' . $value["id"] . '"><i class="fa fa-times"></i></button>';
              }

              echo '</div>
                  </td>
                </tr>';
            }

            ?>

          </tbody>

        </table>

        <?php

        $eliminarVenta = new ControladorVentas();
        $eliminarVenta->ctrEliminarVenta();

        ?>


      </div>

    </div>

  </section>

</div>