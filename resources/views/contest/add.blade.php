@extends('layouts.main')

@section('title' , 'Add constest')

@section('styles')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
    {!!Html::style('plugins/chosen/chosen.css')!!}
    {!!Html::style('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')!!}    
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><center>Add Contest</center></strong></div>
                    <div class="panel-body">
                        {!!Form::open(['route' => 'contest.store', 'method' => 'POST', 'class' => 'form-horizontal'])!!}


                            @include('contest.partials.contest')

                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-5 row">
                                    {!!Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('type' => 'submit', 'class' => 'form-control btn btn-primary'))!!}
                                </div>

                            </div>

                        {!!Form::close()!!}
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {!!Html::script('plugins/trumbowyg/trumbowyg.js') !!}
    {!!Html::script('plugins/chosen/chosen.jquery.js')!!}
    {!!Html::script('plugins/moment/js/moment.min.js')!!}    
    {!!Html::script('plugins/bootstrap/js/transition.js')!!}
    {!!Html::script('plugins/bootstrap/js/collapse.js')!!}
    {!!Html::script('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')!!}    

    <script type="text/javascript">
        $('.textarea-content').trumbowyg();
      
        $('.select-organization').chosen({
        });
    </script>
    <script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
@endsection
