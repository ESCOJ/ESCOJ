@extends('layouts.main')

@section('title' , 'Standings')
@section('styles')
    {!!Html::style('plugins/chosen/chosen.css')!!} 
@endsection  

@section('content')
<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Ranks</div>
                    <div class="panel-body">


                        <div class="form-group">
                            {!!Form::open(['route' => 'ranks.index', 'method' => 'GET'])!!}
                                <div id = "search" class="form-group">
                                    <table style="border-collapse: separate;margin:0 auto;">
                                        <tr style="display:inline; border-spacing:10px;">
                                            <td>
                                                {!!Form::text('name',null,['id'=>'name','class'=>'form-control ','placeholder'=>'Nickname'])!!}
                                            </td>
                                            
                                            <td>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa fa-search" aria-hidden="true"></i> Search
                                                </button>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            {!! Form::close() !!}
                            <table class="table table-striped table-bordered table-hover table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" class="col-md-1">Rank</th>
                                        <th style="text-align: center;" class="col-md-1">Country</th>
                                        <th style="text-align: center;" class="col-md-2">User</th>
                                        <th style="text-align: center;" class="col-md-1">Sub</th>
                                        <th style="text-align: center;" class="col-md-1">AC</th>
                                        <th style="text-align: center;" class="col-md-1">AC%</th>
                                        <th style="text-align: center;" class="col-md-1">Score</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;" >
                                    <?php $counter = 1;?>
                                    @foreach($users as $user)
                                    <tr>
                                        <?php $ac_percentage = $user->accepted * 100; 
                                                $submitted = ($user->submitted == 0 ? 1:$user->submitted);    
                                        ?>
                                        <?php $ac_percentage = $ac_percentage/$submitted;?>
                                        <td><?php echo $counter;$counter++;?></td>
                                        <td><img src="{{ asset('images/flags/'. $user['country']->flag) }}"  style=" width:30px; height:20px; position: relative; left: 0px;"></td>
                                        <td>{{ $user->nickname }}</td>
                                        <td>{{ $user->submitted }}</td>
                                        <td>{{ $user->accepted }}</td>
                                        <td><?php echo $ac_percentage; ?></td>
                                        <td>{{ $user->points }}</td>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: center;">
                                {{ $users->render() }}
                            </div>


                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {!!Html::script('plugins/chosen/chosen.jquery.js')!!}
    
    <script type="text/javascript">  
        $('.select-chosen').chosen({
        });
    </script>
@endsection