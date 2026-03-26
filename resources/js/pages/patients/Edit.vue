<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import Label from '@/components/ui/label/Label.vue';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Patient, BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    patient: Patient;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pacientes',
        href: '/patients',
    },
    {
        title: 'Editar paciente',
        href: `/patients/${props.patient.id}/edit`,
    },
];

const form = useForm({
    name: props.patient.name,
    phone: props.patient.phone,
    sex: props.patient.sex,
});

const submit = () => {
    form.put(`/patients/${props.patient.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="`Editar Paciente: ${props.patient.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col items-center justify-center gap-6 p-8">
            <Card class="w-full max-w-xl">
                <CardHeader>
                    <CardTitle class="text-lg">Editar Paciente</CardTitle>
                </CardHeader>

                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <Label class="text-base" for="name">Nombre</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Ej: Juan Perez"
                                autofocus
                                class="px-3 py-5"
                            />
                            <!-- Muestra el error de validación si Larvel lo devuelve ($request->validate) -->
                            <InputError :message="form.errors.name" />
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <Label class="text-base" for="phone">Telefono</Label>
                            <Input
                                id="phone"
                                v-model="form.phone"
                                type="text"
                                placeholder="Ej: 5512345678"
                                autofocus
                                class="px-3 py-5"
                            />
                            <InputError :message="form.errors.phone" />
                        </div>

                        <!-- Sex -->
                        <div class="space-y-2">
                            <Label class="text-base" for="sex">Sexo</Label>
                            <Select v-model="form.sex">
                                <SelectTrigger id="sex" class="w-full px-3 py-5">
                                    <SelectValue placeholder="Selecciona el sexo" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="male">Masculino</SelectItem>
                                    <SelectItem value="female">Femenino</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.sex" />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <Button variant="outline" size="lg" as-child>
                                <Link href="/patients">Cancelar</Link>
                            </Button>

                            <Button
                                type="submit"
                                size="lg"
                                :disabled="form.processing"
                            >
                                Actualizar Paciente
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
