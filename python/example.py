# script.py
import sys
import json

def main():
    data = {"message": "Hello from Python"}
    print(json.dumps(data))  # Output data as JSON

if __name__ == "__main__":
    main()
