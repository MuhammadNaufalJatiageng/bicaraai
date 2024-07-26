<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bicara AI | Speech To Text</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="d-flex justify-content-center align-items-center" style="height: 100vh">

    <div class="bg-dark-subtle shadow-lg p-4 rounded rounded-4 text-center">
      <form action="/speech-to-text" method="post" enctype="multipart/form-data" class="text-center" id="myForm">
        @csrf
        <input type="hidden" name="response" id="audioFile">
      </form>
            {{-- AUDIO CONTROL --}}
            <audio id="recorder" muted hidden></audio>
            <audio id="player" controls></audio>
            {{-- AUDIO BUTTON --}}
            <div class="mt-3">
              <button id="start" class="btn-orange rounded py-1 px-2">Start Record</button>
              <button id="stop" class="btn-orange rounded py-1 px-2 d-none">Stop Recording</button>
            </div>
        {{-- <form action="/speech-to-text" method="post" enctype="multipart/form-data" class="text-center">
            @csrf
            <input type="file" name="file" class="d-block form-control" >
            <button class="btn btn-secondary shadow mt-3 fw-semibold">Generate</button>
        </form> --}}
    </div>

    <div class="bg-light shadow-lg w-50 h-25 ms-5 border border-3 rounded rounded-4 p-3 overflow-y-scroll">

        @if(session()->has('response'))
            {{-- @dd(session('response')->content() ) --}}
            @php
                $data = json_decode(session('response')->content(), true);
                
                $data = json_decode($data["response"], true)
            @endphp

            @isset ($data['text'])
              <p>{{ $data['text'] }}</p>
            @endisset
        @endif
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/audio-recorder.js') }}"></script>
  </body>
</html>