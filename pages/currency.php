<?php
session_start();
include_once '../includes/functions.php';

$result = null;
$error = null;

if ($_POST && isset($_POST['amount'])) {
    $amount = floatval($_POST['amount']);
    if ($amount > 0) {
        $url = "https://api.exchangerate-api.com/v4/latest/USD";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Portal-APIs/1.0'
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if ($data && isset($data['rates'])) {
                $result = [
                    'amount' => $amount,
                    'rates' => $data['rates'],
                    'date' => $data['date'] ?? date('Y-m-d')
                ];
            } else {
                $error = "No se pudieron obtener las tasas de cambio.";
            }
        } else {
            $error = "Error al conectar con el servicio de cambio de monedas.";
        }
    } else {
        $error = "Por favor, ingresa una cantidad válida mayor a 0.";
    }
}

// Monedas principales para mostrar
$mainCurrencies = [
    'DOP' => ['name' => 'Peso Dominicano', 'symbol' => 'RD$', 'flag' => '🇩🇴'],
    'EUR' => ['name' => 'Euro', 'symbol' => '€', 'flag' => '🇪🇺'],
    'GBP' => ['name' => 'Libra Esterlina', 'symbol' => '£', 'flag' => '🇬🇧'],
    'JPY' => ['name' => 'Yen Japonés', 'symbol' => '¥', 'flag' => '🇯🇵'],
    'CAD' => ['name' => 'Dólar Canadiense', 'symbol' => 'C$', 'flag' => '🇨🇦'],
    'AUD' => ['name' => 'Dólar Australiano', 'symbol' => 'A$', 'flag' => '🇦🇺'],
    'CHF' => ['name' => 'Franco Suizo', 'symbol' => 'CHF', 'flag' => '🇨🇭'],
    'CNY' => ['name' => 'Yuan Chino', 'symbol' => '¥', 'flag' => '🇨🇳']
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversión de Monedas - Portal APIs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen">
    <?php include '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">💰</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Conversión de Monedas</h1>
                <p class="text-gray-600">Convierte dólares estadounidenses a otras monedas del mundo</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign mr-2"></i>Cantidad en USD
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">$</span>
                            <input type="number" 
                                   id="amount" 
                                   name="amount" 
                                   step="0.01"
                                   min="0.01"
                                   value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : ''; ?>"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                                   placeholder="100.00"
                                   required>
                        </div>
                    </div>
                    <button type="submit" class="btn-currency w-full">
                        <i class="fas fa-exchange-alt mr-2"></i>Convertir Moneda
                    </button>
                </form>
            </div>

            <!-- Resultados -->
            <?php if ($result): ?>
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8 animate-fade-in">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">
                            Conversión de $<?php echo number_format($result['amount'], 2); ?> USD
                        </h2>
                        <p class="text-gray-600">Tasas actualizadas: <?php echo $result['date']; ?></p>
                    </div>
                    
                    <!-- Monedas principales -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <?php foreach ($mainCurrencies as $code => $currency): ?>
                            <?php if (isset($result['rates'][$code])): ?>
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border border-green-200 hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-2xl"><?php echo $currency['flag']; ?></span>
                                        <span class="text-xs text-gray-500"><?php echo $code; ?></span>
                                    </div>
                                    <div class="text-lg font-bold text-gray-800 mb-1">
                                        <?php echo $currency['symbol']; ?><?php echo number_format($result['amount'] * $result['rates'][$code], 2); ?>
                                    </div>
                                    <div class="text-xs text-gray-600"><?php echo $currency['name']; ?></div>
                                    <div class="text-xs text-green-600 mt-1">
                                        1 USD = <?php echo number_format($result['rates'][$code], 4); ?> <?php echo $code; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Destacando peso dominicano -->
                    <?php if (isset($result['rates']['DOP'])): ?>
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white mb-6">
                            <div class="text-center">
                                <div class="text-4xl mb-2">🇩🇴</div>
                                <h3 class="text-xl font-bold mb-2">Peso Dominicano (DOP)</h3>
                                <div class="text-3xl font-bold mb-2">
                                    RD$<?php echo number_format($result['amount'] * $result['rates']['DOP'], 2); ?>
                                </div>
                                <div class="text-sm opacity-90">
                                    Tasa: 1 USD = <?php echo number_format($result['rates']['DOP'], 2); ?> DOP
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Calculadora rápida -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-calculator mr-2"></i>Calculadora Rápida
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <?php 
                            $quickAmounts = [10, 50, 100, 500];
                            foreach ($quickAmounts as $quickAmount): 
                            ?>
                                <div class="text-center p-3 bg-white rounded border">
                                    <div class="font-bold text-gray-800">$<?php echo $quickAmount; ?> USD</div>
                                    <div class="text-sm text-gray-600">
                                        RD$<?php echo number_format($quickAmount * $result['rates']['DOP'], 0); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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

            <!-- Cantidades sugeridas -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Cantidades populares:</h3>
                <div class="flex flex-wrap gap-2">
                    <?php 
                    $amounts = [1, 10, 25, 50, 100, 250, 500, 1000];
                    foreach ($amounts as $amount): 
                    ?>
                        <button onclick="setAmount(<?php echo $amount; ?>)" 
                                class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm transition-colors duration-300">
                            $<?php echo $amount; ?>
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
        function setAmount(amount) {
            document.getElementById('amount').value = amount;
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>