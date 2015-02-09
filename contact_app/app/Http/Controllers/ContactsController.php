<?php namespace App\Http\Controllers;

use File;
use Input;
use Redirect;
use Validator;
use App\Contact;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;
use Excel;

use Illuminate\Http\Request;

class ContactsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$contacts = Contact::all();
		return view('contacts.index', compact('contacts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('contacts.create');
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
			Contact::create( $input );
			return Redirect::route('contacts.index')->with('message', 'Contact created');
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
		return view('contacts.show', compact('contact'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Contact $contact)
	{
		return view('contacts.edit', compact('contact'));
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
			
			return Redirect::route('contacts.create')->withInput()->withErrors( $messages );
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
		return view('contacts.loadsheet');
	}
	 
	 /**
	 * Process contact data.
	 *
	 * 
	 * @return view
	 */
	 
	public function importSpreadsheet()
	{
		$dateformat = "";
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
				
				$rows = $reader->all();
				$first_row = $reader->first();
				
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
								$error_message = $error_message . "required info missing at row " . ($key + 1) . "<br />";
								$count_error+=1;
							}
							//verify gender format
							if(!($row->gender == "M" || $row->gender == "F" || $row->gender == "") ){
								$error_message = $error_message . "gender format error at row " . ($key + 1) . "<br />";	
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
								$error_message = $error_message . "invalid date format at row : " . ($key + 1) . "<br />";
								$count_error+=1;
							}
							
						}
						
						if ($count_error > 0){
							echo "hay errores en el archivo: " . $error_message;
						}
						else{
								
						}
						
				}
				else
				{
					echo "bad headers";
				}
				
				/*if (isset($firstrow['first_name']) && isset($firstrow['last_name']) && isset($firstrow['gender']) && isset($firstrow['birthday']) && isset($firstrow['phones']) && isset($firstrow['emails'])) {
					echo "completo";
				}
				
				echo $reader->first()->first_name;
				echo $reader->first()->last_name;
				echo $reader->first()->gender;
				echo $reader->first()->birthday;
				echo $reader->first()->emails;
				echo $reader->first()->phones;
				*/
			})->get();
			
			
			File::delete($url);
			
			//return $xx->all();
		}
		else
		{
			echo "no hay";
		}
		
	}
	

}
