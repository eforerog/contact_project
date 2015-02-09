@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Upload data</div>
                	<div class="panel-body">
 						
                        {!! Form::open(array('route' => 'importSpreadsheet', 'files'=>true)) !!}
                        
                            <div class="form-group">
                                {!! Form::label('file_data', 'File to upload:') !!}
                                {!! Form::file('file_data') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Upload', ['class'=>'btn primary']) !!}
                            </div>
                        {!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
