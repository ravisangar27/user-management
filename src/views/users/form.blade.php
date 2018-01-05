<div class="form-group {!! ($errors->has('name')) ? 'has-error' : '' !!}">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'attendance' )) !!}
    {!! ($errors->has('name') ? $errors->first('name') : '') !!}
</div>

<div class="form-group {!! ($errors->has('email')) ? 'has-error' : '' !!}">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => '' )) !!}
    {!! ($errors->has('email') ? $errors->first('email') : '') !!}
</div> 

<div class="form-group {!! ($errors->has('password	')) ? 'has-error' : '' !!}">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', null, array('class' => 'form-control awesome' )) !!}
    {!! ($errors->has('password	') ? $errors->first('password	') : '') !!}
</div> 

<div class="form-group {!! ($errors->has('confirm_password')) ? 'has-error' : '' !!}">
    {!! Form::label('confirm_password', 'Confirm password') !!}
    {!! Form::password('confirm_password', null, array('class' => 'form-control', 'placeholder' => '' )) !!}
    {!! ($errors->has('confirm_password') ? $errors->first('confirm_password') : '') !!}
</div> 
 
