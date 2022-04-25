<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>QCM</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mb-5">Questionnaire</h1>
            <div class="container">
                <p class="text-center">Ajout de question :</p>
                <div class="container">
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Tags</button>
                    <ul class="dropdown-menu">
                        <?php
                            foreach (App\Models\Tags::all() as $a) echo
                            "<div class='mx-3 my-2'>
                                <input class='form-check-input checkboxes' type='checkbox' value='$a[id]' id='flexCheckDefault'>
                                <label class='form-check-label' for='flexCheckDefault'>
                                    $a[tag]
                                </label>
                            </div>"
                        ?>
                    </ul>
                    <input type="text" class="form-control" aria-label="Ajouter la question">
                    </div>
                </div>
                <div class="container" id="placeholder">

                </div>
            </div>
        </div>
    </body>
</html>

<script>
    for (const el of document.getElementsByClassName('checkboxes')) {
        el.addEventListener("click", () => {
            for (const el of document.getElementsByClassName('checkboxes')) if (el.checked) {
                console.log('a');
                break;
            }
        });
    }
</script>