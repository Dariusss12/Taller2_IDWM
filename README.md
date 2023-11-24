# Practica 2 de Introducción al Desarrollo Web/Móvil

### Dario Contreras Abaca
****
## INSTALACION:
Debes instalar [Visual Studio Code](https://code.visualstudio.com/) y [Xampp](https://www.apachefriends.org/es/download.html).

Para comenzar la instalación, debes abrir Visual Studio Code, ir a File -> Open Folder, y seleccionar carpeta en donde quieres clonar el proyecto.

Ir a Terminal -> New Terminal para abrir una nueva terminal.

Ejecutar los siguientes comandos en orden: 

```bash
git clone https://github.com/Dariusss12/Taller2_IDWM
```

```bash
cd Taller2_IDWM
```

```bash
cd API_TALLER_2
```

```bash
npm i
```

```bash
copy .env.example .env
```

```bash
composer install
```

```bash
php artisan key:generate
```

```bash
php artisan jwt:secret
```

Abrir Xampp Control Panel e iniciar Apache y MySQL dando click en el botón "start" respetando el orden.

Ahora debes ir al archivo .env en la carpeta API_LARAVEL y en el apartado "DB_DATABASE=laravel" cambiar laravel por taller2_idwm y guardar los cambios con ctrl + s.

Debes verificar que el puerto de MySQL coincida con "DB_PORT" en el archivo .env de API_TALLER_2. 

****
En caso de que no coincidan, debes copiar el puerto de MySQL y colocarlo en "DB_PORT".

Ejemplo: "DB_PORT=1234".
****

Ir a Terminal -> New Terminal para abrir una nueva terminal.

Ejecutar los siguientes comandos en orden:

****
En caso de que no exista la base de datos:

```bash
php artisan migrate
```

Si sale el siguiente mensaje:

```bash
   WARN  The database 'taller2_idwm' does not exist on the 'mysql' connection.  

  Would you like to create it? (yes/no) [no]
```
Debes escribir yes:

```bash
yes
```
****
En caso de que ya exista la base de datos:

```bash
php artisan migrate:fresh
```
****
```bash
php artisan db:seed
```

```bash
cd..
```
```bash
cd FRONT_TALLER_2
```

```bash
npm i
```

****
## INCIAR SISTEMA:
En Visual Studio Code, ir a File -> Open Folder, y seleccionar la carpeta API_LARAVEL.

Ir a Terminal -> New Terminal para abrir una nueva terminal.

Ejecutar el siguiente comando:

```bash
php artisan serve
```

Luego en Visual Studio Code, ir a File -> New Window.

En esa nueva ventana ir a File -> Open Folder, y seleccionar la carpeta FRONT_VUE.

Ir a Terminal -> new terminal para abrir una nueva terminal.

Ejecutar el siguiente comando en ese nueva ventana:

```bash
npm run dev
```

Abrir el enlace indicado por la consola como "Local:" para visualizar la página web.

```bash
> front-vue@0.0.0 dev
> vite


  VITE v4.5.0  ready in 506 ms

  ➜  Local:   http://localhost:5173/
  ➜  Network: use --host to expose
  ➜  press h to show help
```
****
## Postman

Para probar el la api usando "postman-file", necesitas instalar [Postman](https://www.postman.com/downloads/).
Al abrir Postman y elegir un espacio de trabajo, debes hacer click en "Import" y seleccionar "postman-file".

## Ejecución

#### Login
Primero debes iniciar la prueba de Login, si el login es exitoso, la api deberia devolverte un token.
Para realizar las otras pruebas es necesario ese token, por lo que debes copiarlo y guardarlo en algun bloc de notas.

#### Get User con token
Para realizar el get, debes ir a la pestaña de Authorization -> Tpye y seleccionar "Bearer Token", esto mostrara una opcion al lado en donde debes copiar el token del Login.
Luego ejecutas la prueba y la api debería retornarte la lista de los usuarios.

#### Post User 
Para realizar el Post, debes ir a la pestaña de Authorization -> Tpye y seleccionar "Bearer Token", esto mostrara una opcion al lado en donde debes copiar el token del Login.
Luego ejecutas la prueba y la api debería retornarte el nuevo usuario creado.

#### Put User
Para realizar el Put, debes ir a la pestaña de Authorization -> Tpye y seleccionar "Bearer Token", esto mostrara una opcion al lado en donde debes copiar el token del Login.
Luego ejecutas la prueba y la api debería retornarte el usuario de id 1 actualizado. Si quieres actualizar otro usuario, debes cambiar el 1 de la url por una id valida de un usuario.

#### Delete User
Para realizar el Delete, debes ir a la pestaña de Authorization -> Tpye y seleccionar "Bearer Token", esto mostrara una opcion al lado en donde debes copiar el token del Login.
Luego ejecutas la prueba y la api debería retornarte un mensaje indicando que se eliminó el usuario 1. Si quieres eliminar otro usuario, debes cambiar el 1 de la url por una id valida de un usuario.

#### Logout
Para realizar el Delete, debes ir a la pestaña de Authorization -> Tpye y seleccionar "Bearer Token", esto mostrara una opcion al lado en donde debes copiar el token del Login.
Luego ejecutas la prueba y la api debería retornarte un mensaje indicando que el logout fue exitoso.


