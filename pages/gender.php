<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $url = "https://api.genderize.io/?name=" . urlencode($name);
        $response = file_get_contents($url);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && isset($data['gender'])) {
                $result = $data;
            } else {
                $error = "No se pudo determinar el género para este nombre.";
            }
        } else {
            $error = "Error al conectar con la API. Inténtalo más tarde.";
        }
    } else {
        $error = "Por favor, ingresa un nombre válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicción de Género - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-pink-50 via-blue-50 to-purple-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">👦👧</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Predicción de Género</h1>
                <p class="text-gray-600">Descubre si un nombre es típicamente masculino o femenino</p>
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ej: María, Juan, Alex..."
                               required>
                    </div>
                    <button type="submit" class="btn-primary w-full">
                        <i class="fas fa-search mr-2"></i>Predecir Género
                    </button>
                </form>
            </div>

            <!-- Results -->
            <?php if ($result): ?>
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8 animate-fade-in">
                    <div class="text-center">
                        <?php 
                        $bgColor = $result['gender'] === 'female' ? 'from-pink-400 to-pink-600' : 'from-blue-400 to-blue-600';
                        $textColor = $result['gender'] === 'female' ? 'text-pink-600' : 'text-blue-600';
                        $icon = $result['gender'] === 'female' ? '👧' : '👦';
                        ?>
                        
                        <div class="w-24 h-24 bg-gradient-to-r <?php echo $bgColor; ?> rounded-full flex items-center justify-center text-4xl mb-4 mx-auto">
                            <?php echo $icon; ?>
                        </div>
                        
                        <h3 class="text-2xl font-bold <?php echo $textColor; ?> mb-2">
                            <?php echo ucfirst($result['name']); ?>
                        </h3>
                        
                        <p class="text-lg text-gray-700 mb-4">
                            Es típicamente <strong><?php echo $result['gender'] === 'female' ? 'Femenino' : 'Masculino'; ?></strong>
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="font-semibold text-gray-700">Probabilidad</div>
                                <div class="text-2xl font-bold <?php echo $textColor; ?>">
                                    <?php echo round($result['probability'] * 100); ?>%
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="font-semibold text-gray-700">Muestras</div>
                                <div class="text-2xl font-bold text-gray-800">
                                    <?php echo number_format($result['count']); ?>
                                </div>
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