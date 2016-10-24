@extends('layouts.main')

@section('title' , 'Submits')
@section('styles')
    {!!Html::style('plugins/fileinput/css/fileinput.min.css')!!}
    <style type="text/css" media="screen">
    
        table thead {
          color: #fff;
          background-color: #4C83C3;
        }
    </style>
@endsection  

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Judgements</div>
                    <div class="panel-body">


                        <div class="form-group">

                            <div id = "search" class="form-group">
                                <table style="border-collapse: separate;margin:0 auto;">
                                    <tr style="display:inline; border-spacing:10px;">
                                        <td>
                                            {!!Form::text('user',null,['id'=>'user','class'=>'form-control ','placeholder'=>'User'])!!}
                                        </td>
                                        <td>
                                           {!!Form::text('problem',null,['id'=>'problem','class'=>'form-control ','placeholder'=>'Problem'])!!}
                                        </td>
                                        <td>
                                            {!! Form::select('tags',$tags,null,['id'=>'tag', 'class' => 'form-control select-chosen','placeholder'=>'Select a tag']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('languages',$languages,null,['id'=>'language', 'class' => 'form-control select-chosen','placeholder'=>'Select a language']) !!}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" >
                                                <i class="fa fa-search" aria-hidden="true"></i> Filter
                                            </button>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                             <table class="table table-striped table-bordered table-hover table-condensed table-responsive">

                                <thead>
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;">Date</th>
                                        <th style="text-align: center;">User</th>
                                        <th style="text-align: center;">Problem</th>
                                        <th style="text-align: center;">Judgement</th>
                                        <th style="text-align: center;">Time</th>
                                        <th style="text-align: center;">Mem</th>
                                        <th style="text-align: center;">Size</th>
                                        <th style="text-align: center;">Lang</th>

                                    </tr>
                                </thead>

                                <tbody style="text-align: center;" >
                                    
                                </tbody>

                            </table>
                            <div style="text-align: center;">
                                
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection