# Portal APIs - Ronny Ariel De León Abreu

Un portal web dinámico desarrollado en PHP que integra 10 APIs diferentes para demostrar el consumo de servicios web externos y la creación de interfaces interactivas.

![Portal APIs](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 📋 Descripción

Este proyecto es un portal web que consume múltiples APIs externas para proporcionar información diversa como predicción de género y edad, datos meteorológicos, información de Pokémon, noticias, conversión de monedas, y más. Está diseñado con un enfoque responsive y moderno utilizando TailwindCSS.

## ✨ Características Principales

- **10 APIs Integradas**: Diversas funcionalidades desde predicción de datos hasta entretenimiento
- **Diseño Responsive**: Compatible con dispositivos móviles, tablets y desktop
- **Interfaz Moderna**: Utiliza TailwindCSS para un diseño atractivo y profesional
- **Manejo de Errores**: Gestión adecuada de errores de conexión y respuestas de APIs
- **Optimización**: Código limpio y optimizado para rendimiento
- **Accesibilidad**: Implementación de buenas prácticas de accesibilidad web

## 🚀 APIs Incluidas

1. **Predicción de Género** - Predice el género basado en un nombre
2. **Predicción de Edad** - Estima la edad basada en un nombre
3. **Universidades** - Busca universidades por país
4. **Clima Mundial** - Información meteorológica actual
5. **Pokémon Info** - Datos detallados de Pokémon
6. **Noticias WordPress** - Últimas noticias de sitios web
7. **Conversión de Monedas** - Convierte USD a otras monedas
8. **Generador de Imágenes** - Búsqueda de imágenes por palabra clave
9. **Datos de Países** - Información detallada de países del mundo
10. **Generador de Chistes** - Chistes aleatorios en inglés

## 🛠️ Requisitos del Sistema

### Requisitos Mínimos
- **PHP**: 7.4 o superior
- **Servidor Web**: Apache, Nginx, o servidor de desarrollo PHP
- **Extensiones PHP**:
  - `curl` (para realizar peticiones HTTP)
  - `json` (para manejo de JSON)
  - `mbstring` (para manejo de cadenas multibyte)

### Requisitos Recomendados
- **PHP**: 8.0 o superior
- **Memoria**: 128MB o más
- **Conexión a Internet**: Requerida para el consumo de APIs

## 📦 Instalación

### Opción 1: Servidor Local (XAMPP/WAMP/MAMP)

1. **Descargar e instalar XAMPP**:
   ```bash
   # Descargar desde: https://www.apachefriends.org/
   ```

2. **Clonar o descargar el proyecto**:
   ```bash
   git clone https://github.com/Ronny-Abreu/Portal-Apis.git
   # O descargar el ZIP y extraer
   ```

3. **Mover el proyecto a la carpeta del servidor**:
   ```bash
   # Para XAMPP en Windows
   C:\xampp\htdocs\portal-apis\


4. **Iniciar los servicios**:
   - Abrir el Panel de Control de XAMPP
   - Iniciar Apache
   - Iniciar MySQL

5. **Acceder al portal**:
   ```
   http://localhost/portal-apis/
   ```


## 🔧 Configuración

### Configuración Básica

El proyecto no requiere configuración adicional para funcionar.


## 📁 Estructura del Proyecto

```
portal-apis/
├── assets/
│   ├── css/
│   │   └── style.css          # Estilos personalizados
│   ├── js/
│   │   └── main.js           # JavaScript principal
│   └── images/
│       └── profile.jpg       # Foto de perfil
├── includes/
│   ├── header.php           # Header común
│   ├── footer.php           # Footer común
│   └── functions.php        # Funciones auxiliares
├── pages/
│   ├── about.php           # Página de información
│   ├── age.php             # API de predicción de edad
│   ├── countries.php       # API de datos de países
│   ├── currency.php        # API de conversión de monedas
│   ├── gender.php          # API de predicción de género
│   ├── images.php          # API de búsqueda de imágenes
│   ├── jokes.php           # API de chistes
│   ├── news.php            # API de noticias
│   ├── pokemon.php         # API de Pokémon
│   ├── universities.php    # API de universidades
│   └── weather.php         # API del clima
├── index.php               # Página principal
└── README.md              # Este archivo
```

## 🎯 Uso del Portal

### Navegación Principal

1. **Página de Inicio**: Muestra todas las APIs disponibles en tarjetas interactivas
2. **Menú de Navegación**: Acceso rápido a todas las funcionalidades
3. **Footer**: Enlaces adicionales y información de contacto

### Funcionalidades por API

#### Predicción de Género/Edad
- Ingresa un nombre en el formulario
- Obtén predicciones basadas en datos estadísticos
- Visualiza probabilidades y confianza de la predicción

#### Información del Clima
- Busca por ciudad o país
- Obtén temperatura, humedad, y condiciones actuales
- Visualiza iconos representativos del clima

#### Datos de Pokémon
- Busca por nombre o número de Pokédex
- Visualiza estadísticas, tipos, y habilidades
- Imágenes oficiales de cada Pokémon

#### Conversión de Monedas
- Convierte desde USD a múltiples monedas
- Tasas de cambio actualizadas en tiempo real
- Historial de conversiones

Cada API tiene su propia interfaz optimizada con funcionalidades específicas.

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Para contribuir:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request


## 👨‍💻 Autor

**Ronny Ariel De León Abreu**

```

Este README.md proporciona una guía completa para instalar, configurar y ejecutar el portal web dinámico con APIs. Incluye:

1. **Descripción detallada** del proyecto y sus características
2. **Instrucciones de instalación** para diferentes entornos
3. **Estructura del proyecto** claramente explicada
4. **Guía de uso** para cada funcionalidad
5. **Solución de problemas** comunes
6. **Información de despliegue** en producción
7. **Detalles técnicos** y requisitos del sistema

