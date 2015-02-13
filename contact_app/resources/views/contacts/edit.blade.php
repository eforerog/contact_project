@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit contact</div>
                
                	<div class="panel-body">                        
                        
                         {!! Form::model($contact, ['method' => 'PATCH', 'route' => ['contacts.update', $contact->id], 'class' => 'form-horizontal']) !!}
                            @include('contacts/partials/_form', ['submit_text' => 'Edit Contact'])
                        {!! Form::close() !!}
                
                
				</div>
			</div>
            
            <div class="panel panel-default">
            	<div class="panel-heading">Phone numbers</div>
                <div class="panel-body"> 
                	@if ( !$phones->count() )
                        No phones numbers for this contact.
                    @else
                    	<div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left">Phone Number</th>
                                        <th style="text-align:center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach( $phones as $phone )
                                        <tr>
                                        	<td style="width:60%">
                                            	{{ $phone->phone }}
                                            </td>
                                            <td style="width:40%; text-align:center;">
                                                {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('contacts.phones.destroy', $contact->id, $phone->id))) !!}
                                                	{!! link_to_route('contacts.phones.edit', 'Edit', array($contact->id,$phone->id), array('class' => 'btn btn-info btn-xs','style'=>'width:100px;')) !!}
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
                <div class="text-center" style="height:50px;">
                    <a class="btn btn-default" href="/contacts/{{$contact->id}}/phones/create" role="button">Create phone number</a>
                </div>
            </div>
            
            <div class="panel panel-default">
            	<div class="panel-heading">Email addresses</div>
                <div class="panel-body"> 
                	@if ( !$emails->count() )
                        No emails addresses for this contact.
                    @else
                    	<div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left">Email</th>
                                        <th style="text-align:left">Primary</th>
                                        <th style="text-align:center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach( $emails as $email )
                                        <tr>
                                        	<td style="width:50%">
                                            	{{ $email->email }}
                                            </td>
                                            <td style="width:10%" class="text-center">
                                            	@if ( $email->primary == 1  )
                                                	Yes
                                                @else
                                                	No
                                                @endif
                                            	
                                            </td>
                                            <td style="width:40%; text-align:center;">
                                                {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('contacts.emails.destroy', $contact->id,$email->id))) !!}
                                                	{!! link_to_route('contacts.emails.edit', 'Edit', array($contact->id, $email->id), array('class' => 'btn btn-info btn-xs','style'=>'width:100px;')) !!}
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
                
                <div class="text-center" style="height:50px;">
                    <a class="btn btn-default" href="/contacts/{{$contact->id}}/emails/create" role="button">Create email</a>
                </div>
                
            </div>
		</div>
	</div>
</div>
@endsection
