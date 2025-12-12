# EVA 'Evaluación Asistida'

<img src="public/logo_eva.png" witch="40px" height="40px"/>

Eva es un sistema de gestion de notas para escuelas de nivel basico en donde lo profesores podran cargar sus proyectos de aprendizaje y cargar sus referentes teoricos con sus indicadores.

Esta version de Eva no gestiona a los `profesores`, `matriculas` ni `estudiante`, ya que esos datos los espera por medio de un API externa. 



---

## Indice
- [EVA 'Evaluación Asistida'](#eva-evaluación-asistida)
  - [Indice](#indice)
  - [Estructura](#estructura)
  - [Requisitos](#requisitos)
  - [Tecnologias](#tecnologias)
  - [Instalación](#instalación)
  - [Ejecución del Proyecto](#ejecución-del-proyecto)
  - [🔗 Documentaciones](#-documentaciones)

---
## Estructura
```
app/
├── Console/
│   └── Commands/
│       ├── DispatchPendingJobs.php <-- Shedule para la creación de los boletines
│       └── JapecoSync.php <-- Shedula para la syncronización con JAPECO
│
├── Constants/
│   ├──PermissionConstants.php <-- Contantes de permisos
│   ├──RoleConstants.php <-- Contantes de roles
│   └──TDTO.php <-- Contantes de transformaciones de DTO
│
├── DTOs/
│   ├── Details/ <-- DTOs detallados de los modelos
│   ├── Searches/ <-- DTOs para búsquedas
│   └── Summary/ <-- DTOs resumidos de los modelos
│
├── Events/
│
├── Exceptions/ <-- Excepciones personalizadas
│
├── Exports/
│   └── NotesExport.php <-- Clase para exportar notas a Excel
│
├── Factories/
│   └── ***/ <-- Archivos de transformación de datos a DTOs
│
├── Http/
│   ├── Controllers/ <-- Controladores de peticiones Http
│   │   └── ***/
│   ├── Middleware/
│   │   └── ***/
│   └── Requests/ <-- Clases de validación para peticiones Http
│       └── ***/
│
├── Jobs/
│   └── CreateTicketJob.php <-- Job para la creación de boletines
│
├── Models/
│   └── ***/
│
├── Providers/
│   └── ***/
│
├── Repositories/
│   ├── Interfaces/ <-- Interfaces para los repositorios
│   └── ***/ <-- Implementaciones de los repositorios
│
├── Rules/
│   └── ***/ <-- Reglas de validación personalizadas
│
├── Services/
│   └── ***/ <-- Lógica de negocio de la aplicación
│
├── .env <-- Archivo de configuracion
```

---
## Requisitos


* **PHP:** Versión 8.0 o superior.
* **Composer:** Gestor de dependencias de PHP.
* **Node.js:** Versión 16.x o superior.
* **npm** (viene con Node.js).
* **MySQL** (o tu base de datos preferida, como PostgreSQL, SQLite, etc.).
* **Git:** Para clonar el repositorio.

---

## Tecnologias

**Frameworks**
* **Laravel:** Versión `^12.0.0`
* **Vue.js:** Versión `^3.5.13`
* **Tailwindcss:** Versión `^3.3.2`

**Dependencias Vue**
* **Typescript:** Versión `^5.2.2`
* **Headlessui:** Versión `^1.7.23`
* **Pinia:** Versión `^3.0.3`
* **Inertiajs:** Versión `^5.2.4`
* **Tsparticles:** Versión `^3.9.1`

**Dependencias Laravel**
* **maatwebsite/excel:** Versión `^3.1`
* **phpoffice/phpword:** Versión `^1.4`
* **predis/predis:** Versión `^3.2`
* **spatie/laravel-activitylog:** Versión `^4.10`
* **spatie/laravel-backup:** Versión `^9.3`
* **spatie/laravel-permission:** Versión `^6.20`

---

## Instalación

Sigue estos pasos para poner en marcha el proyecto en tu máquina local:

1.  **Clona el repositorio:**

    ```bash
    git clone https://github.com/IsacC2005/EvaluacionAsistida.git
    cd EvaluacionAsistida
    ```

2.  **Instala las dependencias de PHP:**

    ```bash
    composer install
    ```

3.  **Configura el archivo de entorno (`.env`):**

    Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`:

    ```bash
    cp .env.example .env
    ```

    Abre el archivo `.env` recién creado y configura tus credenciales de base de datos y cualquier otra variable de entorno necesaria. Aquí tienes un ejemplo de configuración de base de datos para MySQL:

    ```env
    APP_NAME="Eva"
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=eva_db # Cambia esto por el nombre de tu BD
    DB_USERNAME=user_db           # Cambia esto por tu usuario de BD
    DB_PASSWORD=password_bd          # Cambia esto por tu contraseña de BD

    JAPECO_URL= "localhost:4000" # Cambia esto por la dirección del API de JAPECO
    ```

4.  **Genera la clave de la aplicación Laravel:**

    ```bash
    php artisan key:generate
    ```

5.  **Ejecuta las migraciones de la base de datos:**

    Esto creará las tablas necesarias en tu base de datos.

    ```bash
    php artisan migrate --seed
    ```

6.  **Instala las dependencias de JavaScript:**

    ```bash
    npm install 
    ```

7.  **Compila los assets de frontend:**

    * **Para desarrollo (con recarga en caliente - HMR):**

        ```bash
        npm run dev
        ```

    * **Para producción (archivos optimizados):**

        ```bash
        npm run build
        ```

---

## Ejecución del Proyecto

Una vez que hayas completado los pasos de instalación, puedes iniciar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Para iniciar el servidor de Vue ejecuta el siguiente comando:
```bash
npm run dev
```

Para iniciar las colas de procesos ejecuta el siguiente comando:
```bash 
php artisan queue:work --queue=work,japeco-sync
```

Para correr los shedules ejecuta el siguiente comando: 
```bash 
while($true){
	php artisan schedule:run
	sleep(60)
}
```

---

## 🔗 Documentaciones

A continuación se listan los enlaces a la documentación oficial de los principales *frameworks* y librerías utilizados en este proyecto, agrupados por su contexto para una fácil referencia.

| Categoría         | Tecnología                   | Enlace Directo a la Documentación                                                  |
| :---------------- | :--------------------------- | :--------------------------------------------------------------------------------- |
| **Backend / PHP** | **Laravel**                  | 🔗 [laravel.com/docs](https://laravel.com/docs/)                                    |
|                   | `maatwebsite/excel`          | 🔗 [docs.laravel-excel.com](https://docs.laravel-excel.com/)                        |
|                   | `phpoffice/phpword`          | 🔗 [phpword.readthedocs.io](https://phpword.readthedocs.io/)                        |
|                   | `predis/predis`              | 🔗 [predis.github.io/predis/](https://predis.github.io/predis/)                     |
|                   | `spatie/laravel-activitylog` | 🔗 [spatie.be/docs/laravel-activitylog](https://spatie.be/docs/laravel-activitylog) |
|                   | `spatie/laravel-backup`      | 🔗 [spatie.be/docs/laravel-backup](https://spatie.be/docs/laravel-backup)           |
|                   | `spatie/laravel-permission`  | 🔗 [spatie.be/docs/laravel-permission](https://spatie.be/docs/laravel-permission)   |
| **Frontend / JS** | **Vue.js**                   | 🔗 [vuejs.org/guide/](https://vuejs.org/guide/)                                     |
|                   | **Pinia**                    | 🔗 [pinia.vuejs.org/](https://pinia.vuejs.org/)                                     |
|                   | **Inertia.js**               | 🔗 [inertiajs.com/documentation](https://inertiajs.com/documentation)               |
|                   | **TypeScript**               | 🔗 [typescriptlang.org/docs/](https://www.typescriptlang.org/docs/)                 |
|                   | **Headless UI**              | 🔗 [headlessui.com/react/menu](https://headlessui.com/react/menu)                   |
|                   | **TSParticles**              | 🔗 [particles.js.org/docs/](https://particles.js.org/docs/)                         |
| **Estilos**       | **Tailwind CSS**             | 🔗 [tailwindcss.com/docs](https://tailwindcss.com/docs/)                            |