@extends('layouts.main')

@section('title' , 'Users')

@section('styles')
    {!!Html::style('plugins/chosen/chosen.css')!!}
@endsection  

@section('content')

@include('user.admin.modal')

<div id="divEspacio" class="rox marg-main" style="margin-top:40px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">ESCOJ-Users</div>
                    <div class="panel-body">

                            <div class="col-md-8 col-md-offset-2 text-center">
                                <h5>
                                    @include('flash::message')
                                </h5>
                            </div>  
                        <div class="form-group">
                            
                            {!!Form::open(['route' => 'user.users', 'method' => 'GET'])!!}
                        
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-7">
                                            {!!Form::text('nickname',null,['id'=>'nickname','class'=>'form-control ','placeholder'=>'Nickname'])!!}
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa fa-search" aria-hidden="true"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                <br>
                        
                            {!! Form::close() !!}

                             <table class="table table-striped table-bordered table-hover table-condensed table-responsive">

                                <thead>
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;" >Nickname</th>
                                        <th style="text-align: center;" >Name</th>
                                        <th style="text-align: center;" >Role</th>
                                        <th style="text-align: center;" >Edit</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align: center;" >
                                    @foreach($users as $user)
                                        <tr>
                                            <!--ID-->
                                            <td>
                                                {{ $user->id }}
                                            </td>
                                            <!--Nickname-->
                                            <td>
                                                {{ $user->nickname }}
                                            </td>
                                            <!--Name-->
                                            <td>
                                                {{ $user->name . ' ' . $user->last_name}} 
                                            </td>
                                            <!--Role-->
                                            <td>
                                                @if($user->role === 'admin')
                                                    <span class="label label-primary">{{ $user->role }}</span>
                                                @elseif($user->role === 'problem_setter')
                                                    <span class="label label-info">{{ $user->role }}</span>
                                                @elseif($user->role === 'coach')
                                                    <span class="label label-success">{{ $user->role }}</span>
                                                @else
                                                    <span class="label label-default">{{ $user->role }}</span>
                                                @endif
                                            </td>
                                            <!--Edit-->
                                            <td>
                                                <button value="{{ $user->id . ' ' . $user->nickname . ' ' . $user->role }}" OnClick='Mostrar(this);' class='btn btn-primary' data-toggle='modal' data-target='#myModal'>
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div style="text-align: center;">
                                {{ $users->appends(Request::input())->render() }}
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
        $('div.alert').delay(10000).fadeOut(350);

        function Mostrar(btn){
            var res = btn.value.split(" ");
            $("#id").val(res[0]);
            $("#nickname").val(res[1]);

            $('#role option').each(function() {
                $(this).removeAttr('selected');
            });

            $("#role option[value=" +res[2]+ "]").attr('selected','selected');

            $('#role').chosen({
                width: "100%"
            });
            $("#role").trigger("chosen:updated");
        }


    </script>
@endsection