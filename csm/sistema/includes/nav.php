<nav>
			<ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
				<li class="principal">
			<?php
				if($_SESSION['rol'] == 1){
			?>
					<a href="#"><i class="fas fa-user"></i> Administradores</a>
						<ul>
							<li><a href="registro_usuario.php"><i class="fas fa-user-plus"></i> Nuevo Administrador</a></li>
							<li><a href="lista_usuarios.php"><i class="far fa-list-alt"></i> Lista de Administradores</a></li>
						</ul>
					</li>
			<?php }?>
			
			<?php
				if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){
			?>
				<li class="principal">
					<a href="#"><i class="far fa-building"></i> Proveedores</a>
					<ul>
						<li><a href="registro_proveedor.php"><i class="fas fa-plus"></i> Nuevo Proveedor</a></li>
						<li><a href="lista_proveedores.php"><i class="far fa-list-alt"></i> Lista de Proveedores</a></li>
					</ul>
				</li>
			<?php } ?>

			<?php
				if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){
			?>
				<li class="principal">
					<a href="#"><i class="fas fa-cubes"></i> Productos</a>
					<ul>
						<li><a href="registro_producto.php"><i class="fas fa-plus"></i> Nuevo Producto</a></li>
						<li><a href="lista_producto.php"><i class="fas fa-cube"></i> Lista de Productos</a></li>
					</ul>
				</li>
			<?php } ?>
				<li class="principal">
					<a href="#"><i class="fab fa-amazon-pay fa-1x"></i> Catalogo</a>
					<ul>
						<li><a href="./catalogo1.php"><i class="fas fa-eye"></i> Lista de Productos</a></li>
					</ul>
				</li>
				<?php
				if($_SESSION['rol'] == 1){
			?>
				<li class="principal">
					<a href="#"> Banner</a>
					<ul>
						<li><a href="banner.php"> Subir Imagenes</a></li>
					</ul>
				</li>
			<?php } ?>
			</ul>
		</nav>

		