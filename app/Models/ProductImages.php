<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product_images
 * @package App\Models
 * @property $id
 * @property $product_id
 * @property $is_primary
 * @property $file_url
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */

class ProductImages extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $guarded = ['id'];

    protected $table = 'product_images';

    protected $fillable = ['product_id', 'file_url', 'is_primary', 'status', 'deleted_at'];

    public static function findByProductImages($condition){
        return self::where($condition);
    }

    public function product(){
        return $this->belongsTo(Products::class, 'product_id');
    }
}
