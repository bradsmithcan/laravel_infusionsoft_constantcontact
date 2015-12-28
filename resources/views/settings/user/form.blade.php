<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', 'Confirm password:') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
</div>

@if($user->plan)
    <div class="form-group">
        {!! Form::label('plan', 'Plan:') !!}
        {!! Form::select('plan_id', $plans, $user->plan->id, ['id' => 'plan_id', 'class' => 'form-control']) !!}
    </div>
@endif

<div class="form-group">
    {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
</div>