const DEFAULTS = {
  threshold: 1,
  maximumItems: 30,
  highlightTyped: true,
  highlightClass: 'text-primary',
  label: 'label',
  value: 'value',
  showValue: true,
  showValueBeforeLabel: true,
};

class QAT {
  constructor(input, answers, tags) {
    this.field = input;
    this.answers = answers;
    this.tags = tags;
    this.dropdown = null;
    this.options = Object.assign({}, DEFAULTS, []);

    field.parentNode.classList.add('dropdown');
    field.setAttribute('data-bs-toggle', 'dropdown');
    field.classList.add('dropdown-toggle');

    const dropdown = ce(`<div class="dropdown-menu"></div>`);
    if (this.options.dropdownClass)
      dropdown.classList.add(this.options.dropdownClass);

    insertAfter(dropdown, field);

    this.dropdown = new bootstrap.Dropdown(field, this.options.dropdownOptions);

    field.addEventListener('click', (e) => {
      if (this.createItems() === 0) {
        e.stopPropagation();
        this.dropdown.hide();
      }
    });

    field.addEventListener('input', () => {
      if (this.field.value.replace(/\s/g, "") == "") {
        this.setData([]);
        return;
      }

      let a = this;

      $.ajax({
        type: 'POST',
        url: FUZZYSEARCHQUESTIONROUTE,
        data: {
            field: this.field.value
        },
        
        success: function(data) {
            let newData = [];
            JSON.parse(data).forEach((element) => {
              newData.push({label: element['question'], value: element['id']});
            });

            a.setData(newData);
        }
      });
    });

    field.addEventListener('keydown', (e) => {
      if (e.keyCode === 27) {
        this.dropdown.hide();
        return;
      }
      if (e.keyCode === 40) {
        this.dropdown._menu.children[0]?.focus();
        return;
      }
    });
  }

  setData(data) {
    this.options.data = data;
    this.renderIfNeeded();
  }

  renderIfNeeded() {
    if (this.createItems() > 0)
      this.dropdown.show();
    else
      this.field.click();
  }

  createItem(lookup, item) {
    let label;
    if (this.options.highlightTyped) {
      const idx = removeDiacritics(item.label)
        .toLowerCase()
        .indexOf(removeDiacritics(lookup).toLowerCase());
      const className = Array.isArray(this.options.highlightClass) ? this.options.highlightClass.join(' ')
        : (typeof this.options.highlightClass == 'string' ? this.options.highlightClass : '');
      label = item.label.substring(0, idx)
        + `<span class="${className}">${item.label.substring(idx, idx + lookup.length)}</span>`
        + item.label.substring(idx + lookup.length, item.label.length);
    } else {
      label = item.label;
    }

    if (this.options.showValue) {
      if (this.options.showValueBeforeLabel) {
        label = `${item.value}. ${label}`;
      } else {
        label += ` ${item.value}`;
      }
    }

    return ce(`<button type="button" class="dropdown-item" data-label="${item.label}" data-value="${item.value}">${label}</button>`);
  }

  createItems() {
    const lookup = this.field.value;
    if (lookup === undefined || this.options.data === undefined || lookup.replace(/\s/g, "") == "") return;
    if (lookup.length < this.options.threshold) {
      this.dropdown.hide();
      return 0;
    }

    const items = this.field.nextSibling;
    items.innerHTML = '';

    const keys = Object.keys(this.options.data);

    let count = 0;
    for (let i = 0; i < keys.length; i++) {
      const key = keys[i];
      const entry = this.options.data[key];
      const item = {
        label: this.options.label ? entry[this.options.label] : key,
        value: this.options.value ? entry[this.options.value] : entry
      };

      items.appendChild(this.createItem(lookup, item));
      if (this.options.maximumItems > 0 && ++count >= this.options.maximumItems)
        break;
    }

    this.field.nextSibling.querySelectorAll('.dropdown-item').forEach((item) => {
      item.addEventListener('click', (e) => {
        let dataLabel = e.target.getAttribute('data-label');
        let dataValue = e.target.getAttribute('data-value');

        this.field.value = dataLabel;

        if (this.options.onSelectItem) {
          this.options.onSelectItem({
            value: dataValue,
            label: dataLabel
          });
        }

        this.dropdown.hide();
      })
    });

    return items.childNodes.length;
  }
}

/**
 * @param html
 * @returns {Node}
 */
function ce(html) {
  let div = document.createElement('div');
  div.innerHTML = html;
  return div.firstChild;
}

/**
 * @param elem
 * @param refElem
 * @returns {*}
 */
function insertAfter(elem, refElem) {
  return refElem.parentNode.insertBefore(elem, refElem.nextSibling);
}

/**
 * @param {String} str
 * @returns {String}
 */
function removeDiacritics(str) {
  return str
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '');
}