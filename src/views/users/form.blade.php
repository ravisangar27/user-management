<div class="form-group {!! ($errors->has($userName)) ? 'has-error' : '' !!}">
    {!! Form::label($userName, 'User name') !!}
    {!! Form::text($userName, null, array('class' => 'form-control', 'placeholder' => '' )) !!}
    {!! ($errors->has($userName) ? $errors->first($userName) : '') !!}
</div>




 
