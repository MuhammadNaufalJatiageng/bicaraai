import sys
import json
import speech_recognition as sr
from pydub import AudioSegment

def convert_audio_to_text(audio_file_path):
    recognizer = sr.Recognizer()

    # Load and convert the audio file to WAV format if needed
    audio_format = audio_file_path.split('.')[-1].lower()
    if audio_format != 'wav':
        audio = AudioSegment.from_file(audio_file_path)
        audio_file_path = 'converted_audio.wav'
        audio.export(audio_file_path, format='wav')

    # Load the audio file
    with sr.AudioFile(audio_file_path) as source:
        audio_data = recognizer.record(source)
    
    try:
        # Perform speech recognition
        text = recognizer.recognize_google(audio_data)
        return {"status": "success", "text": text}
    except sr.UnknownValueError:
        return {"status": "error", "message": "Speech recognition could not understand audio"}
    except sr.RequestError as e:
        return {"status": "error", "message": f"Could not request results from Google Speech Recognition service; {e}"}

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print(json.dumps({"status": "error", "message": "Usage: python speech_to_text.py <path_to_audio_file>"}))
        sys.exit(1)

    audio_file_path = sys.argv[1]
    result = convert_audio_to_text(audio_file_path)
    print(json.dumps(result))
