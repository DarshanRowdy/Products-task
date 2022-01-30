<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Products
 * @package App\Models
 * @property $id
 * @property $category_id
 * @property $name
 * @property $description
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Products extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $guarded = ['id'];

    protected $table = 'products';

    protected $fillable = ['name', 'category_id', 'status', 'deleted_at'];

    protected $appends = array('product_primary_image');

    public function category(){
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public static function findByProduct($condition){
        return self::where($condition);
    }

    public function getProductPrimaryImageAttribute(){
        $primaryImageName = null;
        foreach ($this->productImages as $image){
            if(!empty($image) && $image->is_primary){
                $primaryImageName = $image->file_url;
            }
        }
        if($primaryImageName == null && $this->productImages->count() > 0){
            $primaryImageName = $this->productImages[0]->file_url;
        }
        return $primaryImageName;
    }

    public function productImages(){
        return $this->hasMany(ProductImages::class, 'product_id','id');
    }
}
