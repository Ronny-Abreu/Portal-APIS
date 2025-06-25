<header class="bg-white shadow-lg sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-code text-white"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Portal APIs</span>
            </div>
            
            <!-- Mobile menu button -->
            <button class="md:hidden" onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-2xl text-gray-600"></i>
            </button>
            
            <!-- Desktop menu -->
            <div class="hidden md:flex space-x-6">
                <a href="/portal-apis/" class="nav-link">
                    <i class="fas fa-home mr-1"></i>Inicio
                </a>
                <div class="relative group">
                    <button class="nav-link flex items-center">
                        <i class="fas fa-cog mr-1"></i>APIs
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <a href="pages/gender.php" class="dropdown-link">
                            <i class="fas fa-venus-mars mr-2"></i>Género
                        </a>
                        <a href="pages/age.php" class="dropdown-link">
                            <i class="fas fa-birthday-cake mr-2"></i>Edad
                        </a>
                        <a href="pages/universities.php" class="dropdown-link">
                            <i class="fas fa-university mr-2"></i>Universidades
                        </a>
                        <a href="pages/weather.php" class="dropdown-link">
                            <i class="fas fa-cloud-sun mr-2"></i>Clima
                        </a>
                        <a href="pages/pokemon.php" class="dropdown-link">
                            <i class="fas fa-gamepad mr-2"></i>Pokémon
                        </a>
                    </div>
                </div>
                <a href="pages/about.php" class="nav-link">
                    <i class="fas fa-info-circle mr-1"></i>Acerca de
                </a>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobileMenu" class="md:hidden mt-4 hidden">
            <div class="flex flex-col space-y-2">
                <a href="/portal-apis/" class="mobile-nav-link">
                    <i class="fas fa-home mr-2"></i>Inicio
                </a>
                <a href="pages/gender.php" class="mobile-nav-link">
                    <i class="fas fa-venus-mars mr-2"></i>Género
                </a>
                <a href="pages/age.php" class="mobile-nav-link">
                    <i class="fas fa-birthday-cake mr-2"></i>Edad
                </a>
                <a href="pages/universities.php" class="mobile-nav-link">
                    <i class="fas fa-university mr-2"></i>Universidades
                </a>
                <a href="pages/weather.php" class="mobile-nav-link">
                    <i class="fas fa-cloud-sun mr-2"></i>Clima
                </a>
                <a href="pages/pokemon.php" class="mobile-nav-link">
                    <i class="fas fa-gamepad mr-2"></i>Pokémon
                </a>
                <a href="pages/about.php" class="mobile-nav-link">
                    <i class="fas fa-info-circle mr-2"></i>Acerca de
                </a>
            </div>
        </div>
    </nav>
</header>   