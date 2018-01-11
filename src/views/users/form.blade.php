<div class="form-group {!! ($errors->has('name')) ? 'has-error' : '' !!}">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'attendance' )) !!}
    {!! ($errors->has('name') ? $errors->first('name') : '') !!}
</div>




 
