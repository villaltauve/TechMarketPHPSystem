# TechMarket PHP System

TechMarket es un sistema de comercio electrónico desarrollado en PHP que permite la gestión de productos, carrito de compras, usuarios y administración de contenido.

## 🚀 Características

- Sistema de autenticación de usuarios
- Catálogo de productos
- Carrito de compras
- Sistema de reseñas
- Panel de administración
- Gestión de favoritos
- Sistema de facturación
- Checkout seguro

## 📁 Estructura del Proyecto

```
TechMarketPHPSystem/
├── assets/         # Recursos estáticos (CSS, JS, imágenes)
├── config/         # Configuraciones del sistema
├── controllers/    # Controladores de la aplicación
├── libs/          # Bibliotecas y utilidades
├── models/        # Modelos de datos
└── views/         # Vistas y plantillas
```

## 🛠️ Tecnologías Utilizadas

- PHP
- MySQL
- HTML/CSS
- JavaScript
- XAMPP (Servidor local)

## 🔧 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web Apache
- XAMPP (recomendado)

## 🚀 Instalación

1. Clona este repositorio en tu directorio htdocs de XAMPP:
   ```bash
   git clone [URL_DEL_REPOSITORIO]
   ```

2. Importa la base de datos:
   - Accede a phpMyAdmin
   - Crea una nueva base de datos
   - Importa el archivo de base de datos desde la carpeta `config`

3. Configura la conexión a la base de datos:
   - Edita el archivo `config/database.php`
   - Actualiza las credenciales según tu configuración

4. Inicia los servicios de XAMPP:
   - Apache
   - MySQL

5. Accede al sistema a través de:
   ```
   http://localhost/TechMarketPHPSystem
   ```

## 📋 Módulos Principales

### Usuarios
- Registro
- Inicio de sesión
- Gestión de perfil
- Favoritos

### Productos
- Catálogo
- Detalles de producto
- Búsqueda
- Filtros

### Carrito
- Agregar/eliminar productos
- Actualizar cantidades
- Calcular totales

### Administración
- Gestión de productos
- Gestión de usuarios
- Gestión de pedidos
- Estadísticas

### Checkout
- Proceso de pago
- Generación de facturas
- Confirmación de pedidos

## 🔐 Seguridad

- Autenticación segura
- Protección contra SQL Injection
- Validación de datos
- Sesiones seguras
