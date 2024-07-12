let input = document.getElementById("response");

function countingWords() {
    let text = input.value;
    const wordsArray = text.trim().split(" ");
    const maxWords = Math.min(wordsArray.length);

    if (!input.value) {
        document.getElementById("words").innerHTML = "Words : 0";
    } else {
        document.getElementById("words").innerHTML = "Words : " + maxWords;
    }
}

countingWords();

input.addEventListener("input", () => {
    countingWords();
});
