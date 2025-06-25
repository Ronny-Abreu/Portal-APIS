<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['city'])) {
    $city = trim($_POST['city']);
    if (!empty($city)) {
        $url = "http://api.weatherapi.com/v1/current.json?key=demo&q=" . urlencode($city) . "&aqi=no";
        
        // API alternativa
        $url = "https://wttr.in/" . urlencode($city) . "?format=j1";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && isset($data['current_condition'])) {
                $result = $data;
            } else {
                $error = "No se pudo obtener información del clima para esta ciudad.";
            }
        } else {
            $error = "Error al conectar con el servicio del clima. Inténtalo más tarde.";
        }
    } else {
        $error = "Por favor, ingresa el nombre de una ciudad.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🌦️</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Clima Mundial</h1>
                <p class="text-gray-600">Consulta el clima actual de cualquier ciudad del mundo</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Nombre de la ciudad
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ej: Santo Domingo, New York, London..."
                               required>
                    </div>
                    <button type="submit" class="btn-weather w-full">
                        <i class="fas fa-cloud-sun mr-2"></i>Consultar Clima
                    </button>
                </form>
            </div>

            <!-- Results -->
            <?php if ($result): ?>
                <?php 
                $current = $result['current_condition'][0];
                $location = $result['nearest_area'][0];
                $temp_c = $current['temp_C'];
                $condition = $current['weatherDesc'][0]['value'];
                $humidity = $current['humidity'];
                $windSpeed = $current['windspeedKmph'];
                $feelsLike = $current['FeelsLikeC'];
                
                // Determinar el ícono y color basado en la temperatura y condición
                $weatherIcon = '☀️';
                $bgGradient = 'from-yellow-400 to-orange-500';
                
                if ($temp_c < 10) {
                    $weatherIcon = '❄️';
                    $bgGradient = 'from-blue-400 to-blue-600';
                } elseif ($temp_c < 20) {
                    $weatherIcon = '☁️';
                    $bgGradient = 'from-gray-400 to-gray-600';
                } elseif (strpos(strtolower($condition), 'rain') !== false) {
                    $weatherIcon = '🌧️';
                    $bgGradient = 'from-blue-500 to-indigo-600';
                } elseif (strpos(strtolower($condition), 'cloud') !== false) {
                    $weatherIcon = '⛅';
                    $bgGradient = 'from-gray-300 to-gray-500';
                }
                ?>
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 animate-fade-in">
                    <div class="bg-gradient-to-r <?php echo $bgGradient; ?> p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold mb-1">
                                    <?php echo $location['areaName'][0]['value']; ?>
                                </h2>
                                <p class="text-lg opacity-90">
                                    <?php echo $location['country'][0]['value']; ?>
                                </p>
                            </div>
                            <div class="text-6xl">
                                <?php echo $weatherIcon; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Temperatura Principal -->
                            <div class="text-center">
                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 mb-6">
                                    <div class="text-6xl font-bold text-gray-800 mb-2">
                                        <?php echo $temp_c; ?>°C
                                    </div>
                                    <p class="text-xl text-gray-600 mb-4"><?php echo $condition; ?></p>
                                    <div class="text-sm text-gray-500">
                                        Sensación térmica: <?php echo $feelsLike; ?>°C
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Detalles del Clima -->
                            <div class="space-y-4">
                                <div class="bg-blue-50 rounded-lg p-4 flex items-center">
                                    <div class="text-2xl mr-4">💧</div>
                                    <div>
                                        <div class="font-semibold text-blue-700">Humedad</div>
                                        <div class="text-xl font-bold text-blue-800"><?php echo $humidity; ?>%</div>
                                    </div>
                                </div>
                                
                                <div class="bg-green-50 rounded-lg p-4 flex items-center">
                                    <div class="text-2xl mr-4">💨</div>
                                    <div>
                                        <div class="font-semibold text-green-700">Viento</div>
                                        <div class="text-xl font-bold text-green-800"><?php echo $windSpeed; ?> km/h</div>
                                    </div>
                                </div>
                                
                                <div class="bg-purple-50 rounded-lg p-4 flex items-center">
                                    <div class="text-2xl mr-4">🌡️</div>
                                    <div>
                                        <div class="font-semibold text-purple-700">Presión</div>
                                        <div class="text-xl font-bold text-purple-800"><?php echo $current['pressure']; ?> mb</div>
                                    </div>
                                </div>
                                
                                <div class="bg-orange-50 rounded-lg p-4 flex items-center">
                                    <div class="text-2xl mr-4">👁️</div>
                                    <div>
                                        <div class="font-semibold text-orange-700">Visibilidad</div>
                                        <div class="text-xl font-bold text-orange-800"><?php echo $current['visibility']; ?> km</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-sm font-medium text-gray-600">UV Index</div>
                                <div class="text-lg font-bold text-gray-800"><?php echo $current['uvIndex']; ?></div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-sm font-medium text-gray-600">Nubosidad</div>
                                <div class="text-lg font-bold text-gray-800"><?php echo $current['cloudcover']; ?>%</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-sm font-medium text-gray-600">Hora Local</div>
                                <div class="text-lg font-bold text-gray-800">
                                    <?php echo date('H:i', strtotime($current['localObsDateTime'])); ?>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-sm font-medium text-gray-600">Temperatura °F</div>
                                <div class="text-lg font-bold text-gray-800"><?php echo $current['temp_F']; ?>°F</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Error -->
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                        <p class="text-red-700"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Ciudades sugeridas -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ciudades populares:</h3>
                <div class="flex flex-wrap gap-2">
                    <?php 
                    $cities = ['Santo Domingo', 'New York', 'London', 'Tokyo', 'Paris', 'Madrid', 'Rome', 'Berlin'];
                    foreach ($cities as $city): 
                    ?>
                        <button onclick="searchCity('<?php echo $city; ?>')" 
                                class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-sm transition-colors duration-300">
                            <?php echo $city; ?>
                        </button>
                    <?php endforeach; ?>
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
    <script>
        function searchCity(cityName) {
            document.getElementById('city').value = cityName;
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>