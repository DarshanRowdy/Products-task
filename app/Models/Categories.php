<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Categories
 * @package App\Models
 * @property $id
 * @property $name
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */

class Categories extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'categories';

    protected $fillable = ['name', 'status', 'deleted_at'];
}
