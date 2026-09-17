# Constituição do projeto

Princípios que valem para toda especificação e todo código deste repositório.

1. **Especificação antes do código.** Nenhuma funcionalidade é implementada sem uma spec aprovada em `specs/NNN-nome/spec.md`.
2. **Todo critério de aceitação vira teste.** Cada `CA-xx` da spec tem pelo menos um teste automatizado com o mesmo identificador no nome.
3. **A main está sempre publicável.** Só chega na `main` o que passou na pipeline: testes, auditoria de dependências e quality gate do SonarQube.
4. **Segurança bloqueia o deploy.** Se o quality gate reprovar, a nova versão não é publicada.
5. **Segredos fora do código.** Chaves, tokens e senhas ficam apenas em GitHub Secrets.
6. **Simplicidade.** Usar o que o framework já oferece antes de adicionar dependências.

## Fluxo de trabalho (SDD)

`spec.md` (o quê e por quê) → `plan.md` (como) → `tasks.md` (passos) → implementação → testes que comprovam a spec → pipeline.
