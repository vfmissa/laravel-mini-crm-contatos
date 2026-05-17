
## Tecnologias Utilizadas
* **PHP 8 / Laravel**
* **MySQL 8** (Persistência)
* **Redis** (Filas e Cache)
* **Laravel Reverb** (WebSockets)
* **Docker Compose** (Infraestrutura isolada)

---
## ⚙️ Como Subir o Ambiente (Setup Automático)

Para facilitar a avaliação, todo o ambiente foi containerizado e scripts de automação foram criados. Você não precisa configurar o banco de dados manualmente ou rodar os *workers* em abas separadas.

### Pré-requisitos
* Docker e Docker Compose instalados na máquina.
* Git para clonar o repositório.

### Passo a Passo

1. **Clone o repositório e acesse a pasta:**
   ```bash
   git clone
   cd laravel-mini-crm-contatos

2.**Configure o arquivo de ambiente:**
Copie o arquivo de exemplo para criar o seu .env local. (com as chaves para test já no arquivo)
Bash
**cp .env.example .env**

  
3. **Inicie os Containers e a Aplicação:**
   Utilize o script de inicialização correspondente ao seu sistema operacional. Ele subirá os containers, aguardará o banco de dados, rodará as *migrations* e limpará os caches automaticamente.

   **No Linux / macOS:**
   ```bash
   chmod +x start.sh
   ./start.sh

   **No Windowns**
   Execute o start.bat ou rode no terminal:

**Após a execução, os seguintes serviços estarão disponíveis:**

   API REST: http://localhost:8000

   WebSocket (Reverb): Porta 8080

 ### http://127.0.0.1:8000/example.html

   Interface de Teste Acesse http://127.0.0.1:8000/example.html diretamente no seu navegador para ver uma execução em tela com alguns logs

**Como Executar os Testes**
Para rodar os testes basta executar um docker compose exec -T app php artisan test se quiser ver os testes unitarios

No Linux / macOS:
Bash
chmod +x test.sh
./test.sh

No Windows:
DOS
### docker compose exec -T app php artisan test

