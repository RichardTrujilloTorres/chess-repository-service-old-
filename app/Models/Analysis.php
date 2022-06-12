<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;

    protected $table = 'analysis';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'game_id',
        'moves',
    ];

    protected $casts = [
        'moves' => 'json',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
