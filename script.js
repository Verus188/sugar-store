document.addEventListener('DOMContentLoaded', () => {
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70, // Adjust for sticky header
                    behavior: 'smooth'
                });
            }
        });
    });

    // Buy button interaction (AJAX to PHP)
    const buyButtons = document.querySelectorAll('.btn-buy');
    buyButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const image = this.getAttribute('data-image');

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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`"${name}" добавлен в корзину!`);
                    // Update cart count in header if element exists
                    const countEl = document.getElementById('cart-count');
                    if (countEl) countEl.innerText = data.count;
                }
            });
        });
    });

    // Auth Tabs Logic
    const authTabs = document.querySelectorAll('.auth-tab');
    if (authTabs.length > 0) {
        authTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Deactivate all tabs and forms
                document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));

                // Activate clicked tab
                tab.classList.add('active');
                
                // Activate target form
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });
    }

    // Auth Forms Submission (AJAX to PHP)
    const authForms = document.querySelectorAll('.auth-form');
    authForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            fetch('auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    if (form.id === 'login-form') {
                        window.location.href = 'index.php';
                    } else {
                        // After register, switch to login tab
                        document.querySelector('[data-target="login-form"]').click();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
