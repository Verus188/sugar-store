<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - Клуб любителей сладостей</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <h1 class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">Клуб любителей сладостей</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php#about">О нас</a></li>
                    <li><a href="catalog.php">Каталог</a></li>
                    <li><a href="cart.php" class="active">Корзина (<span id="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?></span>)</a></li>
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
                <h2>Ваша корзина</h2>
                <div id="cart-items" class="cart-container">
                    <!-- Товары будут загружены через JS -->
                    <p>Загрузка корзины...</p>
                </div>
                <div class="cart-total" style="margin-top: 30px; font-size: 1.5rem; font-weight: bold;">
                    Итого: <span id="total-price">0</span> ₽
                </div>
                <button id="checkout-btn" class="btn-primary" style="margin-top: 20px;">Оформить заказ</button>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Клуб любителей сладостей. Все права защищены.</p>
        </div>
    </footer>

    <script src="script.js"></script>
    <script>
        // Inline script for cart specific logic
        document.addEventListener('DOMContentLoaded', loadCart);

        async function loadCart() {
            const response = await fetch('cart_action.php?action=get');
            const data = await response.json();
            const container = document.getElementById('cart-items');
            const totalSpan = document.getElementById('total-price');
            
            container.innerHTML = '';
            let total = 0;

            if (data.cart.length === 0) {
                container.innerHTML = '<p>Корзина пуста. <a href="catalog.php">Перейти в каталог</a></p>';
            } else {
                data.cart.forEach((item, index) => {
                    total += parseInt(item.price);
                    const div = document.createElement('div');
                    div.className = 'product-card'; // Reuse style
                    div.style.flexDirection = 'row';
                    div.style.justifyContent = 'space-between';
                    div.style.marginBottom = '20px';
                    div.innerHTML = `
                        <div style="display:flex; align-items:center; gap: 20px;">
                            <img src="${item.image}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                            <div>
                                <h3>${item.name}</h3>
                                <span class="price">${item.price}</span>
                            </div>
                        </div>
                    `;
                    container.appendChild(div);
                });
            }
            totalSpan.innerText = total;
        }

        document.getElementById('checkout-btn').addEventListener('click', () => {
             alert('Заказ оформлен! (Демо)');
             fetch('cart_action.php', {
                method: 'POST',
                body: JSON.stringify({ action: 'clear' })
             }).then(() => window.location.reload());
        });
    </script>
</body>
</html>
