<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог - Клуб любителей сладостей</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <h1 class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">Клуб любителей сладостей</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php#about">О нас</a></li>
                    <li><a href="catalog.php" class="active">Каталог</a></li>
                    <li><a href="cart.php">Корзина (<span id="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?></span>)</a></li>
                    <li><a href="index.php#location">Где нас найти?</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><a href="#" class="btn-login"><?= htmlspecialchars($_SESSION['user_name']) ?></a></li>
                        <li><form action="auth.php" method="POST" style="display:inline;"><input type="hidden" name="action" value="logout"><button type="submit" style="background:none;border:none;cursor:pointer;color:inherit;font-weight:500;">Выйти</button></form></li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-login">Вход в аккаунт</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="section bg-alt">
            <div class="container">
                <h2>Наш сладкий ассортимент</h2>
                <div class="catalog-grid">
                    <!-- Product 1 -->
                    <div class="product-card">
                        <img src="pic/Cupcake.jpg" alt="Нежный Капкейк" class="product-image">
                        <h3>Нежный Капкейк</h3>
                        <p>Ванильный бисквит с клубничным кремом.</p>
                        <span class="price">150 ₽</span>
                        <button class="btn-buy" data-name="Нежный Капкейк" data-price="150" data-image="pic/Cupcake.jpg">Купить</button>
                    </div>
                    <!-- Product 2 -->
                    <div class="product-card">
                        <img src="pic/Donut.jpg" alt="Пончик Глазурь" class="product-image">
                        <h3>Пончик "Глазурь"</h3>
                        <p>Классический пончик с розовой глазурью.</p>
                        <span class="price">100 ₽</span>
                        <button class="btn-buy" data-name="Пончик Глазурь" data-price="100" data-image="pic/Donut.jpg">Купить</button>
                    </div>
                    <!-- Product 3 -->
                    <div class="product-card">
                        <img src="pic/Cheesecake.jpg" alt="Чизкейк Нью-Йорк" class="product-image">
                        <h3>Чизкейк Нью-Йорк</h3>
                        <p>Классический сливочный вкус.</p>
                        <span class="price">250 ₽</span>
                        <button class="btn-buy" data-name="Чизкейк Нью-Йорк" data-price="250" data-image="pic/Cheesecake.jpg">Купить</button>
                    </div>
                    <!-- Product 4 -->
                    <div class="product-card">
                        <img src="pic/Macaron.jpg" alt="Печенье Макарон" class="product-image">
                        <h3>Печенье Макарон</h3>
                        <p>Набор из 5 штук разных вкусов.</p>
                        <span class="price">400 ₽</span>
                        <button class="btn-buy" data-name="Печенье Макарон" data-price="400" data-image="pic/Macaron.jpg">Купить</button>
                    </div>
                     <!-- Product 5 -->
                     <div class="product-card">
                        <img src="pic/ice cream.jpg" alt="Мороженое Радуга" class="product-image">
                        <h3>Мороженое "Радуга"</h3>
                        <p>Три шарика фруктового мороженого.</p>
                        <span class="price">120 ₽</span>
                        <button class="btn-buy" data-name="Мороженое Радуга" data-price="120" data-image="pic/ice cream.jpg">Купить</button>
                    </div>
                    <!-- Product 6 -->
                    <div class="product-card">
                        <img src="pic/Croissant.jpg" alt="Круассан с шоколадом" class="product-image">
                        <h3>Круассан с шоколадом</h3>
                        <p>Слоеное тесто и бельгийский шоколад.</p>
                        <span class="price">180 ₽</span>
                        <button class="btn-buy" data-name="Круассан с шоколадом" data-price="180" data-image="pic/Croissant.jpg">Купить</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Клуб любителей сладостей. Все права защищены.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
