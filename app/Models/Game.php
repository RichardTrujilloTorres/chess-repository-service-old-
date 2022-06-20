<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    const DEFAULT_FILE_EXTENSION = 'pgn';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'opponent',
        'moves',
        'result',
    ];

    protected $casts = [
        'moves' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function analysis()
    {
        return $this->hasMany(Analysis::class);
    }

    public function scopeByUser($builder, int $id)
    {
        return $builder->where('user_id', $id);
    }
}
