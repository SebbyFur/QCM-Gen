function displayStudents() {
    const id_group = this.getAttribute('data-id');
    const students_div = document.querySelector('.students');
    if (students_div.hasAttribute('data-id'))
        document.querySelector('.students-group-' + students_div.getAttribute('data-id')).hidden = true;

    students_div.setAttribute('data-id', id_group);
    document.querySelector('.students-group-' + id_group).hidden = false;
}

function setMaxQuestions() {
    const max = this.getAttribute('data-count');

    const questionsSelector = document.querySelector('.questions-select');
    
    questionsSelector.textContent = '';
    questionsSelector.disabled = max == 0;

    for (let i = 1; i <= max; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.innerText = i;
        questionsSelector.append(option);
    }
}

function checkAllGroupStudents() {
    for (const checkbox of document.getElementsByClassName('checkbox-group-' + this.getAttribute('data-id')))
        checkbox.checked = true;
}

function uncheckAllGroupStudents() {
    for (const checkbox of document.getElementsByClassName('checkbox-group-' + this.getAttribute('data-id')))
        checkbox.checked = false;
}

function checkAllStudents() {
    for (const checkbox of document.getElementsByClassName('checkboxes'))
        checkbox.checked = true;
}

function uncheckAllStudents() {
    for (const checkbox of document.getElementsByClassName('checkboxes'))
        checkbox.checked = false;
}

function getCheckedStudentsIds() {
    const ret = [];

    for (const checkbox of document.getElementsByClassName('checkboxes'))
        if (checkbox.checked) ret.push(checkbox.id);

    return ret;
}

function createMCQRequest() {
    let data = {};
    let category = '';
    const studentIds = getCheckedStudentsIds();
    const questionsCount = document.querySelector('.questions-select').value;
    const examId = document.querySelector('.exam-select').value;
    const createMCQButton = document.querySelector('.create-mcq');
    const spinner = document.querySelector('.spinner-border');
    createMCQButton.disabled = true;
    spinner.hidden = false;

    switch (document.querySelector('.nav-link.active').id) {
        case 'pills-model-tab':
            category = document.querySelector('.model-tab');
            let checkedModel = undefined;
            for (const ret of category.getElementsByClassName('model-radio-button'))
                if (ret.checked) checkedModel = ret;

            if (checkedModel === undefined) {
                document.querySelector('.alert').textContent = '';
                document.querySelector('.alert').append(createAlert("Choisissez un modèle !"));
                spinner.hidden = true;
                return;
            }

            data = {
                'id_model': checkedModel.value,
                'student_ids': studentIds,
                'questions_count': questionsCount,
                'id_exam': examId
            }

            break;
        case 'pills-tag-tab':
            category = document.querySelector('.tag-tab');
            let checkedTag = undefined;
            for (const ret of category.getElementsByClassName('tag-radio-button'))
                if (ret.checked) checkedTag = ret;
        
            if (checkedTag === undefined) {
                document.querySelector('.alert').textContent = '';
                document.querySelector('.alert').append(createAlert("Choisissez un tag !"));
                spinner.hidden = true;
                return;
            }

            data = {
                'id_tag': checkedTag.value,
                'student_ids': studentIds,
                'questions_count': questionsCount,
                'id_exam': examId
            }

            break;
        case 'pills-random-tab':
            data = {
                'is_random': 1,
                'student_ids': studentIds,
                'questions_count': questionsCount,
                'id_exam': examId
            }
            break;
    }

    axios.post(route('createmcq'), data)
    .then(response => {
        window.location.href = route('mcqmenu');
    })
    .catch(error => {
        document.querySelector('.alert').textContent = '';
        document.querySelector('.alert').append(createAlert(error.response.data.message));
        createMCQButton.disabled = false;
        spinner.hidden = true;
    })
}

for (const radio of document.getElementsByClassName('model-radio-button'))
    radio.addEventListener('click', setMaxQuestions);

for (const radio of document.getElementsByClassName('tag-radio-button'))
    radio.addEventListener('click', setMaxQuestions);
    
for (const nav of document.getElementsByClassName('nav-link')) {
    nav.addEventListener('click', () => {
        const questionsSelector = document.querySelector('.questions-select');
            
        questionsSelector.textContent = '';
        questionsSelector.disabled = true;
    })
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

document.querySelector('.random').addEventListener('click', setMaxQuestions);

for (const info of document.getElementsByClassName('group-info'))
    info.addEventListener('click', displayStudents);

for (const button of document.getElementsByClassName('check-all-group-students'))
    button.addEventListener('click', checkAllGroupStudents);

for (const button of document.getElementsByClassName('uncheck-all-group-students'))
    button.addEventListener('click', uncheckAllGroupStudents);

document.querySelector('.check-all-students').addEventListener('click', checkAllStudents);
document.querySelector('.uncheck-all-students').addEventListener('click', uncheckAllStudents);
document.querySelector('.create-mcq').addEventListener('click', createMCQRequest);