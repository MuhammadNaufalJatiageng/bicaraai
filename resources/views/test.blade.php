<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timer Ujian</title>
</head>
<body>
    <div id="timer"></div>

    <script>
        // Atur waktu akhir ujian dari server
        let endTime = new Date("{{ $end_time }}").getTime();
        
        let x = setInterval(function() {
            let now = new Date().getTime();
            let distance = endTime - now;
            console.log(distance);

            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML = hours + ": "
            + minutes + ": " + seconds + " ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "Waktu ujian telah berakhir.";
                // Mungkin tambahkan logika di sini setelah waktu ujian berakhir
            }
        }, 1000);
    </script>
</body>
</html>
