function displayStudents() {
    const id_group = this.getAttribute('data-id');
    const students_div = document.querySelector('.students');
    if (students_div.hasAttribute('data-id'))
        document.querySelector('.students-group-' + students_div.getAttribute('data-id')).hidden = true;

    students_div.setAttribute('data-id', id_group);
    document.querySelector('.students-group-' + id_group).hidden = false;
}

function setMaxQuestions(int) {
    const max = this.getAttribute('data-count');
    
    const questionsSelector = document.querySelector('.questions-select');

    questionsSelector.textContent = '';
    questionsSelector.disabled = false;

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

document.querySelector('.random').addEventListener('click', setMaxQuestions);

for (const info of document.getElementsByClassName('group-info'))
    info.addEventListener('click', displayStudents);

for (const button of document.getElementsByClassName('check-all-group-students'))
    button.addEventListener('click', checkAllGroupStudents);

for (const button of document.getElementsByClassName('uncheck-all-group-students'))
    button.addEventListener('click', uncheckAllGroupStudents);

document.querySelector('.check-all-students').addEventListener('click', checkAllStudents);
document.querySelector('.uncheck-all-students').addEventListener('click', uncheckAllStudents);