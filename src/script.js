document.addEventListener('DOMContentLoaded', () => {
    // Ждем, пока вся страница (HTML) прогрузится, иначе скрипт может не найти элементы
    
    // --- ПЛАВНЫЙ СКРОЛЛ ---
    // Ищем все ссылки, которые начинаются с #
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault(); // Отменяем стандартный прыжок браузера
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70, // Отнимаем 70px, чтобы хедер не перекрывал заголовок
                    behavior: 'smooth' // Магия плавности
                });
            }
        });
    });

    // --- ДОБАВЛЕНИЕ В КОРЗИНУ ---
    // Находим все кнопки "Купить"
    const buyButtons = document.querySelectorAll('.btn-buy');
    buyButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Берем данные о товаре прямо из data-атрибутов кнопки
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const image = this.getAttribute('data-image');

            // Отправляем запрос на сервер (AJAX), чтобы страница не перезагружалась
            fetch('cart_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'add',
                    name: name,
                    price: price,
                    image: image
                })
            })
            .then(response => response.json()) // Превращаем ответ сервера в объект JS
            .then(data => {
                if (data.success) {
                    alert(`"${name}" добавлен в корзину!`);
                    // Обновляем счетчик в шапке, если он есть на странице
                    const countEl = document.getElementById('cart-count');
                    if (countEl) countEl.innerText = data.count;
                }
            });
        });
    });

    // --- ПЕРЕКЛЮЧЕНИЕ ВКЛАДОК (Вход / Регистрация) ---
    const authTabs = document.querySelectorAll('.auth-tab');
    if (authTabs.length > 0) {
        authTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Сначала убираем активный класс у всех вкладок и форм
                document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));

                // Делаем активной нажатую вкладку
                tab.classList.add('active');
                
                // И показываем соответствующую форму (по ID из data-target)
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });
    }

    // --- ОТПРАВКА ФОРМ ВХОДА И РЕГИСТРАЦИИ ---
    const authForms = document.querySelectorAll('.auth-form');
    authForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // Не даем форме отправиться "по старинке" с перезагрузкой
            const formData = new FormData(form);

            // Шлем данные на auth.php
            fetch('auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message); // Показываем то, что ответил сервер
                if (data.success) {
                    if (form.id === 'login-form') {
                        // Если вошли успешно - редирект на главную
                        window.location.href = 'index.php';
                    } else {
                        // Если зарегались - переключаем на вкладку входа
                        document.querySelector('[data-target="login-form"]').click();
                    }
                }
            })
            .catch(error => console.error('Error:', error)); // Если сломалось - пишем в консоль
        });
    });
});