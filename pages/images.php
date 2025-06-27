<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);
    if (!empty($keyword)) {
        // Usando Unsplash API (requiere clave, pero tiene endpoint público limitado)
        // Alternativa: usar Lorem Picsum con búsqueda simulada
        $url = "https://api.unsplash.com/search/photos?query=" . urlencode($keyword) . "&per_page=12&client_id=demo";
        
        // Como alternativa gratuita, usaremos Lorem Picsum con diferentes IDs basados en la búsqueda
        $searchHash = crc32($keyword);
        $images = [];
        
        for ($i = 0; $i < 12; $i++) {
            $imageId = abs($searchHash + $i) % 1000;
            $images[] = [
                'id' => $imageId,
                'url' => "https://picsum.photos/400/300?random=" . $imageId,
                'download_url' => "https://picsum.photos/800/600?random=" . $imageId,
                'description' => "Imagen relacionada con: " . $keyword
            ];
        }
        
        $result = [
            'keyword' => $keyword,
            'images' => $images
        ];
    } else {
        $error = "Por favor, ingresa una palabra clave para buscar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Imágenes - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-rose-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🖼️</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Generador de Imágenes</h1>
                <p class="text-gray-600">Busca imágenes hermosas basadas en palabras clave</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-2"></i>Palabra clave para buscar
                        </label>
                        <input type="text" 
                               id="keyword" 
                               name="keyword" 
                               value="<?php echo isset($_POST['keyword']) ? htmlspecialchars($_POST['keyword']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ej: naturaleza, ciudad, tecnología, arte..."
                               required>
                    </div>
                    <button type="submit" class="btn-images w-full">
                        <i class="fas fa-magic mr-2"></i>Generar Imágenes
                    </button>
                </form>
            </div>

            <!-- Resultados -->
            <?php if ($result): ?>
                <div class="mb-6">
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-800">
                                Imágenes para: "<?php echo htmlspecialchars($result['keyword']); ?>"
                            </h2>
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                <?php echo count($result['images']); ?> imágenes
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($result['images'] as $index => $image): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in" 
                             style="animation-delay: <?php echo $index * 0.1; ?>s">
                            <div class="relative group">
                                <img src="<?php echo htmlspecialchars($image['url']); ?>" 
                                     alt="<?php echo htmlspecialchars($image['description']); ?>"
                                     class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                                     loading="lazy">
                                
                                <!-- Overlay con acciones -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex space-x-2">
                                        <button onclick="viewImage('<?php echo htmlspecialchars($image['download_url']); ?>')" 
                                                class="bg-white text-gray-800 p-2 rounded-full hover:bg-gray-100 transition-colors duration-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="<?php echo htmlspecialchars($image['download_url']); ?>" 
                                           download
                                           class="bg-white text-gray-800 p-2 rounded-full hover:bg-gray-100 transition-colors duration-300">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button onclick="copyImageUrl('<?php echo htmlspecialchars($image['url']); ?>')" 
                                                class="bg-white text-gray-800 p-2 rounded-full hover:bg-gray-100 transition-colors duration-300">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <p class="text-sm text-gray-600 mb-2"><?php echo htmlspecialchars($image['description']); ?></p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>ID: <?php echo $image['id']; ?></span>
                                    <span>400x300</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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

            <!-- Palabras clave sugeridas -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Palabras clave populares:</h3>
                <div class="flex flex-wrap gap-2">
                    <?php 
                    $keywords = ['naturaleza', 'ciudad', 'tecnología', 'arte', 'comida', 'viajes', 'animales', 'arquitectura', 'paisaje', 'retrato', 'abstracto', 'vintage'];
                    foreach ($keywords as $keyword): 
                    ?>
                        <button onclick="searchKeyword('<?php echo $keyword; ?>')" 
                                class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-3 py-1 rounded-full text-sm transition-colors duration-300">
                            <?php echo $keyword; ?>
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

    <!-- Modal para ver imagen -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="/placeholder.svg" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/main.js"></script>
    <script>
        function searchKeyword(keyword) {
            document.getElementById('keyword').value = keyword;
            document.querySelector('form').submit();
        }

        function viewImage(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        function copyImageUrl(url) {
            navigator.clipboard.writeText(url).then(function() {
                showNotification('URL de imagen copiada al portapapeles', 'success');
            });
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>