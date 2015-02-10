@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Upload data</div>
                	<div class="panel-body">
 					
                    @if($error_message)
                        <div class="alert alert-danger">
                            <p>{{$error_message}}</p>
                        </div>
                    @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
