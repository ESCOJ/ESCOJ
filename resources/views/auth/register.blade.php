@extends('layouts.main')

@section('title', 'Register')

@section('styles')
    {!!Html::style('plugins/fileinput/css/fileinput.min.css')!!}
@endsection   

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:55px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                               
                                @if(!session('name'))
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>
                                @else
                                    <input id="name" type="text" class="form-control" name="name" value="{{ session('name') }}" autofocus>
                                @endif
                                
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Last name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                            <label id="nickname" for="nickname" class="col-md-4 control-label">NickName</label>

                            <div class="col-md-6">
                                @if(!session('nickname'))
                                    <input type="text" class="form-control" name="nickname" value="{{ old('nickname') }}">
                                @else
                                    <input type="text" class="form-control" name="nickname" value="{{ session('nickname') }}">
                                @endif

                                @if ($errors->has('nickname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                
                                @if(!session('email'))
                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" >
                                @else
                                    <input id="email" type="text" class="form-control" name="email" value="{{ session('email') }}" >
                                @endif

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('email_confirmation') ? ' has-error' : '' }}">
                            <label for="email_confirmation" class="col-md-4 control-label">Confirm E-Mail</label>

                            <div class="col-md-6">
                                <input id="email_confirmation" type="text" class="form-control" name="email_confirmation" value="{{ old('email_confirmation') }}" >

                                @if ($errors->has('email_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            <label for="country" class="col-md-4 control-label">Country</label>                            
                            <div class="col-md-6">
                                {!! Form::select('country',$countries,null,['placeholder' => 'Select a counntry','id'=>'country', 'class' => 'form-control']) !!}

                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('institution') ? ' has-error' : '' }}">
                            
                            <label for="institution" class="col-md-4 control-label">Institution</label>                            
                            <div class="col-md-6">
                                {!! Form::select('institution',[''=>''],null,['id'=>'institution', 'class' => 'form-control']) !!}

                                @if ($errors->has('institution'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('institution') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                        
                            <label for="avatar" class="col-md-4 control-label">Avatar (120x120, <35KB)</label>                            
                            <div class="col-md-6">
                                <input id="avatar" type="file" name="avatar" class="btn-primary" value>
                                @if ($errors->has('avatar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">

                            <label class="col-md-4 control-label">Captcha</label>

                            <div class="col-md-6">
                                {!! app('captcha')->display() !!}

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('terms_of_services') ? ' has-error' : '' }}">
                            
                            <label class="col-md-4 control-label">
                                    <input id="terms_of_services" type="radio" name="terms_of_services">
                            </label>  
                                                                                  
                            <div class="col-md-6 radio">
                                I agree with the <a href="{{ url('/register/escojtos') }}" target="new">ESCOJ Terms of Service</a>
                                @if ($errors->has('terms_of_services'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('terms_of_services') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        @if(session('provider'))
                            <input type="hidden" name="provider" value="{{ session('provider') }}">
                            <input type="hidden" name="provider_id" value="{{ session('provider_id') }}">
                        @else
                            <input type="hidden" name="provider" value="{{ old('provider') }}">
                            <input type="hidden" name="provider_id" value="{{ old('provider_id') }}">  
                              
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-user"></span>  Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    {!!Html::script('js/dropdown.js') !!}
    {!!Html::script('plugins/fileinput/js/fileinput.min.js')!!}
    <script type="text/javascript">
         $("#avatar").fileinput({
            maxFileSize : 35,
            msgProgress : 'Loading {percent}%',
            previewClass : 'file_preview',
            previewFileType : "image",
            browseClass : "btn btn-primary",
            browseLabel : "Pick image",
            browseIcon : '<i class="fa fa-picture-o"></i>&nbsp;',
            removeClass : "btn btn-default",
            removeLabel : "Delete",
            removeIcon : '<i class="fa fa-trash"></i>',
            showUpload: false,
            allowedFileTypes : ['image'],

        });
    </script>
@endsection

