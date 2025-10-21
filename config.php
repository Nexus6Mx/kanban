<?php
// Habilitar todos los errores para depuración.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- CONFIGURACIÓN DE LA BASE DE DATOS ---
// Soporta variables de entorno para que funcione en Docker y en hosting.
// En Docker Compose normalmente se usa el servicio 'db'. En hosting puede ser 127.0.0.1 o localhost.
$servername = getenv('DB_HOST') ?: 'db';
$username   = getenv('DB_USER') ?: 'u185421649_user_kanban';
$password   = getenv('DB_PASS') ?: 'Chckci74$';
$dbname     = getenv('DB_NAME') ?: 'u185421649_kanban';
// Puerto de MySQL (puedes configurar DB_PORT en el entorno). Por defecto 3306.
$dbport     = getenv('DB_PORT') ?: 3306;
// -----------------------------------------

// --- CONFIGURACIÓN DE ARCHIVOS ---
$upload_dir = 'uploads/';
// ---------------------------------

// --- CONFIGURACIÓN DE ROLES / ADMINISTRADORES ---
// Lista de usuarios con privilegios de administrador que pueden gestionar cualquier tablero.
// Se valida contra el campo `name` de la tabla `users` (en este proyecto se usa el correo como nombre).
$admin_users = [
	'cbarbap@gmail.com',
	'admin@errautomotriz.online',
];
// ---------------------------------
?>