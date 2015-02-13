<?php namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Contact;
use App\Phone;
use Redirect;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PhonesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Contact $contact)
	{
		if(Auth::check()){
			return view('phones.create', compact('contact'));
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
	public function store(Contact $contact)
	{
		$input = Input::all();
		$input['contact_id'] = $contact->id;
		Phone::create($input);
		return Redirect::route('contacts.edit', $contact->id)->with('Phone number created.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Contact $contact, Phone $phone)
	{
		return view('phones.edit', compact('contact', 'phone'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Contact $contact, Phone $phone)
	{
		$rules = array(
			'phone'=> 'required',
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails()) {
			$messages = $validator->messages();
			
			return Redirect::route('contacts.phones.edit')->withInput()->withErrors( $messages );
		}
		else {
			$input = array_except(Input::all(), '_method');
			$phone->update($input);
			return Redirect::route('contacts.edit', $contact->id)->with('message', 'Phone updated.');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Contact $contact, Phone $phone)
	{
		$contact_id = $contact->id;
		$phone->delete();

		return Redirect::route('contacts.edit',  array($contact_id))->with('message', 'Phone deleted.');
	}

}
