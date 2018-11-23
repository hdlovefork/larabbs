<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2018/11/22
 * Time: 下午10:14
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
        ];
    }
}