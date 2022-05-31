<!DOCTYPE html>
<html>
    <head>
        <style>
            @page {
                margin-top: 120px; /* create space for header */
            }

            .border {
                border: solid 2px black;
            }

            .header {
                margin: 3% 5% 0 5%;
                position: fixed;
                left: 0;
                right: 0;
                margin-top: -70px;
            }

            .logo {
                width: 12%;
                position: absolute;
                right: 20;
                top: 5;
            }

            .logo2 {
                width: 12%;
                position: absolute;
                right: 0;
                top: 20;
            }

            .qr {
                width: 8%;
                position: absolute;
                left: 40;
                top: -50;
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
            <h3>{{ $data['first_name'] }} {{ $data['last_name'] }} - {{ $data['title'] }}</h3>
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
        <img class="qr" src="data:image/svg+xml;base64,{{ $data['qr'] }}"/>
        <table style='margin: 0 0 0 50px'>
            <tbody>
                <tr>
                    <td style='width: 210px'>
                        <div>
                            <div style='width: 30px; display: inline;'>R: </div>
                            <div style='display: inline; margin-left: 5px;'>
                                @for ($j = 1; $j < 7; $j++)
                                <div style='display: inline; margin-left: 8.6px'>{{ $j }}</div>
                                @endfor
                            </div>
                        </div>
                        @for ($i = 0; ($i < 40 && $i < count($data['questions'])); $i++)
                        <div>
                            <div style='width: 30px; display: inline-block; height: 20px'>{{$i + 1}}</div>
                            <div style='display: inline;'>
                                @for ($j = 0; $j < 6; $j++)
                                    @if (isset($data['questions'][$i]->answers[$j]))
                                    <input type='checkbox'/>
                                    @else
                                    <input type='checkbox' style='background-color: black; height: 18px; margin: 2px 0 3px 0' hidden/>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @endfor
                    </td>
                    <td style='width: 210px; @if (count($data['questions']) < 80) display: inline; @endif'>
                        <div>
                            <div style='width: 30px; display: inline;'>R: </div>
                            <div style='display: inline; margin-left: 5px;'>
                                @for ($j = 1; $j < 7; $j++)
                                <div style='display: inline; margin-left: 8.6px'>{{ $j }}</div>
                                @endfor
                            </div>
                        </div>
                        @for ($i; ($i < 80 && $i < count($data['questions'])); $i++)
                        <div>
                            <div style='width: 30px; display: inline-block; height: 20px'>{{$i + 1}}</div>
                            <div style='display: inline;'>
                                @for ($j = 0; $j < 6; $j++)
                                    @if (isset($data['questions'][$i]->answers[$j]))
                                    <input type='checkbox'/>
                                    @else
                                    <input type='checkbox' style='background-color: black; height: 18px; margin: 2px 0 3px 0' hidden/>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @endfor
                    </td>
                    <td style='width: 210px; display: inline'>
                        <div>
                            <div style='width: 30px; display: inline;'>R: </div>
                            <div style='display: inline; margin-left: 5px;'>
                                @for ($j = 1; $j < 7; $j++)
                                <div style='display: inline; margin-left: 8.6px'>{{ $j }}</div>
                                @endfor
                            </div>
                        </div>
                        @for ($i; ($i < 120 && $i < count($data['questions'])); $i++)
                        <div>
                            <div style='width: 30px; display: inline-block; height: 20px'>{{$i + 1}}</div>
                            <div style='display: inline;'>
                                @for ($j = 0; $j < 6; $j++)
                                    @if (isset($data['questions'][$i]->answers[$j]))
                                    <input type='checkbox'/>
                                    @else
                                    <input type='checkbox' style='background-color: black; height: 18px; margin: 2px 0 3px 0' hidden/>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @endfor
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html> 