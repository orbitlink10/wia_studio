<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCredit extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'role', 'name'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
