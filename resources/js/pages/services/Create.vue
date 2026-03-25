<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Servicios', href: '/services' },
    { title: 'Nuevo Servicio', href: '/services/create' },
];

/**
 * useForm:
 * Declaramos los campos del formulario.
 * - name será string
 * - price será string para manejar el input type="number" sin problemas (Laravel convierte a float)
 */
const form = useForm({
    name: '',
    price: '',
});

/**
 * Método que ejecuta el envío.
 * Usa `form.post` para enviar a la ruta /services (correspondiente al store() del controller)
 */
const submit = () => {
    form.post('/services', {
        // preserveScroll mantiene la posición de la página aunque haya error de validación
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Nuevo Servicio" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col items-center justify-center gap-6 p-8">
            <Card class="w-full max-w-xl">
                <CardHeader>
                    <CardTitle class="text-lg">Agregar Nuevo Servicio</CardTitle>
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
                                placeholder="Ej: Tratamiento de pie de atleta"
                                autofocus
                                class="px-3 py-5"
                            />
                            <!-- Muestra el error de validación si Larvel lo devuelve ($request->validate) -->
                            <InputError :message="form.errors.name" />
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                            <Label class="text-base" for="price">Precio</Label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-muted-foreground">$</span>
                                <Input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    placeholder="400"
                                    class="px-3 py-5 pl-7"
                                />
                            </div>
                            <InputError :message="form.errors.price" />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <Button variant="outline" size="lg" as-child>
                                <Link href="/services">Cancelar</Link>
                            </Button>
                            
                            <!-- form.processing disables the button while Laravel responds -->
                            <Button type="submit" size="lg" :disabled="form.processing">
                                Guardar Servicio
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
