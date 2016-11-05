<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Add Submit</div>
                    <div class="panel-body">
                        <form enctype="multipart/form-data" id="formuploadajax" method="POST" accept-charset="UTF-8" class="form-horizontal">

                            <!--Problem id-->
                            <div id="div_problem_id" class="form-group">
                                {!!Form::label('problem_id','Problem:',['class' => 'col-md-3 control-label'])!!}
                                <div class="col-md-7">
                                    {!! Form::select('problem_id',$problems_map,null,['id'=>'problem_id', 'class' => 'form-control select-chosen']) !!}
                                    <span id = "span_problem_id" class="help-block" style="display:none">
                
                                    </span>
                                </div>
                            </div>

                            <!--Language-->
                            <div id="div_language" class="form-group">
                                {!!Form::label('language','Programming language:',['class' => 'col-md-3 control-label'])!!}
                                <div class="col-md-7">
                                    {!! Form::select('language',$languages,'1',['id'=>'language', 'class' => 'form-control select-chosen']) !!}
                                     <span id = "span_language" class="help-block" style="display:none">
                
                                    </span>
                                </div>
                            </div>

                            <!--Code input file-->
                            <div id="div_code" class="form-group">
                                {!!Form::label('code','Source code:',['class' => 'col-md-3 control-label file'])!!}
                                <div class="col-md-7">
                                    <input id="code" name="code" type="file" value="" />
                                    <span id = "span_code" class="help-block" style="display:none">
                
                                    </span>
                                 </div>
                            </div>

                            <!--Editor to put your code-->
                            <div id="div_your_code_in_the_editor" class="form-group">
                                <div id="editor"></div>
                                <div class="col-md-7 col-md-offset-3">
                                    <input type="hidden" name="your_code_in_the_editor" id="your_code_in_the_editor">
                                    <span id = "span_your_code_in_the_editor" class="help-block" style="display:none">
                
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-5">
                                    <input type="button" value="Clear" onclick="clearBox()" class="btn btn-primary">
                                     
                                    <input type="submit" value="Submit" class="btn btn-primary">

                                    <input type="hidden" name="contest_id" id="contest_id" value="{{ $contest->id }}">  
                                </div>
                            </div>
                        </form>
                        <!-- div to display success message-->
                        <div id = "div_success" class="col-md-6 col-md-offset-3" style="display:none"> </div>
                    </div>
            </div>
        </div>
    </div>
</div>