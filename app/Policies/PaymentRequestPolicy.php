<?php

namespace App\Policies;

use App\Models\PaymentRequest;
use App\Models\User;

class PaymentRequestPolicy
{

    // public function before(User $user)
    // {
    //     if ($user->type == 'Admin') {
    //         return true;
    //     }

    // }
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
    public function view(User $user, PaymentRequest $paymentRequest)
    {
        return $user->seller->id == $paymentRequest->seller_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {

        return $user->type == 'Admin';
    }

    public function acceptAll(User $user, $paymentRequests = null)
    {
        return $user->type == 'Admin';
    }
    public function rejectAll(User $user, $paymentRequests = null)
    {
        return $user->type == 'Admin';
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PaymentRequest $paymentRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PaymentRequest $paymentRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PaymentRequest $paymentRequest)
    {
        //
    }
}
