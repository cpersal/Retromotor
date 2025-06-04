<?php

namespace App\Policies;

use App\Models\Pieza;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PiezaPolicy
{
    public function update(User $user, Pieza $pieza)
    {
        return $user->id === $pieza->user_id;
    }

    public function delete(User $user, Pieza $pieza)
    {
        return $user->id === $pieza->user_id;
    }
}
