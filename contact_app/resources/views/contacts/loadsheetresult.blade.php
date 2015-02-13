@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
        
            @if($error_message)
                <div class="alert alert-danger">
                    <p>{{$error_message}}</p>
                </div>
            @endif
            
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Upload Result</h3>
              </div>
              <div class="panel-body">
                	<p><strong>Time uploading: </strong>{{$final}}</p>
                    <p><strong>Count of errors: </strong>{{$count_error}}</p>
                    <p><strong>Date: </strong>{{$date_out}}</p>
                    <p><strong>User: </strong>{{$user_out}}</p>
                    <p><strong>Status: </strong>{{$message}}</p>
              </div>
            </div>
            
            <nav class="navbar navbar-default" style="text-align:center; padding-top:7px;">
            	<div class="container-fluid">
                	<a class="btn btn-default" href="/loadSpreadsheet" role="button">Try again</a>
                    <a class="btn btn-default" href="/contacts" role="button">Back to contacts</a>
                </div>
            </nav>
		</div>
	</div>
</div>
@endsection
