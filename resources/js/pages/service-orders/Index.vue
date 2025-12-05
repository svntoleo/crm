<script setup lang="ts">
import { Head, Link, usePage, router } from '@inertiajs/vue3';
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
import KanbanBoard from '@/components/KanbanBoard.vue';
import { ref } from 'vue';

interface Stage {
  id: number;
  label: string;
}

interface ServiceOrder {
  id: number;
  number?: string;
  title: string;
  total: number;
  customer?: { name: string };
  stage?: Stage;
}

const page = usePage<{
  service_orders: { data: ServiceOrder[] };
  stages: Stage[];
}>();
const showKanban = ref(true);

const handleMove = async (moves: Array<{ id: number; stage_id: number; position: number }>) => {
  router.post(route('service_orders.move'), { moves }, {
    preserveScroll: true,
    onSuccess: () => router.reload({ only: ['service_orders'] }),
  });
};

const handleCardClick = (serviceOrderId: number) => {
  router.visit(route('service_orders.edit', serviceOrderId));
};

const deleteServiceOrder = (serviceOrderId: number) => {
  router.delete(route('service_orders.destroy', serviceOrderId), {
    onSuccess: () => router.reload(),
  });
};
</script>

<template>
  <Head title="Service Orders" />
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Service Orders</h1>
        <div class="flex gap-2">
          <Button 
            :variant="showKanban ? 'default' : 'outline'"
            @click="showKanban = true"
          >
            Kanban
          </Button>
          <Button 
            :variant="!showKanban ? 'default' : 'outline'"
            @click="showKanban = false"
          >
            List
          </Button>
          <Link :href="route('service_orders.create')">
            <Button>New Service Order</Button>
          </Link>
        </div>
      </div>

      <KanbanBoard 
        v-if="showKanban"
        :documents="page.props.service_orders.data"
        :stages="page.props.stages"
        :on-move="handleMove"
        :on-card-click="handleCardClick"
      />

      <Card v-else>
        <CardHeader>
          <CardTitle>List View</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>#</TableHead>
                <TableHead>Title</TableHead>
                <TableHead>Customer</TableHead>
                <TableHead>Stage</TableHead>
                <TableHead>Total</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="o in page.props.service_orders.data" :key="o.id">
                <TableCell>{{ o.number ?? `#${o.id}` }}</TableCell>
                <TableCell>{{ o.title || '—' }}</TableCell>
                <TableCell>{{ o.customer?.name ?? '—' }}</TableCell>
                <TableCell>{{ o.stage?.label ?? '—' }}</TableCell>
                <TableCell>R$ {{ Number(o.total).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }}</TableCell>
                <TableCell>
                  <div class="flex gap-2">
                    <Link :href="route('service_orders.show', o.id)">
                      <Button variant="outline" size="sm">View</Button>
                    </Link>
                    <Link :href="route('service_orders.edit', o.id)">
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
                            This will permanently delete service order {{ o.number ?? `#${o.id}` }}.
                            This action cannot be undone.
                          </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                          <AlertDialogCancel>Cancel</AlertDialogCancel>
                          <AlertDialogAction @click="deleteServiceOrder(o.id)">
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