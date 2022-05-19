<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEntity extends Model
{
    use HasFactory;

    public const COUNT = 5;
    public const OFFSET = 0;
    public const PAGE = 1;
}
