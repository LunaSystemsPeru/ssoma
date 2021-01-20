<header id="navbar">
	<div id="navbar-container" class="boxed">
		
		<!--Brand logo & name-->
		<!--================================-->
		<div class="navbar-header">
			<a href="index.php" class="navbar-brand">
				<img src="../public/img/logo.png" alt="Nifty Logo" class="brand-icon">
				<div class="brand-title">
					<span class="brand-text">SGSI</span>
				</div>
			</a>
		</div>
		<!--================================-->
		<!--End brand logo & name-->
		
		
		<!--Navbar Dropdown-->
		<!--================================-->
		<div class="navbar-content clearfix">
			<ul class="nav navbar-top-links pull-left">
				
				<!--Navigation toogle button-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<li class="tgl-menu-btn">
					<a class="mainnav-toggle" href="#">
						<i class="fa fa-navicon fa-lg"></i>
					</a>
				</li>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End Navigation toogle button-->
				
				
				
				<!--Notification dropdown-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End notifications dropdown-->
				
				
				
				<!--Mega dropdown-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End mega dropdown-->
				
			</ul>
			<ul class="nav navbar-top-links pull-right">
				
				
				
				<!--User dropdown-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<li id="dropdown-user" class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
						<span class="pull-right">
							<img class="img-circle img-user media-object" src="../public/img/av1.png" alt="Profile Picture">
						</span>
						<div class="username hidden-xs"><?php echo $_SESSION['empleado'];?></div>
					</a>
					
					
					<div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">
						

						<!-- User dropdown menu -->
						<ul class="head-list">
							<li>
								<a href="registra_usuario.php?id=<?php echo $_SESSION['usuario'] ?>">
									<i class="fa fa-user fa-fw fa-lg"></i> Perfil
								</a>
							</li>
						</ul>
						
						<!-- Dropdown footer -->
						<div class="pad-all text-right">
							<a href="../controller/logout.php" class="btn btn-primary">
								<i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion
							</a>
						</div>
					</div>
				</li>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End user dropdown-->
				
			</ul>
		</div>
		<!--================================-->
		<!--End Navbar Dropdown-->
		
	</div>
</header>