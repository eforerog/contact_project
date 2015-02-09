<div class="form-group">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name') !!}
</div>
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name') !!}
</div>
<div class="form-group">
    {!! Form::hidden('user_id', Auth::id()) !!}
</div>
<div class="form-group">
	<p>Gender:</p>
    {!! Form::label('gender', 'Male:') !!}
    {!! Form::radio('gender', 'M') !!}<br />
    {!! Form::label('gender', 'Female:') !!}
    {!! Form::radio('gender', 'F') !!}
</div>
<div class="form-group">
    {!! Form::label('birthday', 'Birthday:') !!}
    {!! Form::input('date', 'birthday') !!}
</div>

<div class="form-group">
    {!! Form::submit($submit_text, ['class'=>'btn primary']) !!}
</div>