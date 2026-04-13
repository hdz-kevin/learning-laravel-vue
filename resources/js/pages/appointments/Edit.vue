<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Patient, Service, Appointment } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    appointment: Appointment;
    patients: Pick<Patient, 'id' | 'name'>[];
    services: Pick<Service, 'id' | 'name' | 'price'>[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Citas', href: '/appointments' },
    { title: 'Editar Cita', href: `/appointments/${props.appointment.id}/edit` },
];

const form = useForm({
    patient_id: String(props.appointment.patient_id),
    date: props.appointment.date,
    time: props.appointment.time ? props.appointment.time.substring(0, 5) : '',
    service_ids: props.appointment.services ? props.appointment.services.map(s => s.id) : [] as number[],
});

const toggleService = (serviceId: number) => {
    const current = form.service_ids;
    if (current.includes(serviceId)) {
        form.service_ids = current.filter((id) => id !== serviceId);
    } else {
        form.service_ids = [...current, serviceId];
    }
};

const submit = () => {
    form.put(`/appointments/${props.appointment.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Editar Cita" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col items-center justify-center gap-6 p-8">
            <Card class="w-full max-w-2xl">
                <CardHeader>
                    <CardTitle class="text-lg">Editar Cita</CardTitle>
                </CardHeader>

                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">

                        <!-- Paciente -->
                        <div class="space-y-2">
                            <Label class="text-base" for="patient_id">Paciente</Label>
                            <Select v-model="form.patient_id">
                                <SelectTrigger id="patient_id" class="w-full px-3 py-5">
                                    <SelectValue placeholder="Selecciona un paciente" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="patient in patients"
                                        :key="patient.id"
                                        :value="String(patient.id)"
                                    >
                                        {{ patient.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.patient_id" />
                        </div>

                        <!-- Fecha y Hora en fila -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label class="text-base" for="date">Fecha</Label>
                                <Input
                                    id="date"
                                    v-model="form.date"
                                    type="date"
                                    class="px-3 py-5"
                                />
                                <InputError :message="form.errors.date" />
                            </div>

                            <div class="space-y-2">
                                <Label class="text-base" for="time">Hora</Label>
                                <Input
                                    id="time"
                                    v-model="form.time"
                                    type="time"
                                    class="px-3 py-5"
                                />
                                <InputError :message="form.errors.time" />
                            </div>
                        </div>

                        <!-- Servicios (múltiples, con checkboxes) -->
                        <div class="space-y-3">
                            <Label class="text-base">Servicios</Label>
                            <div class="rounded-lg border divide-y">
                                <label
                                    v-for="service in services"
                                    :key="service.id"
                                    :for="`service-${service.id}`"
                                    class="flex cursor-pointer items-center justify-between px-4 py-3 transition-colors hover:bg-muted/50"
                                >
                                    <div class="flex items-center gap-3">
                                        <Checkbox
                                            :id="`service-${service.id}`"
                                            :model-value="form.service_ids.includes(service.id)"
                                            @update:model-value="() => toggleService(service.id)"
                                        />
                                        <span class="text-sm font-medium">{{ service.name }}</span>
                                    </div>
                                    <span class="text-sm text-muted-foreground">${{ service.price }}</span>
                                </label>
                            </div>
                            <InputError :message="form.errors.service_ids" />
                        </div>

                        <!-- Acciones -->
                        <div class="mt-8 flex items-center justify-end gap-4">
                            <Button variant="outline" size="lg" as-child>
                                <Link href="/appointments">Cancelar</Link>
                            </Button>
                            <Button type="submit" size="lg" :disabled="form.processing">
                                Guardar Cambios
                            </Button>
                        </div>

                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
