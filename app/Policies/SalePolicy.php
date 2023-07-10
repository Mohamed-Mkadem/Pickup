<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;

class SalePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sale $sale)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sale $sale)
    {
        return $user->seller->store->id == $sale->store_id;
    }
    public function edit(User $user, Sale $sale)
    {
        return $user->seller->store->id == $sale->store_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sale $sale)
    {
        return $user->seller->store->id == $sale->store_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sale $sale)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sale $sale)
    {
        //
    }
}
