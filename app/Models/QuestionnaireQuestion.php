<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireQuestion extends Model
{
    protected $table = "questionnaire_questions";

    public function questionnaire()
    {
        return $this->hasOne('App\Models\Questionnaire');
    }
}
