<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface CustomerProfile {
  company_name?: string;
  phone?: string;
  address?: string;
  postcode?: string;
  city?: string;
  country?: string;
  cnpj?: string;
}

interface Customer {
  id: number;
  name: string;
  email: string;
  profile?: CustomerProfile;
}

interface Props {
  customer: Customer;
}

withDefaults(defineProps<Props>(), {});
</script>

<template>
  <Head :title="`${customer.name} - Customer`" />
  <AppLayout>
    <div class="p-6 max-w-2xl">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ customer.name }}</h1>
        <Link :href="route('customers.edit', customer.id)">
          <Button>Edit</Button>
        </Link>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Customer Information</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div>
              <span class="font-semibold">Email:</span>
              <p>{{ customer.email }}</p>
            </div>
            <div v-if="customer.profile?.company_name">
              <span class="font-semibold">Company:</span>
              <p>{{ customer.profile.company_name }}</p>
            </div>
            <div v-if="customer.profile?.cnpj">
              <span class="font-semibold">CNPJ:</span>
              <p>{{ customer.profile.cnpj }}</p>
            </div>
            <div v-if="customer.profile?.phone">
              <span class="font-semibold">Phone:</span>
              <p>{{ customer.profile.phone }}</p>
            </div>
            <div v-if="customer.profile?.address">
              <span class="font-semibold">Address:</span>
              <p>{{ customer.profile.address }}</p>
            </div>
            <div v-if="customer.profile?.postcode || customer.profile?.city || customer.profile?.country">
              <span class="font-semibold">Location:</span>
              <p>
                <span v-if="customer.profile?.postcode">{{ customer.profile.postcode }}</span>
                <span v-if="customer.profile?.city"> {{ customer.profile.city }}</span>
                <span v-if="customer.profile?.country"> {{ customer.profile.country }}</span>
              </p>
            </div>
          </div>

          <div class="mt-6">
            <Link :href="route('customers.index')">
              <Button variant="outline">Back to Customers</Button>
            </Link>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
