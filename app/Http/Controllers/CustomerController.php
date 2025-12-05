<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->with('profile')
            ->paginate(50)
            ->withQueryString()->through(fn($customer) => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'role' => $customer->role,
                'profile' => $customer->profile,
                'urls' => [
                    'show' => route('customers.show', $customer),
                    'edit' => route('customers.edit', $customer),
                ],
            ]);

        return Inertia::render('customers/Index', [
            'customers' => $customers,
            'urls' => [
                ]
            ]);
    }

    public function show(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load('profile', 'quotations', 'serviceOrders');

        return Inertia::render('customers/Show', [
            'customer' => $customer,
            'urls' => [
                'edit' => route('customers.edit', $customer),
                'index' => route('customers.index')
            ]
            ]);
    }

    public function edit(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load('profile');

        return Inertia::render('customers/Form', [
            'customer' => $customer,
            'urls' => [
                'update' => route('customers.update', $customer),
                'show' => route('customers.show', $customer)
            ]
            ]);
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$customer->id,
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'postcode' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'cnpj' => 'nullable|string|max:20'
            ]);

        $customer->update($validated);

        if (isset($validated['company_name']) || isset($validated['phone']) || isset($validated['postcode']) || isset($validated['address']) || isset($validated['city']) || isset($validated['country']) || isset($validated['cnpj'])) {
            $customer->profile()->updateOrCreate([], [
                'company_name' => $validated['company_name'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'postcode' => $validated['postcode'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'country' => $validated['country'] ?? null,
                'cnpj' => $validated['cnpj'] ?? null
            ]);
        }

        return redirect()->route('customers.show', $customer)->with('success', 'Customer updated successfully.');
    }
}
