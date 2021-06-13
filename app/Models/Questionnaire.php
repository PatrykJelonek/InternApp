<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaires';

    public function questions(): HasMany
    {
        return $this->hasMany('App\Models\QuestionnaireQuestion', 'questionnaire_id', 'id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Role', 'questionnaires_roles', 'questionnaire_id','role_id');
    }
}
