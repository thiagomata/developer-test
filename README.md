# developer-test
A very simple PHP server to add, remove and change products on a cart.

## Important Files

[Web Routes](store/routes/web.php)

Models [Cart](store/app/Cart.php), 
[Product](store/app/Product.php), 
[CartProduct](store/app/CartProduct.php)

Migrations of the 
[Products Table](store/database/migrations/2019_02_05_183351_create_products_table.php), 
[Cart Table](store/database/migrations/2019_02_05_184002_create_carts_table.php) and 
[Cart Products Table](store/database/migrations/2019_02_05_283952_create_cart_products_table.php)

[Cart Controller](store/app/Http/Controllers/CartController.php)

The template [Cart Blade](store/resources/views/cart.blade.php)



