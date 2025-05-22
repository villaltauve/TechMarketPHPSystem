<?php
// Si no se ha definido 'acc' en la URL, redirige automáticamente a acc=Home
if (!isset($_GET['acc'])) {
    header("Location: index.php?acc=Home");
    exit();
}
// Si no se ha definido $acc, lo asignamos como "Home" por defecto
$acc = isset($_GET['acc']) ? $_GET['acc'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($acc) {
    case "Home":
        require_once("./controllers/home/cHome.php");
        break;
    case "ProductDetails":
        require_once("./controllers/product_details/cProductDetails.php");
        break;
    case "Products":
        require_once("./controllers/products/cProducts.php");
        break;
    case "Cart":
        require_once("./controllers/cart/cCart.php");
        break;
    case "Admin":
        require_once("./controllers/admin/cAdmin.php");
        break;
    case "logout":
        require_once("./controllers/logout/logout.php");
        break;
    case "Checkout":
        require_once("./controllers/checkout/cCheckout.php");
        break;
    case "Invoice":
        require_once("./controllers/invoice/cInvoice.php");
        break;

    default:
        // Opcional: incluir una página de error o redireccionar a Home
        require_once("../home/cHome.php");
        break;
}

?>