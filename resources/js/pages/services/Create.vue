<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue'; // Si este componente no existe podemos mostrar el string directamente, pero es común en el starter kit
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
            <!-- Card component para darle un buen diseño usando el UI token del Starter Kit -->
            <Card class="w-full max-w-lg">
                <CardHeader>
                    <CardTitle class="text-lg">Agregar Nuevo Servicio</CardTitle>
                </CardHeader>

                <CardContent>
                    <!-- Formulario asociado al sumbit() declarado en el <script> -->
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <!-- Input para el Nombre -->
                        <div class="space-y-2">
                            <Label class="text-base" for="name">Nombre</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Ej: Tratamiento de pie de atleta"
                                autofocus
                            />
                            <!-- Muestra el error de validación si Larvel lo devuelve ($request->validate) -->
                            <InputError :message="form.errors.name" />
                        </div>

                        <!-- Input para el Precio -->
                        <div class="space-y-2">
                            <Label class="text-base" for="price">Precio</Label>
                            <div class="relative">
                                <!-- Ícono de peso en absoluto usando Tailwind -->
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-muted-foreground">$</span>
                                <Input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    placeholder="400"
                                    class="pl-7"
                                />
                            </div>
                            <InputError :message="form.errors.price" />
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center justify-end gap-4">
                            <Button variant="outline" as-child>
                                <Link href="/services">Cancelar</Link>
                            </Button>
                            
                            <!-- form.processing deshabilita el botón mientras Laravel responde -->
                            <Button type="submit" :disabled="form.processing">
                                Guardar Servicio
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
