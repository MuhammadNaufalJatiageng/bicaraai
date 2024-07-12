<?php

namespace App\Http\Controllers;

use App\Models\TestDetail;
use Illuminate\Http\Request;

class TestDetailController extends Controller
{
    public function answerStore(Request $request)
    {
        $testDetails['question_id'] = $request->question_id;
        $testDetails['test_id'] = $request->test_id;

        if ($request->question_id == '2') {
            $base64 = $request->response;
 
            $file_name = "audio/" . time() . ".mp3";
            file_put_contents(public_path($file_name), base64_decode($base64));
            $testDetails['response'] = $file_name;
        } else {
            $testDetails['response'] = $request->response;
        }
        
        TestDetail::create($testDetails);
        return redirect('/exam/online');
    }
}
