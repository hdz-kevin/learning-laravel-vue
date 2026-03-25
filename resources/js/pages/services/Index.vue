<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import type { BreadcrumbItem, Service } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Servicios',
        href: '/services',
    },
];

/**
 * defineProps<T>() — Mini-lección:
 *
 * En JS normal harías:
 *   defineProps({ services: { type: Array, required: true } })
 *
 * Con TypeScript usamos genéricos <> para definir el tipo exacto:
 *   defineProps<{ services: Service[] }>()
 *
 * Esto le dice a Vue: "este componente recibe una prop 'services' que es un array de objetos Service".
 * Si Laravel envía algo diferente, TypeScript te avisará.
 */
const props = defineProps<{
    services: Service[];
}>();

/**
 * Delete a service with Inertia
 */
const deleteService = (id: number) => {
    if (confirm('¿Estás seguro de que deseas eliminar este servicio?')) {
        // preserveScroll mantiene la pantalla en la misma posición al recargar
        router.delete(`/services/${id}`, {
            preserveScroll: true,
        });
    }
};

</script>

<template>
    <Head title="Servicios" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-8">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">Servicios</h1>
                <Button size="lg" as-child>
                    <Link href="/services/create">
                        <Plus class="size-4.5" />
                        Nuevo Servicio
                    </Link>
                </Button>
            </div>

            <!-- Services Table -->
            <div class="overflow-hidden rounded-lg border mt-1">
                <table class="w-full text-left">
                    <thead class="border-b bg-muted/50">
                        <tr>
                            <th class="px-6 py-3 font-medium text-muted-foreground">
                                Nombre
                            </th>
                            <th class="px-6 py-3 font-medium text-muted-foreground">
                                Precio
                            </th>
                            <th class="px-6 py-3 text-right font-medium text-muted-foreground">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="service in services"
                            :key="service.id"
                            class="border-b transition-colors hover:bg-muted/50"
                        >
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ service.name }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-green-700 font-medium">
                                    ${{ service.price }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <Button
                                        variant="ghost"
                                        size="default"
                                        as-child
                                    >
                                        <Link :href="`/services/${service.id}/edit`">
                                            <Pencil class="size-4.5" />
                                        </Link>
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="default"
                                        class="text-destructive hover:text-destructive"
                                        @click="deleteService(service.id)"
                                    >
                                        <Trash2 class="size-4.5" />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                        <!-- Estado vacío -->
                        <tr v-if="services.length === 0">
                            <td
                                colspan="3"
                                class="px-6 py-12 text-center text-muted-foreground"
                            >
                                No hay servicios registrados aún.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
