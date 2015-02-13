@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Upload data</div>
                	<div class="panel-body">
                    
                    	<p>In this section you can import contacts from external file. This system support XLS, XLSX, CSV and TSV files. Your file must have a header column with the next titles:</p>
                        <ul>
                        	<li>FIRST_NAME (required)</li>
                            <li>LAST_NAME (required)</li>
                            <li>GENDER (Optional, M for Male and F for Female)</li>
                            <li>BIRTHDAY: (Optional)</li>
                            <li>PHONES: (one required, you can import a lot of numbers. Only need separate the numbers with space)</li>
                            <li>EMAILS: (optional, you can import a lot of emails. Only need separate the emails with space)</li>
                        </ul>
                        <p>&nbsp;</p>
                        
                        <div class="jumbotron">
                          <h1 class="text-center">File to upload</h1>
                          
                          {!! Form::open(array('route' => 'importSpreadsheet', 'files'=>true)) !!}
                                <p class="text-center">
                                	{!! Form::file('file_data') !!}
                                </p>
                                <p> </p>
                            <p class="text-center">
                                {!! Form::submit('Upload', ['class'=>'btn btn-primary btn-lg']) !!}
                            </p>
                        {!! Form::close() !!}
                          
                          
                        </div>
 						
                        
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
