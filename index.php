<?php
session_start();
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal APIs - Ronny Ariel De León Abreu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <?php include 'includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <div class="relative inline-block mb-6">
                <img src="assets/images/profile.jpg" alt="Ronny Ariel De León Abreu" 
                     class="w-48 h-48 rounded-full mx-auto shadow-2xl border-4 border-white object-cover">
                <div class="absolute -bottom-2 -right-2 bg-green-500 w-8 h-8 rounded-full border-4 border-white"></div>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-4">
                Ronny Ariel De León Abreu
            </h1>
            <p class="text-xl text-gray-600 mb-8">Portal Web Dinámico con APIs</p>
            <div class="flex justify-center space-x-4">
                <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                    <i class="fab fa-php mr-2"></i>PHP Developer
                </span>
                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                    <i class="fas fa-code mr-2"></i>API Integration
                </span>
            </div>
        </div>

        <!-- APIs Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Gender API Card -->
            <div class="api-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="text-4xl mb-4 text-center">👦👧</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Predicción de Género</h3>
                    <p class="text-gray-600 mb-4">Predice el género basado en un nombre</p>
                    <a href="pages/gender.php" class="btn-primary w-full text-center block">
                        <i class="fas fa-search mr-2"></i>Explorar
                    </a>
                </div>
            </div>

            <!-- Age API Card -->
            <div class="api-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="text-4xl mb-4 text-center">🎂</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Predicción de Edad</h3>
                    <p class="text-gray-600 mb-4">Estima la edad basada en un nombre</p>
                    <a href="pages/age.php" class="btn-primary w-full text-center block">
                        <i class="fas fa-birthday-cake mr-2"></i>Explorar
                    </a>
                </div>
            </div>

            <!-- Universities API Card -->
            <div class="api-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="text-4xl mb-4 text-center">🎓</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Universidades</h3>
                    <p class="text-gray-600 mb-4">Busca universidades por país</p>
                    <a href="pages/universities.php" class="btn-primary w-full text-center block">
                        <i class="fas fa-university mr-2"></i>Explorar
                    </a>
                </div>
            </div>

            <!-- Weather API Card -->
            <div class="api-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="text-4xl mb-4 text-center">🌦️</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Clima RD</h3>
                    <p class="text-gray-600 mb-4">Información del clima actual</p>
                    <a href="pages/weather.php" class="btn-primary w-full text-center block">
                        <i class="fas fa-cloud-sun mr-2"></i>Explorar
                    </a>
                </div>
            </div>

            <!-- Pokemon API Card -->
            <div class="api-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="text-4xl mb-4 text-center">⚡</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pokémon Info</h3>
                    <p class="text-gray-600 mb-4">Información detallada de Pokémon</p>
                    <a href="pages/pokemon.php" class="btn-primary w-full text-center block">
                        <i class="fas fa-gamepad mr-2"></i>Explorar
                    </a>
                </div>
            </div>

        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>