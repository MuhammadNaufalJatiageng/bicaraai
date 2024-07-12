<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function exam()
    {
        $test = new Test();
        $test->user_id = auth()->user()->id;
        $test->start_time = Carbon::now();
        $test->end_time = Carbon::now()->addMinutes(10);
        $test->save();

        
        return redirect('/exam/online');
    }
    
    public function examOnline()
    {
        $dataTest = Test::where('user_id', auth()->user()->id)->latest()->first();
        $testDetails = TestDetail::all();

        if ($testDetails->count() == 0) {
            return view('pages.essay', [
                'dataTest' => $dataTest,
                'progress' => '0%'
            ]);
        }
        if ($testDetails->count() == 1) {
            return view('pages.speaking', [
                'dataTest' => $dataTest,
                'progress' => '33%'
            ]);
        }
        if ($testDetails->count() == 2) {
            return view('pages.listening', [
                'dataTest' => $dataTest,
                'progress' => '66%'
            ]);
        }
        if($testDetails->count() === 3) {
            return view('pages.finish', [
                'dataTest' => $dataTest,
                'results' => TestDetail::all()
            ]);
        }
    }
}

