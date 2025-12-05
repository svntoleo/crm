<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog';

interface Category {
  id: number;
  label: string;
}

interface Product {
  id: number;
  label: string;
  sku: string;
  price: number;
  category?: Category;
}

interface Props {
  products: {
    data: Product[];
  };
  categories: Category[];
}

const props = withDefaults(defineProps<Props>(), {});

const deleteProduct = (productId: number) => {
  router.delete(route('products.destroy', productId), {
    onSuccess: () => router.reload(),
  });
};
</script>

<template>
  <Head title="Products" />
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Products</h1>
        <Link :href="route('products.create')">
          <Button>New Product</Button>
        </Link>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Product Catalog</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>SKU</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Category</TableHead>
                <TableHead>Price</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="product in props.products.data" :key="product.id">
                <TableCell class="font-mono text-sm">{{ product.sku }}</TableCell>
                <TableCell>{{ product.label }}</TableCell>
                <TableCell>{{ product.category?.label ?? '—' }}</TableCell>
                <TableCell>R$ {{ product.price.toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }}</TableCell>
                <TableCell>
                  <div class="flex gap-2">
                    <Link :href="route('products.edit', product.id)">
                      <Button variant="outline" size="sm">Edit</Button>
                    </Link>
                    <AlertDialog>
                      <AlertDialogTrigger as-child>
                        <Button variant="destructive" size="sm">Delete</Button>
                      </AlertDialogTrigger>
                      <AlertDialogContent>
                        <AlertDialogHeader>
                          <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                          <AlertDialogDescription>
                            This will permanently delete {{ product.label }}.
                            This action cannot be undone.
                          </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                          <AlertDialogCancel>Cancel</AlertDialogCancel>
                          <AlertDialogAction @click="deleteProduct(product.id)">
                            Delete
                          </AlertDialogAction>
                        </AlertDialogFooter>
                      </AlertDialogContent>
                    </AlertDialog>
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
