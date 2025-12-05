<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface ServiceOrderItem {
  id: number;
  description: string;
  quantity: number;
  unit_price: number;
}

interface ServiceOrder {
  id: number;
  title: string;
  notes: string;
  stage_id: number;
  scheduled_datetime: string;
  items?: ServiceOrderItem[];
}

interface Urls {
  store: string;
  update: string;
  index: string;
  show: string;
  storeItem: string;
  destroyItem: (itemId: number) => string;
}

const props = defineProps<{ serviceOrder?: ServiceOrder; urls?: Urls }>();
const showItemForm = ref(false);
const itemForm = useForm({
  description: '',
  quantity: 1,
  unit_price: 0,
});

const form = useForm({
  title: props.serviceOrder?.title ?? '',
  notes: props.serviceOrder?.notes ?? '',
  stage_id: props.serviceOrder?.stage_id ?? null,
  scheduled_datetime: props.serviceOrder?.scheduled_datetime ?? '',
});

function submit() {
  if (props.serviceOrder?.id && props.urls?.update) {
    form.put(props.urls.update, {
      onSuccess: () => router.visit(props.urls!.show),
    });
  } else if (props.urls?.store) {
    form.post(props.urls.store, {
      onSuccess: () => router.visit(props.urls!.index),
    });
  }
}

function addItem() {
  if (!props.serviceOrder?.id || !props.urls?.storeItem) return;
  itemForm.post(props.urls.storeItem, {
    onSuccess: () => {
      itemForm.reset();
      showItemForm.value = false;
      router.reload({ only: ['serviceOrder'] });
    },
  });
}

function deleteItem(itemId: number) {
  if (!props.serviceOrder?.id || !props.urls?.destroyItem) return;
  itemForm.delete(props.urls.destroyItem(itemId), {
    onSuccess: () => router.reload({ only: ['serviceOrder'] }),
  });
}
</script>

<template>
  <Head :title="props.serviceOrder ? 'Edit Service Order' : 'Create Service Order'" />
  <AppLayout>
    <div class="p-6 max-w-4xl">
      <h1 class="text-3xl font-bold mb-6">{{ props.serviceOrder ? 'Edit Service Order' : 'Create Service Order' }}</h1>

      <Card class="mb-6">
        <CardHeader>
          <CardTitle>Details</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div>
              <Label for="title">Title</Label>
              <Input id="title" v-model="form.title" placeholder="e.g. Installation & Setup" />
            </div>

            <div>
              <Label for="notes">Notes</Label>
              <Textarea id="notes" v-model="form.notes" placeholder="Add notes..." />
            </div>

            <div>
              <Label for="scheduled">Scheduled Date</Label>
              <Input id="scheduled" v-model="form.scheduled_datetime" type="datetime-local" />
            </div>

            <div class="flex gap-2">
              <Button @click="submit">Save</Button>
              <Link :href="props.urls?.index || '#'">
                <Button variant="outline">Cancel</Button>
              </Link>
            </div>
          </div>
        </CardContent>
      </Card>

      <Card v-if="props.serviceOrder">
        <CardHeader class="flex flex-row items-center justify-between">
          <CardTitle>Items</CardTitle>
          <Button v-if="!showItemForm" size="sm" @click="showItemForm = true">Add Item</Button>
        </CardHeader>
        <CardContent>
          <div v-if="showItemForm" class="mb-6 p-4 border rounded">
            <h3 class="font-medium mb-4">New Item</h3>
            <div class="space-y-3">
              <Input v-model="itemForm.description" placeholder="Description" />
              <Input v-model.number="itemForm.quantity" type="number" min="1" placeholder="Quantity" />
              <Input v-model.number="itemForm.unit_price" type="number" min="0" step="0.01" placeholder="Unit Price" />
              <div class="flex gap-2">
                <Button @click="addItem" size="sm">Add</Button>
                <Button @click="showItemForm = false" variant="outline" size="sm">Cancel</Button>
              </div>
            </div>
          </div>

          <Table v-if="props.serviceOrder.items?.length">
            <TableHeader>
              <TableRow>
                <TableHead>Description</TableHead>
                <TableHead>Qty</TableHead>
                <TableHead>Unit Price</TableHead>
                <TableHead>Total</TableHead>
                <TableHead>Action</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="item in props.serviceOrder.items" :key="item.id">
                <TableCell>{{ item.description }}</TableCell>
                <TableCell>{{ item.quantity }}</TableCell>
                <TableCell>{{ item.unit_price }}</TableCell>
                <TableCell>{{ item.quantity * item.unit_price }}</TableCell>
                <TableCell>
                  <AlertDialog>
                    <AlertDialogTrigger as-child>
                      <Button variant="destructive" size="sm">Delete</Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogTitle>Delete Item</AlertDialogTitle>
                      <AlertDialogDescription>Are you sure?</AlertDialogDescription>
                      <div class="flex gap-2">
                        <AlertDialogAction @click="deleteItem(item.id)">Delete</AlertDialogAction>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                      </div>
                    </AlertDialogContent>
                  </AlertDialog>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
          <p v-else class="text-gray-500">No items yet.</p>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>