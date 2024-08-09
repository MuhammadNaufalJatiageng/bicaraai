<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonController extends Controller
{
    public function convertAudioToText(Request $request)
    {
        // Validate the request
        $request->validate([
            'audio' => 'required|file|mimes:mp3,wav',
        ]);

        // Store the uploaded audio file
        $audioFile = $request->file('audio');
        $path = $audioFile->storeAs('audio', 'input.' . $audioFile->getClientOriginalExtension());

        // Path to the Python script
        $scriptPath = base_path('python/app.py');
        $fullPath = public_path('audio/Recording.mp3');
        // $fullPath = storage_path('app/' . $path);

        // Prepare the command to run the Python script
        $command = ['python', $scriptPath, $fullPath];

        // Create and run the process
        $process = new Process($command);
        $process->run();

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Get the output from the Python script
        $output = $process->getOutput();

        // Clean up the uploaded file
        Storage::delete($path);

        // Return the output of the Python script
        return response()->json([
            'text' => $output,
        ]);
    }
}
