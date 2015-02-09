<?php namespace App\Http\Controllers;

use File;
use Input;
use Redirect;
use Validator;
use App\Contact;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
	 * Process data.
	 *
	 * 
	 * @return Response
	 */
	 
	public function loadSpreadsheet()
	{
		return view('contacts.loadsheet');
	}
	 
	 
	public function importSpreadsheet()
	{
		if (Input::hasFile('file_data')) {
			
			Input::file('file_data')->move('public/uploads', Input::file('file_data')->getClientOriginalName());
			
			switch(Input::file('file_data')->guessClientExtension())
			{
				case "xls":	break;
				case "xlsx":	break;
				case "csv":	$xx = Excel::setDelimiter(";");
							break;
				case "tsv": 	$xx = Excel::setDelimiter("\t");
							break;
				default:
							break;
			}
			
			$url = 'public/uploads/' . Input::file('file_data')->getClientOriginalName();
			
			$xx = Excel::load($url, function($reader) {
				
				echo $reader->first();
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
