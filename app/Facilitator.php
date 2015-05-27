<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Facilitator extends Model {

	public function event() {
		return $this->belongsTo('App\Event');
	}

	public $timestamps = false;
}
