# CRUD simples para gerenciamento de clientes
O projeto não foi pensado para ser usado em produção, seu objetivo é didático.

## Como rodar?

### Usando Docker (Recomendado)
**Requisitos:**

- Docker
- Docker Compose

Use o comando `docker-compose up` para subir a aplicação.

o `frontend` estará disponível em http://127.0.0.1:3000/ e o `backend` em http://127.0.0.1:8000/

\* O npm pode demorar um pouco para instalar as dependencias, isso pode atrasar a disponibilidade do `frontend` em alguns segundos.

*O MySQL é resetado a cada restart.*

### Usando a paciência
**Requisitos:**
- MySQL
- Nginx
- PHP 8.1
- NPM

Primeiro é preciso configurar o `backend`.

- Crie uma `database` no MySQL.

- [Configure o `nginx`](https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04) com o diretório `root` apontado para `app/backend/public` (Você pode se basear no arquivo `config/nginx.conf`).

- Entre na pasta `backend (app/backend)`.

- Configure as credenciais do MySQL no arquivo `.env` na pasta raiz do `backend`

Agora vamos criar as tabelas no MySQL rodando o comando `php composer.phar setup-database` também na pasta raiz do `backend`.

Você pode acessar o nginx com a porta e server_name que você configurou.

Se tudo estiver certo você terá o seguinte retorno:

```
{
    "version": "0.1"
}
```

Com o `backend` funcionando corretamente, precisamos subir o `frontend`.

- Entre na pasta `app/frontend`.

- Configure a url do `backend` no arquivo `.env` (Veja o `.env.example`).

- Rode o comando `npm run start`.

Se tudo estiver correto o `frontend` estará disponível em http://localhost:3000/ .