# Tarefas — Spec 001

## Fase 1: base
- [x] T01 Criar projeto Laravel e repositório no GitHub
- [x] T02 Registrar constituição, spec e plano em `specs/`

## Fase 2: testes primeiro (a partir dos critérios de aceitação)
- [x] T03 Escrever `VeiculoTest` com um teste por critério (CA-01 a CA-11)
- [x] T04 Criar `VeiculoFactory`

## Fase 3: implementação
- [x] T05 Migration da tabela `veiculos`
- [x] T06 Model `Veiculo` com situações e placa formatada (RN-01, RN-04)
- [x] T07 `VeiculoRequest` com validações e normalização da placa (RN-01 a RN-05)
- [x] T08 `VeiculoController` e rotas
- [x] T09 Views Blade (layout, lista, cadastro, edição)
- [x] T10 Rota `/versao` e `config/sistema.php` (RNF-03)
- [x] T11 Rodar a suíte localmente até ficar verde

## Fase 4: entrega
- [x] T12 Dockerfile sem root e com volume para o SQLite (RNF-05, RNF-06)
- [x] T13 Criar EC2 com Docker
- [x] T14 Configurar SonarQube Cloud e secrets do GitHub
- [x] T15 Pipeline com testes, segurança, build e deploy (RNF-01, RNF-02)
- [x] T16 Validar a aplicação publicada pela internet
