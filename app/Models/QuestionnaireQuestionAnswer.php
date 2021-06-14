<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireQuestionAnswer extends Model
{
    public $table = 'questionnaire_question_answers';

    public function question()
    {
        return $this->hasOne('App\Models\QuestionnaireQuestion', 'id', 'questionnaire_question_id');
    }
}
