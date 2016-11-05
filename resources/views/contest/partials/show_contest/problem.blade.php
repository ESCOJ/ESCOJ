<div class="col-md-6 col-md-offset-3">
    <button onclick = "showProblemsTable()" class="form-control btn btn-default" type="button">
        <i class="fa fa-eye" aria-hidden="true"></i> Show problems
    </button>
</div>
<br><br><br>
<div class="container" >
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><center>{{ $problem->id }} - {{ $problem->name }}</center></strong></div>
                    <div class="panel-body">
                        
                        <h3><center>{{ $problem->name}}</center></h3>
                        <br>
                         
                        <h4>    
                            <label for="input" class="col-sm-offset-1 col-sm-10 label label-primary">
                                <center>Problem Limits</center>
                            </label>
                        </h4>

                        <div class="col-xs-offset-2 col-xs-8" >
                            <br>
                            <table class="table table-condensed table-bordered table-responsive">
                                <thead>
                                    <tr class="active">
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

                        <h4>    
                            <label for="input" class="col-sm-offset-1 col-sm-10 label label-primary">
                                <center>Problem Description</center>
                            </label>
                        </h4>

                        <div class="col-xs-offset-1">
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
                        
                        <h4>    
                            <label for="input" class="col-sm-offset-1 col-sm-10 label label-primary">
                                <center>Problem Data</center>
                            </label>
                        </h4>
                        
                        <div class="col-xs-offset-2 col-xs-8">
                            <br>
                            <table class="table table-condensed table-responsive table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="info"><strong>Author:</strong></td>
                                        <td class="active">{{ $problem->source->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info"><strong>Added by:</strong></td>
                                        <td class="active">{{ $problem->user->nickname }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info"><strong>Points</strong></td>
                                        <td class="active">{{ $problem->points }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info"><strong>Date Added:</strong></td>
                                        <td class="active">{{ $problem->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info"><strong>Languages:</strong></td>
                                        <td class="active">
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

                        @if(Auth::check())
                            <div class="col-xs-offset-2 col-xs-8" style=" text-align: center;">
                                    <a onclick = "addJudgment({{ $problem->id }})" id="show_problem" style="cursor:pointer;" class="btn btn-primary">
                                        <strong>Submit </strong><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </a>
                            </div>
                        @endif

                    </div>
            </div>
        </div>
    </div>
</div>