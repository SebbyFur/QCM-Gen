const ID_MODEL = document.querySelector("meta[name='id']").id;
let page = 1;

function getQuestionsRequest(p) {
    page += p;
    axios.get(route('qatouterjoin'), {
        params: {
            id: ID_MODEL,
            page: page
        }
    })
    .then(response => {
        const content = document.querySelector('.questions-div');
        content.textContent = '';
        for (let data of response.data.data)
            content.append(createQuestionEntry(data.id, data.id, data.question, data.is_valid, "create"));

        document.querySelector('.previous-questions').disabled = response.data.current_page == 1 ? true : false;
        document.querySelector('.next-questions').disabled = response.data.current_page >= response.data.last_page ? true : false;
    })
}

function createModelDataRequest() {
    axios.post(route('createmcqmodeldata'), {
        id_model: ID_MODEL,
        id_question: this.getAttribute('data-id')
    })
    .then(response => {
        const data = response.data;
        document.querySelector('.question-div-' + data.id_question).remove();
        getQuestionsRequest(0);
        document.querySelector('.questions-data-div').append(createQuestionEntry(data.id, data.id_question, data.question, data.is_valid, "delete"));
    })
}

function deleteModelDataRequest() {
    const id = this.getAttribute('data-id');
    axios.post(route('deletemcqmodeldata'), {
        id_mcqdata: id
    })
    .then(response => {
        getQuestionsRequest(0);
        document.querySelector('.question-data-div-' + id).remove();
    })
}

function createQuestionEntry(dataid, id, question, isValid, mode) {
    let toAppend = document.createElement('div');
    toAppend.setAttribute('class', 'container d-flex mb-2');

    const group = document.createElement('div');

    group.setAttribute('class', 'd-flex list-group-item w-100');
    if (!isValid) group.style.backgroundColor = "#f6df6d";
    group.setAttribute('data-id', dataid);
    group.append(document.createElement('div'));
    group.append(document.createElement('div'));

    group.children[0].innerText = '#' + id + '.';

    group.children[1].setAttribute('class', 'mx-1');

    group.children[1].append(document.createElement('div'));
    group.children[1].children[0].setAttribute('class', 'group-item d-flex');
    group.children[1].children[0].innerText = question;

    toAppend.append(group);

    if (mode === "create") {
        const button = document.createElement('button');
        toAppend.setAttribute('class', 'container d-flex mb-2 question-div-' + dataid)

        button.setAttribute('type', 'button');
        button.setAttribute('class', 'btn btn-success mx-1 add-question-button');
        button.setAttribute('data-id', dataid);
        button.addEventListener('click', createModelDataRequest);
        button.append(document.createElement('i'));
        button.firstElementChild.setAttribute('class', 'bi bi-plus-circle-fill');
        toAppend.append(button);
    } else if (mode === "delete") {
        const button = document.createElement('button');
        toAppend.setAttribute('class', 'container d-flex mb-2 question-data-div-' + dataid);

        button.setAttribute('type', 'button');
        button.setAttribute('class', 'btn btn-danger mx-1 add-question-button');
        button.setAttribute('data-id', dataid);
        button.addEventListener('click', deleteModelDataRequest);
        button.append(document.createElement('i'));
        button.firstElementChild.setAttribute('class', 'bi bi-dash-circle-fill');
        toAppend.append(button);
    }

    return toAppend;
}

getQuestionsRequest(0);

document.querySelector('.next-questions').addEventListener('click', () => {getQuestionsRequest(1)});
document.querySelector('.previous-questions').addEventListener('click', () => {getQuestionsRequest(-1)});

for (let rmbutton of document.getElementsByClassName('delete-question-button'))
    rmbutton.addEventListener('click', deleteModelDataRequest);

new SearchBar(document.querySelector('.question-input'), document.querySelector('.search-data'));