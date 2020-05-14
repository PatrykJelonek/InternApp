<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireQuestion extends Model
{
    protected $table = "questionnaire_questions";

    public function questionnaire()
    {
        return $this->hasOne('App\Questionnaire');
    }
}
