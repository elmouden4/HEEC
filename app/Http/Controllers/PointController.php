<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\User;

class PointController extends Controller
{
    /**
     * Ajouter des points à un utilisateur
     */
    public function addPoints(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:1',
        ]);

        $point = Point::addPoints($request->user_id, $request->points);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Points ajoutés avec succès',
                'data' => [
                    'user_id' => $point->user_id,
                    'new_score' => $point->score,
                    'points_added' => $request->points,
                ]
            ], 200);
        }

        return back()->with('success', 'Points ajoutés avec succès');
    }

    /**
     * Obtenir le score d'un utilisateur
     */
    public function getUserScore($userId)
    {
        $user = User::findOrFail($userId);
        $score = Point::getUserScore($userId);

        return response()->json([
            'success' => true,
            'data' => [
                'user_id' => $userId,
                'user_name' => $user->name,
                'score' => $score,
            ]
        ]);
    }

    /**
     * Obtenir tous les scores (classement)
     */
    public function getAllScores()
    {
        $scores = Point::with('user')
            ->orderBy('score', 'desc')
            ->get()
            ->map(function ($point) {
                return [
                    'user_id' => $point->user_id,
                    'user_name' => $point->user->name,
                    'score' => $point->score,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $scores
        ]);
    }

    /**
     * Obtenir le score de l'utilisateur connecté
     */
    public function getMyScore(Request $request)
    {
        $userId = $request->user()->id;
        $score = Point::getUserScore($userId);

        return response()->json([
            'success' => true,
            'data' => [
                'user_id' => $userId,
                'user_name' => $request->user()->name,
                'score' => $score,
            ]
        ]);
    }

    /**
     * Réinitialiser le score d'un utilisateur
     */
    public function resetScore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $point = Point::where('user_id', $request->user_id)->first();

        if ($point) {
            $point->update(['score' => 0]);
        } else {
            Point::create([
                'user_id' => $request->user_id,
                'score' => 0,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Score réinitialisé avec succès',
            'data' => [
                'user_id' => $request->user_id,
                'new_score' => 0,
            ]
        ]);
    }
}
