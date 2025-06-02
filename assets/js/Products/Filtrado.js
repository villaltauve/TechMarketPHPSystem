document.addEventListener('DOMContentLoaded', function () {
    const ordenSelect = document.getElementById('ordenPrecio');
    const precioMinInput = document.getElementById('precioMin');
    const precioMaxInput = document.getElementById('precioMax');

    // Escuchar cambios en filtros
    ordenSelect.addEventListener('change', filtrarProductos);
    precioMinInput.addEventListener('input', filtrarProductos);
    precioMaxInput.addEventListener('input', filtrarProductos);

    function filtrarProductos() {
        const orden = ordenSelect.value;
        const precioMin = precioMinInput.value;
        const precioMax = precioMaxInput.value;

        // Construir los parámetros
        const params = new URLSearchParams({
            ordenPrecio: orden,
            precioMin: precioMin,
            precioMax: precioMax
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
}); 