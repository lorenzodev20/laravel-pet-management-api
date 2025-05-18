# API RESTFul para la gestión de las personas y sus mascotas  

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

También comparto mi colección de POSTMAN si desean usarla [AQUÍ](https://documenter.getpostman.com/view/18208862/2sB2qXji4P)
