<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

// Obtener idioma seleccionado (por POST o por defecto)
$idioma = $_POST['idioma'] ?? ($_SESSION['idioma'] ?? 'en');
$_SESSION['idioma'] = $idioma;

// Cargar chiste automáticamente al entrar o al pedir uno nuevo
$url = "https://official-joke-api.appspot.com/random_joke";

$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'user_agent' => 'Portal-APIs/1.0'
    ]
]);

if ($_POST && isset($_POST['new_joke'])) {
    $response = file_get_contents($url, false, $context);
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && isset($data['setup']) && isset($data['punchline'])) {
            $result = $data;
            $error = null;
        }
    }
} else {
    $response = file_get_contents($url, false, $context);
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && isset($data['setup']) && isset($data['punchline'])) {
            $result = $data;
        } else {
            $error = "No se pudo obtener un chiste en este momento.";
        }
    } else {
        $error = "Error al conectar con el servicio de chistes.";
    }
}

// Si el idioma es español, traducir usando LibreTranslate
if ($result && $idioma == 'es') {
    function traducir($texto, $from, $to) {
        $translate_url = "https://libretranslate.de/translate";
        $opts = [
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/x-www-form-urlencoded",
                "content" => http_build_query([
                    "q" => $texto,
                    "source" => $from,
                    "target" => $to,
                    "format" => "text"
                ])
            ]
        ];
        $context = stream_context_create($opts);
        $response = @file_get_contents($translate_url, false, $context);
        $translated = json_decode($response, true);
        return $translated['translatedText'] ?? $texto;
    }
    $result['setup'] = traducir($result['setup'], 'en', 'es');
    $result['punchline'] = traducir($result['punchline'], 'en', 'es');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Chistes - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🤣</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Generador de Chistes</h1>
                <p class="text-gray-600">¡Ríete con chistes aleatorios en inglés!</p>
            </div>

            <!-- Chiste principal -->
            <?php if ($result): ?>
                <div class="joke-card rounded-xl shadow-lg p-8 mb-8 animate-fade-in">
                    <div class="text-center mb-6">
                        <div class="text-4xl mb-4">😄</div>
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                            <?php echo ucfirst($result['type']); ?>
                        </span>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Setup del chiste -->
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="flex items-start">
                                <div class="text-2xl mr-4">🗣️</div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-2">Setup:</h3>
                                    <p class="text-lg text-gray-700 leading-relaxed">
                                        <?php echo htmlspecialchars($result['setup']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Punchline del chiste -->
                        <div class="bg-gradient-to-r from-yellow-100 to-orange-100 rounded-lg p-6 shadow-sm">
                            <div class="flex items-start">
                                <div class="text-2xl mr-4">💥</div>
                                <div>
                                    <h3 class="font-semibold text-orange-800 mb-2">Punchline:</h3>
                                    <p class="text-lg text-orange-700 leading-relaxed font-medium">
                                        <?php echo htmlspecialchars($result['punchline']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información del chiste -->
                    <div class="mt-6 text-center">
                        <div class="bg-white rounded-lg p-4 inline-block">
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-hashtag mr-1"></i>
                                Chiste ID: <?php echo $result['id']; ?>
                            </span>
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

            <!-- Botones de acción -->
            <div class="text-center mb-8">
                <form method="POST" class="inline-block">
                    <select name="idioma" class="border rounded px-2 py-1 mr-2" onchange="this.form.submit()">
                        <option value="en" <?php if($idioma=='en') echo 'selected'; ?>>Inglés</option>
                        <option value="es" <?php if($idioma=='es') echo 'selected'; ?>>Español</option>
                    </select>
                    <input type="hidden" name="new_joke" value="1">
                    <button type="submit" class="btn-jokes">
                        <i class="fas fa-sync-alt mr-2"></i>Nuevo Chiste
                    </button>
                </form>
                <?php if ($result): ?>
                    <div class="mt-4 flex justify-center space-x-4">
                        <button onclick="shareJoke()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                            <i class="fas fa-share mr-2"></i>Compartir
                        </button>
                        <button onclick="copyJoke()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                            <i class="fas fa-copy mr-2"></i>Copiar
                        </button>
                        <button onclick="rateJoke()" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                            <i class="fas fa-star mr-2"></i>Calificar
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Información -->
  <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
        Sobre los Chistes
    </h3>
    <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
        <div class="flex items-center">
            <i class="fas fa-language mr-2 text-green-500"></i>
            <span>Idioma: <?php echo $idioma == 'es' ? 'Español' : 'Inglés'; ?></span>
        </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-blue-500"></i>
                        <span>Contenido: Familiar</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-random mr-2 text-purple-500"></i>
                        <span>Tipo: Aleatorio</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-orange-500"></i>
                        <span>Actualización: Tiempo real</span>
                    </div>
                </div>
            </div>

            <!-- Estadísticas o algo más -->
            <div class="bg-gradient-to-r from-yellow-100 to-orange-100 rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-orange-800 mb-4 text-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    ¿Sabías que...?
                </h3>
                <div class="grid md:grid-cols-2 gap-4 text-center">
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-2xl font-bold text-orange-600">😂</div>
                        <div class="text-sm text-gray-600 mt-2">
                            Reír 15 minutos al día quema hasta 40 calorías
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-2xl font-bold text-yellow-600">🧠</div>
                        <div class="text-sm text-gray-600 mt-2">
                            Los chistes activan múltiples áreas del cerebro
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
    <script>
        function shareJoke() {
            const setup = "<?php echo addslashes($result['setup'] ?? ''); ?>";
            const punchline = "<?php echo addslashes($result['punchline'] ?? ''); ?>";
            const text = `${setup}\n\n${punchline}\n\n#Joke #PortalAPIs`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Chiste Divertido',
                    text: text
                });
            } else {
                navigator.clipboard.writeText(text).then(function() {
                    showNotification('Chiste copiado al portapapeles', 'success');
                });
            }
        }

        function copyJoke() {
            const setup = "<?php echo addslashes($result['setup'] ?? ''); ?>";
            const punchline = "<?php echo addslashes($result['punchline'] ?? ''); ?>";
            const text = `${setup}\n\n${punchline}`;
            
            navigator.clipboard.writeText(text).then(function() {
                showNotification('Chiste copiado al portapapeles', 'success');
            });
        }

        function rateJoke() {
            const rating = prompt('¿Cómo calificarías este chiste del 1 al 5?');
            if (rating && rating >= 1 && rating <= 5) {
                showNotification(`¡Gracias por calificar con ${rating} estrellas!`, 'success');
            }
        }

        setInterval(function() {
            document.querySelector('form').submit();
        }, 30000);
    </script>
</body>
</html>