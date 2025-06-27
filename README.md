### Teste Técnico Alloy - To-Do List
#### Descrição do Projeto
Este é um teste técnico para desenvolvedores da Alloy, consistindo na implementação de uma aplicação de lista de tarefas (To-Do List) utilizando Laravel 12 como backend e Vue.js 3 como frontend.
Foi implementada uma aplicação completa de gerenciamento de tarefas que demonstra conhecimentos em:

```
• Desenvolvimento de APIs RESTful com Laravel;
• Frontend moderno com Vue.js e Pinia;
• Gerenciamento de banco de dados SQLite;
• Sistema de filas e jobs em Laravel;
• Implementação de cache e invalidação;
• Soft deletes;
• Integração frontend/backend;
```
#### Configure o projeto
```
• Clone o projeto
• composer install
• npm install
• Configure o .env
• php artisan key:generate
• php artisan migrate
```
#### Rode o projeto
```
• Terminal 1: php artisan serve
• Terminal 2: php artisan queue:work
• Terminal 3: npm run dev

Ou tudo em conjunto

• npm run dev & php artisan serve & php artisan queue:work

A aplicação estará disponível em http://localhost:8000
```
