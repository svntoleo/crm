<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface User {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'sales' | 'customer';
}

interface Props {
    user?: User;
}

const props = defineProps<Props>();

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    role: props.user?.role || 'customer',
    password: '',
});

const submit = () => {
    if (props.user) {
        form.put(route('users.update', props.user.id));
    } else {
        form.post(route('users.store'));
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="user ? 'Edit User' : 'New User'" />

        <div class="p-6 space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">{{ user ? 'Edit User' : 'New User' }}</h1>
                    <p class="text-muted-foreground">
                        {{ user ? 'Update user information and role' : 'Create a new system user' }}
                    </p>
                </div>
                <Button variant="outline" as-child>
                    <Link :href="route('users.index')">Back to Users</Link>
                </Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>User Details</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="space-y-2">
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                            />
                            <p v-if="form.errors.name" class="text-sm text-destructive">
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                            />
                            <p v-if="form.errors.email" class="text-sm text-destructive">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="role">Role</Label>
                            <select
                                id="role"
                                v-model="form.role"
                                class="w-full px-3 py-2 border rounded-md bg-white"
                                required
                            >
                                <option value="customer">Customer</option>
                                <option value="sales">Sales</option>
                                <option value="admin">Admin</option>
                            </select>
                            <p v-if="form.errors.role" class="text-sm text-destructive">
                                {{ form.errors.role }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="password">
                                Password
                                <span v-if="user" class="text-muted-foreground text-xs">
                                    (leave blank to keep current)
                                </span>
                            </Label>
                            <Input
                                id="password"
                                v-model="form.password"
                                type="password"
                                :required="!user"
                            />
                            <p v-if="form.errors.password" class="text-sm text-destructive">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <Button variant="outline" type="button" as-child>
                                <Link :href="route('users.index')">Cancel</Link>
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                {{ user ? 'Update User' : 'Create User' }}
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
