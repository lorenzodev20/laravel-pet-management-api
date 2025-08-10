# API para la gestión de las personas y sus mascotas

### Despliegue del API y Documentación [AQUÍ](https://github.com/lorenzodev20/laravel-pet-management-api)

## Descripción del proyecto:
Esta es una API RESTful robusta, desarrollada con Laravel 8.x+ y PHP, cuyo objetivo es gestionar personas y sus mascotas. La API utiliza JWT (JSON Web Tokens) para la autenticación de usuarios, garantizando la seguridad de las rutas privadas.

El proyecto sigue una arquitectura sugerida que incluye el uso de controladores, servicios, repositorios, recursos y validadores (Form Requests) para mantener una estructura de código limpia y escalable. La base de datos utilizada es MySQL o MariaDB y se integra con Eloquent como ORM.

### Módulos y Funcionalidades Principales
Autenticación:
- Registro e inicio de sesión de usuarios.
- Endpoint para obtener la información del usuario autenticado.
- Middleware para proteger las rutas que requieren autenticación.

#### Gestión de Personas:
Un CRUD completo (Crear, Consultar, Actualizar, Eliminar) para la gestión de personas. Campos de ejemplo: nombre, email, fecha de nacimiento.

#### Gestión de Mascotas:
Un CRUD completo para la gestión de mascotas. Una persona puede tener varias mascotas, reflejando una relación uno a muchos.
Campos de ejemplo: nombre, especie, raza, edad, persona_id.

#### Consulta Avanzada:
Endpoint dedicado para consultar una persona y todas sus mascotas asociadas.

#### Integración con API Externa:
Al crear una nueva mascota, la API se integra con una API externa (como TheDogAPI o TheCatAPI) para completar automáticamente información relevante como la raza y la imagen de la mascota.

#### Características Técnicas Adicionales
- Uso de migraciones, seeders y factories para la gestión de la base de datos y datos de prueba. Validaciones robustas a través de Form Requests.
- Las respuestas de la API están estandarizadas con Laravel API Resources y manejan códigos HTTP apropiados.
- Manejo de errores global con mensajes claros.

## Tecnologías y herramientas:
- PHP 8.2.28
- Node v22.15.0
- Laravel 12
- Base de datos MySQL/PostgreSQL/SQlite
- ORM Eloquent
- Autenticación JWT
- The Cat API (Información de mascotas, pedir api key en el sitio web)

### Instalación
- Copiar el .env.example -> .env
- Configurar el sistema de bases de datos que desea usar en este caso MySQL
- Ejecutar los siguientes comandos:

```
 - composer install --prefer-dist
 - php artisan key:generate
 - php artisan jwt:secret
 - npm install
 - npm run build
 - php artisan migrate
 - php artisan db:seed
 - php artisan serve 
```


Iniciar sesión (Después de ejecutar php artisan db:seed):
- usuario: admin@example.com
- contraseña: password

Si desea poblar la base de datos con datos de prueba podrá ejecutar el siguiente comando:

```
php artisan db:seed --class=PetSeeder
```
Creará los datos bases de las mascotas asociados a sus dueños, para actualizar con los datos de las razas en especifico puedo hacer uso del API: ```[PUT] /api/v1/pet/:pet``` en el body enviar un recurso como el siguiente:

```
{
    "name": "Minina Acur sdsdsdsd",
    "species": "Gato",
    "breed": "Abyssinian", // Raza del gato que será consultada en The Cat API
    "age": 5,
    "person_id": 111
}
```
Y actualizará el resto de los campos.


Respecto a la documentación si desean actualizarla pueden ejecutar el comando: ```php artisan scribe:generate``` y podrán acceder a la misma.
