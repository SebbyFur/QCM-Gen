function replaceByInput() {
    let text = this.innerText;
    let parent = this.parentNode;
    parent.textContent = '';

    let toAppend = document.createElement('input');
    toAppend.setAttribute('class', "form-control");
    toAppend.setAttribute('style', "height: 1.4rem;");
    toAppend.setAttribute('type', "text");
    toAppend.setAttribute('placeholder', "Entrez un nom de groupe...");
    toAppend.setAttribute('old', text);
    toAppend.setAttribute('data-id', this.getAttribute('data-id'));
    toAppend.setAttribute('value', text);
    
    parent.append(toAppend);
    
    toAppend.addEventListener('blur', updateGroupName);
    toAppend.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') updateGroupName.call(this);
    });
    
    toAppend.focus();
}

function replaceByDiv() {
    let text = this.value;
    let id = this.getAttribute('data-id');

    let parent = this.parentNode;
    parent.textContent = '';

    let toAppend = document.createElement('div');
    toAppend.setAttribute('data-id', id);
    toAppend.setAttribute('class', "group-item");
    toAppend.innerText = text;
    
    toAppend.addEventListener('dblclick', replaceByInput);
    
    parent.append(toAppend);
}

function updateGroupName() {
    const myRequest = new Request(route('updategroup'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_group: this.getAttribute('data-id'),
            name_group: this.value
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
        qsdfghjklm    })
    .then(data => {
        replaceByDiv.call(this);
    })
    .catch(error => {
        error.then(error => {
            createAlert(error.message);
            this.value = this.getAttribute('old');
            replaceByDiv.call(this);
        });
    });
}

function deleteGroup() {
    const myRequest = new Request(route('deletegroup'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_group: this.getAttribute('data-id')
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        this.parentNode.parentNode.parentNode.remove();
        if (this.getAttribute('data-id') === document.querySelector('.add-student-button').getAttribute('data-id')) {
            const studentsDiv = document.querySelector('.students');
            studentsDiv.textContent = '';
            document.querySelector('.add-student-button-dropdown').disabled = true;
            canEditStudent(false);
        }
    })
    .catch(error => {
        error.then(error => {
            createAlert(error.message);
        });
    });
}

function createGroup() {
    let name_group = this.previousElementSibling.value;

    const myRequest = new Request(route('creategroup'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            name_group: name_group
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        document.querySelector('.groups').firstElementChild.append(createGroupEntry(data.id, name_group));
    })
    .catch(error => {
        error.then(error => {
            createAlert(error.message);
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

    document.querySelector('.alert').textContent = '';
    document.querySelector('.alert').append(mainDiv);
}

function createGroupEntry(id, name) {
    let toAppend = document.createElement('div');
    toAppend.setAttribute('class', 'container d-flex mb-2');

    const group = document.createElement('div');

    group.setAttribute('class', 'd-flex list-group-item w-100');
    group.setAttribute('data-id', id);
    group.append(document.createElement('div'));
    group.append(document.createElement('div'));

    group.children[0].innerText = '#' + id + '.';

    group.children[1].setAttribute('id', id);
    group.children[1].setAttribute('class', 'mx-1');

    group.children[1].append(document.createElement('div'));
    group.children[1].children[0].setAttribute('class', 'group-item');
    group.children[1].children[0].innerText = name;
    group.children[1].children[0].addEventListener('dblclick', replaceByInput);


    const listbutton = document.createElement('button');

    listbutton.setAttribute('type', 'button');
    listbutton.setAttribute('class', 'btn btn-primary mx-1 group-info');
    listbutton.setAttribute('data-id', id);
    listbutton.addEventListener('click', readStudents);
    listbutton.append(document.createElement('i'));
    listbutton.firstElementChild.setAttribute('class', 'bi bi-list');


    const dropdown = document.createElement('div');
    
    dropdown.setAttribute('class', 'dropdown dropend');
    const dropdownbutton = document.createElement('button');
    const dropdowndiv = document.createElement('div');
    dropdown.append(dropdownbutton);
    dropdown.append(dropdowndiv);

    dropdownbutton.setAttribute('type', 'button');
    dropdownbutton.setAttribute('id', 'dropdownMenuLink');
    dropdownbutton.setAttribute('data-bs-toggle', 'dropdown');
    dropdownbutton.setAttribute('class', 'h-100 btn btn-danger');
    dropdownbutton.append(document.createElement('i'));
    dropdownbutton.children[0].setAttribute('class', 'bi bi-dash-circle-fill');

    dropdowndiv.setAttribute('class', 'dropdown-menu px-3');
    dropdowndiv.setAttribute('id', 'dropdownMenuLink');
    
    dropdowndiv.append(document.createElement('p'));
    dropdowndiv.append(document.createElement('button'));
    dropdowndiv.append(document.createElement('button'));

    dropdowndiv.children[0].setAttribute('class', 'text-center');
    dropdowndiv.children[0].innerText = 'Vous êtes sur le point de supprimer ce groupe. Les informations relatives aux étudiants seront conservées. Êtes-vous sûr ?';

    dropdowndiv.children[1].setAttribute('data-id', id);
    dropdowndiv.children[1].setAttribute('type', 'button');
    dropdowndiv.children[1].setAttribute('class', 'btn btn-primary mx-1 rm-group');
    dropdowndiv.children[1].addEventListener('click', deleteGroup);
    dropdowndiv.children[1].innerText = 'Oui';

    dropdowndiv.children[2].setAttribute('type', 'button');
    dropdowndiv.children[2].setAttribute('class', 'btn btn-danger mx-1');
    dropdowndiv.children[2].innerText = 'Non';

    toAppend.append(group);
    toAppend.append(listbutton);
    toAppend.append(dropdown);

    return toAppend;
}

function readStudents() {
    const groupId = this.getAttribute('data-id');
    const myRequest = new Request(route('readstudents', groupId), {
        method: 'GET',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        const studentsDiv = document.querySelector('.students');
        studentsDiv.textContent = '';

        if (groupId !== studentsDiv.getAttribute('data-id'))
            canEditStudent(false);
 
        for (const student of data)
            studentsDiv.append(createStudentEntry(student.id, student.first_name, student.last_name));

        if (data.length == 0) {
            studentsDiv.setAttribute('empty', 'true');
            studentsDiv.append(createEmptyDiv());
        } else {
            studentsDiv.setAttribute('empty', 'false');
        }

        studentsDiv.setAttribute('data-id', groupId);
        document.querySelector('.add-student-button-dropdown').disabled = false;
        document.querySelector('.add-student-button').setAttribute('data-id', groupId)
    })
}

function createEmptyDiv() {
    const div = document.createElement('h1');
    div.setAttribute('class', 'text-center text-secondary my-5');
    div.innerText = "(vide)";

    return div;
}

function createStudent() {
    const myRequest = new Request(route('createstudent'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            group_id: this.getAttribute('data-id'),
            first_name: document.querySelector('.create-student-first-name-input').value,
            last_name: document.querySelector('.create-student-last-name-input').value,
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        const studentsDiv = document.querySelector('.students');
        if (studentsDiv.getAttribute('empty') === 'true') {
            studentsDiv.textContent = '';
            studentsDiv.removeAttribute('empty');
        }
    
        document.querySelector('.create-student-first-name-input').value = '';
        document.querySelector('.create-student-last-name-input').value = '';
        studentsDiv.append(createStudentEntry(data.id, data.first_name, data.last_name));
    })
    .catch(error => {
        error.then(error => {
            createAlert(error.message);
        });
    });
}

function createStudentEntry(id, first_name, last_name) {
    let toAppend = document.createElement('div');
    toAppend.setAttribute('class', 'container d-flex mb-2');

    const group = document.createElement('div');

    group.setAttribute('class', 'd-flex list-group-item w-100');
    group.setAttribute('data-id', id);
    group.append(document.createElement('div'));
    group.append(document.createElement('div'));

    group.children[0].innerText = '#' + id + '.';

    group.children[1].setAttribute('class', 'mx-1');

    group.children[1].append(document.createElement('div'));
    group.children[1].children[0].setAttribute('class', 'group-item d-flex');
    group.children[1].children[0].append(document.createElement('div'));
    group.children[1].children[0].append(document.createElement('div'));
    group.children[1].children[0].children[0].setAttribute('class', 'first-name-div-' + id);
    group.children[1].children[0].children[0].innerText = first_name;
    group.children[1].children[0].children[1].setAttribute('class', 'last-name-div-' + id + ' ms-1');
    group.children[1].children[0].children[1].innerText = last_name;

    const editbutton = document.createElement('button');

    editbutton.setAttribute('type', 'button');
    editbutton.setAttribute('class', 'btn btn-primary mx-1 edit-student-button');
    editbutton.setAttribute('data-id', id);
    editbutton.addEventListener('click', () => {canEditStudent(true, id, first_name, last_name)});
    editbutton.append(document.createElement('i'));
    editbutton.firstElementChild.setAttribute('class', 'bi bi-pencil-fill');


    const dropdown = document.createElement('div');
    
    dropdown.setAttribute('class', 'dropdown dropend');
    const dropdownbutton = document.createElement('button');
    const dropdowndiv = document.createElement('div');
    dropdown.append(dropdownbutton);
    dropdown.append(dropdowndiv);

    dropdownbutton.setAttribute('type', 'button');
    dropdownbutton.setAttribute('id', 'dropdownMenuLink');
    dropdownbutton.setAttribute('data-bs-toggle', 'dropdown');
    dropdownbutton.setAttribute('class', 'h-100 btn btn-danger');
    dropdownbutton.append(document.createElement('i'));
    dropdownbutton.children[0].setAttribute('class', 'bi bi-dash-circle-fill');

    dropdowndiv.setAttribute('class', 'dropdown-menu px-3');
    dropdowndiv.setAttribute('id', 'dropdownMenuLink');
    
    dropdowndiv.append(document.createElement('p'));
    dropdowndiv.append(document.createElement('button'));
    dropdowndiv.append(document.createElement('button'));

    dropdowndiv.children[0].setAttribute('class', 'text-center');
    dropdowndiv.children[0].innerText = 'Vous êtes sur le point de supprimer cet étudiant de la base de données. Êtes-vous sûr ?';

    dropdowndiv.children[1].setAttribute('data-id', id);
    dropdowndiv.children[1].setAttribute('type', 'button');
    dropdowndiv.children[1].setAttribute('class', 'btn btn-primary mx-1 rm-group');
    dropdowndiv.children[1].addEventListener('click', deleteStudent);
    dropdowndiv.children[1].innerText = 'Oui';

    dropdowndiv.children[2].setAttribute('type', 'button');
    dropdowndiv.children[2].setAttribute('class', 'btn btn-danger mx-1');
    dropdowndiv.children[2].innerText = 'Non';

    toAppend.append(group);
    toAppend.append(editbutton);
    toAppend.append(dropdown);

    return toAppend;
}

function deleteStudent() {
    const myRequest = new Request(route('deletestudent'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            student_id: this.getAttribute('data-id')
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        this.parentNode.parentNode.parentNode.remove();

        const studentsDiv = document.querySelector('.students');
        if (studentsDiv.childNodes.length == 0) {
            studentsDiv.setAttribute('empty', 'true');
            studentsDiv.append(createEmptyDiv());
        }

        if (this.getAttribute('data-id') === document.querySelector('.student').getAttribute('data-id'))
            canEditStudent(false);
    })
    .catch(error => {
        error.then(error => {
            createAlert(error.message);
        });
    });
}

function canEditStudent(bool, id, first_name, last_name) {
    const editStudentFirstName = document.querySelector('.edit-student-first-name-input');
    const editStudentLastName = document.querySelector('.edit-student-last-name-input');

    editStudentFirstName.hidden = bool ? false : true
    editStudentLastName.hidden = bool ? false : true;
    document.querySelector('.change-group-button').disabled = bool ? false : true;

    if (bool) {
        editStudentFirstName.value = first_name;
        editStudentFirstName.setAttribute('data-id', id);
        editStudentLastName.value = last_name;
        editStudentLastName.setAttribute('data-id', id);
        document.querySelector('.student').setAttribute('data-id', id);
    } else {
        editStudentFirstName.value = '';
        editStudentFirstName.removeAttribute('data-id');
        editStudentLastName.value = '';
        editStudentLastName.removeAttribute('data-id');
        document.querySelector('.student').removeAttribute('data-id');
    }
}

function updateStudent() {
    const id = this.getAttribute('data-id');
    const myRequest = new Request(route('updatestudent'), {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            student_id: id,
            first_name: document.querySelector('.edit-student-first-name-input').value,
            last_name: document.querySelector('.edit-student-last-name-input').value,
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        document.querySelector('.first-name-div-' + id).innerText = document.querySelector('.edit-student-first-name-input').value;
        document.querySelector('.last-name-div-' + id).innerText = document.querySelector('.edit-student-last-name-input').value;
    })
    .catch(error => {
        error.then(error => {
            createAlert(error.message);
        });
    });
}

for (let item of document.getElementsByClassName('group-item'))
    item.addEventListener('dblclick', replaceByInput);

for (let group of document.getElementsByClassName('rm-group'))
    group.addEventListener('click', deleteGroup);

for (let group of document.getElementsByClassName('group-info'))
    group.addEventListener('click', readStudents);

document.querySelector('.add-group').addEventListener('click', createGroup);

document.querySelector('.group-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') createGroup.call(document.querySelector('.add-group'));
});

document.querySelector('.add-student-button').addEventListener('click', createStudent);

document.querySelector('.edit-student-first-name-input').addEventListener('blur', updateStudent);
document.querySelector('.edit-student-last-name-input').addEventListener('blur', updateStudent);