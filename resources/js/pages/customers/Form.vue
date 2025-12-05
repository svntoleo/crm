<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';

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
  customer?: Customer;
  urls: {
    update: string;
    show: string;
  };
}

const props = defineProps<Props>();

const form = useForm({
  name: props.customer?.name ?? '',
  email: props.customer?.email ?? '',
  company_name: props.customer?.profile?.company_name ?? '',
  phone: props.customer?.profile?.phone ?? '',
  postcode: props.customer?.profile?.postcode ?? '',
  address: props.customer?.profile?.address ?? '',
  city: props.customer?.profile?.city ?? '',
  country: props.customer?.profile?.country ?? '',
  cnpj: props.customer?.profile?.cnpj ?? '',
});

function submit() {
  if (props.customer?.id) {
    form.put(props.urls.update, {
      onSuccess: () => router.visit(props.urls.show),
    });
  }
}
</script>

<template>
  <Head :title="`Edit ${customer?.name ?? 'Customer'}`" />
  <AppLayout>
    <div class="p-6 max-w-2xl">
      <h1 class="text-3xl font-bold mb-6">Edit Customer</h1>

      <Card>
        <CardHeader>
          <CardTitle>Customer Information</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div>
              <Label for="name">Name</Label>
              <Input id="name" v-model="form.name" />
            </div>

            <div>
              <Label for="email">Email</Label>
              <Input id="email" v-model="form.email" type="email" />
            </div>

            <div>
              <Label for="company_name">Company Name</Label>
              <Input id="company_name" v-model="form.company_name" />
            </div>

            <div>
              <Label for="cnpj">CNPJ</Label>
              <Input id="cnpj" v-model="form.cnpj" />
            </div>

            <div>
              <Label for="phone">Phone</Label>
              <Input id="phone" v-model="form.phone" />
            </div>

            <div>
              <Label for="address">Address</Label>
              <Input id="address" v-model="form.address" />
            </div>

            <div>
              <Label for="postcode">Postcode</Label>
              <Input id="postcode" v-model="form.postcode" />
            </div>

            <div>
              <Label for="city">City</Label>
              <Input id="city" v-model="form.city" />
            </div>

            <div>
              <Label for="country">Country</Label>
              <Input id="country" v-model="form.country" />
            </div>

            <div class="flex gap-2 pt-4">
              <Button @click="submit">Update</Button>
              <Link :href="props.urls.show">
                <Button variant="outline">Cancel</Button>
              </Link>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
