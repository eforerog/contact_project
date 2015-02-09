@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Contacts</div>

				<div class="panel-body">
					
                    <h2>{{ $contact->first_name }}</h2>
 
                    @if ( !$contact->phones->count() )
                        Your contact has no phone numbers.
                    @else
                        <ul>
                            @foreach( $contact->phones as $phone )
                                <li><a href="{{ route('contacts.phones.show', [$contact->id, $phone->id]) }}">{{ $phone->phone }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                    
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
