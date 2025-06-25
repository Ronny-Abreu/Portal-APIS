<?php
// Configuración de claves de API

// URLs base de las APIs
define('GENDERIZE_API_URL', 'https://api.genderize.io/');
define('POKEMON_API_URL', 'https://pokeapi.co/api/v2/pokemon/');

// Configuración de la aplicación
define('APP_NAME', 'Portal APIs');
define('APP_VERSION', '1.0.0');
define('DEVELOPER_NAME', 'Ronny Ariel De León Abreu');

// Configuración de base de datos
define('DB_HOST', 'localhost:3308');
define('DB_NAME', 'portal_apis');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>