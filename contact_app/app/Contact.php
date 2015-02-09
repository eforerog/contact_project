<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contacts';
	
	protected $guarded = [];
	
	public function phones()
	{
		return $this->hasMany('App\Phone');
	}
	
	public function emails()
	{
		return $this->hasMany('App\Email');
	}

}
