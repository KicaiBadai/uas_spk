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

public function detail(Request $request)
{
    $schools = School::all();
    $school_id = $request->input('school_id');

    if ($school_id) {
        $alternatifs = Player::where('school_id', $school_id)->get();
        $selectedSchool = School::find($school_id);
    } else {
        $alternatifs = Player::all();
        $selectedSchool = null;
    }

    $kriterias = Criterion::all();

    if ($alternatifs->count() == 0 || $kriterias->count() == 0) {
        return redirect('/topsis')->with('error', 'Data tidak lengkap untuk perhitungan.');
    }

    $matrixKeputusan = [];
    foreach ($alternatifs as $index => $alternatif) {
        foreach ($kriterias as $k_index => $kriteria) {
            $nilai = Assessment::where('player_id', $alternatif->id)
                ->where('criterion_id', $kriteria->id)
                ->value('nilai') ?? 0;
            $matrixKeputusan[$index][$k_index] = $nilai;
        }
    }

    $matrixNormalisasi = [];
    $pembagi = [];
    foreach ($kriterias as $k_index => $kriteria) {
        $sum = 0;
        foreach ($alternatifs as $index => $alternatif) {
            $sum += pow($matrixKeputusan[$index][$k_index], 2);
        }
        $pembagi[$k_index] = sqrt($sum);

        foreach ($alternatifs as $index => $alternatif) {
            $matrixNormalisasi[$index][$k_index] = $pembagi[$k_index] == 0 ? 0 : $matrixKeputusan[$index][$k_index] / $pembagi[$k_index];
        }
    }

    $matrixTerbobot = [];
    foreach ($alternatifs as $index => $alternatif) {
        foreach ($kriterias as $k_index => $kriteria) {
            $matrixTerbobot[$index][$k_index] = $matrixNormalisasi[$index][$k_index] * $kriteria->bobot;
        }
    }

    $idealPositif = [];
    $idealNegatif = [];
    foreach ($kriterias as $k_index => $kriteria) {
        $nilaiKolom = [];
        foreach ($alternatifs as $index => $alternatif) {
            $nilaiKolom[] = $matrixTerbobot[$index][$k_index];
        }

        if ($kriteria->tipe == 'benefit') {
            $idealPositif[$k_index] = max($nilaiKolom);
            $idealNegatif[$k_index] = min($nilaiKolom);
        } else {
            $idealPositif[$k_index] = min($nilaiKolom);
            $idealNegatif[$k_index] = max($nilaiKolom);
        }
    }

    $dPlus = [];
    $dMinus = [];
    $preferensi = [];
    $ranking = [];

    foreach ($alternatifs as $index => $alternatif) {
        $jumlahPlus = 0;
        $jumlahMinus = 0;

        foreach ($kriterias as $k_index => $kriteria) {
            $jumlahPlus += pow($matrixTerbobot[$index][$k_index] - $idealPositif[$k_index], 2);
            $jumlahMinus += pow($matrixTerbobot[$index][$k_index] - $idealNegatif[$k_index], 2);
        }

        $dPlus[$index] = sqrt($jumlahPlus);
        $dMinus[$index] = sqrt($jumlahMinus);

        $penyebut = $dMinus[$index] + $dPlus[$index];
        $pref = $penyebut == 0 ? 0 : $dMinus[$index] / $penyebut;
        $preferensi[$index] = $pref;

        $ranking[] = [
            'nama_pemain' => $alternatif->nama_pemain,
            'sekolah' => $alternatif->school->nama_sekolah ?? '-',
            'nilai' => $pref
        ];
    }

    usort($ranking, function ($a, $b) {
        return $b['nilai'] <=> $a['nilai'];
    });

    return view('topsis.hasil', compact(
        'schools', 'selectedSchool', 'school_id',
        'alternatifs', 'kriterias', 'matrixKeputusan', 'matrixNormalisasi',
        'matrixTerbobot', 'idealPositif', 'idealNegatif', 'dPlus', 'dMinus', 'preferensi', 'ranking'
    ));
}
}