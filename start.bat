@echo off
echo ===================================================
echo Iniciando o Ambiente CRM (API, Fila, WebSockets)...
echo ===================================================

:: 1. Sobe todos os conteineres em segundo plano (-d)
docker compose up -d --build

:: 2. Aguarda 5 segundos para garantir que o MySQL aceite conexoes
timeout /t 5 /nobreak > NUL

:: 3. Roda as migrations automaticamente (caso haja alguma nova)
echo Rodando migrations e limpando cache...
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize:clear

echo ===================================================
echo Tudo pronto! 
echo API rodando em: http://localhost:8000
echo WebSocket rodando na porta 8080
echo ===================================================
pause