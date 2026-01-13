<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\User;

class MerchantPolicy
{
    public function view(User $user, Merchant $merchant)
    {
        return $merchant->active || $user->id === $merchant->owner_id;
    }

    public function update(User $user, Merchant $merchant)
    {
        return $user->id === $merchant->owner_id;
    }

    public function delete(User $user, Merchant $merchant)
    {
        return $user->id === $merchant->owner_id;
    }
}
