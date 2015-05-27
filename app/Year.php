<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model {

	public function days(){
		return $this->hasMany('App\Day');
	}

	public function speakers(){
		return $this->hasMany('App\Speaker');
	}

	public function exhibitors(){
		return $this->hasMany('App\Exhibitor');
	}

	public $timestamps = false;

}
