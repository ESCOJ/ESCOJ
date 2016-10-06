

<div class="form-group{{ $errors->has('problem_id') ? ' has-error' : '' }}">
    {!!Form::label('problem_id','Problem ID:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!!Form::text('problem_id',null,['class'=>'form-control','placeholder'=>'ID Problem'])!!}
         @if ($errors->has('problem_id'))
            <span class="help-block">
                <strong>{{ $errors->first('problem_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
    {!!Form::label('language','Programming language:',['class' => 'col-md-3 control-label'])!!}
    <div class="col-md-7">
        {!! Form::select('language',$languages,'1',['id'=>'language', 'class' => 'form-control']) !!}
        @if ($errors->has('language'))
            <span class="help-block">
                <strong>{{ $errors->first('language') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
    {!!Form::label('code','Source code:',['class' => 'col-md-3 control-label file'])!!}
    <div class="col-md-7">
        {!!Form::file('code')!!}
        @if ($errors->has('code'))
            <span class="help-block">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif
     </div>
</div>

<div class="form-group{{ $errors->has('your_code_in_the_editor') ? ' has-error' : '' }}">
    <div id="editor"></div>
    <div class="col-md-7 col-md-offset-3">
        <input type="hidden" name="your_code_in_the_editor" id = "your_code_in_the_editor">
        @if ($errors->has('code'))
            <span class="help-block">
                <strong>{{ $errors->first('your_code_in_the_editor') }}</strong>
            </span>
        @endif
    </div>
</div>



