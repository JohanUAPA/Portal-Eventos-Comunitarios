## Requisitos Previos

- XAMPP instalado en tu computadora.
- Navegador web.

## Instalación

1. **Descargar el Proyecto**
   - Descarga el archivo `portal-de-eventos.zip` desde el repositorio o la fuente proporcionada.
   - Descomprime el archivo en tu computadora.

2. **Mover el Proyecto a XAMPP**
   - Copia la carpeta descomprimida `portal-de-eventos` a la ruta `C:\xampp\htdocs\`.

3. **Configurar la Base de Datos**
   - Abre el panel de control de XAMPP y asegúrate de que los servicios de **Apache** y **MySQL** estén en ejecución.
   - Accede a phpMyAdmin abriendo un navegador y dirigiéndote a `http://localhost/phpmyadmin`.
   - Crea una nueva base de datos llamada `portal_evento`.
   - Importa el archivo SQL de la estructura de la base de datos proporcionado en este repositorio. Puedes hacer esto haciendo clic en la base de datos recién creada, luego en la pestaña "Importar", selecciona el archivo SQL y haz clic en "Continuar".

4. **Configurar el Archivo de Conexión a la Base de Datos**
   - Abre el archivo de configuración de la base de datos (db_connection.php` de la carpeta PHP) y asegúrate de que los datos de conexión a la base de datos sean correctos. Por defecto, deberías usar:
     - **Host**: `localhost`
     - **Usuario**: `root`
     - **Contraseña**: (dejar vacío, si no has establecido una contraseña)
     - **Base de datos**: `portal_evento`

## Uso

1. **Acceder a la Aplicación**
   - Abre un navegador web y visita `http://localhost/portal-de-eventos`.

2. **Registro e Inicio de Sesión**
   - Los usuarios pueden registrarse y luego iniciar sesión para acceder a las funcionalidades de inscripción en eventos y comentarios.

3. **Gestión de Eventos**
   - Los administradores pueden crear, editar y eliminar eventos desde el panel de administración.

## Estructura de la Base de Datos

La base de datos `portal_evento` contiene las siguientes tablas:

- **usuarios**
- **eventos**
- **comentarios**
- **inscripciones**
- **consultas**

(Sigue con la sección anterior sobre la estructura de la base de datos aquí.)

## Notas Adicionales

- Asegúrate de que tu servidor XAMPP esté configurado correctamente para ejecutar aplicaciones PHP y MySQL.
- Si encuentras problemas, revisa los logs de error en el panel de control de XAMPP para obtener más información.

¡Disfruta utilizando el Portal de Eventos!
