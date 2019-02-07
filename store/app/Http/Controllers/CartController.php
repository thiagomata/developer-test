<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use App\CartProduct;

class CartController extends Controller
{
    private function createCart() {
      $objCart = new Cart();
      $objCart->save();
      return $objCart;
    }

    private function getSessionCart(Request $request) {
      /*
       * Search for Cart Id on Session
       */
      $cartId = $request->session()->get('cart_id', function() {
        /*
         * if no cart found, create a new cart
         */
         return $this->createCart()->id;
     });
      /*
       * Search for cart on the database
       * If not found, replace by a new one
       */
      $objCart = Cart::find($cartId);
      if( $objCart == null ) {
        $objCart = $this->createCart();
      }
      /*
       * Check cart id
       */
       if( $objCart == null || $objCart->id == null ) {
         throw new Exception("Invalid Cart");
       }
      $request->session()->put('cart_id', $objCart->id);
      return $objCart;
    }

    public function add(Request $request, $intProductId, $intQuantity) {
      $objCart = $this->getSessionCart($request);
      $objCartProduct = new CartProduct();
      $objCartProduct->cart_id = $objCart->
      $objCartProduct->product_id = $intProductId;
      $objCartProduct->quantity = $intQuantity;
      $objCartProduct->save();
      return $this->showCartAsJson($objCart);
    }

    public function createAndAdd(Request $request, $strProductName, $dblProductPrice, $intQuantity) {

      $objProduct = Product::
        where("name",$strProductName)->
        where("price",$dblProductPrice)->
        first();

      if( $objProduct == null ) {
        $objProduct = new Product();
        $objProduct->name = $strProductName;
        $objProduct->price = $dblProductPrice;
        $objProduct->save();
      }

      $objCart = $this->getSessionCart($request);

      $objCartProduct = CartProduct::
        where("product_id",$objProduct->id)->
        where("cart_id",$objCart->id)->
        first();
      $objCartProduct = null;

      if( $objCartProduct == null ) {
        $objCartProduct = new CartProduct();
        $objCartProduct->cart_id = $objCart->id;
        $objCartProduct->product_id = $objProduct->id;
      }
      $objCartProduct->quantity = $intQuantity;
      $objCartProduct->save();
      if( $objCartProduct->quantity == 0 ) {
        $objCartProduct->delete();
      }
      return $this->showCartAsJson($objCart);
    }

    public function remove(Request $request, $intProductId) {
      $objCart = $this->getSessionCart($request);
      CartProduct::
        where("product_id",$intProductId)->
        where("cart_id",$objCart->id)->
        delete();
      return $this->showCartAsJson($objCart);
    }

    public function removeByName(Request $request, $strProductName, $dblProductPrice) {
      $objCart = $this->getSessionCart($request);
      $objProducts = Product::
        where(
          function( $query ) use ($strProductName) {
            $query->whereRaw(
              \DB::raw("replace(name,' ','_') = :raw_name")
            )->setBindings([
              "raw_name" => str_replace(' ','_',$strProductName)
            ]);
          }
        )->get();

      foreach($objProducts as $objProduct) {
        CartProduct::where("product_id", $objProduct->id)->delete();
      }

      return $this->showCartAsJson($objCart);
    }

    public function show(Request $request) {
      $objCart = $this->getSessionCart($request);
      return $this->showCartAsJson($objCart);
    }

    private function showCartAsJson(Cart $objCart) {
      $objJsonCart = new \StdClass();
      $objJsonCart->id = $objCart->id;
      $objJsonCart->cartProducts = [];
      foreach( $objCart->cartProducts as $objCartProduct ) {
        $objJsonCartProduct = new \StdClass();
        $objJsonCartProduct->name = $objCartProduct->getProduct()->name;
        $objJsonCartProduct->price = $objCartProduct->getProduct()->price;
        $objJsonCartProduct->quantity = $objCartProduct->quantity;
        $objJsonCartProduct->total = $objCartProduct->getTotal();
        $objJsonCartProduct->removeLink = route("cart.remove.product.name",[
          "name" => $objJsonCartProduct->name,
          "price" => $objJsonCartProduct->price
        ]);
        $objJsonCartProduct->selfLink = route("cart.add.product.name",[
          "name" => $objJsonCartProduct->name,
          "price" => $objJsonCartProduct->price,
          "quantity" => $objJsonCartProduct->quantity
        ]);
        $objJsonCartProduct->moreOne = route("cart.add.product.name",[
          "name" => $objJsonCartProduct->name,
          "price" => $objJsonCartProduct->price,
          "quantity" => $objJsonCartProduct->quantity + 1
        ]);
        $objJsonCartProduct->lessOne = route("cart.add.product.name",[
          "name" => $objJsonCartProduct->name,
          "price" => $objJsonCartProduct->price,
          "quantity" => $objJsonCartProduct->quantity - 1
        ]);
        $objJsonCartProduct->removeLink = route("cart.remove.product.name",[
          "name" => $objJsonCartProduct->name,
          "price" => $objJsonCartProduct->price,
          "quantity" => $objJsonCartProduct->quantity - 1
        ]);
        $objJsonCart->cartProducts[] = $objJsonCartProduct;
      }
      $objJsonCart->total = $objCart->getTotal();
      return view('cart', [
        'cart' => $objJsonCart
      ]);
      // return response()->json($objJsonCart);
    }
}
