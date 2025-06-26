<?php
session_start();
include_once '../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="text-6xl mb-4">ℹ️</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Acerca del Proyecto</h1>
                <p class="text-gray-600">Información detallada sobre el desarrollo y tecnologías utilizadas</p>
            </div>

            <!-- Información(PRIMERA CARD) -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                    <div class="flex-shrink-0">
                        <img src="../assets/images/profile.jpg" 
                             alt="Ronny Ariel De León Abreu" 
                             class="w-32 h-32 rounded-full shadow-lg border-4 border-blue-100 object-cover">
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Ronny Ariel De León Abreu</h2>
                        <p class="text-blue-600 font-medium mb-4">Desarrollador Full Stack</p>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Estudiante apasionado por el desarrollo web y la integración de APIs. 
                            Este proyecto representa mi dedicación al aprendizaje continuo y la 
                            implementación de soluciones web modernas y funcionales.
                        </p>
                        <div class="flex justify-center md:justify-start space-x-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                <i class="fab fa-php mr-1"></i>PHP
                            </span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                <i class="fab fa-js-square mr-1"></i>JavaScript
                            </span>
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                <i class="fab fa-css3-alt mr-1"></i>CSS
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Framework y tecnologías -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-tools mr-2 text-blue-600"></i>
                    Tecnologías Utilizadas
                </h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Frontend -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-paint-brush mr-2 text-green-500"></i>
                            Frontend
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fab fa-html5 text-2xl text-orange-500 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800">HTML5</h4>
                                    <p class="text-sm text-gray-600">Estructura semántica y accesible</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fab fa-css3-alt text-2xl text-blue-500 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800">TailwindCSS</h4>
                                    <p class="text-sm text-gray-600">Framework CSS utility-first para diseño rápido y consistente</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fab fa-js-square text-2xl text-yellow-500 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800">JavaScript ES6+</h4>
                                    <p class="text-sm text-gray-600">Interactividad, animaciones y experiencia de usuario</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backend -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-server mr-2 text-purple-500"></i>
                            Backend
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fab fa-php text-2xl text-purple-600 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800">PHP 8+</h4>
                                    <p class="text-sm text-gray-600">Lenguaje principal para lógica del servidor y consumo de APIs</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-database text-2xl text-green-600 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800">MySQL</h4>
                                    <p class="text-sm text-gray-600">Base de datos relacional (configurada para futuras implementaciones)</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-server text-2xl text-red-600 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800">XAMPP</h4>
                                    <p class="text-sm text-gray-600">Servidor local Apache + MySQL + PHP</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EXPLICACION FRAMEWORK CSS -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-question-circle mr-2 text-indigo-600"></i>
                    ¿Por qué elegí TailwindCSS?
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Desarrollo Rápido</h3>
                                <p class="text-sm text-gray-600">Clases utilitarias que permiten crear interfaces rápidamente sin escribir CSS personalizado</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-mobile-alt text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Responsive por Defecto</h3>
                                <p class="text-sm text-gray-600">Sistema de breakpoints integrado que facilita el diseño responsive</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-palette text-purple-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Consistencia Visual</h3>
                                <p class="text-sm text-gray-600">Sistema de diseño coherente con espaciado, colores y tipografía predefinidos</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-feather-alt text-yellow-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Optimización Automática</h3>
                                <p class="text-sm text-gray-600">PurgeCSS integrado que elimina CSS no utilizado en producción</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-cogs text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Altamente Personalizable</h3>
                                <p class="text-sm text-gray-600">Configuración flexible que permite adaptar el framework a las necesidades del proyecto</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-users text-indigo-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Comunidad Activa</h3>
                                <p class="text-sm text-gray-600">Amplia documentación, recursos y comunidad de desarrolladores</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- APIs Implementadas -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-plug mr-2 text-green-600"></i>
                    APIs Integradas
                </h2>
                
                <div class="grid gap-6">
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-800 flex items-center">
                                <span class="text-2xl mr-3">👦👧</span>
                                Genderize.io - Predicción de Género
                            </h3>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Gratuita</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Predice el género de una persona basándose en su nombre</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">https://api.genderize.io/</code>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-800 flex items-center">
                                <span class="text-2xl mr-3">🎂</span>
                                Agify.io - Predicción de Edad
                            </h3>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Gratuita</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Estima la edad de una persona basándose en su nombre</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">https://api.agify.io/</code>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-800 flex items-center">
                                <span class="text-2xl mr-3">🎓</span>
                                Hipolabs - Universidades
                            </h3>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Gratuita</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Base de datos de universidades organizadas por país</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">http://universities.hipolabs.com/</code>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-800 flex items-center">
                                <span class="text-2xl mr-3">🌦️</span>
                                Wttr.in - Información del Clima
                            </h3>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Gratuita</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Servicio de clima en tiempo real sin necesidad de API key</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">https://wttr.in/</code>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-800 flex items-center">
                                <span class="text-2xl mr-3">⚡</span>
                                PokéAPI - Información Pokémon
                            </h3>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Gratuita</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">API completa con información detallada de todos los Pokémon</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">https://pokeapi.co/</code>
                    </div>
                </div>
            </div>

            <!-- Características del proyecto -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-star mr-2 text-yellow-600"></i>
                    Características del Proyecto
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-mobile-alt text-blue-500"></i>
                            <span class="text-gray-700">Diseño 100% Responsive</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            <span class="text-gray-700">Manejo robusto de errores</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-magic text-purple-500"></i>
                            <span class="text-gray-700">Animaciones y transiciones suaves</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-universal-access text-green-500"></i>
                            <span class="text-gray-700">Accesibilidad web implementada</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-tachometer-alt text-orange-500"></i>
                            <span class="text-gray-700">Optimización de rendimiento</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-shield-alt text-indigo-500"></i>
                            <span class="text-gray-700">Validación de datos segura</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-code text-gray-500"></i>
                            <span class="text-gray-700">Código limpio y documentado</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-expand-arrows-alt text-cyan-500"></i>
                            <span class="text-gray-700">Arquitectura escalable</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back button -->
            <div class="text-center">
                <a href="../index.php" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Inicio
                </a>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/main.js"></script>
</body>
</html>