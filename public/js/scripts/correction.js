function createCorrectionRequest(id) {
    axios.post(route('createcorrection'), {
        id_mcq_data: id
    })
    .then(response => {
        const h2 = document.querySelector('.mark').textContent = response.data.mark + '% de réussite';
    });
}

function deleteCorrectionRequest(id) {
    axios.post(route('deletecorrection'), {
        id_mcq_data: id
    })
    .then(response => {
        const h2 = document.querySelector('.mark').textContent = response.data.mark + '% de réussite';
    });
}

for (const checkbox of document.getElementsByClassName('checkbox')) {
    checkbox.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        this.checked ? createCorrectionRequest(id) : deleteCorrectionRequest(id);
    })
}