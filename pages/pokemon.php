<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['pokemon'])) {
    $pokemon = trim(strtolower($_POST['pokemon']));
    if (!empty($pokemon)) {
        $url = "https://pokeapi.co/api/v2/pokemon/" . urlencode($pokemon);
        $response = file_get_contents($url);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && isset($data['name'])) {
                $result = $data;
            } else {
                $error = "No se encontró información para este Pokémon.";
            }
        } else {
            $error = "Pokémon no encontrado. Verifica el nombre e inténtalo de nuevo.";
        }
    } else {
        $error = "Por favor, ingresa el nombre de un Pokémon.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Pokémon - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-yellow-50 via-red-50 to-blue-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">⚡</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Información Pokémon</h1>
                <p class="text-gray-600">Descubre todo sobre tu Pokémon favorito</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="pokemon" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-2"></i>Nombre del Pokémon
                        </label>
                        <input type="text" 
                               id="pokemon" 
                               name="pokemon" 
                               value="<?php echo isset($_POST['pokemon']) ? htmlspecialchars($_POST['pokemon']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ej: pikachu, charizard, mewtwo..."
                               required>
                    </div>
                    <button type="submit" class="btn-pokemon w-full">
                        <i class="fas fa-gamepad mr-2"></i>Buscar Pokémon
                    </button>
                </form>
            </div>

            <!-- Resultados -->
            <?php if ($result): ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 animate-fade-in">
                    <div class="bg-gradient-to-r from-yellow-400 via-red-400 to-blue-400 p-6 text-white text-center">
                        <h2 class="text-3xl font-bold capitalize mb-2"><?php echo $result['name']; ?></h2>
                        <p class="text-lg opacity-90">#<?php echo str_pad($result['id'], 3, '0', STR_PAD_LEFT); ?></p>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Imagenes e Info basicas -->
                            <div class="text-center">
                                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                                    <img src="<?php echo $result['sprites']['other']['official-artwork']['front_default'] ?? $result['sprites']['front_default']; ?>" 
                                         alt="<?php echo $result['name']; ?>" 
                                         class="w-48 h-48 mx-auto object-contain">
                                </div>
                                
                                <!-- Audio -->
                                <?php if (isset($result['cries']['latest'])): ?>
                                    <div class="mb-4">
                                        <button onclick="playPokemonSound('<?php echo $result['cries']['latest']; ?>')" 
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                                            <i class="fas fa-volume-up mr-2"></i>Escuchar sonido
                                        </button>
                                        <audio id="pokemonAudio" preload="none">
                                            <source src="<?php echo $result['cries']['latest']; ?>" type="audio/ogg">
                                        </audio>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="bg-blue-50 rounded-lg p-3">
                                        <div class="font-semibold text-blue-700">Altura</div>
                                        <div class="text-xl font-bold text-blue-800">
                                            <?php echo ($result['height'] / 10); ?> m
                                        </div>
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-3">
                                        <div class="font-semibold text-green-700">Peso</div>
                                        <div class="text-xl font-bold text-green-800">
                                            <?php echo ($result['weight'] / 10); ?> kg
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Stadisticas y habilidades -->
                            <div>
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Tipos</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ($result['types'] as $type): ?>
                                            <span class="pokemon-type type-<?php echo $type['type']['name']; ?>">
                                                <?php echo ucfirst($type['type']['name']); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <!-- Habilidades -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Habilidades</h3>
                                    <div class="space-y-2">
                                        <?php foreach ($result['abilities'] as $ability): ?>
                                            <div class="bg-gray-50 rounded-lg p-3">
                                                <span class="font-medium capitalize">
                                                    <?php echo str_replace('-', ' ', $ability['ability']['name']); ?>
                                                </span>
                                                <?php if ($ability['is_hidden']): ?>
                                                    <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full ml-2">
                                                        Oculta
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <!-- Experiencia Base -->
                                <div class="bg-yellow-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Experiencia Base</h3>
                                    <div class="text-2xl font-bold text-yellow-900">
                                        <?php echo number_format($result['base_experience']); ?> XP
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stadisticas -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Estadísticas Base</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <?php foreach ($result['stats'] as $stat): ?>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="text-sm font-medium text-gray-600 mb-1">
                                            <?php echo ucwords(str_replace('-', ' ', $stat['stat']['name'])); ?>
                                        </div>
                                        <div class="text-2xl font-bold text-gray-800">
                                            <?php echo $stat['base_stat']; ?>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                            <div class="bg-gradient-to-r from-blue-400 to-purple-500 h-2 rounded-full" 
                                                 style="width: <?php echo min(($stat['base_stat'] / 200) * 100, 100); ?>%"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
    <script>
        function playPokemonSound(url) {
            const audio = document.getElementById('pokemonAudio');
            audio.src = url;
            audio.play().catch(e => {
                console.log('Error playing audio:', e);
                alert('No se pudo reproducir el sonido del Pokémon');
            });
        }
    </script>
</body>
</html>