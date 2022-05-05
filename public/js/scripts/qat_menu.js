$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function createQuestion() {
    $.ajax({
        type: 'POST',
        url: CREATE_QUESTION_ROUTE,
        data: {
            question: $('.question-input')[0].value
        },

        success: function(data) {
            REDIRECT_QUESTION = (REDIRECT_QUESTION.slice(0, -1)) + data[1];
            window.location.href = REDIRECT_QUESTION;
        },

        error: function(data) {
            $('.alert').empty();
            $(".alert").append(createAlert(data.responseJSON.message, data.responseJSON['id'] != undefined ? data.responseJSON['id'] : undefined));
        }
    });
}

function rmQuestion(e) {
    $.ajax({
        type: 'POST',
        url: DELETE_QAT_ROUTE,
        data: {
            id: e.currentTarget.id
        },

        success: function(data) {
            if (data === 'true') {
                e.currentTarget.parentNode.parentNode.parentNode.remove();
            }
        }
    });
}

function createAlert(text, id) {
    let add = '';
    if (id !== undefined) {
        REDIRECT_QUESTION = (REDIRECT_QUESTION.slice(0, -1)) + id;
        add = `<a type='button' class='btn btn-primary mx-2' href=` + REDIRECT_QUESTION + `>S'y rendre</a>`;
    }

    let $ret = $(
    `<div class="border border-4 alert alert-danger alert-dismissible fade show w-50 d-flex">
        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
        <div class="alert-text">` + text + add + `</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`);

    return $ret;
}

$('.add-question').on('click', createQuestion);
$('.rm-question').on('click', rmQuestion);