<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bicara AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="d-flex justify-content-center align-items-center" style="height: 100vh">

    <div>
        <a class="btn btn-primary fs-2 px-5 rounded-1 shadow-lg mb-3" onclick="seeResult()">See result</a>

        <a href="/" class="btn btn-warning fs-2 px-5 rounded-1 shadow-lg mb-3">Back to dashboard</a>
    
        <div class="list-group d-none" id="result">
            <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
            Your answer
            </button>
    
            @foreach ($results as $result)
                @if ($result->question_id == 1)
                    
                    <li class="list-group-item list-group-item-action">{{ $loop->iteration }}. {{ $result->response }}</li>
                @else
                    <li class="list-group-item list-group-item-action">
                        {{ $loop->iteration }} 
                        <audio src="{{ asset($result->response) }}" controls></audio>
                    </li>
                    
                @endif
            @endforeach
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function seeResult()
        {
            document.getElementById('result').classList.remove('d-none');
        }
    </script>
  </body>
</html>