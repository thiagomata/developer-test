<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function cartProducts() {
      return $this->hasMany('App\CartProduct');
    }

    /**
     * Calculate the total price of the cart
     * adding all the total from each cart products
     */
    public function getTotal() {
      $dblTotal = 0;
      foreach( $this->cartProducts as $objCartProduct ) {
        $dblTotal += $objCartProduct->getTotal();
      }
      return round($dblTotal, 2);
    }
}
