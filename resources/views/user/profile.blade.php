@extends('layouts.main')

@section('title', 'Profile')

@section('content')

<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div style="color:#337ab7;">
    <h1 class="text-center" style="margin-top: 0px;"><strong>My Profile</strong></h1>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
	    	 <div class="well profile">
	            <div class="col-sm-12">
	                <div class="col-xs-12 col-sm-8">
	                    <h2>{{ explode(' ',$user->name)[0] . ' ' . explode(' ',$user->last_name)[0]}}</h2>
	                    <p><strong>Name: </strong> {{$user->name}} </p>
	                    <p><strong>Last Name: </strong> {{$user->last_name}} </p>
	                    <p><strong>NickName: </strong> {{$user->nickname}} </p>
	                    <p><strong>E-mail: </strong> {{$user->email}} </p>
	                    <p><strong>Registration date: </strong> {{$user->register_date}} </p>
	                    <p><strong>Country: </strong> {{$user->country->name}} </p>
	                    <p><strong>Institution: </strong> {{$user->institution->name}} </p>
	                    <p><strong>Score: </strong> {{$user->points}} </p>
	                    <p><strong>Skills: </strong>
	                        <span class="tags">C++</span> 
	                        <span class="tags">C</span>
	                        <span class="tags">C#</span>
	                        <span class="tags">Python</span>
	                    </p>
	                </div>             
	                <div class="col-xs-12 col-sm-4 text-center">
	                    <figure>
	                   	 	@if(file_exists('images/user_avatar/'. $user->avatar))
		                        <img src="{{ asset('images/user_avatar/' . $user->avatar) }}" alt="" class="img-circle img-responsive">
							@else
								<img src="{{ asset('images/user_avatar/user_default.jpg') }}" alt="" class="img-circle img-responsive">
							@endif
	                        <figcaption class="ratings">
	                            <p>Ratings
	                            <a href="#">
	                                <span class="fa fa-star"></span>
	                            </a>
	                            <a href="#">
	                                <span class="fa fa-star"></span>
	                            </a>
	                            <a href="#">
	                                <span class="fa fa-star"></span>
	                            </a>
	                            <a href="#">
	                                <span class="fa fa-star"></span>
	                            </a>
	                            <a href="#">
	                                 <span class="fa fa-star-o"></span>
	                            </a> 
	                            </p>
	                        </figcaption>
	                    </figure>
	                </div>
	            </div>            
	            <div class="col-xs-12 divider text-center">
	                <div class="col-xs-12 col-sm-4 emphasis">
	                    <h2><strong> 20,7K </strong></h2>                    
	                    <p><small>Followers</small></p>
	                    <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Follow </button>
	                </div>
	                <div class="col-xs-12 col-sm-4 emphasis">
	                    <h2><strong>245</strong></h2>                    
	                    <p><small>Following</small></p>
	                    <button class="btn btn-info btn-block"><span class="fa fa-user"></span> View Profile </button>
	                </div>
	                <div class="col-xs-12 col-sm-4 emphasis">
	                    <h2><strong>43</strong></h2>                    
	                    <p><small>Snippets</small></p>
	                    <div class="btn-group dropup btn-block">
	                      <button type="button" class="btn btn-primary"><span class="fa fa-gear"></span> Options </button>
	                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	                        <span class="caret"></span>
	                        <span class="sr-only">Toggle Dropdown</span>
	                      </button>
	                      <ul class="dropdown-menu text-left" role="menu">
	                        <li><a href="#"><span class="fa fa-envelope pull-right"></span> Send an email </a></li>
	                        <li><a href="#"><span class="fa fa-list pull-right"></span> Add or remove from a list  </a></li>
	                        <li class="divider"></li>
	                        <li><a href="#"><span class="fa fa-warning pull-right"></span>Report this user for spam</a></li>
	                        <li class="divider"></li>
	                        <li><a href="#" class="btn disabled" role="button"> Unfollow </a></li>
	                      </ul>
	                    </div>
	                </div>
	            </div>
	    	 </div>                 
		</div>
	</div>
</div>

@endsection