// Check if the browser supports SpeechRecognition
const SpeechRecognition =
    window.SpeechRecognition || window.webkitSpeechRecognition;

if (!SpeechRecognition) {
    alert("Speech Recognition API is not supported in this browser.");
} else {
    const recognition = new SpeechRecognition();
    recognition.lang = "en-US"; // Set the language for recognition
    recognition.interimResults = false; // Set to true to get results as they are spoken
    recognition.maxAlternatives = 1; // Number of alternative transcriptions to return

    const startButton = document.getElementById("start-recognition");
    const transcriptionElement = document.getElementById("transcription");

    // Function to start speech recognition
    function startRecognition() {
        return new Promise((resolve, reject) => {
            recognition.start();

            // Event handler for when speech recognition returns a result
            recognition.addEventListener("result", (event) => {
                const transcript = event.results[0][0].transcript;
                resolve(transcript);
            });

            // Event handler for when speech recognition encounters an error
            recognition.addEventListener("error", (event) => {
                reject(new Error(`Speech recognition error: ${event.error}`));
            });

            // Event handler for when speech recognition ends
            recognition.addEventListener("end", () => {
                // Optionally handle when speech recognition ends
            });
        });
    }

    // Event handler for when the button is clicked
    startButton.addEventListener("click", async () => {
        transcriptionElement.textContent = "Listening...";

        try {
            const transcript = await startRecognition();
            transcriptionElement.textContent = `You said: ${transcript}`;
        } catch (error) {
            transcriptionElement.textContent = `Error: ${error.message}`;
        }
    });
}
