<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Enquetes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 700px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4f46e5;
            color: white;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        .status {
            font-weight: bold;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            color: white;
            display: inline-block;
        }

        .nao-iniciada { background-color: #6b7280; }
        .em-andamento { background-color: #2563eb; }
        .finalizada { background-color: #16a34a; }

        a {
            color: #4f46e5;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            body {
                padding: 1rem;
            }

            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Início</th>
                <th>Término</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($polls as $poll)
            <tr>
                <td>
                    <a href="{{ route('polls.show', $poll->id) }}">
                        {{ $poll->title }}
                    </a>
                </td>
                <td>{{ $poll->start_at_formatted }}</td>
                <td>{{ $poll->end_at_formatted }}</td>
                <td>
                    <span class="status
                        @if($poll->status == 'Não iniciada') nao-iniciada
                        @elseif($poll->status == 'Em andamento') em-andamento
                        @else finalizada
                        @endif">
                        {{ $poll->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
