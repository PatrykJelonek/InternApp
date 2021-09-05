<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\University;
use App\Models\Company;
use App\Models\Role;
use App\Models\QuestionnaireQuestion;

class Questionnaire extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaires';
    protected $hidden = ['pivot'];

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionnaireQuestion::class, 'questionnaire_id', 'id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'questionnaires_roles', 'questionnaire_id', 'role_id');
    }

    public function company():  BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function university():  BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
