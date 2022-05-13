function createMCQ() {
    axios.post(route('createmcqgenerator'), {
        title: document.querySelector('.create-mcq-title-input').value
    })
    .then(response => {
        window.location.href = route('editmcq', response.data.id);
    })
    .catch(error => {
        console.log(error.response.data.message);
    });
}

function deleteMCQ() {
    axios.post(route('deletemcqgenerator'), {
        id: this.getAttribute('data-id')
    })
    .then(response => {
        this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
    })
    .catch(error => {
        console.log(error.response.data.message);
    });
}

document.querySelector('.create-mcq-button').addEventListener('click', createMCQ);

for (let button of document.getElementsByClassName('delete-mcq-button'))
    button.addEventListener('click', deleteMCQ);