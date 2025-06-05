document.addEventListener('DOMContentLoaded', function () {
    const ordenSelect = document.getElementById('ordenPrecio');
    const precioMinInput = document.getElementById('precioMin');
    const precioMaxInput = document.getElementById('precioMax');
    const searchInput = document.getElementById('searchProduct');
    const stockFilter = document.getElementById('stockFilter');

    // Escuchar cambios en filtros
    ordenSelect.addEventListener('change', filtrarProductos);
    precioMinInput.addEventListener('input', filtrarProductos);
    precioMaxInput.addEventListener('input', filtrarProductos);
    searchInput.addEventListener('input', filtrarProductos);
    stockFilter.addEventListener('change', filtrarProductos);

    function filtrarProductos() {
        const orden = ordenSelect.value;
        const precioMin = precioMinInput.value;
        const precioMax = precioMaxInput.value;
        const search = searchInput.value;
        const stock = stockFilter.value;

        // Construir los parámetros
        const params = new URLSearchParams({
            ordenPrecio: orden,
            precioMin: precioMin,
            precioMax: precioMax,
            search: search,
            stock: stock
        });

        fetch('controllers/products/cFiltrado.php?' + params.toString())
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultadoProductos').innerHTML = data;
            })
            .catch(error => {
                console.error('Error al filtrar productos:', error);
            });
    }

    // Función para limpiar todos los filtros
    window.limpiarFiltros = function() {
        ordenSelect.value = '';
        precioMinInput.value = '';
        precioMaxInput.value = '';
        searchInput.value = '';
        stockFilter.value = '';
        filtrarProductos();
    }
}); 