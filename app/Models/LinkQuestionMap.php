<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkQuestionMap extends Model
{
    protected $table = 'link_question_map';
    protected $primaryKey = "id";

    public function questionInfo() {
		return $this->belongsTo('App\Models\Questions', 'question_id', 'id');
	}
}
