<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bicara AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    {{-- Local CSS --}}
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
  </head>
  <body>

    <section class="content-wrapper">
        <div class="side"></div>
    
        <div id="content" class="w-100 p-5">
            <div class="key-points mb-5">
                <h1>Key Points: Production</h1>
            </div>
            <div class="types mb-5">
                <h1>Which question types?</h1>
            </div>
            <div class="question-wrapper border border-4 p-4">
                <div class="row align-items-center">
                    <div class="col-md-10 ps-4 pe-0">
                        <h5 class="mb-2" id="timer"></h5>
                        @yield('progress')
                    </div>
                    <div class="col-md p-0 text-center">
                        <img src="{{ asset('img/user.jpeg') }}" alt="" width="40rem">
                    </div>
                </div>
                <div class="instructions text-center mb-4">
                    <h5 class="fw-bold">
                        @yield('instructions')
                    </h5>
                </div>
                <div class="question-box row">
                    @yield('question')
                </div>
                <div class="question-footer border-top border-3 mt-3">
                    @yield('question-footer')
                </div>
            </div>

            <div class="question-wrapper mt-4">
                @yield('result')
            </div>
        </div>

    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @yield('script')
    <script>
        // Atur waktu akhir ujian dari server
        let endTime = new Date("{{ $dataTest->end_time }}").getTime();

        let x = setInterval(function () {
            let now = new Date().getTime();
            let distance = endTime - now;
            console.log("haha"+distance);

            let hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML =
                hours + ": " + minutes + ": " + seconds + "";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML =
                    "Waktu ujian telah berakhir.";
                // Mungkin tambahkan logika di sini setelah waktu ujian berakhir
            }
        }, 1000);
    </script>
  </body>
</html>