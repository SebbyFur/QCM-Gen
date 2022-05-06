$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function updateQuestion(e) {
    $.ajax({
        type: 'POST',
        url: UPDATE_QUESTION_ROUTE,
        data: {
            id: ID_QUESTION,
            question: e.currentTarget.value
        },

        error: function(data) {
            $('.alert').empty();
            $(".alert").append(createAlert(data.responseJSON.message));
        }
    });
}

function rmQuestion() {
    $.ajax({
        type: 'POST',
        url: DELETE_QAT_ROUTE,
        data: {
            id: ID_QUESTION
        },

        success: function(data) {
            if (data === 'true') {
                window.location.href = REDIRECT_HOME;
            }
        }
    });
}

function addAnswer() {
    $.ajax({
        type: 'POST',
        url: CREATE_ANSWER_ROUTE,
        data: {
            id_question: ID_QUESTION,
            answer: ""
        },

        success: function(data) {
            if (data[0] === 'true') {
                let el = $(`<div class='mb-4'><div class='flex-grow-1 d-flex answer-div' id=` + data[1] + `></div></div>`);

                
                let checkbox = $("<input class='form-check-input mx-2 my-3 is_correct' type='checkbox'>");
                let input = $("<input class='form-control mx-2 answer' type='text' placeholder='Entrez une réponse...'>");
                let rm = $("<button type='button' class='btn btn-danger ml-2 rm-answer'><i class='bi bi-dash-circle-fill'></i></button>)");
                checkbox.on('click', updateAnswer);
                input.on('blur', updateAnswer);
                rm.on('click', rmAnswer);

                el.children().first().append(checkbox);
                el.children().first().append(input);
                el.children().first().append(rm);
                $('.answers-div').append(el);
            }
        }
    });
}

function rmAnswer(e) {
    $.ajax({
        type: 'POST',
        url: DELETE_ANSWER_ROUTE,
        data: {
            id_answer: e.currentTarget.parentNode.id
        },

        success: function() {
            e.currentTarget.parentNode.parentNode.remove();
        }
    });
}

function updateAnswer(e) {
    let answer = e.currentTarget.parentNode.children[1].value;

    if (answer === '') {
        e.currentTarget.parentNode.children[0].checked = false;
        e.currentTarget.parentNode.children[0].disabled = true;
    } else {
        e.currentTarget.parentNode.children[0].disabled = false;
    }

    $.ajax({
        type: 'POST',
        url: UPDATE_ANSWER_ROUTE,
        data: {
            id_answer: e.currentTarget.parentNode.id,
            is_correct: e.currentTarget.parentNode.children[0].checked ? 1 : 0,
            answer: answer
        }
    });
    
}

function updateBelongingTag(e) {
    $.ajax({
        type: 'POST',
        url: e.currentTarget.checked ? CREATE_TAG_ROUTE : DELETE_TAG_ROUTE,
        data: {
            id_tag: e.currentTarget.id,
            id_question: ID_QUESTION
        }
    });
}

function createAlert(text) {
    return $(
    `<div class="border border-4 alert alert-danger alert-dismissible fade show w-50 d-flex">
        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
        <div class="alert-text">` + text + `</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`);
}

$('.checkboxes').on('click', updateBelongingTag);

$('.question-input').on('blur', updateQuestion);
$('.rm-question').on('click', rmQuestion);

$(".btn-success").first().on("click", addAnswer);
$(".rm-answer").on('click', rmAnswer);

$(".answer").on('blur', updateAnswer);
$(".is_correct").on('click', updateAnswer);