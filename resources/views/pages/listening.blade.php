@extends('template.welcome')

@section('progress')
<div class="progress mb-3" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar bg-orange" style="width: {{ $progress }}"></div>
</div>
@endsection

@section('instructions')
Speak the answer to the question you hear
@endsection

@section('question')

    <button id="listeningBtn" class="btn btn-orange" onclick="audioPlay()">
        <img src="{{ asset("img/speaker.png") }}" alt="">
    </button>
    
    <p class="text-muted text-center my-3">Number of replays left : 2</p>
    <audio src="{{ asset('audio/test.mp3') }}" id="listeningAudio" controls hidden></audio>

    <form action="/exam/store" id="myform" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" name="question_id" value="2">
        <input type="hidden" name="test_id" value="{{ $dataTest->id }}">
        <input type="hidden" name="response" id="audioFile">
    </form>
@endsection

@section('question-footer')
{{-- NEXT BUTTON --}}
<button class="btn btn-orange rounded-1 px-5 w-25" type="submit" form="myform">finish</button>
{{-- AUDIO CONTROL --}}
<audio id="recorder" muted hidden></audio>
<audio id="player" controls></audio>
{{-- AUDIO BUTTON --}}
<div>
   <button id="start" class="btn-orange rounded py-1 px-2">Start Record</button>
   <button id="stop" class="btn-orange rounded py-1 px-2 d-none">Stop Recording</button>
</div>

@endsection

@section('script')
    <script src="{{ asset('js/audio-recorder.js') }}"></script>
    <script>
        function audioPlay()
        {
            document.getElementById("listeningAudio").play();
        }

        function seeResult()
        {
            document.getElementById('result').classList.remove('d-none');
        }

    </script>
@endsection 