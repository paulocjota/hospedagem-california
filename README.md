<p align="center"><a href="https://laravel.com" target="_blank"><img src="public/logo.png" width="300" style="border-radius: 50%"></a></p>

<p align="center">
 <a href="#sobre">Sobre</a> •
 <a href="#configurando">Configurando</a> •
 <a href="#tecnologias">Tecnologias</a> •
 <a href="#autor">Autor</a> •
 <a href="#licenca">Licença</a>
</p>

## Sobre

O projeto California é um sistema de hospedagem feito através do levantamento de requisitos do mundo real. Conta com controle de entrada e ocupação dos quartos bem como controle de estoque, geração de lista de preço, entre outras funcionalidades.

## Configurando

### Requerimentos mínimos

* Docker 20.10.13
* Docker Compose 1.29.2

**Obs.:** Todos os requerimentos abaixo já estão presentes dispensando instalação e configuração caso rode o projeto através do Docker.

* PHP 8.1.3
* MySQL 8.0.28
* Composer 2.2.7
* Node 16.14.0
* NPM 8.5.2

### Preparar o ambiente
Primeiramente clone o repositório:
```bash
git clone git@github.com:paulocjota/hospedagem-california.git
```

Após clonar, acesse o diretório antes de rodar os demais comandos:
```bash
cd hospedagem-california/
```

Faça uma cópia do arquivo `.env.example` para adicionar as informações do seu ambiente:
```bash
cp .env.example .env
```

Vamos instalar as dependências do composer:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Agora é hora de subir os contêineres. A primeira execução é a mais demorada, as próximas demorarão apenas alguns segundos:
```bash
./vendor/bin/sail up -d
```

Vamos gerar a chave da aplicação:
```bash
./vendor/bin/sail artisan key:generate
```

E criar as tabelas e os registros na base de dados:
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

Tudo pronto! Agora é só acessar no seu navegador através da URL `http://localhost:${APP_PORT}`, onde `${APP_PORT}` representa o valor configurado no seu arquivo `.env` ou `80` caso o valor não esteja configurado. Caso for `80` não há necessidade de digitar na URL pois se trata da porta padrão HTTP.

 ### Solução de problemas

 Em caso de `Illuminate\Database\QueryException` ao efetuar a migração

  `SQLSTATE[HY000] [2002] Connection refused (SQL: SHOW FULL TABLES WHERE table_type = 'BASE TABLE')`

Pare os contâineres que estão rodando e remova os volumes através do comando:
```bash
sail down -v
```

Edite o arquivo `.env` alterando `DB_HOST=127.0.0.1` para `DB_HOST=mysql`

Suba novamente os containeres e tente executar o passo de migração novamente
```bash
sail up -d
```

## Tecnologias

### Frontend

- **[AlpineJS](https://alpinejs.dev/)**
- **[Bootstrap CSS](https://getbootstrap.com/)**
- **[jQuery](https://jquery.com/)**
- **[moment](https://github.com/moment/moment/)**
- **[Select2](https://github.com/select2/select2)**

### Backend

- **[Laravel PHP Framework](https://laravel.com)**

#### Depêndencias

- **[Laravel Sail](https://laravel.com/docs/9.x/sail)**
- **[Laravel AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE)**
- **[Laravel Permission](https://github.com/spatie/laravel-permission)**
- **[Laravel Breadcrumbs](https://github.com/diglactic/laravel-breadcrumbs)**
- **[Laravel Lang](https://github.com/Laravel-Lang/lang/blob/main/locales/pt_BR/pt_BR.json)**

## Autor
[paulocjota](https://github.com/paulocjota)

## Licença

O projeto Hospedagem California é um software de código aberto licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT).
