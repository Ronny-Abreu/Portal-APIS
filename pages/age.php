<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $url = "https://api.agify.io/?name=" . urlencode($name);
        $response = file_get_contents($url);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && isset($data['age']) && $data['age'] !== null) {
                $result = $data;
            } else {
                $error = "No se pudo determinar la edad para este nombre.";
            }
        } else {
            $error = "Error al conectar con la API. Inténtalo más tarde.";
        }
    } else {
        $error = "Por favor, ingresa un nombre válido.";
    }
}

// Función para determinar categoría de edad
function getAgeCategory($age) {
    if ($age <= 12) {
        return ['category' => 'Niño/a', 'icon' => '👶', 'color' => 'green', 'bg' => 'from-green-400 to-green-600'];
    } elseif ($age <= 17) {
        return ['category' => 'Adolescente', 'icon' => '🧒', 'color' => 'blue', 'bg' => 'from-blue-400 to-blue-600'];
    } elseif ($age <= 30) {
        return ['category' => 'Joven', 'icon' => '🧑', 'color' => 'purple', 'bg' => 'from-purple-400 to-purple-600'];
    } elseif ($age <= 60) {
        return ['category' => 'Adulto', 'icon' => '👨‍💼', 'color' => 'indigo', 'bg' => 'from-indigo-400 to-indigo-600'];
    } else {
        return ['category' => 'Adulto Mayor', 'icon' => '👴', 'color' => 'gray', 'bg' => 'from-gray-400 to-gray-600'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicción de Edad - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-orange-50 via-yellow-50 to-red-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🎂</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Predicción de Edad</h1>
                <p class="text-gray-600">Descubre la edad estimada basada en un nombre</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Ingresa un nombre
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ej: Carlos, Ana, Miguel..."
                               required>
                    </div>
                    <button type="submit" class="btn-age w-full">
                        <i class="fas fa-birthday-cake mr-2"></i>Predecir Edad
                    </button>
                </form>
            </div>

            <!-- Results -->
            <?php if ($result): ?>
                <?php $ageInfo = getAgeCategory($result['age']); ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 animate-fade-in">
                    <div class="bg-gradient-to-r <?php echo $ageInfo['bg']; ?> p-6 text-white text-center">
                        <div class="text-6xl mb-4"><?php echo $ageInfo['icon']; ?></div>
                        <h2 class="text-3xl font-bold mb-2"><?php echo ucfirst($result['name']); ?></h2>
                        <p class="text-lg opacity-90"><?php echo $ageInfo['category']; ?></p>
                    </div>
                    
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <div class="text-6xl font-bold text-<?php echo $ageInfo['color']; ?>-600 mb-2">
                                <?php echo $result['age']; ?> años
                            </div>
                            <p class="text-gray-600">Edad estimada</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información de la categoría -->
                            <div class="bg-<?php echo $ageInfo['color']; ?>-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-<?php echo $ageInfo['color']; ?>-800 mb-3">
                                    Categoría de Edad
                                </h3>
                                <div class="text-3xl mb-2"><?php echo $ageInfo['icon']; ?></div>
                                <p class="text-<?php echo $ageInfo['color']; ?>-700 font-medium">
                                    <?php echo $ageInfo['category']; ?>
                                </p>
                            </div>
                            
                            <!-- Estadísticas -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Estadísticas</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Muestras analizadas:</span>
                                        <span class="font-bold text-gray-800">
                                            <?php echo number_format($result['count']); ?>
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Rango de edad:</span>
                                        <span class="font-bold text-gray-800">
                                            <?php echo ($result['age'] - 5) . ' - ' . ($result['age'] + 5); ?> años
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Descripción de la categoría -->
                        <div class="mt-6 bg-blue-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-blue-800 mb-3">
                                <i class="fas fa-info-circle mr-2"></i>Sobre esta categoría
                            </h3>
                            <p class="text-blue-700">
                                <?php
                                switch($ageInfo['category']) {
                                    case 'Niño/a':
                                        echo "En esta etapa de la vida, las personas están en pleno desarrollo físico y cognitivo, explorando el mundo que les rodea.";
                                        break;
                                    case 'Adolescente':
                                        echo "Período de transición entre la infancia y la edad adulta, caracterizado por cambios físicos, emocionales y sociales.";
                                        break;
                                    case 'Joven':
                                        echo "Etapa de establecimiento de la identidad personal, formación académica y primeras experiencias laborales.";
                                        break;
                                    case 'Adulto':
                                        echo "Período de mayor estabilidad y productividad, con responsabilidades familiares y profesionales consolidadas.";
                                        break;
                                    case 'Adulto Mayor':
                                        echo "Etapa de sabiduría y experiencia, con contribuciones valiosas basadas en años de vivencias.";
                                        break;
                                }
                                ?>
                            </p>
                        </div>
                        
                        <!-- Barra de progreso de vida -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Progreso de Vida</h3>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-gradient-to-r <?php echo $ageInfo['bg']; ?> h-4 rounded-full transition-all duration-1000" 
                                     style="width: <?php echo min(($result['age'] / 100) * 100, 100); ?>%"></div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 mt-2">
                                <span>0 años</span>
                                <span><?php echo $result['age']; ?> años</span>
                                <span>100+ años</span>
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

            <!-- Nombres sugeridos -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Nombres populares para probar:</h3>
                <div class="flex flex-wrap gap-2">
                    <?php 
                    $names = ['María', 'José', 'Ana', 'Carlos', 'Luis', 'Carmen', 'Antonio', 'Isabel', 'Manuel', 'Rosa'];
                    foreach ($names as $name): 
                    ?>
                        <button onclick="searchName('<?php echo $name; ?>')" 
                                class="bg-orange-100 hover:bg-orange-200 text-orange-800 px-3 py-1 rounded-full text-sm transition-colors duration-300">
                            <?php echo $name; ?>
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
        function searchName(name) {
            document.getElementById('name').value = name;
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>