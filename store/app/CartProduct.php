<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{

    /**
     * Cart that contains the product
     * @var Cart
     */
    protected $cart;

    /**
     * Product on the Cart
     * @var Product
     */
    protected $product;

    /**
     * Quantity of this product on the cart
     * @var integer
     */
    protected $quantity;

    public function product() {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

    public function getProduct() {
      return $this->product()->first();
    }

    public function cart() {
        return $this->hasOne('App\Cart', 'id', 'cart_id');
    }

    public function getCart() {
      return $this->cart()->first();
    }

    public function getQuantity() {
      return $this->attributes['quantity'];
    }

    public function getTotal() {
      return round( $this->getQuantity() * $this->getProduct()->price, 2);
    }
}
