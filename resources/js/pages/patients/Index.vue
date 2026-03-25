<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import type { BreadcrumbItem, Patient, Service } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pacientes',
        href: '/pacientes',
    },
];

const props = defineProps<{
    patients: Patient[];
}>();

const deletePatient = (id: number) => {
    if (confirm('¿Estas seguro de eliminar el paciente?')) {
        router.delete(`/patients/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Pacientes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-8">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">Pacientes</h1>

                <Button size="lg" as-child>
                    <Link href="/patients/create">
                        <Plus class="size-4.5" />
                        Nuevo Paciente
                    </Link>
                </Button>
            </div>

            <!-- Services Table -->
            <div class="mt-1 overflow-hidden rounded-lg border">
                <table class="w-full text-left">
                    <thead class="border-b bg-muted/50">
                        <tr>
                            <th class="px-6 py-3 font-medium text-muted-foreground">
                                Nombre
                            </th>
                            <th class="px-6 py-3 font-medium text-muted-foreground">
                                Telefono
                            </th>
                            <th class="px-6 py-3 font-medium text-muted-foreground">
                                Sexo
                            </th>
                            <th class="px-6 py-3 text-right font-medium text-muted-foreground">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="patient in patients"
                            :key="patient.id"
                            class="border-b transition-colors hover:bg-muted/50"
                        >
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ patient.name }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ patient.phone }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ patient.sex == 'male' ? 'Masculino' : 'Femenino' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <Button
                                        variant="ghost"
                                        size="default"
                                        as-child
                                    >
                                        <Link
                                            :href="`/patients/${patient.id}/edit`"
                                        >
                                            <Pencil class="size-4.5" />
                                        </Link>
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="default"
                                        class="text-destructive hover:text-destructive"
                                        @click="deletePatient(patient.id)"
                                    >
                                        <Trash2 class="size-4.5" />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                        <!-- Estado vacío -->
                        <tr v-if="patients.length === 0">
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
