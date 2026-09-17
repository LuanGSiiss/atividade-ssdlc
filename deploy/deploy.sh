#!/usr/bin/env bash
# Executado NA EC2, enviado pela pipeline via SSH.
# A pipeline injeta antes deste conteúdo: IMAGEM, VERSAO, APP_KEY, APP_URL, GHCR_USER, GHCR_TOKEN.
set -euo pipefail

: "${IMAGEM:?IMAGEM não informada}"
: "${APP_KEY:?APP_KEY não informada}"

CONTAINER=coleta-veiculos
VOLUME=coleta-dados

echo ">> Baixando $IMAGEM"
echo "$GHCR_TOKEN" | docker login ghcr.io -u "$GHCR_USER" --password-stdin >/dev/null
docker pull "$IMAGEM"
docker logout ghcr.io >/dev/null

docker volume create "$VOLUME" >/dev/null

echo ">> Substituindo o contêiner"
docker rm -f "$CONTAINER" >/dev/null 2>&1 || true
docker run -d --name "$CONTAINER" --restart unless-stopped \
  -p 80:8080 \
  -v "$VOLUME":/data \
  -e APP_NAME="Frota da Coleta" \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  -e APP_KEY="$APP_KEY" \
  -e APP_URL="$APP_URL" \
  -e APP_VERSION="$VERSAO" \
  -e DB_CONNECTION=sqlite \
  -e DB_DATABASE=/data/database.sqlite \
  -e SESSION_DRIVER=file \
  -e CACHE_STORE=file \
  -e LOG_CHANNEL=stderr \
  "$IMAGEM" >/dev/null

echo ">> Aguardando a aplicação responder"
for _ in $(seq 1 20); do
  if curl -fsS http://localhost/up >/dev/null 2>&1; then
    echo ">> Versão $VERSAO no ar"
    docker image prune -f >/dev/null
    exit 0
  fi
  sleep 3
done

echo "!! A aplicação não respondeu. Últimos logs:"
docker logs --tail 50 "$CONTAINER"
exit 1
