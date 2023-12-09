<?php
// Cargar la biblioteca de cliente de Google API para PHP
require '../vendor/autoload.php';

// Credenciales de la aplicación y configuración de la API de Google Calendar
$client = new Google_Client();
$client->setAuthConfig('../client_secret.json');
$client->addScope(Google_Service_Calendar::CALENDAR);

// Inicializar la sesión y obtener el token del usuario
session_start();

if (isset($_SESSION['access_token'])) {
    $client->setAccessToken($_SESSION['access_token']);

    // Crear un cliente de servicio para interactuar con la API de Google Calendar
    $service = new Google_Service_Calendar($client);

    // Obtener los datos del evento del formulario en misEventos.php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $nombreEvento = $_GET['nombre']; // Obtener el nombre del evento
        $fechaEvento = $_GET['fecha']; // Obtener la fecha del evento
        $horaEvento = $_GET['hora']; // Obtener la hora del evento

        // Construir la fecha y hora del evento
        $fechaHoraInicio = $fechaEvento . "T" . $horaEvento . ":00"; // Fecha y hora de inicio del evento
        $fechaHoraFin = $fechaEvento . "T" . $horaEvento . ":00"; // Fecha y hora de finalización del evento

        // Crear un objeto de evento
        $event = new Google_Service_Calendar_Event([
            'summary' => $nombreEvento,
            'start' => [
                'dateTime' => $fechaHoraInicio,
                'timeZone' => 'America/Argentina/Buenos_Aires', // Zona horaria del evento
            ],
            'end' => [
                'dateTime' => $fechaHoraFin,
                'timeZone' => 'America/Argentina/Buenos_Aires', // Zona horaria del evento
            ],
        ]);

        try {
            // Insertar el evento en el calendario del usuario
            $calendarId = 'primary'; // ID del calendario del usuario
            $event = $service->events->insert($calendarId, $event);

            // Manejar la respuesta del servidor después de insertar el evento
            $_SESSION['Mensajedeexito'] = "Evento agregado con éxito";
            header("Location: misEventos.php");
        } catch (Google\Service\Exception $e) {
            echo "Error al insertar el evento: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error inesperado: " . $e->getMessage();
        }
    } else {
        echo 'Error: Método de solicitud no válido.';
    }
} else {
    // Si no hay token de acceso, redireccionar a la página de autenticación
    header('Location: ' . $client->createAuthUrl());
    exit;
}
?>