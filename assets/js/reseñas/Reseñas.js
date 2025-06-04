document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchProduct');
    const resultadoBox = document.getElementById('resultadoProductos');
    const formSection = document.getElementById('form-section');
    const productoIdInput = document.getElementById('producto_id');

    searchInput.addEventListener('input', function () {
        const search = searchInput.value.trim();

        if (search.length < 2) {
            resultadoBox.innerHTML = '';
            return;
        }

        fetch('controllers/reseñas/cBuscarProducto.php?search=' + encodeURIComponent(search))
            .then(response => response.text())
            .then(data => {
                resultadoBox.innerHTML = data;
            })
            .catch(error => {
                console.error('Error al buscar productos:', error);
            });
    });

    resultadoBox.addEventListener('click', function (e) {
        if (e.target.classList.contains('resultado-item')) {
            const nombre = e.target.textContent;
            const id = e.target.getAttribute('data-id');

            searchInput.value = nombre;
            productoIdInput.value = id;
            resultadoBox.innerHTML = '';
            formSection.style.display = 'block';
        }
    });
});