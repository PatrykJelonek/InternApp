<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use App\Models\Agreement;
use App\Models\InternshipStatus;
use App\Models\JournalEntry;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Internship extends Model
{
    use HasFactory;

    protected $table = "internships";

    /**
     * @return HasOne
     */
    public function offer(): HasOne
    {
        return $this->hasOne(Offer::class, 'id', 'offer_id');
    }


    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class, 'agreement_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'internships_students', 'internship_id', 'student_id')
            ->withPivot(['grade']);
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(InternshipStatus::class, 'id', 'internship_status_id');
    }

    /**
     * @return HasOne
     */
    public function universitySupervisor(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'university_supervisor_id');
    }

    /**
     * @return HasOne
     */
    public function companySupervisor(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'company_supervisor_id');
    }

    /**
     * @return HasMany
     */
    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class, 'internship_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'internship_id', 'id');
    }
}
