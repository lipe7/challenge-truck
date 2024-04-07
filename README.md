<p align="center">
<a href="https://coodesh.com/" target="_blank">
<img src="https://hipsters.jobs/files/pictures/Coodesh-Logo-Vertical.png" width="160"></a>
<a href="https://www.truckpag.com.br/" target="_blank">
<img src="https://lp.truckpag.com.br/wp-content/uploads/2021/12/icone-linktree.png" width="160"></a>
</p>

# Challenge Coodesh - TruckPag

Nesse desafio trabalharemos no desenvolvimento de uma REST API para utilizar os dados do projeto Open Food Facts, que é um banco de dados aberto com informação nutricional de diversos produtos alimentícios.

**PHP:** v8.1

**Laravel:** v10.10

**Laravel-Mongodb:** v4.2

**Implementações:** Solid, DDD, TDD

## Installation

Instale a aplicação com os comandos abaixo:

```bash
  make up
```

## Running Tests

Para executar testes, execute o seguinte comando:

```bash
  make test
```

## Cron System

O serviço de importação roda todos os dias à meia-noite,
caso queira testar manualmente execute o seguinte comando:
(povoa a collection `products`)

```bash
  make cron
```

## Commands

Comandos úteis:

```bash
  make up         -> instala o projeto
  make down       -> derruba os containers
  make bash       -> acessa o terminal da aplicação
  make op         -> armazene em cache os arquivos de inicialização
  make fdb        -> recria o banco de dados e popula com dados iniciais
  make test       -> executa os testes e limpa a configuração
  make cron       -> executa o serviço de importação
```

## API Reference

### Documentation

Link do postman: https://bityl.co/PCyq

Realize o fork da collection.

#### Headers

```:
  Accept: application/json
  Content-Type: application/json
  X-API-KEY: 51be5348b9602834fbb67fb562bbd30c42b4c013
```

#### Detalhes da API

```http
  GET /api
```

#### Responsável por receber atualizações

```http
  PUT /api/products
```

| Parameter  | Type      | Description          |
| :--------- | :-------- | :------------------- |
| `name`     | `string`  | **Required**         |
| `email`    | `string`  | **Required**         |
| `cpf`      | `string ` | **Required**         |
| `password` | `string ` | **Required** (min 6) |

#### Atualizar usuário

```http
  PUT /api/products/:code
```

| Parameter          | Type      | Description |
| :----------------- | :-------- | :---------- |
| `creator`          | `string`  | Optional    |
| `product_name`     | `string`  | Optional    |
| `quantity`         | `string`  | Optional    |
| `brands`           | `string`  | Optional    |
| `categories`       | `string`  | Optional    |
| `labels`           | `string`  | Optional    |
| `cities`           | `string`  | Optional    |
| `purchase_places`  | `string`  | Optional    |
| `stores`           | `string`  | Optional    |
| `ingredients_text` | `string`  | Optional    |
| `traces`           | `string`  | Optional    |
| `serving_size`     | `string`  | Optional    |
| `serving_quantity` | `numeric` | Optional    |
| `nutriscore_score` | `numeric` | Optional    |
| `nutriscore_grade` | `string`  | Optional    |
| `main_category`    | `string`  | Optional    |

#### Mudar o status do produto para trash

```http
  DELETE /api/products/:code
```

#### Obter a informação somente de um produto da base de dados

```http
  GET /api/products/:code
```

#### Listar todos os produtos da base de dados

```http
  GET /api/products
```

| Parameter       | Type      | Description                         |
| :-------------- | :-------- | :---------------------------------- |
| `per_page`      | `string`  | **Optional** (default 10)           |
| `order_by`      | `integer` | **Optional** (default product_name) |
| `order_by_type` | `array`   | **Optional** (default asc)          |
| `page`          | `integer` | **Optional** (default 1)            |
