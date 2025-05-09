document.addEventListener('DOMContentLoaded', function() {
    // Manejar botones de agregar al carrito
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            addToCart(productId);
        });
    });

    // Función para agregar al carrito
    function addToCart(productId) {
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Producto agregado al carrito');
                updateCartUI();
            } else {
                alert('Error al agregar el producto al carrito');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al agregar el producto al carrito');
        });
    }

    // Función para actualizar la UI del carrito
    function updateCartUI() {
        // Aquí se podría actualizar un contador de items en el carrito
        // o mostrar una notificación
    }

    // Manejar botones de eliminar del carrito
    const removeButtons = document.querySelectorAll('.remove-button');
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const productId = form.querySelector('input[name="product_id"]').value;
            
            if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
                form.submit();
            }
        });
    });

    // Manejar botones de editar en el panel de administración
    const editButtons = document.querySelectorAll('.edit-button');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productItem = this.closest('.product-item');
            const productName = productItem.querySelector('h3').textContent;
            alert(`Editar producto: ${productName}`);
            // Aquí se implementaría la lógica de edición
        });
    });

    // Manejar botones de eliminar en el panel de administración
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productItem = this.closest('.product-item');
            const productName = productItem.querySelector('h3').textContent;
            
            if (confirm(`¿Estás seguro de que deseas eliminar el producto "${productName}"?`)) {
                // Aquí se implementaría la lógica de eliminación
                alert(`Producto "${productName}" eliminado`);
            }
        });
    });

    // Manejar la previsualización de imágenes en el formulario de administración
    const imageInput = document.querySelector('input[type="file"]');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Aquí se podría mostrar una previsualización de la imagen
                    console.log('Imagen cargada:', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    }
}); 