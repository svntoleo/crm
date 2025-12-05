<?php

namespace App\Policies;

use App\Models\Quotation;
use App\Models\User;

class QuotationPolicy
{
    public function view(User $user, Quotation $quotation): bool
    {
        if ($user->isCustomer()) {
            return $quotation->customer_id === $user->id || $quotation->user_id === $user->id;
        }
        return true; // internal users can view all
    }

    public function create(User $user): bool
    {
        // customers can create their own quotations; internal users can too
        return true;
    }

    public function update(User $user, Quotation $quotation): bool
    {
        if ($user->isCustomer()) {
            return $quotation->customer_id === $user->id;
        }
        return true;
    }

    public function delete(User $user, Quotation $quotation): bool
    {
        if ($user->isCustomer()) {
            return $quotation->customer_id === $user->id;
        }
        return true;
    }
}
