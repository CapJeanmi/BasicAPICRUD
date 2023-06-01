## BASIC API CRUD

Servicio API REST para creación, consulta y eliminación de Clientes.

## Pasos a Seguir

Para instalar y correr el proyecto:
- Crear BD y linkear en el archivo ".env"


Comandos a ejecutar:

- composer update
- npm install
- php artisan migrate --seed
- php artisan serve

Programa recomendado para consulta/prueba de la API:
- Postman (Se adjuntó archivo al Evaluador).

## Requisitos Minimos

- Editor de Código
- Base de Datos MySQL
- Postman (RECOMENDADO) ó Programas afines

## Consideraciones a tomar

Accesos por defecto:
- email: test@example.com
- contraseña: password

- Se utilizó Faker para información en Seeders/Factories de prueba.

- Para hacer el sistema más robusto y seguro se utilizaron módulos de Encriptación y Middlewares que ya provee Laravel por defecto.

- TIP: Para ejecutar consultas en Postman, colocar en Headers KEY: ACCEPT - VALUE: application/json.

## Créditos

Jean Ortega (Desarrollador)
