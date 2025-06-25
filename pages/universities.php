<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['country'])) {
    $country = trim($_POST['country']);
    if (!empty($country)) {
        $url = "http://universities.hipolabs.com/search?country=" . urlencode($country);
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && is_array($data) && count($data) > 0) {
                $result = $data;
            } else {
                $error = "No se encontraron universidades para este país. Verifica que el nombre esté en inglés.";
            }
        } else {
            $error = "Error al conectar con la API. Inténtalo más tarde.";
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
    <title>Universidades por País - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🎓</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Universidades por País</h1>
                <p class="text-gray-600">Explora instituciones educativas superiores alrededor del mundo</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-globe mr-2"></i>Nombre del país (en inglés)
                        </label>
                        <input type="text" 
                               id="country" 
                               name="country" 
                               value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ej: Dominican Republic, United States, Spain..."
                               required>
                    </div>
                    <button type="submit" class="btn-university w-full">
                        <i class="fas fa-search mr-2"></i>Buscar Universidades
                    </button>
                </form>
            </div>

            <!-- Results -->
            <?php if ($result): ?>
                <div class="mb-6">
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-800">
                                Universidades en <?php echo htmlspecialchars($_POST['country']); ?>
                            </h2>
                            <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                                <?php echo count($result); ?> encontradas
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($result as $index => $university): ?>
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in" 
                             style="animation-delay: <?php echo $index * 0.1; ?>s">
                            <div class="p-6">
                                <!-- Header de la universidad -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                            <?php echo htmlspecialchars($university['name']); ?>
                                        </h3>
                                        <div class="flex items-center text-sm text-gray-600 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            <?php echo htmlspecialchars($university['country']); ?>
                                            <?php if (!empty($university['state-province'])): ?>
                                                , <?php echo htmlspecialchars($university['state-province']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-2xl ml-2">🏛️</div>
                                </div>

                                <!-- Información de contacto -->
                                <div class="space-y-3 mb-4">
                                    <?php if (!empty($university['domains'])): ?>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-globe text-blue-500 mr-2 w-4"></i>
                                            <span class="text-gray-600 truncate">
                                                <?php echo htmlspecialchars($university['domains'][0]); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-flag text-green-500 mr-2 w-4"></i>
                                        <span class="text-gray-600">
                                            Código: <?php echo htmlspecialchars($university['alpha_two_code']); ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="flex space-x-2">
                                    <?php if (!empty($university['web_pages'])): ?>
                                        <a href="<?php echo htmlspecialchars($university['web_pages'][0]); ?>" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white text-center py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-300">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            Visitar
                                        </a>
                                    <?php endif; ?>
                                    
                                    <button onclick="copyUniversityInfo('<?php echo addslashes($university['name']); ?>', '<?php echo addslashes($university['web_pages'][0] ?? ''); ?>')"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg text-sm transition-colors duration-300">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Estadísticas -->
                <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-chart-bar mr-2"></i>Estadísticas
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-600"><?php echo count($result); ?></div>
                            <div class="text-sm text-gray-600">Total Universidades</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                <?php echo count(array_filter($result, function($u) { return !empty($u['web_pages']); })); ?>
                            </div>
                            <div class="text-sm text-gray-600">Con Sitio Web</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                <?php echo count(array_unique(array_column($result, 'state-province'))); ?>
                            </div>
                            <div class="text-sm text-gray-600">Estados/Provincias</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">
                                <?php echo count(array_unique(array_column($result, 'alpha_two_code'))); ?>
                            </div>
                            <div class="text-sm text-gray-600">Códigos de País</div>
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
                        'Dominican Republic' => '🇩🇴',
                        'United States' => '🇺🇸',
                        'Spain' => '🇪🇸',
                        'Mexico' => '🇲🇽',
                        'Colombia' => '🇨🇴',
                        'Argentina' => '🇦🇷',
                        'Brazil' => '🇧🇷',
                        'Chile' => '🇨🇱'
                    ];
                    foreach ($countries as $country => $flag): 
                    ?>
                        <button onclick="searchCountry('<?php echo $country; ?>')" 
                                class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 px-3 py-2 rounded-lg text-sm transition-colors duration-300 flex items-center justify-center">
                            <span class="mr-2"><?php echo $flag; ?></span>
                            <?php echo $country; ?>
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

        function copyUniversityInfo(name, website) {
            const text = `Universidad: ${name}\nSitio web: ${website}`;
            navigator.clipboard.writeText(text).then(function() {
                showNotification('Información copiada al portapapeles', 'success');
            }, function(err) {
                showNotification('Error al copiar', 'error');
            });
        }
    </script>
</body>
</html>