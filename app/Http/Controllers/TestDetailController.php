<?php

namespace App\Http\Controllers;

use App\Models\TestDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestDetailController extends Controller
{
    public function convertMp3ToWav($src, $output)
    {
        $mp3FilePath = $src;
        $wavFilePath = $output;

        // Execute the FFmpeg command
        exec("ffmpeg -i $mp3FilePath -acodec pcm_s16le -ar 44100 $wavFilePath");

        // Handle any further logic (e.g., save the WAV file path to the database)

        return response()->json(['message' => 'MP3 to WAV conversion completed']);
    }

    public function speechToTextIndex() {
        return view('test');
    }

    public function speechToText(Request $request)
    {
        $base64 = $request->response;
        $file_name = "audio/" . time() . ".mp3";
        file_put_contents(public_path($file_name), base64_decode($base64));

        $file = "audio/" . time() .".wav";

        $this->convertMp3ToWav(public_path($file_name), $file);
        File::delete(public_path($file_name));

        // Check if file exists and is valid
        if ($file) {
            $client = new Client();
            $flaskApiUrl = 'http://127.0.0.1:5000/recognize'; // Replace with your Flask API endpoint

            // Send file using Guzzle HTTP client
            $response = $client->request('POST', $flaskApiUrl, [
                'multipart' => [
                    [
                        'name' => 'audio',
                        'contents' => fopen($file, 'r'),
                        'filename' => $file,
                    ],
                ],
            ]);

            // Handle response from Flask API as needed
            // $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            // deleting file
            File::delete(public_path($file));

            // Return response or do something with $body
            // return response()->json(['status' => 'success', 'response' => $body], $statusCode);
            return back()->with('response', response()->json(['status' => 'success', 'response' => $body]));
        } else {
            // Handle case where file is missing or not valid
            return response()->json(['status' => 'error', 'message' => 'File is missing or not valid.'], 400);
        }
    }

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
