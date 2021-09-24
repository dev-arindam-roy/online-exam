<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';
    protected $primaryKey = "id";

    public function languageInfo() {
		return $this->belongsTo('App\Models\Languages', 'language_id', 'id');
	}

	public function subjectInfo() {
		return $this->belongsTo('App\Models\Subjects', 'subject_id', 'id');
	}

}
