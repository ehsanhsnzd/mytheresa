<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $value
 * @property string $type
 * @property string $key
 */
class Discount extends Model
{
    use HasFactory;
}
