<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model {

	public function day() {
		return $this->belongsTo('App\Day');
	}

	public function events() {
		return $this->hasMany('App\Event');
	}

	public $timestamps = false;
}
