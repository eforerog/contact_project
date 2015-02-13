@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit phone</div>
                
                	<div class="panel-body">
 						{!! Form::model($phone, ['method' => 'PATCH', 'route' => ['contacts.phones.update', $contact->id, $phone->id], 'class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                {!! Form::label('phone', 'Phone:', array('class' =>"col-sm-2 control-label" )) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('phone',null,array('class' =>"form-control")) !!}
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <a class="btn btn-default" href="/contacts/{{$contact->id}}/edit" role="button">Cancel</a>
                                {!! Form::submit('Edit', ['class'=>'btn btn-primary']) !!}
                            </div>
                        {!! Form::close() !!}
						
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
