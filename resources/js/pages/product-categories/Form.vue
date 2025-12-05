<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface Category {
  id: number;
  label: string;
}

interface Urls {
  store: string;
  update: string;
  index: string;
}

interface Props {
  category?: Category;
  urls?: Urls;
}

const props = defineProps<Props>();

const form = useForm({
  label: props.category?.label || '',
});

const submit = () => {
  if (props.category && props.urls?.update) {
    form.put(props.urls.update);
  } else if (props.urls?.store) {
    form.post(props.urls.store);
  }
};
</script>

<template>
  <Head :title="category ? 'Edit Category' : 'New Category'" />
  <AppLayout>
    <div class="p-6 space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold">{{ category ? 'Edit Category' : 'New Category' }}</h1>
          <p class="text-muted-foreground">
            {{ category ? 'Update category information' : 'Create a new product category' }}
          </p>
        </div>
        <Button variant="outline" as-child>
          <Link :href="props.urls?.index || '#'">Back to Categories</Link>
        </Button>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Category Details</CardTitle>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-2">
              <Label for="label">Label</Label>
              <Input
                id="label"
                v-model="form.label"
                type="text"
                required
              />
              <p v-if="form.errors.label" class="text-sm text-destructive">
                {{ form.errors.label }}
              </p>
            </div>

            <div class="flex justify-end space-x-2">
              <Button variant="outline" type="button" as-child>
                <Link :href="props.urls?.index || '#'">Cancel</Link>
              </Button>
              <Button type="submit" :disabled="form.processing">
                {{ category ? 'Update Category' : 'Create Category' }}
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
