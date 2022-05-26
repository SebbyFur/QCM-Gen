function countMCQQuestionsRequest() {
    axios.get(route('countmcqquestions', this.value),)
    .then(response => {
        const questionsSelector = document.querySelector('.questions-select');

        questionsSelector.textContent = '';
        questionsSelector.disabled = false;

        for (let i = 1; i <= response.data.questions; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.innerText = i;
            questionsSelector.append(option);
        }
    })
}

function countTagQuestionsRequest() {
    axios.get(route('counttagquestions', this.value),)
    .then(response => {
        const questionsSelector = document.querySelector('.questions-select');

        questionsSelector.textContent = '';
        questionsSelector.disabled = false;

        for (let i = 1; i <= response.data.questions; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.innerText = i;
            questionsSelector.append(option);
        }
    })
}

for (const radio of document.getElementsByClassName('model-radio-button'))
    radio.addEventListener('click', countMCQQuestionsRequest);

    for (const radio of document.getElementsByClassName('tag-radio-button'))
    radio.addEventListener('click', countTagQuestionsRequest);