<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamLinks extends Model
{
    protected $table = 'links';
    protected $primaryKey = "id";

    public function QuestionIds() {
    	return $this->hasMany('App\Models\LinkQuestionMap', 'link_id', 'id');
    }

    public function GetCandidateIds() {
    	return $this->hasMany('App\Models\Exams', 'exam_link_id', 'id');
    }
}
