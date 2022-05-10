const ID_QUESTION = document.querySelector("meta[name='id']").id;

function updateQuestion() {
    const myRequest = new Request(route('updatequestion'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id: ID_QUESTION,
            question: this.value
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .catch(error => {
        error.then(error => {
            document.querySelector('.alert').textContent = '';
            document.querySelector('.alert').append(createAlert(error.message));
        });
    });
}

function deleteQuestion() {
    const myRequest = new Request(route('deleteqat'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id: ID_QUESTION,
            question: this.value
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        console.log(data);
        window.location.href = REDIRECT_HOME;
    })
    .catch(error => {
        error.then(error => {
            document.querySelector('.alert').textContent = '';
            document.querySelector('.alert').append(createAlert(error.message));
        });
    });
}

function createAlert(text) {
    let mainDiv = document.createElement('div');
    mainDiv.setAttribute('class', "border border-4 alert alert-danger alert-dismissible fade show w-50 d-flex");

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

function createAnswer() {
    const myRequest = new Request(route('createanswer'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_question: ID_QUESTION,
            answer: ""
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        let mainDiv = document.createElement('div');
        mainDiv.setAttribute('class', 'mb-4');

        let childDiv = document.createElement('div');
        childDiv.setAttribute('class', 'flex-grow-1 d-flex answer-div');
        childDiv.setAttribute('id', data.id);
        
        let checkbox = document.createElement('input');
        checkbox.setAttribute('class', 'form-check-input mx-2 my-3 is_correct');
        checkbox.setAttribute('type', 'checkbox');

        let input = document.createElement('input');
        input.setAttribute('class', 'form-control mx-2 answer');
        input.setAttribute('type', 'text');
        input.setAttribute('placeholder', 'Entrez une réponse...');
        
        let button = document.createElement('button');
        button.setAttribute('class', 'btn btn-danger ml-2 rm-answer');
        button.setAttribute('tyoe', 'button');
        
        let img = document.createElement('i');
        img.setAttribute('class', 'bi bi-dash-circle-fill');
        
        checkbox.addEventListener('click', updateAnswer);
        input.addEventListener('blur', updateAnswer);
        button.addEventListener('click', deleteAnswer);

        button.append(img);

        childDiv.append(checkbox);
        childDiv.append(input);
        childDiv.append(button);

        mainDiv.append(childDiv);

        document.querySelector('.answers-div').append(mainDiv);
    })
    .catch(error => {
        error.then(error => {
            document.querySelector('.alert').textContent = '';
            document.querySelector('.alert').append(createAlert(error.message));
        });
    });
}

function deleteAnswer() {
    const myRequest = new Request(route('deleteanswer'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_answer : this.parentNode.id
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        console.log(data);
        this.parentNode.parentNode.remove();
    })
    .catch(error => {
        error.then(error => {
            console.log(error); 
            document.querySelector('.alert').textContent = '';
            document.querySelector('.alert').append(createAlert(error.message));
        });
    });
}

function updateAnswer() {
    let answer = this.parentNode.children[1].value;

    if (answer === '') {
        this.parentNode.children[0].checked = false;
        this.parentNode.children[0].disabled = true;
    } else {
        this.parentNode.children[0].disabled = false;
    }

    const myRequest = new Request(route('updateanswer'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_answer: this.parentNode.id,
            is_correct: this.parentNode.children[0].checked ? 1 : 0,
            answer: answer
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .catch(error => {
        error.then(error => {
            document.querySelector('.alert').textContent = '';
            document.querySelector('.alert').append(createAlert(error.message));
        });
    });
}

function updateBelongingTag() {
    const myRequest = new Request(this.checked ? route('createtag') : route('deletetag'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_tag: this.id,
            id_question: ID_QUESTION
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .catch(error => {
        error.then(error => {
            document.querySelector('.alert').textContent = '';
            document.querySelector('.alert').append(createAlert(error.message));
        });
    });
}

document.querySelector('.rm-question').addEventListener('click', deleteQuestion);
document.querySelector('.question-input').addEventListener('blur', updateQuestion);
document.querySelector('.btn-success').addEventListener('click', createAnswer);

for (let checkbox of document.getElementsByClassName('checkboxes'))
    checkbox.addEventListener('click', updateBelongingTag);

for (let rmbtn of document.getElementsByClassName('rm-answer'))
    rmbtn.addEventListener('click', deleteAnswer);

for (let checkbox of document.getElementsByClassName('is_correct'))
    checkbox.addEventListener('click', updateAnswer);

for (let input of document.getElementsByClassName('answer'))
    input.addEventListener('blur', updateAnswer);