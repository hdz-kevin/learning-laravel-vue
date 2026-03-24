<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
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
 * Esto le dice a Vue: "este componente recibe una prop 'services'
 * que es un array de objetos Service". Si Laravel envía algo diferente,
 * TypeScript te avisará.
 */
const props = defineProps<{
    services: Service[];
}>();

console.log(props.services);

</script>

<template>
    <Head title="Servicios" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-8">
            <!-- Header con título y botón de nuevo servicio -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">Servicios</h1>
                <Button as-child>
                    <Link href="/services/create">
                        <Plus class="size-4" />
                        Nuevo Servicio
                    </Link>
                </Button>
            </div>

            <!-- Tabla de servicios -->
            <div class="overflow-hidden rounded-lg border">
                <table class="w-full text-left text-sm">
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
                            <td class="px-6 py-4 font-medium">
                                {{ service.name }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-base text-green-700 font-medium">
                                    ${{ service.price }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <Button
                                        variant="ghost"
                                        size="icon-sm"
                                        as-child
                                    >
                                        <Link :href="`/services/${service.id}/edit`">
                                            <Pencil class="size-4" />
                                        </Link>
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="icon-sm"
                                        class="text-destructive hover:text-destructive"
                                    >
                                        <Trash2 class="size-4" />
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
