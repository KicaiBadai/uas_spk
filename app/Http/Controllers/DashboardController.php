<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Player;
use App\Models\Criterion;
use App\Models\Assessment;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSekolah = School::count();
        $jumlahPemain = Player::count();
        $jumlahKriteria = Criterion::count();
        $jumlahPenilaian = Assessment::count();

        return view('dashboard', compact(
            'jumlahSekolah',
            'jumlahPemain',
            'jumlahKriteria',
            'jumlahPenilaian'
        ));
    }
}