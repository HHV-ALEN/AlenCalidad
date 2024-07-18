	<?php
  if (isset($title)) {
    $user_name = $_SESSION['user_name'];
  ?>
	  <nav class="navbar navbar-default ">
	    <div class="container-fluid">
	      <!-- Brand and toggle get grouped for better mobile display -->
	      <div class="navbar-header">
	        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	          <span class="sr-only">Toggle navigation</span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>
	        <a class="navbar-brand" href="#">ALEN</a>
	      </div>

	      <!-- Collect the nav links, forms, and other content for toggling -->
	      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	        <ul class="nav navbar-nav">
	          <li class="<?php if (isset($active_empleados)) {
                          echo $active_empleados;
                        } ?>"><a href="Formatos.php"><i class='glyphicon glyphicon-file'></i>CA-F-014 Control documental</a></li>
	          <li class="<?php if (isset($active_areas)) {
                          echo $active_areas;
                        } ?>"><a href="areas.php"><i class='glyphicon glyphicon-home'></i> Áreas</a></li>
	          <?php
            if ($user_name != "ljarillo"){
              ?>
              <li class="<?php if (isset($active_usuarios)) {
                          echo $active_usuarios; 
                        } ?>"><a href="usuarios.php"><i class='glyphicon glyphicon-user'></i> Usuarios</a></li>
                        <?php
            }
            ?>
	          <li class="<?php if (isset($active_bitacoras)) {
                          echo $active_bitacoras;
                        } ?>"><a href="bitacoras.php"><i class='glyphicon glyphicon-barcode'></i> Bitacora</a></li>

	        </ul>
	        <ul class="nav navbar-nav navbar-right">
	          <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
	        </ul>
	      </div><!-- /.navbar-collapse -->
	    </div><!-- /.container-fluid -->
	  </nav>
	<?php
  }
  ?>