function deleteMCQRequest() {
    const id = this.getAttribute('data-id');
    axios.post(route('deletemcq'), {
        id: id
    })
    .then(response => {
        const div = document.querySelector('.model-div-' + id);
        const parent = div.parentNode;
        div.remove();

        if (parent.children.length === 0) {
            const empty = document.createElement('h2');
            empty.setAttribute('class', 'text-center text-secondary');
            empty.innerText='(vide)';
            parent.append(empty);
        }
    })
}

function deleteAllMCQRequest() {
    axios.post(route('deleteallmcq'))
    .then(response => {
        const modelDiv = document.querySelector('.model-mcqs').firstElementChild;
        const tagDiv = document.querySelector('.category-mcqs').firstElementChild;
        const randomDiv = document.querySelector('.unclassed-mcqs').firstElementChild;

        modelDiv.textContent = '';
        tagDiv.textContent = '';
        randomDiv.textContent = '';

        modelDiv.append(makeEmptyH2());
        tagDiv.append(makeEmptyH2());
        randomDiv.append(makeEmptyH2());        
    })
}

function makeEmptyH2() {
    const ret = document.createElement('h2');
    ret.textContent = '(vide)';
    ret.setAttribute('class', 'text-center text-secondary');

    return ret;
}

for (const del of document.getElementsByClassName('delete-mcq-button'))
    del.addEventListener('click', deleteMCQRequest);

document.querySelector('.rm-all-mcqs').addEventListener('click', deleteAllMCQRequest);