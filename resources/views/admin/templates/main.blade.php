<?php 
include("./resources/header.php");
if(!$_POST){
	if(!(isset($_SESSION["isStarted"])) || $_SESSION["isStarted"] == FALSE){
?>
<body style="color:#424242;">
	<div class="container-fluid">
		
		<div id="divEspacio" class="rox marg-main" style="margin-top:150px;"></div>
		<form action="./index.php" method="POST">
			<div style="color:#337ab7;">
				<div class="col-lg-12" id="main-banner" >
					<div>
						<br>
						<h1 class="text-center" style="margin-top: 0px;"><strong>Conviértete en un verdadero maestro de la programación</strong></h1>
						<h2 class="text-center" style="margin-top: 10px; font-size: 24px;">Aprende cómo hacer algoritmos eficientes</h2>
						<div class="text-center"><br>
							<strong id="total-submissions">16873478</strong> submissions, <strong>419448</strong> usuarios registrados, <strong>5955</strong> problemas públicos
						</div><br>
						<div class="text-center"><br><a class="btn btn-lg btn-primary" href="/register">Registrate &amp; Empieza a codiguear!</a></div>
						
						<br><br>
						
					</div>
				</div>
			</div>
			<div class="col-md-12 text-center"> 
				<h5>
					<button class="btn btn-success" style="margin:0;" ><a style="text-decoration:none;color:white;" href="./problems.php">

						Ir a Problemas 
						<span class="glyphicon glyphicon-education" aria-hidden="true">
							
						</span>
						</a>
					</button>
				</h5>
			</div>
			<br>
			
			<!--
			<div class="row">
				<div class="col-md-3 col-md-offset-5 marg-inputs">
					<img src="./media/computer1.ico" class="img-login"/>
				</div>
				<div class="col-md-3 marg-inputs">
					<div class="row marg-box">
						<div class="col-md-4 text-login">Usuario: </div>
						<div class="col-md-8"><input type="text" name="usuario" class="form-control"/></div>
					</div>
					<div class="row marg-box">
						<div class="col-md-4 text-login">Contraseña: </div>
						<div class="col-md-8"><input type="password" name="pass" class="form-control"/></div>
					</div>

				</div>
			</div>-->
			<!--<div class="row">
				<div class="col-md-2 col-md-offset-7 marg-inputs text-right">
					<button type="submit" class="btn btn-success">Iniciar Sesión</button>
				</div>
			</div>-->
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
								Login via
								<div class="social-buttons">
									<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
									<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
								</div>
                                or
								 <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
										<div class="form-group">
											 <label class="sr-only" for="exampleInputEmail2">Email address</label>
											 <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required>
										</div>
										<div class="form-group">
											 <label class="sr-only" for="exampleInputPassword2">Password</label>
											 <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required>
                                             <div class="help-block text-right"><a href="">Forget the password ?</a></div>
										</div>
										<div class="form-group">
											 <button type="submit" class="btn btn-primary btn-block">Sign in</button>
										</div>
										<div class="checkbox">
											 <label>
											 <input type="checkbox"> keep me logged-in
											 </label>
										</div>
								 </form>
							</div>
							<div class="bottom text-center">
								New here ? <a href="#"><b>Join Us</b></a>
							</div>
					 </div>
				</li>
			</ul>
		</form>

	</div>
	
</body>
</html>
<?php 
	}else{
		//Ya hay una sesion iniciada
		header('Location: ./main.php');
	}
}else{
	if($conexion->initSession($_POST['usuario'], $_POST['pass'])){
		//"login correcto";
		header('Location: ./main.php');
	}else{
		echo "Usuario y/o contraseña incorrectos";
	}
}
?>
