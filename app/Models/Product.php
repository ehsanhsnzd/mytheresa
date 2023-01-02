<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string sku
 * @property string name
 * @property string category
 * @property int price
 */
class Product extends Model
{
    use HasFactory;
}
