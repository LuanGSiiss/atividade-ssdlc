# Plano técnico — Spec 001

## Decisões

| Tema | Decisão | Motivo |
|------|---------|--------|
| Linguagem/framework | PHP 8.4 + Laravel 13, MVC com Blade | Stack já conhecida pela equipe |
| Interface | Bootstrap 5 via CDN | Sem etapa de build de front-end |
| Banco | SQLite em volume Docker | Uma única EC2, sem custo de RDS |
| Empacotamento | Imagem Docker `php:8.4-apache`, usuário `www-data`, porta 8080 | Mesmo artefato em qualquer ambiente; atende RNF-05 |
| Registro de imagens | GitHub Container Registry (ghcr.io) | Integrado ao GitHub, sem credencial extra |
| Infraestrutura | AWS EC2 Ubuntu 24.04 com Docker | Requisito da disciplina |
| CI/CD | GitHub Actions | Integrado ao repositório |
| Segurança | SonarQube Cloud (quality gate) + `composer audit` | Bloqueiam o deploy (RNF-02) |

## Modelo de dados

Tabela `veiculos`: `id`, `placa` (7, única), `modelo` (80), `capacidade_kg` (inteiro), `status` (20), `created_at`, `updated_at`.

## Rotas

| Método | URI | Ação |
|--------|-----|------|
| GET | `/` | redireciona para `/veiculos` |
| GET | `/veiculos` | lista (US-02) |
| GET | `/veiculos/create` | formulário de cadastro |
| POST | `/veiculos` | grava (US-01) |
| GET | `/veiculos/{veiculo}/edit` | formulário de edição |
| PUT | `/veiculos/{veiculo}` | altera (US-03) |
| DELETE | `/veiculos/{veiculo}` | exclui (US-04) |
| GET | `/versao` | versão publicada (RNF-03) |
| GET | `/up` | health check nativo do Laravel |

## Rastreabilidade: critério → teste (`tests/Feature/VeiculoTest.php`)

| Critério | Teste |
|----------|-------|
| CA-01 | `test_ca01_cadastra_veiculo_com_dados_validos` |
| CA-02 | `test_ca02_rejeita_placa_em_formato_invalido` |
| CA-03 | `test_ca03_rejeita_placa_duplicada` |
| CA-04 | `test_ca04_rejeita_capacidade_fora_da_faixa` |
| CA-05 | `test_ca05_rejeita_situacao_invalida` |
| CA-06 | `test_ca06_lista_veiculos_com_placa_formatada_e_situacao` |
| CA-07 | `test_ca07_lista_vazia_orienta_o_cadastro` |
| CA-08 | `test_ca08_altera_situacao_mantendo_a_placa` |
| CA-09 | `test_ca09_exclui_veiculo` |
| CA-10 | `test_ca10_health_check_e_versao` |
| CA-11 | `test_ca11_formularios_carregam` |

## Pipeline (`.github/workflows/ci-cd.yml`)

1. **Testes + segurança:** PHPUnit com cobertura, `composer audit`, SonarQube com espera do quality gate.
2. **Build:** imagem Docker marcada com `v1.0.<número da execução>` e enviada ao ghcr.io.
3. **Deploy:** SSH na EC2, troca do contêiner, health check, verificação pela internet e criação da release no GitHub.
