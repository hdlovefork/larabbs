<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2018/11/13
 * Time: 下午9:51
 */

namespace App\Transformers;


use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
        ];
    }
}