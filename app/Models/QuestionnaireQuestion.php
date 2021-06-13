<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireQuestion extends Model
{
    use SoftDeletes;

    protected $table = "questionnaire_questions";

    public function questionnaire()
    {
        return $this->hasOne('App\Models\Questionnaire');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\QuestionnaireQuestionAnswer','questionnaire_question_id', 'id');
    }
}
