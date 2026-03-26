<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { Appointment, BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { CalendarDays, Clock, Plus, User } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Citas',
        href: '/appointments',
    },
];

defineProps<{
    appointments: Appointment[];
}>();

const formatDate = (dateStr: string): string => {
    // Al agregar 'T00:00:00' forzamos que la fecha sea local y no UTC
    // (sin esto el navegador puede mostrar un día antes por el timezone)
    const formatted = new Date(`${dateStr}T00:00:00`).toLocaleDateString('es-MX', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
    });

	return formatted[0].toUpperCase() + formatted.slice(1);
};

/**
 * Formatea '14:30:00' a '2:30 PM'
 */
const formatTime = (timeStr: string): string => {
    const [hours, minutes] = timeStr.split(':');
    return new Date(0, 0, 0, Number(hours), Number(minutes)).toLocaleTimeString('es-MX', {
        hour: 'numeric',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="Citas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-8">
            <!-- Encabezado con botón de nueva cita -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">Citas</h1>
                <Button size="lg" as-child>
                    <Link href="/appointments/create">
                        <Plus class="size-4.5" />
                        Nueva Cita
                    </Link>
                </Button>
            </div>

            <!-- Tabla de citas -->
            <div class="overflow-hidden rounded-lg border">
                <table class="w-full text-left">
                    <thead class="border-b bg-muted/50">
                        <tr>
                            <th class="px-6 py-3 font-medium text-gray-600">Paciente</th>
                            <th class="px-6 py-3 font-medium text-gray-600">Fecha y Hora</th>
                            <th class="px-6 py-3 font-medium text-gray-600">Servicios</th>
                            <th class="px-6 py-3 font-medium text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="appointment in appointments"
                            :key="appointment.id"
                            class="border-b transition-colors hover:bg-muted/50"
                        >
                            <!-- Columna Paciente -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <User class="size-5 shrink-0 text-gray-600" />
                                    <!-- appointment.patient.name funciona porque tipamos la relación -->
                                    <span class="font-medium">{{ appointment.patient.name }}</span>
                                </div>
                            </td>

                            <!-- Columna Fecha y Hora -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-1.5 text-gray-800">
                                        <CalendarDays class="size-4 text-gray-600" />
                                        {{ formatDate(appointment.date) }}
                                    </div>
                                    <div class="flex items-center gap-1.5 text-gray-800">
                                        <Clock class="size-4 text-gray-600" />
                                        {{ formatTime(appointment.time) }}
                                    </div>
                                </div>
                            </td>

                            <!-- Columna Servicios (array de badges) -->
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <!--
                                        appointment.services es Service[] gracias a nuestro type.
                                        Iteramos sobre ese array con otro v-for anidado.
                                    -->
                                    <Badge
                                        v-for="service in appointment.services"
                                        :key="service.id"
                                        variant="secondary"
										class="text-sm text-gray-800 px-3"
                                    >
                                        {{ service.name }}
                                    </Badge>
                                </div>
                            </td>

                            <!-- Columna Total -->
                            <td class="px-6 py-4 font-medium text-green-700">
                                ${{ appointment.total_price }}
                            </td>
                        </tr>

                        <!-- Estado vacío -->
                        <tr v-if="appointments.length === 0">
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-muted-foreground"
                            >
                                No hay citas registradas aún.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
