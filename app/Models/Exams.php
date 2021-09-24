<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    protected $table = 'exam_master';
    protected $primaryKey = "id";

    public function subjectInfo() {
		return $this->belongsTo('App\Models\Subjects', 'subject_id', 'id');
	}

	public function userInfo() {
		return $this->belongsTo('App\Models\Users', 'candidate_id', 'id');
	}
}
