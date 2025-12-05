<?php

namespace App\Policies;

use App\Models\ServiceOrder;
use App\Models\User;

class ServiceOrderPolicy
{
    public function view(User $user, ServiceOrder $serviceOrder): bool
    {
        if ($user->isCustomer()) {
            return $serviceOrder->customer_id === $user->id || $serviceOrder->user_id === $user->id;
        }
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ServiceOrder $serviceOrder): bool
    {
        if ($user->isCustomer()) {
            return $serviceOrder->customer_id === $user->id;
        }
        return true;
    }

    public function delete(User $user, ServiceOrder $serviceOrder): bool
    {
        if ($user->isCustomer()) {
            return $serviceOrder->customer_id === $user->id;
        }
        return true;
    }
}
