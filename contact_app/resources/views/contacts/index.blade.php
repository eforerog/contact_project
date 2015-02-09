@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Contacts</div>
                
                	<div class="panel-body">
 
                    @if ( !$contacts->count() )
                        You have no contacts
                    @else
                        <ul>
                            @foreach( $contacts as $contact )
                                <li>
                                    {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('contacts.destroy', $contact->id))) !!}
                                        <a href="{{ route('contacts.show', $contact->id) }}">{{ $contact->first_name }}</a>
                                        (
                                            {!! link_to_route('contacts.edit', 'Edit', array($contact->id), array('class' => 'btn btn-info')) !!},
                                            {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                                        )
                                    {!! Form::close() !!}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                 
                    <p>
                        {!! link_to_route('contacts.create', 'Create Contact') !!}
                    </p>
                
                
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
