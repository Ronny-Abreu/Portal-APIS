<?php
// Detectar si estamos en la carpeta pages o en la raíz
$isInPagesFolder = strpos($_SERVER['REQUEST_URI'], '/pages/') !== false;
$basePath = $isInPagesFolder ? '../' : '';
$pagesPath = $isInPagesFolder ? '' : 'pages/';
?>

<footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8">

        <div class="md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-code text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Portal APIs</h3>
                        <p class="text-gray-300 text-sm">Desarrollado por Ronny Ariel De León Abreu</p>
                    </div>
                </div>
                <p class="text-gray-300 mb-4 leading-relaxed">
                    Portal web dinámico que integra múltiples APIs para demostrar el poder de la conectividad 
                    y el intercambio de datos en tiempo real. Construido con PHP, TailwindCSS y JavaScript.
                </p>
                <div class="flex space-x-4">
                    <a href="mailto:dleonabreuronny@gmaill.com" 
                       class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-envelope text-lg"></i>
                    </a>
                    <a href="https://github.com/Ronny-Abreu" 
                       target="_blank" 
                       class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
                        <i class="fab fa-github text-lg"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/ronny-abreu-0a02b6336/" 
                       target="_blank" 
                       class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
                        <i class="fab fa-linkedin text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- APIs Implementadas -->
            <div>
                <h4 class="text-lg font-semibold mb-4 text-blue-400">
                    <i class="fas fa-plug mr-2"></i>APIs Integradas
                </h4>
                <ul class="space-y-2">
                    <li>
                        <a href="<?php echo $pagesPath; ?>gender.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-venus-mars mr-2 text-pink-400"></i>
                            Predicción de Género
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $pagesPath; ?>age.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-birthday-cake mr-2 text-orange-400"></i>
                            Predicción de Edad
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $pagesPath; ?>universities.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-university mr-2 text-indigo-400"></i>
                            Universidades
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $pagesPath; ?>weather.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-cloud-sun mr-2 text-cyan-400"></i>
                            Clima Mundial
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $pagesPath; ?>pokemon.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-gamepad mr-2 text-yellow-400"></i>
                            Información Pokémon
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo $pagesPath; ?>news.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-newspaper mr-2 text-red-400"></i>
                            Noticias WordPress
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo $pagesPath; ?>currency.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-exchange-alt mr-2 text-green-400"></i>
                            Conversión de Monedas
                        </a>
                    </li>

                     <li>
                        <a href="<?php echo $pagesPath; ?>images.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-image mr-2 text-purple-400"></i>
                            Generador de Imágenes
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo $pagesPath; ?>countries.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-globe mr-2 text-blue-400"></i>
                            Datos de Países
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo $pagesPath; ?>jokes.php" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                            <i class="fas fa-laugh mr-2 text-yellow-400"></i>
                            Generador de Chistes
                        </a>
                    </li>
                </ul>
            </div>

            

            <!-- Tecnologías -->
            <div>
                <h4 class="text-lg font-semibold mb-4 text-green-400">
                    <i class="fas fa-tools mr-2"></i>Tecnologías
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fab fa-php text-2xl text-purple-400 mr-3"></i>
                        <div>
                            <div class="text-white font-medium">PHP</div>
                            <div class="text-gray-400 text-xs">Backend & API Integration</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-js-square text-2xl text-yellow-400 mr-3"></i>
                        <div>
                            <div class="text-white font-medium">JavaScript</div>
                            <div class="text-gray-400 text-xs">Interactividad & UX</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-css3-alt text-2xl text-blue-400 mr-3"></i>
                        <div>
                            <div class="text-white font-medium">TailwindCSS</div>
                            <div class="text-gray-400 text-xs">Diseño & Estilos</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-server text-2xl text-red-400 mr-3"></i>
                        <div>
                            <div class="text-white font-medium">XAMPP</div>
                            <div class="text-gray-400 text-xs">Servidor Local</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="border-t border-gray-700 mt-8 pt-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-400">5</div>
                    <div class="text-gray-300 text-sm">APIs Integradas</div>
                </div>
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-green-400">HTML <br> TAILWIND</div>
                    <div class="text-gray-300 text-sm">Frontend</div>
                </div>
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-purple-400">PHP</div>
                    <div class="text-gray-300 text-sm">Backend</div>
                </div>
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-yellow-400">2024-0236</div>
                    <div class="text-gray-300 text-sm">Matrícula</div>
                </div>
            </div>
        </div>

        <!-- Copyright y enlaces adicionales -->
        <div class="border-t border-gray-700 mt-8 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-300 text-sm mb-4 md:mb-0">
                    <p>&copy; <?php echo date('Y'); ?> Ronny Ariel De León Abreu. Todos los derechos reservados.</p>
                    <p class="text-xs text-gray-400 mt-1">
                        Proyecto académico - Portal de integración de APIs
                    </p>
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="<?php echo $pagesPath; ?>about.php" class="text-gray-300 hover:text-white transition-colors duration-300">
                        <i class="fas fa-info-circle mr-1"></i>Acerca de
                    </a>
                    <a href="<?php echo $basePath; ?>index.php" class="text-gray-300 hover:text-white transition-colors duration-300">
                        <i class="fas fa-home mr-1"></i>Inicio
                    </a>
                    <a href="#" onclick="scrollToTop()" class="text-gray-300 hover:text-white transition-colors duration-300">
                        <i class="fas fa-arrow-up mr-1"></i>Subir
                    </a>
                    <span class="text-gray-500">|</span>
                    <span class="text-gray-400 text-xs">
                        <i class="fas fa-clock mr-1"></i>
                        Última actualización: <?php echo date('d/m/Y'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón flotante para volver arriba -->
    <button id="scrollToTopBtn" 
            onclick="scrollToTop()" 
            class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 opacity-0 invisible">
        <i class="fas fa-chevron-up"></i>
    </button>
</footer>

<script>
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Mostrar/ocultar botón de scroll to top
window.addEventListener('scroll', function() {
    const scrollBtn = document.getElementById('scrollToTopBtn');
    if (scrollBtn) {
        if (window.pageYOffset > 300) {
            scrollBtn.classList.remove('opacity-0', 'invisible');
            scrollBtn.classList.add('opacity-100', 'visible');
        } else {
            scrollBtn.classList.add('opacity-0', 'invisible');
            scrollBtn.classList.remove('opacity-100', 'visible');
        }
    }
});
</script>