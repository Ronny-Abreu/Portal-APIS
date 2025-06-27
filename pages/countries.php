<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['country'])) {
    $country = trim($_POST['country']);
    if (!empty($country)) {
        $url = "https://restcountries.com/v3.1/name/" . urlencode($country);
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Portal-APIs/1.0'
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && is_array($data) && count($data) > 0) {
                $result = $data[0]; // Tomar el primer resultado
            } else {
                $error = "No se encontró información para este país.";
            }
        } else {
            $error = "País no encontrado. Verifica el nombre e inténtalo de nuevo.";
        }
    } else {
        $error = "Por favor, ingresa el nombre de un país.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Países - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🌍</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Datos de Países</h1>
                <p class="text-gray-600">Explora información detallada de países alrededor del mundo</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-globe mr-2"></i>Nombre del país
                        </label>
                        <input type="text" 
                               id="country" 
                               name="country" 
                               value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ej: Dominican Republic, Spain, Japan..."
                               required>
                    </div>
                    <button type="submit" class="btn-countries w-full">
                        <i class="fas fa-search mr-2"></i>Buscar País
                    </button>
                </form>
            </div>

            <!-- Results -->
            <?php if ($result): ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 animate-fade-in">
                    <!-- Header país -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold mb-2"><?php echo $result['name']['common']; ?></h2>
                                <p class="text-lg opacity-90"><?php echo $result['name']['official']; ?></p>
                            </div>
                            <div class="text-6xl flag-wave">
                                <?php echo $result['flag']; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Información básica -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                    Información General
                                </h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Capital:</span>
                                        <span class="text-gray-800">
                                            <?php echo isset($result['capital']) ? implode(', ', $result['capital']) : 'N/A'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Población:</span>
                                        <span class="text-gray-800">
                                            <?php echo number_format($result['population']); ?> habitantes
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Área:</span>
                                        <span class="text-gray-800">
                                            <?php echo number_format($result['area']); ?> km²
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Región:</span>
                                        <span class="text-gray-800">
                                            <?php echo $result['region']; ?> - <?php echo $result['subregion']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bandera y detalles -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-flag mr-2 text-red-500"></i>
                                    Bandera y Detalles
                                </h3>
                                
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <img src="<?php echo $result['flags']['png']; ?>" 
                                         alt="Bandera de <?php echo $result['name']['common']; ?>"
                                         class="w-full h-32 object-contain rounded border">
                                </div>
                                
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-language mr-2 text-green-500"></i>
                                        <span class="font-medium text-gray-700 mr-2">Idiomas:</span>
                                        <span class="text-gray-800">
                                            <?php 
                                            if (isset($result['languages'])) {
                                                echo implode(', ', array_values($result['languages']));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <i class="fas fa-coins mr-2 text-yellow-500"></i>
                                        <span class="font-medium text-gray-700 mr-2">Moneda:</span>
                                        <span class="text-gray-800">
                                            <?php 
                                            if (isset($result['currencies'])) {
                                                $currencies = [];
                                                foreach ($result['currencies'] as $code => $currency) {
                                                    $currencies[] = $currency['name'] . ' (' . $currency['symbol'] . ')';
                                                }
                                                echo implode(', ', $currencies);
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-2 text-purple-500"></i>
                                        <span class="font-medium text-gray-700 mr-2">Código telefónico:</span>
                                        <span class="text-gray-800">
                                            <?php 
                                            if (isset($result['idd']['root']) && isset($result['idd']['suffixes'])) {
                                                echo $result['idd']['root'] . implode(', ' . $result['idd']['root'], $result['idd']['suffixes']);
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="mt-8 grid md:grid-cols-3 gap-6">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <i class="fas fa-globe-americas text-2xl text-blue-500 mb-2"></i>
                                <h4 class="font-semibold text-blue-800">Continente</h4>
                                <p class="text-blue-700">
                                    <?php echo isset($result['continents']) ? implode(', ', $result['continents']) : 'N/A'; ?>
                                </p>
                            </div>
                            
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <i class="fas fa-clock text-2xl text-green-500 mb-2"></i>
                                <h4 class="font-semibold text-green-800">Zona Horaria</h4>
                                <p class="text-green-700">
                                    <?php echo isset($result['timezones']) ? $result['timezones'][0] : 'N/A'; ?>
                                </p>
                            </div>
                            
                            <div class="bg-purple-50 rounded-lg p-4 text-center">
                                <i class="fas fa-car text-2xl text-purple-500 mb-2"></i>
                                <h4 class="font-semibold text-purple-800">Conducción</h4>
                                <p class="text-purple-700">
                                    <?php echo isset($result['car']['side']) ? ucfirst($result['car']['side']) : 'N/A'; ?>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Enlaces útiles -->
                        <div class="mt-8 flex flex-wrap gap-4 justify-center">
                            <?php if (isset($result['maps']['googleMaps'])): ?>
                                <a href="<?php echo $result['maps']['googleMaps']; ?>" 
                                   target="_blank" 
                                   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                                    <i class="fas fa-map-marked-alt mr-2"></i>Ver en Google Maps
                                </a>
                            <?php endif; ?>
                            
                            <?php if (isset($result['maps']['openStreetMaps'])): ?>
                                <a href="<?php echo $result['maps']['openStreetMaps']; ?>" 
                                   target="_blank" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                                    <i class="fas fa-map mr-2"></i>OpenStreetMap
                                </a>
                            <?php endif; ?>
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

            <!-- Países sugeridos -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Países populares:</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    <?php 
                    $countries = [
                        ['label' => 'Dominican Republic', 'search' => 'Dominican', 'flag' => '🇩🇴'],
                        ['label' => 'USA', 'search' => 'USA', 'flag' => '🇺🇸'],
                        ['label' => 'Spain', 'search' => 'Spain', 'flag' => '🇪🇸'],
                        ['label' => 'Japan', 'search' => 'Japan', 'flag' => '🇯🇵'],
                        ['label' => 'France', 'search' => 'France', 'flag' => '🇫🇷'],
                        ['label' => 'Germany', 'search' => 'Germany', 'flag' => '🇩🇪'],
                        ['label' => 'Brazil', 'search' => 'Brazil', 'flag' => '🇧🇷'],
                        ['label' => 'Canada', 'search' => 'Canada', 'flag' => '🇨🇦']
                    ];
                    foreach ($countries as $country): 
                    ?>
                        <button onclick="searchCountry('<?php echo $country['search']; ?>')" 
                                class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-2 rounded-lg text-sm transition-colors duration-300 flex items-center justify-center">
                            <span class="mr-2"><?php echo $country['flag']; ?></span>
                            <?php echo $country['label']; ?>
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
        function searchCountry(countryName) {
            document.getElementById('country').value = countryName;
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>