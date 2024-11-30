
# API Gestão de Vendas

Este projeto tem como objetivo fornecer uma API RESTful para o gerenciamento de pedidos.

## Tecnologias Utilizadas

- **[Docker](https://www.docker.com/)**: Plataforma para desenvolvimento e execução de containers.
- **[Laravel 11](https://laravel.com/docs/11.x)**: Framework PHP moderno com suporte para PHP 8.2.
- **[Swagger](https://github.com/darkaonline/l5-swagger)**: Biblioteca para geração de documentação da API, adaptada para Laravel.
- **[MySQL](https://dev.mysql.com/)**: Sistema de gerenciamento de banco de dados relacional.

## Autenticação

## Rotas

## Configuração do Ambiente para o Projeto API Gestão de Colaboradores

### Pré-requisitos

A única dependência necessária para rodar o ambiente do projeto é ter o **Docker** instalado em sua máquina e conhecer os comandos básicos do docker-compose para executar um container. Para instalar o Docker, siga as instruções no site oficial: [Instalação do Docker](https://docs.docker.com/get-docker/).

### Passos para Configurar o Ambiente

1. **Clone o repositório**:
   Clone o repositório do projeto usando o comando abaixo e, em seguida, navegue até o repositório do projeto na sua máquina:
   ```bash
   git clone <url-do-repositorio>
   ```

2. **Configure os arquivos**:
   Crie o arquivo .env com base no .env.example:
   ```bash
   cp .env.example .env
   ```
   Configure o APP_URL e as credenciais de conexão com o banco de dados (devem ser as mesmas do docker-compose.override.yml) e envio de e-mails (Mailtrap) no arquivo .env.

3. **Construir os containers com Docker Compose**:
   A seguir, execute o comando para construir os containers do ambiente:
   ```bash
   docker compose build
   ```
   Ou, se quiser construir e iniciar os containers ao mesmo tempo:
   ```bash
   docker compose up -d
   ```
   O comando irá baixar as imagens necessárias, construir os containers e iniciar a aplicação.

    Após criar os containers, acesse o container da aplicação por meio do comando `docker compose exec application bash` e execute os comandos `php artisan passport:keys --force` e `php artisan passport:client --password`, após a criação do Client, configure o .env para informar as chaves

    ```bash
    PASSPORT_PASSWORD_CLIENT_ID=
    PASSPORT_PASSWORD_SECRET=
    PASSPORT_TOKEN_ENDPOINT=
    ```

4. **Verificar se os containers estão rodando**:
   Para garantir que tudo foi iniciado corretamente, use o comando:
   ```bash
   docker compose ps
   ```
   Aqui você verá uma lista de todos os containers em execução. Certifique-se de que tanto o container da aplicação, banco de dados e fila estejam ativos.

## Tecnologias e Motivações

# Docker

Este ambiente Docker é composto por três containers principais para rodar a aplicação Laravel, juntamente com seu banco de dados e um serviço de filas.

## Serviços

### Aplicação

O container `application` hospeda a aplicação Laravel e é configurado para reiniciar automaticamente. Suas configurações são as seguintes:

- **Volumes**:
  - `composer_cache`: Cache do Composer para acelerar o processo de instalação de dependências.
  - `storage`: Armazenamento persistente da aplicação.
  - `init.sh`: Script de inicialização montado em `/docker-entrypoint-init.d/init.sh`.
  - `php.ini`: Configuração PHP montada como somente leitura em `/usr/local/etc/php/php.ini`.

- **Rede**: Conectado à rede `db-network`, permitindo comunicação com o container do banco de dados.
- **Dependências**: Depende do container `db`, garantindo que o banco de dados esteja disponível antes de iniciar a aplicação.

### Banco de Dados

O container `db` executa o MySQL e garante a persistência de dados entre reinicializações. Suas configurações são as seguintes:

- **Volumes**:
  - `db_data`: Persistência de dados do MySQL em `/var/lib/mysql/`.

- **Rede**: Conectado à rede `db-network`, facilitando a comunicação com o container `application`.

### Fila

O container `queue` é uma extensão do container de aplicação `application`, configurado para operar exclusivamente no processamento de filas. Esse container não reinicia automaticamente e possui as seguintes configurações:

- **Variáveis de Ambiente**:
  - `APP_ENV`: Configurado como `local` para fins de desenvolvimento.
  - `CONTAINER_ROLE`: Definido como `queue` para especificar o papel do container.
  - `DB_USERNAME` e `DB_PASSWORD`: Credenciais para o banco de dados, que devem ser definidas no arquivo `docker-compose.override.yml`.

- **Dependências**: Depende do container `application`.

## Volumes

Os volumes são configurados para persistir dados e otimizar o desempenho:

- `composer_cache`: Cache do Composer para otimizar o tempo de instalação de dependências.
- `storage`: Armazenamento persistente da aplicação Laravel.
- `db_data`: Armazenamento de dados do MySQL para persistência.

## Redes

- **db-network**: Rede privada que conecta os containers `application`, `db` e `queue` para comunicação interna segura.

## Laravel

O Laravel utiliza diversos recursos e padrões de projeto:

| Ferramenta           | Descrição                                                                      | Uso                                                                                                                                                                                                       |
|----------------------|--------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **FormRequest**      | Classe auxiliar para validação de requisições no Laravel                       | Validou campos de entrada com base em regras predefinidas, retornando erros como 422 e 400 conforme os requisitos do sistema.                                                                            |
| **Middleware**       | Classe para interceptação de requisições                                        | Garantiu que todas as requisições sejam do tipo application/json.                                                                                                                                     |
| **Resources**        | Classe para formatação e retorno de dados                                       | Garantiu que respostas da API fossem formatadas conforme especificações, como inclusão de IDs em headers em vez do corpo da resposta.                                                                    |
| **PHPUnit**          | Framework integrado ao Laravel para testes automatizados                       | Facilitou a criação de testes automatizados para assegurar o funcionamento adequado das funcionalidades.                                                                                                 |
| **Services**         | Classes para lógica de negócios e manipulação de dados                          | Inclui OrderService para gestão de pedidos e ErrorHandler para padronização de erros.                                                                                                                |

## MySQL

## Logs
