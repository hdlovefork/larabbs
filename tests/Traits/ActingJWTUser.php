<?php

namespace Tests\Traits;

use App\Models\User;

trait ActingJWTUser{

    public function JWTActingAS(User $user){
        $token = \Auth::guard('api')->fromUser($user);
        $this->withHeaders(['Authorization' => 'Bearer '.$token]);

        return $this;
    }
}