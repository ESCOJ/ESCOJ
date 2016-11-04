@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div id="divEspacio1" class="rox marg-main" style="margin-top:60px;"></div>
    <div class="col-md-6 col-md-offset-3 text-center">
        <h4>
            @include('flash::message')
        </h4>
    </div>  
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
                        
                        @if (Auth::guest())

                            <div class="col-md-4 col-md-offset-4 text-center">
                                <br>
                                <h5>
                                    {!!Html::decode(link_to('/register', $title='<i class="fa fa-users" aria-hidden="true"></i> Register and start coding!', $attributes = ['class'=>' btn btn-lg btn-default']))!!}
                                </h5>
                                <br>

                            </div>
                        @endif


                    <br><br>

                </div>
            </div>
        </div>

        <div class="col-md-2 col-md-offset-5 text-center"> 

            {!!Html::decode(link_to_route('problem.index', $title='<i class="fa fa-book" aria-hidden="true"></i> Go problems',$parameters = [] , $attributes = ['class'=>'form-control btn btn-primary']))!!}
        </div>
        <br>
    </form>
</div>         

@endsection

@section('scripts')
    @if(isset($login) or session('login'))
        <script type="text/javascript">
            $('#drop_login').addClass('open');
            $('#a_login').attr("aria-expanded","true");
        </script>
    @endif
@endsection
