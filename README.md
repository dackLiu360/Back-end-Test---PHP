## Sobre o projeto

Avaliação para vaga de desenvolvedor back-end para a empresa Mentes Notáveis (versão PHP)
## Requisitos

- PHP 8.0.10
- Composer 2.1.6
- Mysql 8.0.26

## Tutorial 

1. Fazer a configuração do mysql (com a versão utilizada) e rodar as seguintes queries. 

```sql
CREATE DATABASE db_test_mentes_pensantes;
CREATE USER 'user_test'@'localhost' IDENTIFIED BY '89152195';
GRANT ALL PRIVILEGES ON * . * TO 'user_test'@'localhost';
FLUSH PRIVILEGES;
```

2. Clonar o projeto 

3. Entrar na pasta do projeto e rodar ```composer install``` para instalar as dependencias do composer.json

4. Criar o arquivo ```.env``` na raiz do projeto e copiar o conteúdo do ```.env.example``` nele 

5. Rodar ```php -f database/seeders/DatabaseSeeder.php``` 

6. Executar o projeto com o comando ```php -S 127.0.0.1:8000 -t public```

## APIs


| URL                                                       | Descrição     |
| --------------------------------------------------------- |:-------------:|
| http://127.0.0.1:8000/api/createUser                      | Cria um usuário com as informações de username, address, city e state. Todas as informações são obrigatorias. |
| http://127.0.0.1:8000/api/findUserById/1                  | Encontra um usuário registrado pelo id passado.      |
| http://127.0.0.1:8000/api/findAllUsers                    | Encontra todos os usuários e suas informações vinculadas pelo id.     |
| http://127.0.0.1:8000/api/updateUser/1?_method=PATCH      | Atualiza um usuário e suas informações vinculadas por um id passado. Os campos que vão ser atualizados são opicionais. |
| http://127.0.0.1:8000/api/findAllAdresses                 | Encontra todos os endereços registrados sem repetições.      |
| http://127.0.0.1:8000/api/findAdressById/1                | Encontra um endereço registrada pelo id passado.      |
| http://127.0.0.1:8000/api/findAllCities                   | Encontra todos as cidades registradas sem repetições.   |
| http://127.0.0.1:8000/api/findCityById/1                  | Encontra uma cidade registrada pelo id passado.      |
| http://127.0.0.1:8000/api/findAllStates                   | Encontra todos os estados registrados sem repetições.        |
| http://127.0.0.1:8000/api/findStateById/1                 | Encontra um estado registrado pelo id passado. |
| http://127.0.0.1:8000/api/findUsersTotalByCity/São%Paulo  | Encontra a quantidade de usuários registrados no sistema por uma cidade passada.      |
| http://127.0.0.1:8000/api/findUsersTotalByState/SP        | Encontra a quantidade de usuários registrados no sistema por um estado passada.     |
| http://127.0.0.1:8000/api/deleteUser/1                    | Deleta um usuário e todas as suas informações vinculadas por um id passado. |


- **Documentação**

https://documenter.getpostman.com/view/17287045/TzzHnZHj


- **Rodar as APIs no POSTMAN**

[![Run in Postman](https://run.pstmn.io/button.svg)](https://god.gw.postman.com/run-collection/17287045-5b784848-81cd-406e-afef-8cfcee0b55d5?action=collection%2Ffork&collection-url=entityId%3D17287045-5b784848-81cd-406e-afef-8cfcee0b55d5%26entityType%3Dcollection%26workspaceId%3De6244f3c-404e-4cef-b374-f332dcbbfa9a)