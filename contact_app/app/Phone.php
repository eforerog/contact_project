<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'phones';
	
	protected $guarded = [];
	
	
	protected $fillable = array('phone', 'contact_id');
	
	public function contact()
	{
		return $this->belongsTo('App\Contact');
	}

}
