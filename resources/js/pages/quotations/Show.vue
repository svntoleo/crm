<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const page = usePage();
const props = defineProps({ quotation: Object });

const canEdit = () => {
  const user = page.props.auth.user;
  if (user.role === 'customer') {
    return props.quotation.customer_id === user.id;
  }
  return true;
};
</script>

<template>
  <Head :title="`Quotation ${props.quotation.number ?? props.quotation.id}`" />
  <AppLayout>
    <div class="p-6 max-w-4xl">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-3xl font-bold">{{ props.quotation.title || `#${props.quotation.number ?? props.quotation.id}` }}</h1>
          <p class="text-gray-600">Customer: {{ props.quotation.customer?.name ?? '—' }}</p>
        </div>
        <div v-if="canEdit()" class="flex gap-2">
          <Link :href="route('quotations.edit', props.quotation.id)">
            <Button>Edit</Button>
          </Link>
        </div>
      </div>

      <Card class="mb-6">
        <CardHeader>
          <CardTitle>Items</CardTitle>
        </CardHeader>
        <CardContent>
          <Table v-if="props.quotation.items?.length">
            <TableHeader>
              <TableRow>
                <TableHead>Description</TableHead>
                <TableHead>Qty</TableHead>
                <TableHead>Unit Price</TableHead>
                <TableHead>Total</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="item in props.quotation.items" :key="item.id">
                <TableCell>{{ item.description }}</TableCell>
                <TableCell>{{ item.quantity }}</TableCell>
                <TableCell>{{ item.unit_price }}</TableCell>
                <TableCell>{{ (item.quantity * item.unit_price).toFixed(2) }}</TableCell>
              </TableRow>
            </TableBody>
          </Table>
          <p v-else class="text-gray-500">No items.</p>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Summary</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Total:</span>
              <span class="font-bold">{{ props.quotation.total }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
              <span>Status:</span>
              <span>{{ props.quotation.stage?.label ?? '—' }}</span>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
