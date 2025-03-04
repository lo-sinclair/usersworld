# Users World

REST API для работы с пользователями

Этот API позволяет управлять пользователями, включая создание, обновление, удаление и изменение ролей. Также включает авторизацию через JWT.
Ниже приводится описание реализованный методов:


## **0. Авторизация (Login)**

### **0.1. Получение токена**
**Endpoint: POST** `/api/login_check`

Этот эндпойнт используется для получения JWT токена. В теле запроса передаются учетные данные пользователя (имя пользователя и пароль). Если данные корректны, сервер возвращает токен для дальнейшей авторизации.

### **Тело запроса (JSON)**:
```json
{
  "username": "user@example.com",
  "password": "securepassword"
}
```
### **Ответ (200 OK)**:
Если пользователь зарегистрирован:
```json
{
  "token": "your_jwt_token_here"
}
```

### **0.2. Авторизация с токеном**
**Endpoint: POST** `/api/login`

Этот эндпойнт используется для авторизации пользователя. Он проверяет наличие JWT токена в запросе, и если токен действителен, возвращает приветственное сообщение. Если пользователь не авторизован, возвращается ошибка 401.

### **Запрос (JSON)**:
Для выполнения запроса не нужно передавать тело. Авторизация происходит через JWT, который должен быть передан в заголовке запроса:

**Заголовок запроса**:
```angular2html
Authorization: Bearer <your_jwt_token>
```
### **Ответ (200 OK)**:
Если пользователь авторизован и токен действителен:
```json
{
  "message": "Welcome to your new controller!",
  "path": "src/Controller/Api/LoginController.php"
}
```

## **1. Создание пользователя**
**Endpoint: POST** `/api/user/add`

**Тело запроса (JSON)**:
```json
{
    "email": "user@example.com",
    "plainPassword": "securepassword",
    "isVerified": true,
    "roles": ["ROLE_USER"]
}
```

**Ответ (201 Created)**:
```json
{
"id": 1,
"email": "user@example.com",
"isVerified": true,
"roles": ["ROLE_USER"]
}
```
## **2. Обновление данных пользователя**
**Endpoint: PUT** `/api/user/{id}`

### **Обновление данных пользователя**
**Тело запроса (JSON)**:
```json
{
  "email": "newemail@example.com",
  "plainPassword": "newpassword",
  "isVerified": false
}
```

### **Добавление новых ролей**
```json
{
  "roles": ["ROLE_ADMIN"]
}
```
➡ Добавит ROLE_ADMIN, если её нет.

### **Удаление конкретных ролей**
```json
{
  "removeRoles": ["ROLE_USER"]
}
```
➡ Удалит ROLE_USER, оставив остальные роли нетронутыми

**Ответ (200 Ok)**:
```json
{
"id": 1,
"email": "newemail@example.com",
"isVerified": false,
"roles": ["ROLE_ADMIN"]
}
```

## **3. Удаление пользователя**
**Endpoint: DELETE** `/api/user/{id}`

Удаляет пользователя по указанному ID.

**Ответ (204 No Content)**:
```json
// Пустой ответ, статус 204 No Content
```



















