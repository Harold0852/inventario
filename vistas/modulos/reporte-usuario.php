<?php

$result = ControladorReporteUsuario::ctrMostrarReportesUsuarios();

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Reportes de Usuarios</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <a href="index.php?ruta=reporte-usuario&descargar=ventas" class="btn btn-primary">
                    Descargar reportes de ventas de todos los usuarios
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Foto</th>
                            <th>Perfil</th>
                            <th style="width:20px">Estado</th>
                            <th style="width:20px">Reporte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($result) > 0) {
                            foreach ($result as $row) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['nombre']}</td>
                                        <td>{$row['usuario']}</td>";
                                
                                if ($row["foto"] != "") {
                                    echo '<td><img src="'.$row["foto"].'" class="img-thumbnail" width="40px"></td>';
                                } else {
                                    echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                                }

                                echo "<td>{$row['perfil']}</td>";

                                if ($row["estado"] != 0) {
                                    echo '<td><button class="btn btn-success btn-xs" idUsuario="'.$row["id"].'" estadoUsuario="0">Activado</button></td>';
                                } else {
                                    echo '<td><button class="btn btn-danger btn-xs" idUsuario="'.$row["id"].'" estadoUsuario="1">Desactivado</button></td>';
                                }

                                echo "<td>
                                            <div class='btn-group'>
                                                <a href='index.php?ruta=reporte-usuario&idVendedor={$row['id']}' class='btn btn-warning'><i class='fa fa-table'></i></a>
                                            </div>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No hay usuarios</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

