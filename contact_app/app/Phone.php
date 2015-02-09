<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'phones';
	//
	
	public function contact()
	{
		return $this->belongsTo('App\Contact');
	}

}
