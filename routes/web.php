<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestDetailController;
use App\Models\Test;
use App\Models\TestDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', function () {
    return view('pages.auth.user.login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::middleware('auth')->group(function() {
    
    Route::get('/', function() {
        TestDetail::truncate();
        return view('pages.dashboard');
    });
    
    Route::post('/exam', [TestController::class, 'exam']);
    Route::get('/exam/online', [TestController::class, 'examOnline']);
    Route::post('/exam', [TestDetailController::class, 'answerStore']);

    Route::get('/speech-to-text', [TestDetailController::class, 'speechToTextIndex']);
    Route::post('/speech-to-text', [TestDetailController::class, 'stt']);
});

// Route::post('/', function(Request $request) 
// {
//     $base64 = $request->response;
 
//     $file_name = "audio/" . time() . ".mp3";
//     file_put_contents(public_path($file_name), base64_decode($base64));
    
//     // echo $file_name;
//     // if ($request->quest_type == 'writing') 
//     // {
//     //     $data['quest_type'] = $request->quest_type;
//     //     $data['response'] = $request->response;

//     //     Test::create($data);

//     //     return view('pages.speaking');
//     // }
//     // if ($request->quest_type == 'speaking') 
//     // {
//     //     $data['quest_type'] = $request->quest_type;
//     //     $data['response'] = $request->response;
        
//     //     Test::create($data);
        
//     //     return view('pages.listening', [
//     //         'last_quest' => false,
//     //         'results' => false
//     //     ]);
//     // }
//     // if ($request->quest_type == 'listening') 
//     // {
//     //     $data['quest_type'] = $request->quest_type;
//     //     $data['response'] = $request->response;
//     //     $data['last_quest'] = true;

//     //     Test::create($data);

//     //     $last_quest = true;

//     //     return view('pages.listening', [
//     //         'last_quest' => true,
//     //         'results' => Test::all()
//     //     ]);
//     // }
// }); 

Route::get('/test', function() {

    $pythonScriptPath = base_path('/python/example.py'); // Replace with the path to your Python script

    $command = "python $pythonScriptPath"; // Use `python` if appropriate

    $output = shell_exec($command);
    $result = json_decode($output, true);

    return response()->json($result);

});
