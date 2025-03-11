<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">
			<?php
			// Obtener la página actual
			$current_page = basename($_SERVER['REQUEST_URI'], ".php");

			if ($_SESSION["perfil"] == "Administrador") {
				echo '<li class="' . ($current_page == "inicio" ? "active" : "") . '">
                <a href="inicio">
				<i class="fa fa-home"></i>
				<span>Inicio</span>
                </a>
			</li>
			<li class="' . ($current_page == "usuarios" ? "active" : "") . '">
                <a href="usuarios">
				<i class="fa fa-user"></i>
				<span>Usuarios</span>
                </a>
			</li>
			<li class="' . ($current_page == "reporte-usuario" ? "active" : "") . '">
                <a href="reporte-usuario">
				<i class="fa fa-file"></i>
				<span>Reportes de usuarios</span>
                </a>
			</li>';
			}

			if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial") {
				echo '<li class="' . ($current_page == "categorias" ? "active" : "") . '">
                <a href="categorias">
				<i class="fa fa-th"></i>
				<span>Categorías</span>
                </a>
			</li>
			<li class="' . ($current_page == "productos" ? "active" : "") . '">
                <a href="productos">
				<i class="fa fa-product-hunt"></i>
				<span>Productos</span>
                </a>
			</li>';
			}


			if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor") {
				echo '<li class="treeview ' . ($current_page == "ventas" || $current_page == "crear-venta" || $current_page == "reportes" ? "active" : "") . '">
                <a href="#">
				<i class="fa fa-list-ul"></i>
				<span>Ventas</span>
				<span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
				</span>
                </a>
                <ul class="treeview-menu">
				<li class="' . ($current_page == "crear-venta" ? "active" : "") . '">
					<a href="crear-venta">
					<i class="fa fa-circle-o"></i>
					<span>Crear venta</span>
					</a>
				</li>
				<li class="' . ($current_page == "ventas" ? "active" : "") . '">
                    <a href="ventas">
					<i class="fa fa-circle-o"></i>
					<span>Administrar ventas</span>
                    </a>
				</li>';
				if ($_SESSION["perfil"] == "Administrador") {
					echo '<li class="' . ($current_page == "reportes" ? "active" : "") . '">
                            <a href="reportes">
							<i class="fa fa-circle-o"></i>
							<span>Reporte de ventas</span>
                            </a>
						</li>';
				}
				echo '</ul>
			</li>';
			}
			?>
		</ul>
	</section>
</aside>