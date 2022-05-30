<!DOCTYPE html>
<html>
    <head>
        <style>
            .border {
                border: solid 2px black;
            }

            .header {
                margin: 3% 5% 3% 5%;
            }

            .logo {
                width: 12%;
                position: absolute;
                right: 50;
                top: 20;
            }

            .question {
                page-break-inside: avoid;
                margin: 3% 5% 0 8% !important;
            }
            
            .answer {
                margin: 0 0 0 3%;
            }

            .end-content {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        <div class='header border' style="text-align: center">
            <h3 class='content'>QCM: {{ $data['title'] }}</h3>
            <img class='logo' src={{ asset('storage/images/logo-urca.png') }} alt="Logo URCA">
        </div>
        @php ($i = 1)
        @foreach ($data['questions'] as $question)
        <div class="question @if (count($data['questions']) == $i) end-content @endif">
            <strong>{{ $i++ }}. {{ $question->question }}</strong>
            @foreach ($question->answers as $answer)
            <div class="answer">
                {{ $answer->choice }}. {{ $answer->answer }}
            </div>
            @endforeach
        </div>
        @endforeach
        a
    </body>
</html> 