<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Voto Registrado</title>
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

        .success-wrapper {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
            text-align: center;
        }

        .title {
            font-size: 1.8rem;
            color: #16a34a;
            font-weight: bold;
        }

        .info {
            font-size: 1rem;
            color: #374151;
        }

        .highlight {
            color: #1d4ed8;
            font-weight: bold;
        }

        .back-button {
            padding: 0.8rem 1.5rem;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #1d4ed8;
        }

        @media (max-width: 600px) {
            .title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="success-wrapper">
    <div class="title">Voto Registrado com Sucesso!</div>

    <div class="info">
        Você votou na opção:
        <div class="highlight">{{ $option->text }}</div>
    </div>

    <div class="info">
        Esta opção possui agora:
        <div class="highlight">{{ $option->votes }} votos</div>
    </div>

    <a href="/polls" class="back-button">Voltar para a seleção de Enquetes</a>
</div>
</body>
</html>
