# Proyecto InnclodCrud Laravel 8.4 con Vue.js 2.6

Este proyecto está construido con Laravel 8 y Vue.js. Aquí encontrarás las instrucciones detalladas para la instalación y configuración.

## Requisitos Previos

Asegúrate de tener instalado lo siguiente:
- PHP (versión 7.3 o superior)
- Composer
- Node.js (versión v18.17.1 o superior) y npm (versión v9.6.7 o superior)
- Un servidor de base de datos (MySQL)

## Instalación y Configuración

### Paso 1: Clonar el Repositorio
Clona el repositorio en tu máquina local usando:
`git clone git@github.com:HansSanchez/InnclodCrud.git`
`cd InnclodCrud`

### Paso 2: Configuración del Entorno
Copie el archivo `.env.example` a `.env`:
`cp .env.example .env`
Una vez ya tenga copiado el archivo de las variables de entorno, por favor ajuste las credenciales de la base de datos en la cual va a conectar la prueba

### Paso 3: Instalación de las dependencias de Laravel
Instala todas las dependencias de PHP requeridas por Laravel:
`composer install`

### Paso 4: Configuración de herramienta Voyager
Instala todas las dependencias de PHP requeridas por Laravel:
`php artisan voyager:install --with-dummy`

#### Paso 4.1 Credenciales
email: admin@admin.com
password: password

#### Paso 4.2 
Ejecución o subida de las semillas necesarias para el uso de la aplicación
`php artisan db:seed --class=VoyagerDatabaseSeeder`


### Paso 5: Generar Clave de Aplicación
Genera la clave de la aplicación de Laravel:
`php artisan key:generate`

### Paso 6: Instalar Vue.js
Instale Vue.js y sus dependencias a través de npm install && con npm run dev compile los archivos js y css:
`npm install && npm run dev`
Tenga en cuenta que como la idea es visualizar el proyecto se propone npm run dev si se fuera a editar se recomienda en npm run watch para que este siempre activo escuchando los cambios en nuestro código, de igual manera es opcional.

## Ejecutar el Proyecto
Para ejecutar el proyecto en un servidor de desarrollo local:
`php artisan serve`
Visita `http://localhost:8000` en su navegador para ver la aplicación.

## Conclusión

Este archivo `README.md` proporciona una guía paso a paso para configurar un proyecto de Laravel 8 con Vue.js, cubriendo desde la clonación del repositorio hasta la compilación de los assets de Vue.js, adicionalmente al hacer uso de una plantilla se explica también la instalación y configuración de Voyager el cual es una herramienta para Laravel que facilita algunas tareas repetitivas como son la creación de usuarios, roles y la asignación de los permisos.
