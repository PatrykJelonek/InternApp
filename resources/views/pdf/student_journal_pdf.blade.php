<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Generate PDF Laravel 8 - phpcodingstuff.com</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style type="text/css">
        *{
            font-family: DejaVu Sans, serif; font-size: 12px;}

        @page {
            margin: 0px;
        }

        body {
            margin: 0;
            color: #000;
            background-color: #fff;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
        }

        th {
            vertical-align: top;
            width: 130px;
        }

        td {
            vertical-align: top;
        }

        .page-title {
            font-weight: bold;
            margin: 5px 0 10px 0;
            padding: 0;
            text-transform: uppercase;
        }

        .section {
            padding: 5px;
            border-radius: 5px;
            background: #efefef;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 18px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .pdf-btn {
            margin-top: 30px;
        }

        .journal-entries-table {
            margin: 20px 0;
            width: 100%;
        }

        .subtitle {
            font-weight: bold;
            margin: 5px 0;
            padding: 0;
            text-transform: uppercase;
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 text-center mt-3">
            <h1 class="page-title">Dziennik Praktyk</h1>
        </div>
    </div>

    <div class="row section">
        <div class="col-12 text-left">
            <h2 class="section-title">Informacje o studencie</h2>

            <table>
                <tr>
                    <th>Imię i nazwisko:</th>
                    <td class="pl-5">{{ $student->user->full_name ?? '' }}</td>
                </tr>
                <tr>
                    <th>Index:</th>
                    <td class="pl-5">{{ $student->student_index ?? '' }}</td>
                </tr>
                <tr>
                    <th>Wydział:</th>
                    <td class="pl-5">{{ $student->specialization->field->faculty->name ?? '' }}</td>
                </tr>
                <tr>
                    <th>Kierunek:</th>
                    <td class="pl-5">{{ $student->specialization->field->name ?? '' }}</td>
                </tr>
                <tr>
                    <th>Specjalność:</th>
                    <td class="pl-5">{{ $student->specialization->name ?? '' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row section">
        <div class="col-12 text-left">
            <h2 class="section-title">Informacje o uczelni</h2>
            <div class="row">
                <div class="col-10">
                    <table>
                        <tr>
                            <th>Nazwa:</th>
                            <td class="pl-5">{{ $internship->agreement->university->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Adres:</th>
                            <td class="pl-5">
                                {{ $internship->agreement->university->street ?? 'Wojska Polskiego' }}
                                {{ $internship->agreement->university->street_number ?? '1' }},
                                {{ $internship->agreement->university->city->name ?? 'Elbląg' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Opiekun praktyk:</th>
                            <td class="pl-5">{{ $internship->universitySupervisor->full_name ?? ''}}</td>
                        </tr>
                    </table>
                </div>
{{--                <div class="col-2">--}}
{{--                    <img src="/{{ $internship->agreement->university->logo_url ?? '' }}" alt="Logo uczelni" height="200px"--}}
{{--                         width="auto"/>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    <div class="row section">
        <div class="col-12 text-left">
            <h2 class="section-title">Informacje o firmie</h2>
            <div class="row">
                <div class="col-10">
                    <table>
                        <tr>
                            <th>Nazwa:</th>
                            <td class="pl-5">{{ $internship->agreement->company->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Adres:</th>
                            <td class="pl-5">
                                {{ $internship->agreement->company->street ?? '' }}
                                {{ $internship->agreement->company->street_number ?? '' }},
                                {{ $internship->agreement->company->city->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Opiekun praktyk:</th>
                            <td class="pl-5">{{ $internship->companySupervisor->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Opinia opiekuna praktyk:</th>
                            <td class="pl-5">{{ $internshipStudent->company_supervisor_opinion }}</td>
                        </tr>
                    </table>
                </div>
{{--                <div class="col-2">--}}
{{--                    <img src="/{{$internship->agreement->company->logo_url}} ?? '' }}" alt="Logo firmy" height="200px" width="auto"/>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="subtitle">Wpisy: </h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="journal-entries-table">
                <tr>
                    <th>Data</th>
                    <th>Treść</th>
                    <th>Autor</th>
                </tr>
                @if (count($journalEntires ?? []) > 0)
                    @foreach($journalEntires as $journalEntry)
                        <tr>
                            <td>{{ $journalEntry->formatted_date ?? '' }}</td>
                            <td>{{ $journalEntry->content ?? '' }}</td>
                            <td>{{ $journalEntry->user->full_name ?? '' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center pa-5">Brak wpisów w dzienniku!</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="subtitle">Zadania: </h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="journal-entries-table">
                <tr>
                    <th>Data</th>
                    <th>Treść</th>
                    <th>Autor</th>
                </tr>
                @if (count($studentTasks ?? []) > 0)
                    @foreach($studentTasks as $studentTask)
                        <tr>
                            <td>{{ $studentTask->formatted_created_at ?? '' }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-12">
                                        <b>{{ $studentTask->name ?? '' }}</b>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 5px;">
                                    <div class="col-12">
                                        {{ $studentTask->description ?? '' }}
                                    </div>
                                </div>
                            </td>
                            <td>{{ $studentTask->user->full_name ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>
</body>
</html>
