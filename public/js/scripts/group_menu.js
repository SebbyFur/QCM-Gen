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
    
    toAppend.addEventListener('blur', replaceByDiv);

    parent.append(toAppend);
    toAppend.focus();
}

function replaceByDiv() {
    let text = this.value;
    text.replace(/\s/g, '') === '' ? text = this.getAttribute('old') : updateGroupName(this.parentNode.id, text);

    let parent = this.parentNode;
    parent.textContent = '';

    let toAppend = document.createElement('div');
    toAppend.setAttribute('class', "group-item");
    toAppend.innerText = text;
    
    toAppend.addEventListener('dblclick', replaceByInput);
    
    parent.append(toAppend);
}

async function updateGroupName(id, name) {
    const myRequest = new Request(UPDATE_GROUP_ROUTE, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            id_group: id,
            name_group: name
        })
    });

    await fetch(myRequest)
    .then(response => {
        if (response.ok) return response.json()

        throw response.json();
    })
    .then(data => {
        if (data.ok) console.log('ok');
        console.log(data);
    })
    .catch(error => {
        console.log(error);
    });
}

for (let item of document.getElementsByClassName('group-item'))
    item.addEventListener('dblclick', replaceByInput);