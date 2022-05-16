function createQuestion() {
    const myRequest = new Request(route('createquestion'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            question: this.previousElementSibling.value
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        window.location.href = route('editquestion', data.id);
    })
    .catch(error => {
        error.then(error => {
            let add = createAlert(error.message);
            if (error.id !== undefined) {
                let button = document.createElement('a');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-primary mx-2');
                button.setAttribute('href', route('editquestion', error.id));
                button.innerText = "S'y rendre";
                add.children[1].append(button);
            }

            const alert = document.querySelector('.alert');

            alert.textContent = '';
            alert.append(add);
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
            id: this.id
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        console.log(data);
        this.parentNode.parentNode.parentNode.remove();
    })
    .catch(error => {
        error.then(error => {
            const alert = document.querySelector('.alert');
            alert.textContent = '';
            alert.append(createAlert(error.message));
        });
    });
}

function createAlert(text) {
    let mainDiv = document.createElement('div');
    mainDiv.setAttribute('class', "border border-4 alert alert-danger alert-dismissible fade show w-50 d-flex align-items-center");
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

for (let create of document.getElementsByClassName('add-question'))
    create.addEventListener('click', createQuestion);

for (let del of document.getElementsByClassName('rm-question'))
    del.addEventListener('click', deleteQuestion);