<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AgreementStatus;
use App\Models\Internship;
use App\Models\User;
use App\Models\Offer;
use App\Models\University;
use App\Models\Company;

class Agreement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agreements';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'university_supervisor_id', 'id');
    }

    public function internships()
    {
        return $this->hasMany(Internship::class, 'agreement_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(AgreementStatus::class, 'agreement_status_id', 'id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'agreements_attachments', 'agreement_id', 'attachment_id');
    }
}
