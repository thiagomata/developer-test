<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>My Cart</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            label{
              display: block;
              width: 100%;
              padding: 10px;
            }
            label span  {
              display: inline-block;
              width: 5%;
            }
            a {
              text-decoration:none;
            }
            td {
              border-width: 1px;
              border-color: black;
              border-style: solid;
              padding: 5px;
            }
            table {
              width: 100%;
            }
        </style>
        <script>
        function addProductToCart() {
            let productName     = document.getElementById("product-name").value;
            let productPrice    = document.getElementById("product-price").value;
            let productQuantity = document.getElementById("product-quantity").value;
            addUrl = "/add/" + productName + "/" + productPrice +"/" + productQuantity;
            window.location.href = addUrl;
        }
        </script>
    </head>
    <body>
      <h1> My Cart </h1>
      <?php if(count($cart->cartProducts) > 0 ): ?>
        <table>
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach($cart->cartProducts as $objCartProduct): ?>
              <tr>
                <td>
                  <?php print $objCartProduct->name ?>
                </td>
                <td>
                  <?php print $objCartProduct->price ?>
                </td>
                <td>
                  <?php print $objCartProduct->quantity ?>
                </td>
                <td>
                  <?php print $objCartProduct->total ?>
                </td>
                <td>
                  <a href="<?php print $objCartProduct->moreOne ?>">
                    <input type="button" value="+"/>
                  </a>
                  <a href="<?php print $objCartProduct->moreOne ?>">
                    <input type="button" value="-"/>
                  </a>
                  <a href="<?php print $objCartProduct->removeLink ?>">
                    <input type="button" value="x"/>
                  </a>
                </td>
              </tr>
            <?php endforeach ?>
            <tr>
              <td colspan="3">Total:</td>
              <td><?php print $cart->total ?></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      <?php else: ?>
        <div class="empty-cart">
          Your cart is empty
        </div>
      <?php endif ?>
      <h2> Add Product to Cart </h2>
      <form>
        <label>
          <span> Product: </span>
          <input type="text" name="name" id="product-name"/>
        </label>
        <label>
          <span> Price: </span>
          <input type="number" name="price" id="product-price"/>
        </label>
        <label>
          <span> Quantity: </span>
          <input type="number" name="quantity" id="product-quantity"/>
        </label>
        <label>
          <input type="button" value="Add this product!" onclick="addProductToCart()"/>
        </label>
      </form>
    </body>
</html>
