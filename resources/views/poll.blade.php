<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Enquete</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .poll-wrapper {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 700px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .poll-header {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .poll-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1f2937;
        }

        .poll-dates {
            font-size: 0.95rem;
            color: #6b7280;
        }

        .poll-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .option label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .vote-count {
            font-size: 0.9rem;
            color: #4b5563;
        }

        .submit-button {
            padding: 1rem;
            background-color: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:disabled {
            background-color: #93c5fd;
            cursor: not-allowed;
        }

        .message {
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .unavailable-message {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .finalized-message {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        a.back-button {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: #4f46e5;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }

        @media (max-width: 600px) {
            .poll-wrapper {
                padding: 1rem;
            }

            .poll-title {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
<div class="poll-wrapper">

    <div class="poll-header">
        <div class="poll-title">{{ $poll->title }}</div>
        <div class="poll-dates">
            Início: {{ \Carbon\Carbon::parse($poll->start_at)->format('d/m/Y') }}<br>
            Término: {{ \Carbon\Carbon::parse($poll->end_at)->format('d/m/Y') }}
        </div>
    </div>

    @php
        $now = \Carbon\Carbon::now('America/Sao_Paulo');
        $start = \Carbon\Carbon::parse($poll->start_at, 'America/Sao_Paulo');
        $end = \Carbon\Carbon::parse($poll->end_at, 'America/Sao_Paulo');
    @endphp

    @if($now->lt($start))
        <div class="message unavailable-message">
            Esta enquete está indisponível no momento. Ela estará ativa entre {{ $start->format('d/m/Y') }} e {{ $end->format('d/m/Y') }}.
        </div>
        <a href="{{ url('/polls') }}" class="back-button">Voltar para Enquetes</a>
    @elseif($now->gt($end))
        <div class="message finalized-message">
            Esta enquete foi finalizada em {{ $end->format('d/m/Y') }}.
        </div>
        <a href="{{ url('/polls') }}" class="back-button">Voltar para Enquetes</a>
    @else
        <form method="POST" action="/api/polls/{{ $poll->id }}/vote">
            @csrf
            <div class="poll-options">
                @foreach($poll->options as $option)
                    <div class="option">
                        <label>
                            <input type="radio" name="option_id" value="{{ $option->id }}">
                            {{ $option->text }}
                        </label>
                        <span class="vote-count">{{ $option->votes }} votos</span>
                    </div>
                @endforeach
            </div>
            <br>
            <button type="submit" class="submit-button">Votar</button>
        </form>
    @endif

</div>
</body>
</html>
