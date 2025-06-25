<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Incrémenter le score d'un utilisateur
     */
    public static function addPoints($userId, $points)
    {
        $point = self::firstOrCreate(
            ['user_id' => $userId],
            ['score' => 0]
        );

        $point->increment('score', $points);

        return $point;
    }

    /**
     * Obtenir le score d'un utilisateur
     */
    public static function getUserScore($userId)
    {
        return self::where('user_id', $userId)->value('score') ?? 0;
    }
}
