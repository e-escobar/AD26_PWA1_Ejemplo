<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Receta;

class RecetaPolicy
{
    public function update(User $user, Receta $receta)
    {
        return $user->id === $receta->user_id;
    }

    public function delete(User $user, Receta $receta)
    {
        return $user->id === $receta->user_id;
    }
}
