# Documentación del Proyecto: Aventones

## Descripción General
**Aventones** es una aplicación web desarrollada en **Laravel** diseñada para facilitar el *carpooling* (viajes compartidos). La plataforma conecta a conductores que tienen asientos disponibles en sus vehículos con pasajeros que buscan viajar a los mismos destinos. 

## Arquitectura y Tecnologías
- **Framework Backend:** Laravel (PHP)
- **Base de Datos:** MySQL / Relacional (utiliza Eloquent ORM)
- **Frontend:** Blade Templates con Tailwind CSS.
- **Autenticación:** Sistema propio de usuarios con sesión tradicional, verificación de correo y sistema de *Magic Links* (login sin contraseña).

---

## Modelos Principales (Entidades de la Base de Datos)

El sistema gira en torno a varias entidades clave, reflejadas en sus respectivos modelos (`app\Models`):

1. **User (Usuario):**
   - **Tipos de usuario:** Puede ser `passenger` (pasajero), conductor, o administrador.
   - **Campos destacados:** ID único alfanumérico (`char(9)`), foto de perfil, estado de la cuenta (`pending`, `active`, `inactive`), y manejo de tokens para la verificación de correo electrónico.
   - **Relaciones:** Un usuario puede tener múltiples vehículos (si es conductor), publicar múltiples viajes (`rides`) y realizar múltiples reservaciones (`reservations`).

2. **Vehicle (Vehículo):**
   - Representa los autos registrados por los conductores.
   - Están vinculados al conductor a través del `driver_id`.

3. **Ride (Viaje / Aventón):**
   - Creado por los conductores.
   - Contiene la información del viaje: origen, destino, fecha, hora y asientos disponibles.

4. **Reservation (Reservación):**
   - El enlace entre un Pasajero y un Viaje (`Ride`).
   - Tiene estados dinámicos: un pasajero "reserva" un asiento, y el conductor puede "aceptar" o "rechazar" dicha reservación. El pasajero también puede "cancelarla".

5. **SearchLog (Registro de Búsqueda):**
   - Almacena información sobre las búsquedas de viajes que realizan los usuarios.
   - Sirve para que los administradores generen reportes y entiendan la demanda de rutas.

6. **MagicLoginToken:**
   - Gestiona tokens temporales seguros enviados por correo electrónico para permitir a los usuarios iniciar sesión con un enlace mágico.

---

## Flujos de Usuario y Funcionalidades Clave

### 1. Sistema de Autenticación y Cuentas
- **Registro de Usuarios:** Los usuarios proporcionan sus datos básicos y una foto de perfil. La cuenta inicia en estado `pending`.
- **Verificación de Correo:** Al registrarse, se envía un correo con un token único. Al hacer clic en el enlace, la cuenta pasa a estado `active`.
- **Login Tradicional:** Con credenciales convencionales.
- **Login Mágico (Magic Link):** Una alternativa moderna donde el usuario solicita un acceso por correo, recibe un enlace temporal, y al hacer clic, entra directamente a su cuenta sin contraseña.
- **Gestión de Perfil:** Los usuarios pueden modificar su información personal y foto de perfil (`/edit-profile`).

### 2. Flujo del Conductor
- **Gestión de Vehículos:** Pueden añadir, editar o eliminar vehículos de su propiedad.
- **Publicación de Viajes:** Pueden publicar nuevos viajes especificando los detalles de la ruta y capacidad del vehículo.
- **Gestión de Pasajeros:** Reciben solicitudes de reservación y tienen la autoridad para aceptar o rechazar pasajeros en sus viajes publicados.

### 3. Flujo del Pasajero
- **Búsqueda de Viajes:** Pueden buscar viajes disponibles a su destino en la pantalla principal (`/home/ride`).
- **Reservación:** Solicitan un asiento en el viaje que les interesa.
- **Gestión de Reservas:** Pueden ver sus reservaciones y cancelarlas si ya no viajarán.

### 4. Funciones de Administración
- **Reportes:** Panel de reportes (`/home/report`) para analizar la demanda de rutas mediante `SearchLog`.
- **Moderación de Cuentas:** Capacidad para activar o desactivar cuentas de usuario (`/home/user/activate` y `/home/user/deactivate`).

---

## Rutas y Controladores Principales

- **`UserController`**: Maneja la creación (registro), actualización, eliminación, activación/desactivación de cuentas y la verificación de correo.
- **`LoginController` & `MagicLoginController`**: Gestionan las sesiones y la autenticación sin contraseña.
- **`HomeController`**: Controla la vista principal y la lógica de búsqueda de viajes.
- **`VehicleController`**: Mantenimiento (CRUD) de los vehículos de los usuarios.
- **`RideController`**: Mantenimiento (CRUD) de las rutas/viajes publicados.
- **`ReservationController`**: Maneja el ciclo de vida de la reserva (`book`, `cancel`, `accept`, `reject`).
- **`BookingController`**: Para visualizar las reservas actuales.
- **`SearchLogController`**: Gestiona las analíticas de búsqueda.
