<header class="main-header">
  
  <!--LOGOTIPO-->
  <a href="inicio" class="logo">
    <!-- logo mini -->
    <span class="logo-mini">
      <img src="vistas/img/plantilla/logo.jpg" class="img-responsive" style="padding:10px; max-height:40px; object-fit:contain;">
    </span>
    <!-- logo normal -->
    <span class="logo-lg">
      <img src="vistas/img/plantilla/logo.jpg" class="img-responsive" style="padding:5px 0px; max-height:60px; object-fit:contain;">
    </span>
  </a>

  <!--BARRA DE NAVEGACIÓN-->
  <nav class="navbar navbar-static-top" role="navigation">  
    <!-- Botón de navegación -->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Alternar navegación</span>
    </a>
    <!-- perfil de usuario -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php
            if($_SESSION["foto"] != ""){
              echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
            }else{
              echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
            }
            ?>  
            <span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>
          </a>

					<!-- Ventana desplegable de cerrar sesión -->

					<ul class="dropdown-menu" style="min-width: 200px; padding: 20px;">
 					 <li class="user-body">
  					  <div style="text-align: center;">
    				   <h3 style="margin-bottom: 10px;">Celular Center</h3>
     					 <h5 style="margin-bottom: 20px;">Cerrar Sesión</h5>
      					<a href="salir" class="btn btn-flat" style="background-color: red; color: white !important; border-color: red; width: 100%;">Salir</a>
					  </div>
 					 </li>
					</ul>

				</li>

			</ul>

		</div>

	</nav>

 </header>