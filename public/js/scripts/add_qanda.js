$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function addEntry(disabled) {
    $(`
    <div class='mb-4'>
        <div class='flex-grow-1 d-flex answer-div'>
            <input class='form-check-input mx-2 my-3' type='checkbox'>
            <input class='form-control mx-2 answer' type='text'>
            <button type='button' class='btn btn-danger ml-2 rm-answer' ` + (disabled ? "disabled" : "") + `><i class="bi bi-dash-circle-fill"></i></button>
        </div>
    </div>`).appendTo($('.holder'));

    let el = $(".answer-div").last().children().last();
    el.on("click", rmEntry);
}

function rmEntry(e) {
    if (getAnswerCount() == 1) {
        console.log("ENculé");
    } else {
        e.currentTarget.parentNode.parentNode.remove();
    }
}

function addQuestionRequest(e) {
    if (e.currentTarget.value.replace(/\s/g, "") == "") return;

    $.ajax({
        type: 'POST',
        url: ADDQUESTIONROUTE,
        data: {
            question: e.currentTarget.value
        },
        
        success: function(data) {
            if (data[0] == "true") {
                updateFromId(data[1]);
            }

            $('.question-input').attr('id', data[1]);
        }
    });
}

function updateQuestionInput(e) {
    if (e.currentTarget.value.replace(/\s/g, "") == "") return; 
}

function updateFromId(id) {
    $.ajax({
        type: 'POST',
        url: FUZZYSEARCHQUESTIONROUTE,
        data: {
            field: e.currentTarget.value
        },
        
        success: function(data) {
            console.log(data);
        }
    });
}

$(".btn-success").first().on("click", () => {addEntry(false)});

$('.question-input').on("blur", addQuestionRequest);
$('.question-input').on("input", updateQuestionInput);

$('.question').on("click", (e) => {
    $('.question-input').first().val(e.currentTarget.innerText);
});


addEntry(true);
addEntry(true);