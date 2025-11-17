<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="background-color: #e5e7eb; font-weight: bold; padding: 5px;">
                    Estudiantes
                </th>
                @foreach ($data['classes'] as $referent)
                    <th class="border border-black" style="background-color: #f3f4f6; padding: 5px; text-align: center;"
                        colspan="{{ count($referent['indicators']) }}">
                        {{ $referent['title'] }}
                    </th>
                @endforeach
            </tr>
            <tr>
                @foreach ($data['classes'] as $referent)
                    @foreach ($referent['indicators'] as $indicator)
                        <th style="padding: 5px; font-size: 10px; text-align: center;">
                            {{ $indicator['name'] }}
                        </th>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data['students'] as $student)
                <tr>
                    <td style="font-weight: bold; padding: 8px; text-align: left; font-size: 12px;">
                        {{ $student['name'] }}
                    </td>

                    @foreach ($data['classes'] as $referent)
                        @foreach ($referent['indicators'] as $indicator)
                            <td style="padding: 8px; text-align: center; font-size: 12px;">
                                @php
                                    $note = $student['notesByReferent'][$referent['id']][$indicator['id']] ?? '-';
                                @endphp
                                {{ $note }}
                            </td>
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
