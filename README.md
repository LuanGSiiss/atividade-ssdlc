# Frota da Coleta

Sistema web simples para cadastrar os veículos da coleta de resíduos, desenvolvido com **Spec-Driven Development (SDD)** e publicado na AWS por uma pipeline de CI/CD com análise de segurança.

## Especificação (SDD)

| Artefato | Conteúdo |
|----------|----------|
| [`specs/constitution.md`](specs/constitution.md) | Princípios do projeto |
| [`specs/001-cadastro-veiculos/spec.md`](specs/001-cadastro-veiculos/spec.md) | Histórias, regras e critérios de aceitação |
| [`specs/001-cadastro-veiculos/plan.md`](specs/001-cadastro-veiculos/plan.md) | Decisões técnicas e rastreabilidade critério → teste |
| [`specs/001-cadastro-veiculos/tasks.md`](specs/001-cadastro-veiculos/tasks.md) | Tarefas de implementação |

## Stack

PHP 8.4, Laravel 13, Blade, Bootstrap 5, SQLite, Docker, GitHub Actions, SonarQube Cloud, AWS EC2.

## Pipeline

`push na main` → testes + `composer audit` + SonarQube (quality gate) → build da imagem → ghcr.io → deploy na EC2 via SSH → verificação pela internet → release no GitHub.

## Rodar localmente

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan test
php artisan serve
```

Acesse http://localhost:8000.

## Endpoints úteis

- `/veiculos` — sistema
- `/versao` — versão publicada
- `/up` — health check
