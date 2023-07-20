<?php

namespace App\Policies;

use App\Models\PickRequest;
use App\Models\User;

class PickRequestPolicy
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
    public function view(User $user, PickRequest $pickRequest)
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
    public function update(User $user, PickRequest $pickRequest)
    {
        return $user->client->id == $pickRequest->order->client_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PickRequest $pickRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PickRequest $pickRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PickRequest $pickRequest)
    {
        //
    }
}
