<!-- header.php -->
<header>
    <nav>
        <div><a href="index.php?acc=Home" class="logo">TechMarket</a></div>
        <ul>
            <li><a href="index.php?acc=Home">Inicio</a></li>
            <li><a href="index.php?acc=Products">Productos</a></li>
            <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
                <li><a href="index.php?acc=Cart">Carrito</a></li>
                 <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="index.php?acc=Admin">Administrar</a></li>
                <?php endif; ?>
                <li><a href="index.php?acc=logout">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

