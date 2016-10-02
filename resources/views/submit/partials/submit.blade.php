<style type="text/css" media="screen">
    
    #editor {
        position: relative;
        width: 800px;
        height: 400px;
        left:70px;
    }
</style>
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!!Form::label('name','Problem ID:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Some ID Problem Here'])!!}
         @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
    
    {!!Form::label('author','Programming language:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!!Form::select('planguage',[
           '1' => 'C++',
           '2' => 'C',
           '3' => 'Java',
           '4' => 'Python'],null,['class' => 'form-control']
        )!!}
        @if ($errors->has('author'))
            <span class="help-block">
                <strong>{{ $errors->first('author') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
    {!!Form::label('SourceCode','Source code:',['class' => 'col-md-3 control-label file'])!!}
    <div class="col-md-7">
        {!!Form::file('code')!!}
        @if ($errors->has('code'))
            <span class="help-block">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif
     </div>
     
</div>
<div id="editor"></div>

<script src="js/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>

<script>
    var editor = ace.edit("editor");
    editor.setTheme("js/ace/theme/twilight");
    editor.session.setMode("js/ace/mode/javascript");
    function clearBox()
    {
        var editor = ace.edit("editor");
        editor.setValue("new code here");
        //To get the code from the editor
        //var code = editor.getValue();
    }
</script>
