<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model {

	public function year() {
		return $this->belongsTo('App\Year');
	}

	public $timestamps = false;

}
