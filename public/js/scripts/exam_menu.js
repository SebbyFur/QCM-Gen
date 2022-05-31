function deleteExamRequest(data) {
    axios.post(route('deleteexam'), data)
    .then(response => {
        document.querySelector('.exam-div-' + data['id']).remove();
    })
    .catch(error => {
        const alert = document.querySelector('.alert');
        alert.textContent = '';
        alert.append(createAlert(error.response.data.message));
    });
}

function createExamRequest(data) {
    axios.post(route('createexam'), {
        title: document.querySelector('.create-exam-title-input').value
    })
    .then(response => {
        window.location.href = route('examview', response.data.id);
    })
    .catch(error => {
        const alert = document.querySelector('.alert');
        alert.textContent = '';
        alert.append(createAlert(error.response.data.message));
    });
}

function createAlert(text) {
    let mainDiv = document.createElement('div');
    mainDiv.setAttribute('class', "border border-4 alert alert-danger alert-dismissible fade show w-50 d-flex");
    mainDiv.style.pointerEvents = 'auto';

    let img = document.createElement('i');
    img.setAttribute('class', 'bi bi-exclamation-triangle-fill flex-shrink-0 me-2');

    let div = document.createElement('div');
    div.setAttribute('class', 'alert-text');
    div.innerText = text;

    let btn = document.createElement('button');
    btn.setAttribute('type', 'button');
    btn.setAttribute('class', 'btn-close');
    btn.setAttribute('data-bs-dismiss', 'alert');

    mainDiv.append(img);
    mainDiv.append(div);
    mainDiv.append(btn);

    return mainDiv;
}

for (const button of document.getElementsByClassName('delete-mcq-exam-button')) {
    button.addEventListener('click', function() {
        deleteExamRequest({
            id: this.getAttribute('data-id'),
            remove_mcq: 1
        });
    });
}

for (const button of document.getElementsByClassName('delete-exam-button')) {
    button.addEventListener('click', function() {
        deleteExamRequest({
            id: this.getAttribute('data-id')
        });
    });
}

document.querySelector('.create-exam-button').addEventListener('click', createExamRequest);