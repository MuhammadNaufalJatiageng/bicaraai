@extends('template.welcome')

@section('progress')
<div class="progress mb-3" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar bg-orange" style="width: {{ $progress }}"></div>
</div>
@endsection

@section('instructions')
Respon to the question in at least 50 words
@endsection

@section('question')
    <div class="col-md-6">
        <p>A university plans to develop a new research center in your country. Some people want a center for business research, while others want a center for research in agriculture (farming). Which of these two kinds of research centers would you recommend, and why?</p>
    </div>
    <form action="/exam/store" method="post" class="col-md-6" id="myform">
        @csrf
        <input type="hidden" name="question_id" value="1" >
        <input type="hidden" name="test_id" value="{{ $dataTest->id }}" >
        <textarea class="col-md-6 border border-3 answer-box w-100" name="response" id="response" cols="30" rows="15" placeholder="Your response"></textarea>
        <p class="text-muted" id="words">Words : 0</p>
    </form>
@endsection

@section('question-footer')
<button class="btn btn-orange rounded-1 px-5 mt-3 w-25" type="submit" form="myform">Next</button>
@endsection

@section('script')
    <script src="{{ asset('/js/counting-words.js') }}"></script>
@endsection