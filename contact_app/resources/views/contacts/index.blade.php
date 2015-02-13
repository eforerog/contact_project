@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
        
        	<div class="text-right" style="height:50px;">
            	<a class="btn btn-default" href="/contacts/create" role="button">Create contact</a>
            </div>
           
			<div class="panel panel-default">
				<div class="panel-heading">Contact List</div>
                
                	<div class="panel-body">
                    
                    @if ( !$contacts->count() )
                        You have no contacts
                    @else
                    	<div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left">First Name</th>
                                        <th style="text-align:left">Last Name</th>
                                        <th style="text-align:center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach( $contacts as $contact )
                                        <tr>
                                        	<td style="width:30%">
                                            	{{ $contact->first_name }}
                                            </td>
                                            <td style="width:30%">
                                            	{{ $contact->last_name }}
                                            </td >
                                            <td style="width:40%; text-align:center;">
                                                {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('contacts.destroy', $contact->id))) !!}
                                                	{!! link_to_route('contacts.edit', 'Edit', array($contact->id), array('class' => 'btn btn-info btn-xs','style'=>'width:100px;')) !!}
                                                	{!! Form::submit('Delete', array('class' => 'btn btn-xs btn-danger','style'=>'width:100px;')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                     @endforeach
                                </tbody>
                            </table>
                        
                        </div>
                    
                    @endif
                 
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
