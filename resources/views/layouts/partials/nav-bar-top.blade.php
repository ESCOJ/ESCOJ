<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" style="background-color:blue;">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			<li><img src="{{ asset('images/escoj7.png') }}" style=" width:210px; height:50px; position: relative; top:0px; left: -15px;"></li>
			<li><a href="./problems.php">Problems <span class="sr-only">(current)</span></a></li>
			<li><a href="./sentencias.php">Verdicts</a></li>
			<li><a href="#">Ranks</a></li>
			<li><a href="./concursos.php">Contests</a></li>

			<!--_________________________________Aqui_______________________________________-->
			@if (Auth::guest())
				<li><p class="navbar-text" style="margin-left:30em;">Already have an account?</p></li>
				<li class="dropdown" style="margin-left:.5em;">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
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
									<form class="form" role="form" method="POST" action="{{ url('/login') }}" accept-charset="UTF-8" id="login-nav"> {{ csrf_field() }}
										<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
											<label class="sr-only" for="exampleInputEmail2">Email address</label>
											<input type="text" class="form-control" id="exampleInputEmail2" placeholder="Email address" name="email" value="{{ old('email') }}">
										    @if ($errors->has('email'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('email') }}</strong>
			                                    </span>
			                                @endif
										</div>

										<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
											<label class="sr-only" for="exampleInputPassword2">Password</label>
											<input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password">
										    @if ($errors->has('password'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('password') }}</strong>
			                                    </span>
			                                @endif
											<div class="help-block text-right"><a href="{{ url('/password/reset') }}">Forget the password ?</a></div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block">Sign in</button>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="remember"> keep me logged-in
											</label>
										</div>
									</form>
								</div>
								<div class="bottom text-center">
								New here ? <a href="{{ url('/register') }}"><b>Join Us</b></a>
								</div>
							</div>
						</li>
					</ul>
				</li>
			@else
				<li><p class="navbar-text" style="margin-left:43em;"></p></li>
				<li class="dropdown"style="margin-left:.5em;">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						{{ Auth::user()->name }} <span class="caret"></span>
					</a>

					<ul class="dropdown-menu">
						<li><a href="{{ url('/contestant/profile') }}">Your profile</a></li>
						<li><a href="{{ url('/contestant/edit') }}">Edit account</a></li>
						<li><a href="#">Something else here</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">Separated link</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">One more separated link</a></li>
						<li>
							<a href="{{ url('/logout') }}"
							    onclick="event.preventDefault();
							             document.getElementById('logout-form').submit();">
							    Logout
							</a>

							<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
							    {{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
			@endif
		</ul>
	</div>
</nav>