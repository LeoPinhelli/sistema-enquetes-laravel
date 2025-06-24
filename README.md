
# SISTEMA DE VOTAÇÃO

## Descrição

Sistema completo para gerenciamento de enquetes com CRUD de criação, edição e exclusão de enquetes e opções.

- A enquete deve ter um título e uma data programada para início e término.
- O cadastro das opções de respostas da enquete é dinâmico, sendo obrigatório no mínimo 3 opções.
- Visualização das enquetes com título e datas de início e término, mostrando status: não iniciadas, em andamento ou finalizadas.
- Tela para apresentação da enquete com opções de resposta e datas, com exibição do número total de votos ao lado de cada opção.
- Se a enquete não estiver ativa, as opções e o botão de votar ficam desabilitados.
- Os resultados são atualizados em tempo real a cada novo voto.

## Diferenciais

- Formulário responsivo.
- Layout com Flexbox para melhor responsividade.

## Instalação

1. Clone o repositório:
```
git clone https://github.com/LeoPinhelli/sistema-enquetes-laravel.git
```
2. Entre na pasta do projeto:
```
cd seu-repositorio
```
3. Instale as dependências via Composer:
```
composer install
```
4. Copie o arquivo `.env.example` para `.env` e configure seu banco de dados:
```
cp .env.example .env
```
5. Gere a chave da aplicação:
```
php artisan key:generate
```
6. Execute as migrations para criar as tabelas no banco:
```
php artisan migrate
```
7. Inicie o servidor de desenvolvimento:
```
php artisan serve
```
8. Acesse o sistema em `http://localhost:8000/polls`

## API Endpoints para testes (exemplo com Postman)

- GET `/api/polls` - Lista todas as enquetes
- POST `/api/polls` - Cria uma nova enquete (JSON com title, start_at, end_at e options)
- GET `/api/polls/{id}` - Mostra enquete específica
- PUT `/api/polls/{id}` - Atualiza enquete e opções
- DELETE `/api/polls/{id}` - Exclui enquete e opções
- POST `/api/polls/{id}/vote` - Vota em uma opção da enquete

## Tecnologias

- Laravel 11
- PHP 8+
- MySQL
- Blade (views)
- Flexbox (CSS)

## Observações

- As opções da enquete devem ser enviadas em um array com no mínimo 3 strings.
- O sistema respeita o timezone configurado para validação das datas.
- O sistema está preparado para uso via API e frontend com views Blade.

---
**Desenvolvido por Leonardo Sotti Pinhelli**

## Contato

Leonardo Sotti Pinhelli
  
GitHub: [@LeoPinhelli](https://github.com/LeoPinhelli)

Email: leopinhelli@gmail.com

Telefone: 41 99638-9232

Linkedin: [Leonardo Sotti Pinhelli](https://www.linkedin.com/in/leonardo-sotti-pinhelli/)

