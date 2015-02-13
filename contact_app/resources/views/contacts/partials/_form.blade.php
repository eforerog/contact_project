<div class="form-group">
    {!! Form::label('first_name', 'First Name:', array('class' =>"col-sm-2 control-label" )) !!}
    <div class="col-sm-10">
    	{!! Form::text('first_name',null,array('class' =>"form-control")) !!}
	</div>
</div>
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:', array('class' =>"col-sm-2 control-label" )) !!}
    <div class="col-sm-10">
    	{!! Form::text('last_name',null,array('class' =>"form-control")) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::hidden('user_id', Auth::id()) !!}
</div>
<div class="form-group">
	<p class="col-sm-2 control-label">Gender:</p>
    <div class="col-sm-10">
    	{!! Form::radio('gender', 'M') !!}
    	{!! Form::label('gender', '  Male', array('class' =>"control-label" )) !!}<br />
        {!! Form::radio('gender', 'F') !!}
        {!! Form::label('gender', '  Female', array('class' =>"control-label" )) !!}
        
    </div>
</div>
<div class="form-group">
    {!! Form::label('birthday', 'Birthday:', array('class' =>"col-sm-2 control-label" )) !!}
     <div class="col-sm-10">
     	 {!! Form::text('birthday', null, array('class' =>"form-control" )) !!}
         <script type="text/javascript">
		 
		 	$( document ).ready(function() {
				$('#birthday').datetimepicker({
					format: 'YYYY-MM-DD',
				});
			});
			
		</script>
     </div>
   
</div>

<div class="form-group text-center">
	<a class="btn btn-default" href="/contacts" role="button">Cancel</a>
    {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
</div>