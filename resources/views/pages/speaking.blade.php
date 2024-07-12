@extends('template.welcome')

@section('progress')
<div class="progress mb-3" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar bg-orange" style="width: {{ $progress }}"></div>
</div>
@endsection

@section('instructions')
Speak your answer to the question below
@endsection

@section('question')
    <div class="border border-4 w-75 m-auto p-3 mb-3">
        <h5>Talk about a book you read recently.</h5>
        <ul>
            <li>What was the title?</li>
            <li>What was it about?</li>
            <li>How did you first hear of it?</li>
            <li>What did you like or dislike about it?</li>
        </ul>
    </div>

    <form action="/exam/store" id="myform" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" name="question_id" value="2">
        <input type="hidden" name="test_id" value="{{ $dataTest->id }}">
        <input type="hidden" name="response" id="audioFile">
    </form>
@endsection

@section('question-footer')
{{-- NEXT BUTTON --}}
<button class="btn btn-orange rounded-1 px-5 w-25" type="submit" form="myform">Next</button>
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
@endsection 