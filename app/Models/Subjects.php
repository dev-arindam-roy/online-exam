<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $table = 'subjects';
    protected $primaryKey = "id";

    public function languageInfo() {
		return $this->belongsTo('App\Models\Languages', 'language_id', 'id');
	}

	public function questions() {
		return $this->hasMany('App\Models\Questions', 'subject_id', 'id')->where('status', '=', '1');
	}
}
