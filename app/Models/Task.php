<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    //Task model
    use HasFactory;
    // Create protected data
    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id'
    ];
    protected $casts = [
        'completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Status completed = true
    public function markAsCompleted(): void
    {
        $this->update([
            'completed' => true,
        ]);
    }

    // Status completed = false
    public function markAsIncomplete(): void
    {
        $this->update([
            'completed' => false,
        ]);
    }
}
