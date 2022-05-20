class SearchBar {
    constructor(input, data) {
        this.input = input;
        this.data = data;

        input.addEventListener('keyup', this.onInputClick.bind(this));
        this.searchRequest();
    }

    onInputClick() {
        this.searchRequest();
    }

    getInputContent() {
        return this.input.value;
    }

    emptyData() {
        this.data.textContent = '';
    }

    searchRequest() {
        axios.get(route('fuzzysearchquestion'), {
            params: {
                content: this.getInputContent()
            }
        })
        .then(response => {
            this.addContentToInput(response.data);
        })
    }

    addContentToInput(data) {
        this.emptyData();
        for (let obj of data) {
            this.data.append(this.makeContentDiv(obj));
        }
    }

    makeContentDiv(obj) {
        let div = document.createElement('div');
        let link = document.createElement('a');
        link.setAttribute('data-id', obj.id);
        link.setAttribute('class', 'list-group-item list-group-item-action');
        link.setAttribute('role', 'button');
        link.setAttribute('href', route('editquestion', obj.id));
        link.innerText = obj.question;

        div.append(link);

        return div;
    }
}