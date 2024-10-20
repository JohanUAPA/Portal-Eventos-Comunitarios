## Descripción del Proyecto

El Portal de Eventos Comunitarios es una plataforma web desarrollada en PHP, con MySQL como base de datos, junto con HTML y JavaScript para crear una interfaz de usuario interactiva y dinámica. El objetivo principal de este portal es facilitar la organización y participación en eventos comunitarios, proporcionando una experiencia fluida tanto para los usuarios regulares como para los administradores.

## Funcionalidades

  -	Página de Inicio: Muestra los eventos destacados y facilita el acceso rápido a las principales funcionalidades del portal.
  
  -	Registro y Autenticación: Permite a los usuarios crear una cuenta, iniciar sesión y gestionar su perfil.
  
  -	Gestión de Eventos: Los administradores tienen acceso a un panel donde pueden añadir, editar y eliminar eventos.
  
  - Comentarios y Calificaciones: Los usuarios pueden dejar reseñas y calificar los eventos con un sistema de estrellas.
  
  -	Inscripción a Eventos: Los usuarios pueden inscribirse y gestionar los eventos a los que desean asistir.
  
  -	Buscador y Filtros: Permite buscar eventos por fecha, categoría y ubicación.
  
 -	Panel de Control para Administradores: Herramientas para gestionar usuarios, eventos y comentarios.

## Tecnologías

  -	PHP: Para la lógica del servidor.
  -	MySQL: Base de datos relacional que almacena los eventos, usuarios, comentarios e inscripciones.
  -	HTML y CSS: Para estructurar y estilizar la interfaz del usuario.
  -	Bootstrap: Framework utilizado para crear un diseño responsivo y atractivo.
  -	JavaScript: Para añadir interactividad en la interfaz de usuario.JavaScript: Para añadir interactividad en la interfaz de usuario.

## Requisitos

  -	XAMPP https://www.apachefriends.org/index.html (incluye Apache y MySQL)
  -	Navegador web (Chrome, Firefox, etc.)
Instalación

## Descargar el proyecto:

  •	Clona el repositorio del proyecto en tu máquina local con el siguiente comando:
      ```bash
     git clone <URL_DEL_REPOSITORIO>
     ```

## Mover el proyecto a XAMPP:

 -	Copia o mueve la carpeta `portal-de-eventos` a la carpeta `htdocs` de tu instalación de XAMPP. La ruta típica es:
        ```
     C:\xampp\htdocs\portal-de-eventos
     ```

## Configurar XAMPP

  - Abre XAMPP y asegúrate de que Apache y MySQL estén en ejecución.

## Importar la base de datos:

  -	Abre tu navegador y ve a `http://localhost/phpmyadmin`.
  -	Crea una nueva base de datos llamada `portal_evento`.
  - Haz clic en la pestaña "Importar".
  -	Selecciona el archivo SQL de la base de datos que se incluye en el proyecto y haz clic en "Continuar".

## Configurar la conexión a la base de datos:

Abre el archivo de configuración de la base de datos (db_connection.php` de la carpeta PHP) y asegúrate de que los datos de conexión a la base de datos sean correctos. Por defecto, deberías usar:
Asegúrate de que la configuración de conexión en tus archivos PHP sea correcta. Por defecto, el usuario es `root` y no hay contraseña.

     **Host**: `localhost`
     **Usuario**: `root`
     **Contraseña**: (dejar vacío, si no has establecido una contraseña)
     **Base de datos**: `portal_evento`

## Acceder al proyecto:

  -	Ve a `http://localhost/portal-de-eventos` en tu navegador.

 ## Uso
 
-Registro de usuarios: Los nuevos usuarios pueden registrarse desde la página de registro.
-Inicio de sesión:Los usuarios registrados pueden iniciar sesión para acceder a sus perfiles y funciones.
-Gestión de eventos: Los administradores pueden crear, editar y eliminar eventos.
-Comentarios y calificaciones: Los usuarios pueden dejar comentarios y calificaciones en los eventos a los que se inscriben.


## Estructura de la Base de Datos
La base de datos `portal_evento` contiene las siguientes tablas:

1. **usuarios**
   - `id`: INT, PRIMARY KEY, AUTO_INCREMENT
   - `nombre`: VARCHAR(50), NOT NULL
   - `email`: VARCHAR(50), NOT NULL
   - `contrasena`: VARCHAR(255), DEFAULT NULL
   - `rol`: ENUM('usuario', 'admin'), DEFAULT 'usuario'
   - `reg_date`: TIMESTAMP, NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

2. **eventos**
   - `id`: INT, PRIMARY KEY, AUTO_INCREMENT
   - `titulo`: VARCHAR(100), NOT NULL
   - `descripcion`: TEXT, NOT NULL
   - `fecha`: DATE, NOT NULL
   - `ubicacion`: VARCHAR(100), NOT NULL
   - `categoria`: VARCHAR(50), NOT NULL
   - `valoracion_promedio`: FLOAT, DEFAULT 0
   - `fecha_creacion`: TIMESTAMP, NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   - `hora`: TIME, NOT NULL

3. **comentarios**
   - `id`: INT, PRIMARY KEY, AUTO_INCREMENT
   - `evento_id`: INT, UNSIGNED, NOT NULL (FOREIGN KEY referencia a `eventos.id`)
   - `usuario_id`: INT, UNSIGNED, NOT NULL (FOREIGN KEY referencia a `usuarios.id`)
   - `comentario`: TEXT, NOT NULL
   - `valoracion`: INT(1), NOT NULL
   - `fecha_comentario`: TIMESTAMP, NOT NULL DEFAULT CURRENT_TIMESTAMP
   - `calificacion`: INT(11), DEFAULT NULL

4. **inscripciones**
   - `id`: INT, PRIMARY KEY, AUTO_INCREMENT
   - `evento_id`: INT, UNSIGNED, NOT NULL (FOREIGN KEY referencia a `eventos.id`)
   - `usuario_id`: INT, UNSIGNED, NOT NULL (FOREIGN KEY referencia a `usuarios.id`)
   - `fecha_inscripcion`: TIMESTAMP, NOT NULL DEFAULT CURRENT_TIMESTAMP

5. **consultas**
   - `id`: INT, PRIMARY KEY, AUTO_INCREMENT
   - `nombre`: VARCHAR(100), NOT NULL
   - `email`: VARCHAR(100), NOT NULL
   - `mensaje`: TEXT, NOT NULL
   - `respondido`: TINYINT(1), DEFAULT 0
   - `fecha`: TIMESTAMP, NOT NULL DEFAULT CURRENT_TIMESTAMP

