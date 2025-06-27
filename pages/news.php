<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

// Lista de sitios WordPress disponibles
$wordpressSites = [
    'TechCrunch' => 'https://techcrunch.com/wp-json/wp/v2/posts',
    'WordPress.org News' => 'https://wordpress.org/news/wp-json/wp/v2/posts'
];

if ($_POST && isset($_POST['site'])) {
    $selectedSite = $_POST['site'];
    
    if (array_key_exists($selectedSite, $wordpressSites)) {
        $url = $wordpressSites[$selectedSite] . '?per_page=3&_embed';
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'user_agent' => 'Portal-APIs/1.0'
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && is_array($data) && count($data) > 0) {
                $result = [
                    'site' => $selectedSite,
                    'posts' => $data
                ];
            } else {
                $error = "No se pudieron obtener noticias de este sitio.";
            }
        } else {
            $error = "Error al conectar con el sitio de noticias. Algunos sitios pueden no tener API pública disponible.";
        }
    } else {
        $error = "Sitio no válido seleccionado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias WordPress - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">📰</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Noticias WordPress</h1>
                <p class="text-gray-600">Últimas noticias de sitios web construidos con WordPress</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="site" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-newspaper mr-2"></i>Selecciona un sitio de noticias
                        </label>
                        <select id="site" 
                                name="site" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300"
                                required>
                            <option value="">Selecciona un sitio...</option>
                            <?php foreach ($wordpressSites as $name => $url): ?>
                                <option value="<?php echo htmlspecialchars($name); ?>" 
                                        <?php echo (isset($_POST['site']) && $_POST['site'] === $name) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-news w-full">
                        <i class="fas fa-sync-alt mr-2"></i>Obtener Noticias
                    </button>
                </form>
            </div>

            <!-- Results -->
            <?php if ($result): ?>
                <div class="mb-6">
                    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-globe mr-3 text-red-500"></i>
                                <?php echo htmlspecialchars($result['site']); ?>
                            </h2>
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                <?php echo count($result['posts']); ?> noticias
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-8 md:grid-cols-1 lg:grid-cols-1">
                    <?php foreach ($result['posts'] as $index => $post): ?>
                        <article class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden animate-fade-in" 
                                 style="animation-delay: <?php echo $index * 0.2; ?>s">
                            <div class="md:flex">
                                <!-- Imagen -->
                                <div class="md:w-1/3">
                                    <?php 
                                    $imageUrl = '/placeholder.svg?height=200&width=300';
                                    if (isset($post['_embedded']['wp:featuredmedia'][0]['source_url'])) {
                                        $imageUrl = $post['_embedded']['wp:featuredmedia'][0]['source_url'];
                                    }
                                    ?>
                                    <img src="<?php echo htmlspecialchars($imageUrl); ?>" 
                                         alt="<?php echo htmlspecialchars(strip_tags($post['title']['rendered'])); ?>"
                                         class="w-full h-48 md:h-full object-cover">
                                </div>
                                
                                <!-- Contenido -->
                                <div class="md:w-2/3 p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <?php echo date('d/m/Y H:i', strtotime($post['date'])); ?>
                                        <?php if (isset($post['_embedded']['author'][0]['name'])): ?>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-user mr-1"></i>
                                            <?php echo htmlspecialchars($post['_embedded']['author'][0]['name']); ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                                        <?php echo strip_tags($post['title']['rendered']); ?>
                                    </h3>
                                    
                                    <div class="text-gray-600 mb-4 line-clamp-3">
                                        <?php 
                                        $excerpt = strip_tags($post['excerpt']['rendered']);
                                        echo strlen($excerpt) > 200 ? substr($excerpt, 0, 200) . '...' : $excerpt;
                                        ?>
                                    </div>
                                    
                                    <!-- Categorías -->
                                    <?php if (isset($post['_embedded']['wp:term'][0]) && !empty($post['_embedded']['wp:term'][0])): ?>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <?php foreach (array_slice($post['_embedded']['wp:term'][0], 0, 3) as $category): ?>
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex justify-between items-center">
                                        <a href="<?php echo htmlspecialchars($post['link']); ?>" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-300">
                                            <i class="fas fa-external-link-alt mr-2"></i>Leer más
                                        </a>
                                        
                                        <button onclick="shareArticle('<?php echo addslashes($post['title']['rendered']); ?>', '<?php echo addslashes($post['link']); ?>')"
                                                class="text-gray-500 hover:text-red-500 transition-colors duration-300">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Error -->
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-red-700 font-medium"><?php echo htmlspecialchars($error); ?></p>
                            <p class="text-red-600 text-sm mt-1">
                                Nota: Algunos sitios pueden no tener su API REST de WordPress disponible públicamente.
                            </p>
                        </div>
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
    <script>
        function shareArticle(title, url) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                });
            } else {
                // Fallback para navegadores que no soportan Web Share API
                const text = `${title} - ${url}`;
                navigator.clipboard.writeText(text).then(function() {
                    showNotification('Enlace copiado al portapapeles', 'success');
                });
            }
        }
    </script>
</body>
</html>