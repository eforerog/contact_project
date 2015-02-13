<?php namespace App\Http\Controllers;

use Input;
use Redirect;
use Validator;
use App\Contact;
use App\Email;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use Illuminate\Http\Request;

class EmailsController extends Controller {

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
			return view('emails.create', compact('contact'));
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
		Email::create($input);
		return Redirect::route('contacts.edit', $contact->id)->with('Email created.');
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
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Contact $contact, Email $email)
	{
		$contact_id = $contact->id;
		$email->delete();

		return Redirect::route('contacts.edit',  array($contact_id))->with('message', 'Email deleted.');
	}

}
