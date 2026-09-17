<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Veículos') | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&family=Barlow+Condensed:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --verde: #1d4a37;
            --verde-escuro: #12311f;
            --amarelo: #f3c623;
            --azul-placa: #1a4fa0;
            --fundo: #f3f5f1;
            --texto: #1c2420;
            --bs-body-font-family: "Barlow", system-ui, sans-serif;
            --bs-body-color: var(--texto);
            --bs-body-bg: var(--fundo);
        }

        .topo { background: var(--verde); color: #fff; }
        .topo a { color: inherit; text-decoration: none; }
        .topo .marca { font-family: "Barlow Condensed", "Barlow", sans-serif; font-size: 1.6rem; letter-spacing: .02em; }
        .topo small { color: #cfe0d6; }

        /* Faixa refletiva de para-choque: o único elemento de destaque */
        .faixa {
            height: 10px;
            background: repeating-linear-gradient(-45deg, var(--amarelo) 0 14px, var(--verde-escuro) 14px 28px);
        }

        .btn-primary {
            --bs-btn-bg: var(--verde);
            --bs-btn-border-color: var(--verde);
            --bs-btn-hover-bg: var(--verde-escuro);
            --bs-btn-hover-border-color: var(--verde-escuro);
            --bs-btn-active-bg: var(--verde-escuro);
            --bs-btn-active-border-color: var(--verde-escuro);
        }
        .btn-outline-primary {
            --bs-btn-color: var(--verde);
            --bs-btn-border-color: var(--verde);
            --bs-btn-hover-bg: var(--verde);
            --bs-btn-hover-border-color: var(--verde);
        }

        .painel { background: #fff; border: 1px solid #dde3dc; border-radius: .5rem; padding: 1.5rem; }
        .table { --bs-table-bg: #fff; }

        /* Placa desenhada como a placa real: faixa azul no topo */
        .placa {
            display: inline-block;
            min-width: 6.5rem;
            text-align: center;
            font-family: "Barlow Condensed", "Barlow", sans-serif;
            font-size: 1.05rem;
            letter-spacing: .08em;
            background: #fff;
            border: 2px solid var(--texto);
            border-top: 6px solid var(--azul-placa);
            border-radius: 4px;
            padding: 0 .5rem;
        }

        .status { display: inline-flex; align-items: center; gap: .4rem; font-weight: 500; }
        .status::before { content: ""; width: .6rem; height: .6rem; border-radius: 50%; background: #8a948e; }
        .status-ativo::before { background: #2f9e5b; }
        .status-manutencao::before { background: #e0a100; }

        .vazio { border: 2px dashed #c5cec6; border-radius: .5rem; padding: 2.5rem 1rem; text-align: center; background: #fff; }
        .rodape { color: #6a746e; font-size: .9rem; }
    </style>
</head>
<body>
<header class="topo">
    <div class="container py-3">
        <a href="{{ route('veiculos.index') }}" class="marca d-block">{{ config('app.name') }}</a>
        <small>Controle da frota da coleta de resíduos</small>
    </div>
    <div class="faixa" role="presentation"></div>
</header>

<main class="container py-4" style="max-width: 960px">
    @if (session('sucesso'))
        <div class="alert alert-success" role="status">{{ session('sucesso') }}</div>
    @endif

    @yield('conteudo')
</main>

<footer class="container pb-4 rodape" style="max-width: 960px">
    Versão {{ config('sistema.versao') }}
</footer>

<script>
    // Pede confirmação em formulários marcados com data-confirmar (exclusão)
    document.addEventListener('submit', function (evento) {
        var mensagem = evento.target.dataset.confirmar;
        if (mensagem && !window.confirm(mensagem)) {
            evento.preventDefault();
        }
    });
</script>
</body>
</html>
