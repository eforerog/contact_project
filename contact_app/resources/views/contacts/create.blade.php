@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Create new contact</div>
                
                	<div class="panel-body">
 
                    	{!! Form::model(new App\Contact, ['route' => ['contacts.store']]) !!}
                            @include('contacts/partials/_form', ['submit_text' => 'Create Contact'])
                        {!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
