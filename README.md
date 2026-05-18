
## Tecnologias Utilizadas
* **PHP 8 / Laravel**
* **MySQL 8** (Persistência)
* **Redis** (Filas e Cache)
* **Laravel Reverb** (WebSockets)
* **Docker Compose** (Infraestrutura isolada)

---
## ⚙️ Como Subir o Ambiente (Setup Automático)

### Pré-requisitos
* Docker e Docker Compose instalados na máquina.
* Git para clonar o repositório.

### Passo a Passo

* 1. Baixar o código do repositório na pasta do projeto
git clone url-do-seu-repositorio-aqui

 2. Criar o arquivo de variáveis de ambiente a partir do exemplo
cp .env.example .env

 3. Instalar as dependências do Laravel (Composer) usando um contêiner temporário // Foi necessario no quando testei no windowns
docker run --rm -v $(pwd):/var/www -w /var/www composer install

 4. Construir as imagens (API, DB, Redis, Queue, Reverb)
docker compose up -d --build

 5. Aguardar o banco de dados ligar completamente (Aguarde ~20 segundos)
 Use este comando para olhar o "coração" do banco de dados. 
 Quando você ler "ready for connections", aperte Ctrl+C para sair dos logs e continuar.
docker compose logs db -f

 7. Execute as Migrations
docker compose exec app php artisan migrate

# Verificar a saúde de todos os contêineres e assistir a Fila (Queue) trabalhando
docker compose ps
docker compose logs queue -f

**Após a execução, os seguintes serviços estarão disponíveis:**

   API REST: http://localhost:8000

   WebSocket (Reverb): Porta 8080

 ### http://127.0.0.1:8000/example.html

   Interface de Teste Acesse http://127.0.0.1:8000/example.html diretamente no seu navegador para ver uma execução em tela com alguns logs

**Como Executar os Testes**
Para rodar os testes basta executar se quiser ver os testes unitarios

**docker compose exec app php artisan test**

