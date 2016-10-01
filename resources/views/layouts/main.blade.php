<!DOCTYPE HTML>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ESCOJ - @yield('title','Welcome')</title>

 		 <!-- Styles -->
        {!!Html::style('plugins/bootstrap/css/bootstrap.min.css')!!}
	    {!!Html::style('plugins/bootstrap/css/bootstrap-theme.min.css')!!}
	    {!!Html::style('css/style.css')!!}
        {!! Html::style('plugins/font-awesome/css/font-awesome.min.css') !!}
        {!! Html::style('plugins/bootstrap-social/css/bootstrap-social.css') !!}
        
        @yield('styles')

            <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

    </head>

	<body>
      
        @include('layouts.partials.nav-bar-top')    

        @yield('content')

        <!-- Scripts -->
	    {!!Html::script('plugins/bootstrap/js/bootstrap.min.js')!!}
	    {!!Html::script('plugins/jquery/js/jquery-3.1.0.js')!!}
	    {!!Html::script('plugins/bootstrap/js/bootstrap.js')!!}
        
        @yield('scripts')
      

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

    </body>

</html>