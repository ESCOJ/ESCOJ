<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" style="background-color:blue;">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			<li><a href="{{ url('/') }}" style="height:50px;"><img src="{{ asset('images/escoj7.png') }}" style=" width:210px; height:50px; position: relative; top:-14px; left: -30px;"></a></li>
			<li><a href="{{ route('problem.index') }}">Problems <span class="sr-only">(current)</span></a></li>
			<li><a href="{{ route('judgment.index') }}">Judgments</a></li>
			<li><a href="#">Ranks</a></li>
			<li><a href="./concursos.php">Contests</a></li>

			<!--_________________________________Aqui_______________________________________-->
			@if (Auth::guest())
				<li><p class="navbar-text" style="margin-left:28em;">Already have an account?</p></li>
				<li id="drop_login" class="dropdown" style="margin-left:.5em;">
					<a id="a_login" href="#" class="dropdown-toggle " data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
					<ul id="login-dp" class="dropdown-menu dropdown-menu-us">
						<li>
							<div class="row">
								<div class="col-md-12">
									Login via
									<div class="social-buttons">
										<a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-social btn-facebook">
											<span class="fa fa-facebook"></span>Facebook
										</a>
										<a href="{{ url('/auth/redirect/github') }}" class="btn btn-social btn-github">
											<span class="fa fa-github"></span>Github
										</a>
									</div>
									or
									<form class="form" role="form" method="POST" action="{{ url('/login') }}" accept-charset="UTF-8" id="login-nav"> {{ csrf_field() }}
										<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
											<label class="sr-only" for="exampleInputEmail2">Email address</label>
											<input type="text" class="form-control" id="exampleInputEmail2" placeholder="Nickname or E-mail" name="email" value="{{ old('email') }}">
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
											<button type="submit" class="btn btn-primary btn-block">
												<span class="fa fa-user"></span>     Sign in
											</button>
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
				<li><p class="navbar-text" style="margin-left:35em;"></p></li>
				<li class="dropdown"style="margin-left:.5em;">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="height:50px;  ">
						<img src="{{ asset('images/user_avatar/'.Auth::user()->avatar) }}" class="img-circle" style=" width:45px; height:45px; left: -5px; position: relative; top:-12px;"> <span style="position: relative; top:-12px;">{{ Auth::user()->nickname }} <span class="caret" ></span></span>
					</a>
					
					<ul class="dropdown-menu dropdown-menu-us">
						<li><a href="{{ url('/contestant/profile') }}"><i class="fa fa-user" aria-hidden="true"></i>
 Your profile</a></li>
						<li><a href="{{ url('/contestant/edit') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
 Edit account</a></li>
						<li><a href="#">Something else here</a></li>

						@if(Auth::user()->role != 'contestant')
							<li role="separator" class="divider"></li>
							<li class="dropdown-header" style="font-size:100%;">
								@if(Auth::user()->role === 'admin')
									Administrator Options
								@elseif(Auth::user()->role === 'problem_setter')
									Problem Setter Options
								@else
									Coach Options
								@endif
							</li>
							@if(Auth::user()->role === 'admin' or Auth::user()->role === 'problem_setter')
								<li>
									<a href="{{ route('problem.create') }}">
										<i class="fa fa-upload" aria-hidden="true"></i> Add problem
									</a>
								</li>
								<li>
									<a href="{{ route('problem.problems') }}">
									<i class="fa fa-folder-open" aria-hidden="true"></i> Problems
									</a>
								</li>
								@if(Auth::user()->role === 'admin')
									<li>
										<a href="{{ route('user.users') }}">
											<i class="fa fa-exchange" aria-hidden="true"></i> Change user role
										</a>
									</li>
								@endif
 							@endif
							<li>
								<a href="{{ route('problem.create') }}">
									<i class="fa fa-upload" aria-hidden="true"></i> Create Contest
								</a>
							</li>
							<li>
								<a href="{{ route('problem.problems') }}">
								<i class="fa fa-folder-open" aria-hidden="true"></i> Contests
								</a>
							</li>							
						@endif

						<li role="separator" class="divider"></li>
						<li>
							<a href="{{ url('/logout') }}"
							    onclick="event.preventDefault();
							             document.getElementById('logout-form').submit();">
							    <i class="fa fa-power-off" aria-hidden="true"></i> Logout
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