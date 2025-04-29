# Sistema de Gestão de Eventos
Projeto desenvolvido com laravel usando API e Sanctum. Ele conta com as seguintes funcionalidades: 

## Funcionalidades
- **Autenticação(Sanctum)**
    - Registro de usuários.
    - Login e Logout.
    - Proteção de rotas com middleware auth:sanctum.


- **Gerenciamento de usuário**
    - criação, edição e exclusão de usuário.
    - Login e Logout.

- **Gestão de Eventos**
    - Criar evento (usuário logado).
    - Editar e deletar evento (somente o criador).
    - Listar eventos públicos.
    - Ver detalhes de um evento.
    - Eventos possuem:
        - Data futura obrigatória.
        - Campo de público (público ou privado).
        - Relacionamento com o usuário (belongsTo).
        - Relacionamento com as Inscrições (hasMany)



- **Gestão de Inscrições**
     - Inscrever-se em evento (usuário logado)
     - Cancelar inscrição (somente o dono da inscrição)
     - Listar eventos em que o usuário está inscrito
     - Listar participantes de um evento (somente o criador do evento)
     - Relacionamento com o usuario (belonsTo)
     - Relacionamento com o evento (belonsTo)
 
- **Regras de Negócio**
      - Não pode se inscrever em eventos passados
      - Não pode exceder o limite de participantes
      - Não pode se inscrever duas vezes no mesmo evento


## Tecnologias

- PHP 8+
- Laravel 10+
- Laravel Sanctum
- SQLite
- Insomnia (para testes de API)

  
##  Instalação e Execução

1.  Clone este repositório.
2. Instale as dependências com `composer install`.
3. Configure o arquivo `.env` para seu banco de dados.
4. Instale a API com `php artisan install:api` , sacntum já é instalado junto
5. Execute as migrações com `php artisan migrate`.
6. Inicie o servidor local com `php artisan serve`.
      
