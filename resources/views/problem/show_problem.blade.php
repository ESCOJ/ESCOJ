@extends('layouts.main')

@section('title' , 'Add Submit')

@section('styles')
@endsection

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><center>{{ $problem->id }} - {{ $problem->name }}</center></strong></div>
                    <div class="panel-body">
                        
                        <h3><center>{{ $problem->name}}</center></h3>
                        <!--border: 1px dotted blue; border-radius: 15px;-->
                         
                        <div class="col-xs-offset-2 col-xs-8" >
                            <br>
                            <table class="table table-condensed table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Time Limit Per Case</th>
                                        <th style="text-align: center;">Total Time Limit</th>
                                        <th style="text-align: center;">Memory Limit</th>
                                        <th style="text-align: center;">Source Limit</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    <tr class="info">
                                        <td>{{ $problem->tlpc }} ms</td>
                                        <td>{{ $problem->ttl }} ms</td>
                                        <td>{{ $problem->ml }} mb</td>
                                        <td>{{ $problem->sl }} mb</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="">
                            <div class="col-xs-10">
                                <br>
                                <h4 class="text-primary">Description</h4>
                                <div class="row">
                                    <div class="col-xs-10" data-language="en">
                                        {!! $problem->description !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-10">
                                <h4 class="text-primary">Input Specification</h4>
                                <div class="row">
                                    <div class="col-xs-10" data-language="en">
                                        {!! $problem->input_specification !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-10">
                                <h4 class="text-primary">Output Specification</h4>
                                <div class="row">
                                    <div class="col-xs-10" data-language="en">
                                        {!! $problem->output_specification !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-10">
                                <h4 class="text-primary">Sample Input</h4>
                                <div class="row">
                                    <div class="col-xs-10" data-language="en">
                                        <code>{!! $problem->sample_input !!}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-10">
                                <h4 class="text-primary">Sample Output</h4>
                                <div class="row">
                                    <div class="col-xs-10" data-language="en">
                                        <code>{!! $problem->sample_output !!}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-10">
                                <h4 class="text-primary">Hints</h4>
                                <div class="row">
                                    <div class="col-xs-10" data-language="en">
                                        {!! $problem->hints !!}
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-offset-1 col-xs-10">
                            <div class="panel panel-primary text-center">
                               <span class="text-info">Problem Data</span>
                            </div>
                        </div>
                        
                        <div class="col-xs-offset-2 col-xs-8">
                            <br>
                            <table class="table table-condensed table-responsive table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Author:</strong></td>
                                        <td>{{ $problem->source->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Added by:</strong></td>
                                        <td>{{ $problem->user->nickname }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Points</strong></td>
                                        <td>{{ $problem->points }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date Added:</strong></td>
                                        <td>{{ $problem->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Languages:</strong></td>
                                        <td>
                                            @foreach($problem->languages as $language)
                                                @if($loop->last)
                                                    {{ $language->name }}
                                                @else
                                                    {{ $language->name }}, 
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                       <div class="col-xs-offset-2 col-xs-8" style=" text-align: center;">

                       {!! Html::decode(link_to_action('ProblemController@downloadDatasets', $title = '<i class="fa fa-paper-plane" aria-hidden="true"></i> Submit', $parameters = ['id'=> $problem->id ], $attributes = [ 'class' => 'btn btn-primary' ])) !!}
                       <div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection