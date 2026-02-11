<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Клуб любителей сладостей</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <h1 class="logo">Клуб любителей сладостей</h1>
            <nav>
                <ul>
                    <li><a href="#about">О нас</a></li>
                    <li><a href="#team">Наша команда</a></li>
                    <li><a href="catalog.php">Каталог</a></li>
                    <li><a href="cart.php">Корзина (<span id="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?></span>)</a></li>
                    <li><a href="#location">Где нас найти?</a></li>
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
        <section id="hero" class="hero-section">
            <div class="container">
                <h2>Добро пожаловать в сладкий рай!</h2>
                <p>Самые вкусные торты, пирожные и конфеты ручной работы.</p>
                <a href="catalog.php" class="btn-primary">Смотреть каталог</a>
            </div>
        </section>

        <section id="about" class="section">
            <div class="container about-container">
                <div class="about-text">
                    <h2>О нас</h2>
                    <p>Мы — команда энтузиастов, которые не представляют жизнь без сладкого. С 2010 года мы радуем наших клиентов уникальными десертами, созданными с любовью и только из натуральных ингредиентов. Наш магазин — это место, где сбываются сладкие мечты.</p>
                </div>
                <div class="about-image">
                    <img src="pic/store.jpg" alt="Наш магазин">
                </div>
            </div>
        </section>

        <section id="team" class="section bg-alt">
            <div class="container">
                <h2>Наша команда</h2>
                <p class="section-desc">Люди, которые делают вашу жизнь слаще.</p>
                <div class="team-content">
                    <img src="pic/Team.jpg" alt="Наша команда" class="team-image">
                    <p>Мы — дружный коллектив профессиональных кондитеров. Каждый из нас вкладывает душу в свое творение, будь то маленький капкейк или огромный свадебный торт. Мы постоянно учимся новому и экспериментируем со вкусами, чтобы удивлять вас каждый день!</p>
                </div>
            </div>
        </section>

        <section id="reviews" class="section">
            <div class="container">
                <h2>Отзывы наших клиентов</h2>
                <div class="reviews-grid">
                    <div class="review-card">
                        <p class="review-text">"Заказывала торт на день рождения сына. Все гости были в восторге! Очень нежный бисквит и крем не приторный. Спасибо огромное!"</p>
                        <p class="review-author">— Марина С.</p>
                    </div>
                    <div class="review-card">
                        <p class="review-text">"Лучшие пончики в городе! Всегда свежие, мягкие и очень вкусные. Захожу каждое утро перед работой за кофе и пончиком."</p>
                        <p class="review-author">— Алексей П.</p>
                    </div>
                    <div class="review-card">
                        <p class="review-text">"Обожаю ваши макаронс! Перепробовала много где, но у вас они идеальные — хрустящая корочка и нежная начинка."</p>
                        <p class="review-author">— Елена В.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="location" class="section bg-alt">
            <div class="container">
                <h2>Где нас найти?</h2>
                <p>Мы находимся в самом центре города.</p>
                <address>
                    г. Москва, ул. Сладкая, д. 15<br>
                    Телефон: +7 (999) 000-00-00<br>
                    Email: info@sweets-club.ru
                </address>
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