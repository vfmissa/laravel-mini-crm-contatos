#!/bin/bash

echo "==================================================="
echo "Iniciando o Ambiente CRM (API, Fila, WebSockets)..."
echo "==================================================="

# 1. Sobe todos os contêineres em segundo plano e reconstrói se necessário
docker compose up -d --build

# 2. Aguarda 5 segundos para garantir que o MySQL aceitou conexões em segundo plano
sleep 5

# 3. Executa as migrations de forma automatizada e limpa os caches do Laravel
echo "Rodando migrations e limpando cache..."
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize:clear

echo "==================================================="
echo "Tudo pronto!"
echo "API rodando em: http://localhost:8000"
echo "WebSocket rodando na porta 8080"
echo "==================================================="