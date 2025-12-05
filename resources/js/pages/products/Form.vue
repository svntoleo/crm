<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/vue3';

interface Category {
  id: number;
  label: string;
}

interface Product {
  id: number;
  label: string;
  sku: string;
  price: number;
  category_id: number;
  description?: string;
}

interface Props {
  product?: Product;
  categories: Category[];
}

const props = defineProps<Props>();

const form = useForm({
  label: props.product?.label ?? '',
  sku: props.product?.sku ?? '',
  description: props.product?.description ?? '',
  category_id: props.product?.category_id ?? '',
  price: props.product?.price ?? 0,
});

function submit() {
  if (props.product?.id) {
    form.put(route('products.update', props.product.id), {
      onSuccess: () => router.visit(route('products.index')),
    });
  } else {
    form.post(route('products.store'), {
      onSuccess: () => router.visit(route('products.index')),
    });
  }
}
</script>

<template>
  <Head :title="props.product ? 'Edit Product' : 'New Product'" />
  <AppLayout>
    <div class="p-6 max-w-2xl">
      <h1 class="text-3xl font-bold mb-6">{{ props.product ? 'Edit Product' : 'New Product' }}</h1>

      <Card>
        <CardHeader>
          <CardTitle>Product Details</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div>
              <Label for="label">Product Name</Label>
              <Input id="label" v-model="form.label" placeholder="e.g. PALFINGER PK 23002" />
            </div>

            <div>
              <Label for="sku">SKU</Label>
              <Input id="sku" v-model="form.sku" placeholder="e.g. VEH-PK23002" :disabled="!!props.product" />
            </div>

            <div>
              <Label for="category_id">Category</Label>
              <select v-model.number="form.category_id" class="w-full px-3 py-2 border rounded-md bg-white">
                <option :value="null">Select a category</option>
                <option v-for="cat in props.categories" :key="cat.id" :value="cat.id">
                  {{ cat.label }}
                </option>
              </select>
            </div>

            <div>
              <Label for="price">Price (€)</Label>
              <Input id="price" v-model.number="form.price" type="number" min="0" step="0.01" placeholder="0.00" />
            </div>

            <div>
              <Label for="description">Description</Label>
              <Textarea id="description" v-model="form.description" placeholder="Add product description..." />
            </div>

            <div class="flex gap-2 pt-4">
              <Button @click="submit">{{ props.product ? 'Update' : 'Create' }}</Button>
              <Link :href="route('products.index')">
                <Button variant="outline">Cancel</Button>
              </Link>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
