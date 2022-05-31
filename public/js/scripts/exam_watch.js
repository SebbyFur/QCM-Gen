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
            location.reload();
        }
    })
}

for (const del of document.getElementsByClassName('delete-mcq-button'))
    del.addEventListener('click', deleteMCQRequest);