<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Criterion;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Models\School;

class AssessmentController extends Controller
{
    public function index()
    {
        $schools = School::with('players')->get();
        $players = Player::all();
        $criteria = Criterion::all();

        $assessments = Assessment::all()
            ->groupBy('player_id');

        return view(
            'assessments.index',
            compact(
                'schools',
                'players',
                'criteria',
                'assessments'
            )
        );
    }

    public function store(Request $request)
    {
        foreach ($request->nilai as $playerId => $criterias) {

            foreach ($criterias as $criterionId => $nilai) {

                Assessment::updateOrCreate(
                    [
                        'player_id' => $playerId,
                        'criterion_id' => $criterionId
                    ],
                    [
                        'nilai' => $nilai
                    ]
                );
            }
        }

        return redirect('/assessments')
            ->with('success', 'Penilaian berhasil disimpan');
    }
}