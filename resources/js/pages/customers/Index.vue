<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

interface CustomerProfile {
  company_name?: string;
  phone?: string;
  city?: string;
  country?: string;
}

interface Customer {
  id: number;
  name: string;
  email: string;
  profile?: CustomerProfile;
}

interface Props {
  customers: {
    data: Customer[];
  };
  urls: {
    show: (id: number) => string;
    edit: (id: number) => string;
  };
}

const props = withDefaults(defineProps<Props>(), {});
</script>

<template>
  <Head title="Customers" />
  <AppLayout>
    <div class="p-6">
      <h1 class="text-3xl font-bold mb-6">Customers</h1>

      <Card>
        <CardHeader>
          <CardTitle>Customer Directory</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Name</TableHead>
                <TableHead>Email</TableHead>
                <TableHead>Company</TableHead>
                <TableHead>City</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="customer in props.customers.data" :key="customer.id">
                <TableCell>{{ customer.name }}</TableCell>
                <TableCell>{{ customer.email }}</TableCell>
                <TableCell>{{ customer.profile?.company_name ?? '—' }}</TableCell>
                <TableCell>{{ customer.profile?.city ?? '—' }}</TableCell>
                <TableCell>
                  <div class="flex gap-2">
                    <Link :href="customer.urls.show">
                      <Button variant="outline" size="sm">View</Button>
                    </Link>
                    <Link :href="customer.urls.edit">
                      <Button variant="outline" size="sm">Edit</Button>
                    </Link>
                  </div>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
