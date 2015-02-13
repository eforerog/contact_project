<?php namespace App\Http\Controllers;

use File;
use Input;
use Redirect;
use Validator;
use App\Contact;
use App\Phone;
use App\Email;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;
use Excel;
use DB;
use Auth;

use Illuminate\Http\Request;

class ContactsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::check()){
			$contacts = Contact::all();
			return view('contacts.index', compact('contacts'));
		}
		else {
			return view('Auth/login');
			//return Redirect::route('index')->with('message', 'Please login.');
		}
		
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Auth::check()){
			return view('contacts.create');
		}
		else
		{
			return view('Auth/login');
		}
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'first_name'=> 'required',
			'last_name'=> 'required'//,
			//'birthday'=> 'required'
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails()) {
			$messages = $validator->messages();
			
			return Redirect::route('contacts.create')->withInput()->withErrors( $messages );
		}
		else {
			$input = Input::all();
			$contact = Contact::create( $input );
			return Redirect::route('contacts.edit', $contact->id)->with('message', 'Contact created');
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Contact $contact)
	{
		if(Auth::check()){
			return view('contacts.show', compact('contact'));
		}
		else
		{
			return view('Auth/login');
		}
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Contact $contact)
	{
		if(Auth::check()){
			
			$phones = Phone::where('contact_id','=',$contact->id)->get();
			
			$emails = Email::where('contact_id','=',$contact->id)->get();
			
			return view('contacts.edit', compact('contact', 'phones', 'emails'));
		}
		else
		{
			return view('Auth/login');
		}
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Contact $contact)
	{
		
		$rules = array(
			'first_name'=> 'required',
			'last_name'=> 'required'//,
			//'birthday'=> 'required'
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails()) {
			$messages = $validator->messages();
			
			return Redirect::route('contacts.edit')->withInput()->withErrors( $messages );
		}
		else {
			$input = array_except(Input::all(), '_method');
			$contact->update($input);
			return Redirect::route('contacts.index')->with('message', 'Contact updated.');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Contact $contact)
	{
		$contact->delete();
		return Redirect::route('contacts.index')->with('message', 'Contact deleted.');
	}
	
	/**
	 * form to upload contact data.
	 *
	 * 
	 * @return view
	 */
	 
	public function loadSpreadsheet()
	{
		if(Auth::check()){
			
			return view('contacts.loadsheet');
		}
		else
		{
			return view('Auth/login');
		}
		
	}
	 
	 /**
	 * Process contact data.
	 *
	 * 
	 * @return view
	 */
	 
	public function importSpreadsheet()
	{
		$error_message = "";
		$dateformat = "";
		$start_datetime = new DateTime();
		
		$starttime = microtime(true);
		
		if (Input::hasFile('file_data')) {
			
			Input::file('file_data')->move('public/uploads', Input::file('file_data')->getClientOriginalName());
			
			switch(Input::file('file_data')->guessClientExtension())
			{
				case "xls":	break;
				case "xlsx":break;
				case "csv":	$xx = Excel::setDelimiter(";");
							break;
				case "tsv": 	$xx = Excel::setDelimiter("\t");
							break;
				default:		break;
			}
			
			$url = 'public/uploads/' . Input::file('file_data')->getClientOriginalName();
			
			$xx = Excel::load($url, function($reader) {
				
			})->get();
			
			
			$rows = $xx;
			$first_row = $xx->first();
			
			//headers check
			$test_header =  json_encode($first_row);
			
			if ((strpos($test_header,'"first_name"') !== false) 
				&& (strpos($test_header,'"last_name"') !== false)
				&& (strpos($test_header,'"gender"') !== false)
				&& (strpos($test_header,'"birthday"') !== false)
				&& (strpos($test_header,'"emails"') !== false)
				&& (strpos($test_header,'"phones"') !== false)){
					
					$count_error = 0;
					$error_message = "";
					foreach ($rows as $key=>$row ) {
						//verifiy required data
						if(!($row->first_name != "" && $row->last_name !="" && $row->phones != "")) {
							$error_message = $error_message . "required info missing at row " . ($key + 1) . ", ";
							$count_error+=1;
						}
						//verify gender format
						if(!($row->gender == "M" || $row->gender == "F" || $row->gender == "") ){
							$error_message = $error_message . "gender format error at row " . ($key + 1) . ", ";	
							$count_error+=1;
						}
						
						//verify birthday format
						switch(Input::file('file_data')->guessClientExtension())
						{
							case "xls":	$dateformat = 'Y-m-d H:i:s';
										break;
							case "xlsx":$dateformat = 'Y-m-d H:i:s';
										break;
							case "csv":	$dateformat = 'd/m/Y';
										break;
							case "tsv": 	$dateformat = 'd/m/Y';
										break;
							default:
										break;
						}
						
						$ymd = DateTime::createFromFormat($dateformat, $row->birthday);
						if(!$ymd){
							$error_message = $error_message . "invalid date format at row : " . ($key + 1) . ", ";
							$count_error+=1;
						}
						
					}
					
					if ($count_error > 0){
						$error_message = "Errors in upload process: " . $count_error . " - Description: " .  $error_message . ". Please check and try again.";
						
						//print log
						$url_log = 'public/contact_errors.log';
						if (File::exists($url_log)){
							$log_file = File::get($url_log);
							
							$log_file = $log_file . "\n" . Auth::id() . "\t" . $start_datetime->format('Y\-m\-d\ h:i:s') . "\t" . $error_message;
						
						$bytes_written = File::put($url_log, $log_file);
						}
						else{
							$log_file = "user_id\tdate\terror_description\n";
							$log_file = $log_file . Auth::id() . "\t" . $start_datetime->format('Y\-m\-d\ h:i:s') . "\t" . $error_message;
							$bytes_written = File::put($url_log, $log_file);
						}
						
						//Time calc
						$diff = microtime(true) - $starttime;
						$sec = intval($diff);
						$micro = $diff - $sec;
						$final = strftime('%T', mktime(0, 0, $sec)) . str_replace('0.', '.', sprintf('%.3f', $micro));
						
						$date_out = $start_datetime->format('Y\-m\-d\ h:i:s');
						$user_out = Auth::user()->name;
						$message = "Upload with errors. Data not saved.";
						
						return view('contacts.loadsheetresult', compact('error_message', 'final', 'count_error', 'date_out', 'user_out', 'message'));
						
					}
					else{
						
							foreach ($rows as $key=>$row ) {
								$newContact = Contact::create([
									'first_name'=> $row->first_name,
									'last_name'=> $row->last_name,
									'gender'=> $row->gender,
									'birthday'=> $row->birthday,
									'user_id'=>Auth::id()
								]);
								
                                $arrayPhones = explode(" ", $row->phones);
								
								foreach ($arrayPhones as $value) {
									$newPhone = Phone::create([
										'phone'=> $value,
										'contact_id'=> $newContact->id
									]);
								}
								
								if($row->emails != ""){
									$arrayEmails = explode(" ", $row->emails);
									foreach ($arrayEmails as $key_1=>$value) {
										if($key_1 == 0){
											$primary_value = 1;
										}
										else {
											$primary_value = 0;
										}
										$newEmail = Email::create([
											'email'=> $value,
											'primary'=> $primary_value,
											'contact_id'=> $newContact->id
										]);
									}
								}
							}
							
							$diff = microtime(true) - $starttime;
							$sec = intval($diff);
							$micro = $diff - $sec;
							$final = strftime('%T', mktime(0, 0, $sec)) . str_replace('0.', '.', sprintf('%.3f', $micro));
						
							$date_out = $start_datetime->format('Y\-m\-d\ h:i:s');
							$user_out = Auth::user()->name;
							$message = "Contacts uploaded succesfully.";
							
							return view('contacts.loadsheetresult', compact('error_message', 'final', 'count_error', 'date_out', 'user_out', 'message'));
						
					}
					
			}
			else
			{
				$diff = microtime(true) - $starttime;
				$sec = intval($diff);
				$micro = $diff - $sec;
				$final = strftime('%T', mktime(0, 0, $sec)) . str_replace('0.', '.', sprintf('%.3f', $micro));
				$date_out = $start_datetime->format('Y\-m\-d\ h:i:s');
				$user_out = Auth::user()->name;
				$message = "Headers missing or with errors. Data not saved.";
				$count_error = 1;
				
				$error_message = "The file have some headers errors. Remember that the headers must be: first_name, last_name, gender, birthday, phones and emails";
				
				return view('contacts.loadsheetresult', compact('error_message', 'final', 'count_error', 'date_out', 'user_out', 'message'));
				
			}
			
			
			File::delete($url);
			
		}
		else
		{
			$diff = microtime(true) - $starttime;
			$sec = intval($diff);
			$micro = $diff - $sec;
			$final = strftime('%T', mktime(0, 0, $sec)) . str_replace('0.', '.', sprintf('%.3f', $micro));
			$date_out = $start_datetime->format('Y\-m\-d\ h:i:s');
			$user_out = Auth::user()->name;
			$message = "No file selected to upload";
			$count_error = 1;
				
			$error_message = "No file selected to upload";
			return view('contacts.loadsheetresult', compact('error_message', 'final', 'count_error', 'date_out', 'user_out', 'message'));
				
			
		}
		
		
		
	}
	

}
