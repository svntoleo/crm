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
import type { QuotationsIndexPageProps } from '@/types/models';

const page = usePage();
const pageProps = page.props as unknown as QuotationsIndexPageProps & {
  urls: {
    move: string;
    create: string;
    show: (id: number) => string;
    edit: (id: number) => string;
    destroy: (id: number) => string;
  };
};
const showKanban = ref(true);

const handleMove = async (moves: Array<{ id: number; stage_id: number; position: number }>) => {
  router.post(pageProps.urls.move, { moves }, {
    preserveScroll: true,
    onSuccess: () => router.reload({ only: ['quotations'] }),
  });
};

const handleCardClick = (quotationId: number) => {
  router.visit(pageProps.urls.edit(quotationId));
};

const deleteQuotation = (quotationId: number) => {
  router.delete(pageProps.urls.destroy(quotationId), {
    onSuccess: () => router.reload(),
  });
};
</script>

<template>
  <Head title="Quotations" />
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Quotations</h1>
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
          <Link :href="pageProps.urls.create">
            <Button>New Quotation</Button>
          </Link>
        </div>
      </div>

        <KanbanBoard 
          v-if="showKanban"
          :documents="pageProps.quotations.data"
          :stages="pageProps.stages || []"
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
              <TableRow v-for="q in pageProps.quotations.data" :key="q.id">
                <TableCell>{{ q.number ?? `#${q.id}` }}</TableCell>
                <TableCell>{{ q.title || '—' }}</TableCell>
                <TableCell>{{ q.customer?.name ?? '—' }}</TableCell>
                <TableCell>{{ q.stage?.label ?? '—' }}</TableCell>
                <TableCell>R$ {{ Number(q.total).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }}</TableCell>
                <TableCell>
                  <div class="flex gap-2">
                    <Link :href="q.urls.show">
                      <Button variant="outline" size="sm">View</Button>
                    </Link>
                    <Link :href="q.urls.edit">
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
                            This will permanently delete quotation {{ q.number ?? `#${q.id}` }}.
                            This action cannot be undone.
                          </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                          <AlertDialogCancel>Cancel</AlertDialogCancel>
                          <AlertDialogAction @click="deleteQuotation(q.id)">
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
