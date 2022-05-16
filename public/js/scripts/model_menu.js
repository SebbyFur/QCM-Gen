function createModel() {
    axios.post(route('createmcqmodel'), {
        title: document.querySelector('.create-model-title-input').value
    })
    .then(response => {
        window.location.href = route('editmodel', response.data.id);
    })
    .catch(error => {
        console.log(error.response.data.message);
    });
}

function deleteModel() {
    const id = this.getAttribute('data-id');
    axios.post(route('deletemcqmodel'), {
        id: id
    })
    .then(response => {
        document.querySelector('.model-div-' + id).remove();
    })
    .catch(error => {
        console.log(error.response.data.message);
    })
}

document.querySelector('.create-model-button').addEventListener('click', createModel);

for (let button of document.getElementsByClassName('delete-model-button'))
    button.addEventListener('click', deleteModel);