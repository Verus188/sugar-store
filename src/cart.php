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
                    <!-- Сюда JS будет вставлять товары -->
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
        // Скрипт чисто для этой страницы (чтобы не захламлять общий файл)
        document.addEventListener('DOMContentLoaded', loadCart);

        // Функция загрузки корзины с сервера
        async function loadCart() {
            // Спрашиваем у PHP: "Что там в корзине?"
            const response = await fetch('cart_action.php?action=get');
            const data = await response.json();
            
            const container = document.getElementById('cart-items');
            const totalSpan = document.getElementById('total-price');
            const cartCount = document.getElementById('cart-count');
            
            // Сразу обновляем цифру в меню, чтобы было красиво
            if (cartCount) cartCount.innerText = data.cart.length;
            
            // Чистим контейнер перед перерисовкой
            container.innerHTML = '';
            let total = 0;

            if (data.cart.length === 0) {
                container.innerHTML = '<p>Корзина пуста. <a href="catalog.php">Перейти в каталог</a></p>';
            } else {
                // Бежим по товарам и создаем HTML для каждого
                data.cart.forEach((item, index) => {
                    total += parseInt(item.price); // Считаем сумму
                    const div = document.createElement('div');
                    div.className = 'product-card'; // Используем те же стили, что и в каталоге
                    div.style.flexDirection = 'row';
                    div.style.justifyContent = 'space-between';
                    div.style.marginBottom = '20px';
                    div.style.alignItems = 'center';
                    
                    // Вставляем картинку, текст и кнопку удаления
                    div.innerHTML = `
                        <div style="display:flex; align-items:center; gap: 20px;">
                            <img src="${item.image}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                            <div>
                                <h3>${item.name}</h3>
                                <span class="price">${item.price}</span>
                            </div>
                        </div>
                        <button class="btn-remove" data-index="${index}" style="background: #ff6f91; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Удалить</button>
                    `;
                    container.appendChild(div);
                });
                
                // Вешаем события на кнопки "Удалить"
                document.querySelectorAll('.btn-remove').forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Передаем индекс товара в функцию удаления
                        removeFromCart(this.getAttribute('data-index'));
                    });
                });
            }
            totalSpan.innerText = total;
        }

        // Функция удаления товара
        async function removeFromCart(index) {
             const response = await fetch('cart_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'remove', index: index })
             });
             const data = await response.json();
             if (data.success) {
                 loadCart(); // Перерисовываем корзину, чтобы товар исчез визуально
             }
        }

        // Оформление заказа (пока просто очистка)
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