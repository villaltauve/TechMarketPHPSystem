document.addEventListener('DOMContentLoaded', function() {
    // Función para actualizar el estado del botón de favorito
    function updateFavoriteButton(button, isFavorite) {
        if (isFavorite) {
            button.classList.add('favorite-active');
            button.innerHTML = '<i class="fas fa-heart"></i>';
        } else {
            button.classList.remove('favorite-active');
            button.innerHTML = '<i class="far fa-heart"></i>';
        }
    }

    // Función para manejar el clic en el botón de favorito
    function handleFavoriteClick(button, productId) {
        const isFavorite = button.classList.contains('favorite-active');
        const action = isFavorite ? 'remove' : 'add';

        fetch('controllers/favorites/cFavorites.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&action=${action}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateFavoriteButton(button, !isFavorite);
                // Mostrar mensaje de éxito
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error al procesar la solicitud', 'error');
        });
    }

    // Función para mostrar notificaciones
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Inicializar botones de favorito
    document.querySelectorAll('.favorite-button').forEach(button => {
        const productId = button.dataset.productId;
        
        // Verificar estado inicial
        fetch('controllers/favorites/cFavorites.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&action=check`
        })
        .then(response => response.json())
        .then(data => {
            updateFavoriteButton(button, data.isFavorite);
        })
        .catch(error => console.error('Error:', error));

        // Agregar evento de clic
        button.addEventListener('click', () => handleFavoriteClick(button, productId));
    });
}); 