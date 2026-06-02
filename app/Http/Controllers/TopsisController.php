<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Criterion;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Models\School;

class TopsisController extends Controller
{
   public function index()
{
    $schools = School::with('players')->get();
    $criteria = Criterion::all();

    $hasilPerSekolah = [];

    foreach ($schools as $school) {

        $players = $school->players;

        if ($players->count() == 0) {
            continue;
        }

        // Matriks keputusan
        $matrix = [];

        foreach ($players as $player) {
            foreach ($criteria as $criterion) {

                $nilai = Assessment::where('player_id', $player->id)
                    ->where('criterion_id', $criterion->id)
                    ->value('nilai') ?? 0;

                $matrix[$player->id][$criterion->id] = $nilai;
            }
        }

        // Normalisasi
        $normalisasi = [];

        foreach ($criteria as $criterion) {

            $pembagi = 0;

            foreach ($players as $player) {
                $pembagi += pow(
                    $matrix[$player->id][$criterion->id],
                    2
                );
            }

            $pembagi = sqrt($pembagi);

            foreach ($players as $player) {

                $normalisasi[$player->id][$criterion->id] =
                    $pembagi == 0
                    ? 0
                    : $matrix[$player->id][$criterion->id] / $pembagi;
            }
        }

        // Normalisasi terbobot
        $terbobot = [];

        foreach ($criteria as $criterion) {

            foreach ($players as $player) {

                $terbobot[$player->id][$criterion->id] =
                    $normalisasi[$player->id][$criterion->id]
                    * $criterion->bobot;
            }
        }

        // Ideal positif dan negatif
        $idealPositif = [];
        $idealNegatif = [];

        foreach ($criteria as $criterion) {

            $nilaiKolom = [];

            foreach ($players as $player) {
                $nilaiKolom[] =
                    $terbobot[$player->id][$criterion->id];
            }

            if ($criterion->tipe == 'benefit') {

                $idealPositif[$criterion->id] =
                    max($nilaiKolom);

                $idealNegatif[$criterion->id] =
                    min($nilaiKolom);

            } else {

                $idealPositif[$criterion->id] =
                    min($nilaiKolom);

                $idealNegatif[$criterion->id] =
                    max($nilaiKolom);
            }
        }

        // D+ dan D-
        $dPlus = [];
        $dMinus = [];

        foreach ($players as $player) {

            $jumlahPlus = 0;
            $jumlahMinus = 0;

            foreach ($criteria as $criterion) {

                $jumlahPlus += pow(
                    $terbobot[$player->id][$criterion->id]
                    - $idealPositif[$criterion->id],
                    2
                );

                $jumlahMinus += pow(
                    $terbobot[$player->id][$criterion->id]
                    - $idealNegatif[$criterion->id],
                    2
                );
            }

            $dPlus[$player->id] = sqrt($jumlahPlus);
            $dMinus[$player->id] = sqrt($jumlahMinus);
        }

        // Ranking sekolah ini
        $ranking = [];

        foreach ($players as $player) {

            $penyebut =
                $dMinus[$player->id] +
                $dPlus[$player->id];

            $preferensi =
                $penyebut == 0
                ? 0
                : $dMinus[$player->id] / $penyebut;

            $ranking[] = [
                'nama_pemain' => $player->nama_pemain,
                'nilai' => round($preferensi, 4)
            ];
        }

        usort($ranking, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        $hasilPerSekolah[] = [
            'sekolah' => $school,
            'ranking' => $ranking
        ];
    }

    return view(
        'topsis.index',
        compact('hasilPerSekolah')
    );
}
}