# Spec 001 — Cadastro de veículos da coleta

- **Status:** aprovada
- **Versão da spec:** 1.0

## Contexto

O gestor da coleta de resíduos precisa saber quais veículos compõem a frota e em que situação cada um está antes de programar rotas e viagens. Hoje esse controle é feito em planilha, sem validação de placa e com registros duplicados.

## Objetivo

Permitir que o gestor cadastre, consulte, altere e exclua os veículos da frota por uma interface web publicada na internet.

## Histórias de usuário

- **US-01** — Como gestor, quero cadastrar um veículo informando placa, modelo, capacidade e situação, para manter a frota atualizada.
- **US-02** — Como gestor, quero ver a lista de veículos com a placa formatada e a situação de cada um, para saber o que está disponível.
- **US-03** — Como gestor, quero alterar os dados de um veículo, para registrar, por exemplo, que ele entrou em manutenção.
- **US-04** — Como gestor, quero excluir um veículo que saiu da frota.

## Regras de negócio

| ID    | Regra |
|-------|-------|
| RN-01 | A placa segue o padrão antigo (ABC1234) ou Mercosul (ABC1D23). Hífen, espaços e letras minúsculas digitados são aceitos e normalizados antes de gravar. |
| RN-02 | Não pode haver dois veículos com a mesma placa. |
| RN-03 | A capacidade de carga é informada em kg, entre 500 e 30.000. |
| RN-04 | A situação é uma destas: Em operação, Em manutenção, Inativo. |
| RN-05 | O modelo é obrigatório e tem no máximo 80 caracteres. |

## Critérios de aceitação

| ID    | Dado | Quando | Então |
|-------|------|--------|-------|
| CA-01 | dados válidos com a placa `abc-1d23` | o gestor salva o cadastro | o veículo é gravado com a placa `ABC1D23` e uma mensagem de sucesso aparece |
| CA-02 | a placa `12ABC34` | o gestor salva | o campo placa mostra erro e nada é gravado |
| CA-03 | já existe a placa `ABC1234` | o gestor cadastra `ABC-1234` | o campo placa mostra erro de duplicidade |
| CA-04 | capacidade 499 ou 30.001 | o gestor salva | o campo capacidade mostra erro |
| CA-05 | uma situação fora da lista | o gestor salva | o campo situação mostra erro |
| CA-06 | veículos `ABC1234` (manutenção) e `BRA2E19` (operação) | o gestor abre a lista | vê `ABC-1234`, `BRA2E19`, "Em manutenção" e "Em operação" |
| CA-07 | nenhum veículo cadastrado | o gestor abre a lista | vê "Nenhum veículo cadastrado" e um botão para cadastrar |
| CA-08 | um veículo existente | o gestor muda só a situação, mantendo a placa | a alteração é salva sem erro de duplicidade |
| CA-09 | um veículo existente | o gestor confirma a exclusão | o veículo deixa de existir |
| CA-10 | a aplicação publicada | alguém acessa `/up` e `/versao` | recebe 200 e um JSON com o nome e a versão |
| CA-11 | um veículo existente | o gestor abre os formulários de cadastro e edição | as telas carregam com os dados corretos |

## Requisitos não funcionais

- **RNF-01** — A aplicação é publicada na internet pela pipeline, sem passos manuais depois do push na `main`.
- **RNF-02** — O deploy só acontece se os testes passarem, se `composer audit` não encontrar vulnerabilidades e se o quality gate do SonarQube for aprovado.
- **RNF-03** — A versão publicada aparece no rodapé e em `/versao`.
- **RNF-04** — Nenhum segredo fica no repositório.
- **RNF-05** — O contêiner roda sem privilégios de root.
- **RNF-06** — Os dados persistem entre deploys.

## Fora de escopo

Login de usuários, rotas, viagens e equipes. Ficam para specs futuras.
