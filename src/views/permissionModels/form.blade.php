<div class="form-group {!! ($errors->has('name')) ? 'has-error' : '' !!}">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'attendance' )) !!}
    {!! ($errors->has('name') ? $errors->first('name') : '') !!}
</div> 
<div class="form-group {!! ($errors->has('display_name')) ? 'has-error' : '' !!}">
    {!! Form::label('display_name', 'Display name') !!}
    {!! Form::text('display_name', null, array('class' => 'form-control', 'placeholder' => 'attendance' )) !!}
    {!! ($errors->has('display_name') ? $errors->first('display_name') : '') !!}
</div>