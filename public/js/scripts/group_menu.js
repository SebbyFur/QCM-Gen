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

    let parent = this.parentNode;
    parent.textContent = '';

    let toAppend = document.createElement('div');
    toAppend.setAttribute('class', "group-item");
    toAppend.innerText = text;
    
    toAppend.addEventListener('dblclick', replaceByInput);
    
    parent.append(toAppend);
}

function updateGroupName() {
    const myRequest = new Request(UPDATE_GROUP_ROUTE, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_group: this.parentNode.id,
            name_group: this.value
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
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
    const myRequest = new Request(DELETE_GROUP_ROUTE, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_group: this.id
        })
    });

    fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        this.parentNode.parentNode.parentNode.remove();
    })
    .catch(error => {
        error.then(error => {
            createAlert(error.message);
        });
    });
}

function createGroup() {
    let name_group = this.previousElementSibling.value;

    const myRequest = new Request(CREATE_GROUP_ROUTE, {
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
        let toAppend = document.createElement('div');
        toAppend.setAttribute('class', 'container d-flex mb-2');

        toAppend.append(document.createElement('div'));
        toAppend.append(document.createElement('div'));
        console.log(toAppend.children);

        let group = toAppend.children[0];
        let dropdown = toAppend.children[1];

        group.setAttribute('class', 'd-flex list-group-item w-100');
        group.append(document.createElement('div'));
        group.append(document.createElement('div'));

        group.children[0].innerText = '#' + data.id + '.';

        group.children[1].setAttribute('id', data.id);
        group.children[1].setAttribute('class', 'mx-1');

        group.children[1].append(document.createElement('div'));
        group.children[1].children[0].setAttribute('class', 'group-item');
        group.children[1].children[0].innerText = name_group;
        group.children[1].children[0].addEventListener('dblclick', replaceByInput);

        dropdown.setAttribute('class', 'dropdown dropend px-2');
        dropdown.append(document.createElement('button'));
        dropdown.append(document.createElement('div'));

        dropdown.children[0].setAttribute('type', 'button');
        dropdown.children[0].setAttribute('id', 'dropdownMenuLink');
        dropdown.children[0].setAttribute('data-bs-toggle', 'dropdown');
        dropdown.children[0].setAttribute('class', 'h-100 btn btn-danger rm-question');
        dropdown.children[0].append(document.createElement('i'));
        dropdown.children[0].children[0].setAttribute('class', 'bi bi-dash-circle-fill');

        dropdown.children[1].setAttribute('class', 'dropdown-menu px-3');
        dropdown.children[1].setAttribute('id', 'dropdownMenuLink');
        
        dropdown.children[1].append(document.createElement('p'));
        dropdown.children[1].append(document.createElement('button'));
        dropdown.children[1].append(document.createElement('button'));

        dropdown.children[1].children[0].setAttribute('class', 'text-center');
        dropdown.children[1].children[0].innerText = 'Vous êtes sur le point de supprimer ce groupe. Les informations relatives aux étudiants seront conservées. Êtes-vous sûr ?';

        dropdown.children[1].children[1].setAttribute('id', data.id);
        dropdown.children[1].children[1].setAttribute('type', 'button');
        dropdown.children[1].children[1].setAttribute('class', 'btn btn-primary mx-1 rm-group');
        dropdown.children[1].children[1].addEventListener('click', deleteGroup);
        dropdown.children[1].children[1].innerText = 'Oui';

        dropdown.children[1].children[2].setAttribute('type', 'button');
        dropdown.children[1].children[2].setAttribute('class', 'btn btn-danger mx-1');
        dropdown.children[1].children[2].innerText = 'Non';

        document.getElementsByClassName('list-group')[0].append(toAppend);
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

    document.getElementsByClassName('alert')[0].textContent = '';
    document.getElementsByClassName('alert')[0].append(mainDiv);
}

for (let item of document.getElementsByClassName('group-item'))
    item.addEventListener('dblclick', replaceByInput);

for (let group of document.getElementsByClassName('rm-group'))
    group.addEventListener('click', deleteGroup);

document.getElementsByClassName('add-group')[0].addEventListener('click', createGroup);