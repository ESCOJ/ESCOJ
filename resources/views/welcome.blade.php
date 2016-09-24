@extends('layouts.main')
@section('content')
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
                        <div class="text-center"><br><a class="btn btn-lg btn-primary" href="{{ url('/register') }}">Registrate &amp; Empieza a codiguear!</a></div>

                    <br><br>

                </div>
            </div>
        </div>

        <div class="col-md-12 text-center"> 
            <h5>
                <button class="btn btn-success" style="margin:0;" >
                    <a style="text-decoration:none;color:white;" href="./problems.php">
                    Ir a Problemas 
                    <span class="glyphicon glyphicon-education" aria-hidden="true"></span>
                    </a>
                </button>
            </h5>
        </div>
        <br>
    </form>
</div>         

@endsection
