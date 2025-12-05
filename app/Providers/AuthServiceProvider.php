<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Quotation;
use App\Models\ServiceOrder;
use App\Policies\QuotationPolicy;
use App\Policies\ServiceOrderPolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Quotation::class, QuotationPolicy::class);
        Gate::policy(ServiceOrder::class, ServiceOrderPolicy::class);
    }
}
