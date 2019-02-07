<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  /**
   * Name of the product
   * @var string
   */
  protected $name;

  /**
   * Price of the product
   * @var string
   */
  protected $price;
}
