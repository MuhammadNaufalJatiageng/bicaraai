function sendVoiceNote(base64) {
    document.querySelector("#audioFile").value = base64;
}

class VoiceRecorder {
    constructor() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            console.log("getUserMedia supported");
        } else {
            console.log("getUserMedia is not supported on your browser!");
        }

        this.mediaRecorder;
        this.stream;
        this.chunks = [];
        this.isRecording = false;

        this.recorderRef = document.querySelector("#recorder");
        this.playerRef = document.querySelector("#player");
        this.startRef = document.querySelector("#start");
        this.stopRef = document.querySelector("#stop");
        this.audioFile = document.querySelector("#audioFile");

        this.startRef.onclick = this.startRecording.bind(this);
        this.stopRef.onclick = this.stopRecording.bind(this);

        this.constraints = {
            audio: true,
            video: false,
        };
    }

    handleSuccess(stream) {
        this.stream = stream;
        this.stream.oninactive = () => {
            console.log("Stream ended!");
        };
        this.recorderRef.srcObject = this.stream;
        this.mediaRecorder = new MediaRecorder(this.stream);
        console.log(this.mediaRecorder);
        this.mediaRecorder.ondataavailable =
            this.onMediaRecorderDataAvailable.bind(this);
        this.mediaRecorder.onstop = this.onMediaRecorderStop.bind(this);
        this.recorderRef.play();
        this.mediaRecorder.start();
    }

    handleError(error) {
        console.log("navigator.getUserMedia error: ", error);
    }

    onMediaRecorderDataAvailable(e) {
        this.chunks.push(e.data);
    }

    onMediaRecorderStop(e) {
        const blob = new Blob(this.chunks, { type: "audio/wav" });
        const audioURL = window.URL.createObjectURL(blob);
        this.playerRef.src = audioURL;
        this.getAudioStream(blob);
        this.chunks = [];
        this.stream.getAudioTracks().forEach((track) => track.stop());
        this.stream = null;
    }

    startRecording() {
        if (this.isRecording) return;
        this.isRecording = true;
        this.startRef.innerHTML = "Recording...";
        this.startRef.classList.add("d-none");
        this.stopRef.classList.remove("d-none");
        this.playerRef.src = "";
        navigator.mediaDevices
            .getUserMedia(this.constraints)
            .then(this.handleSuccess.bind(this))
            .catch(this.handleError.bind(this));
    }

    stopRecording() {
        if (!this.isRecording) return;
        this.isRecording = false;
        this.startRef.innerHTML = "Record";
        this.startRef.classList.remove("d-none");
        this.stopRef.classList.add("d-none");
        this.recorderRef.pause();
        this.mediaRecorder.stop();
    }
    getAudioStream(blob) {
        const reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
            // get base64
            let base64 = reader.result;

            // get only base64 data
            base64 = base64.split(",")[1];

            // send base64 to server to save
            sendVoiceNote(base64);
        };
    }

    sendBlobToServer(blob) {
        // Buat objek FormData
        const formData = new FormData();
        formData.append("audio", blob, "recorded_audio.wav");

        // Kirim blob ke server menggunakan fetch
        fetch("/save-audio", {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Gagal mengirim blob ke server");
                }
                return response.json();
            })
            .then((data) => {
                console.log("File berhasil diunggah:", data);
                // Lakukan sesuatu setelah file diunggah, seperti menampilkan pesan sukses
            })
            .catch((error) => {
                console.error("Gagal mengirim blob ke server:", error);
                // Lakukan sesuatu untuk menangani kesalahan, seperti menampilkan pesan error
            });
    }
}

window.voiceRecorder = new VoiceRecorder();
