<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardTitle, CardHeader } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import type { BreadcrumbItem, Service } from '@/types';

/**
 * Recibimos el "service" que Laravel nos mandó desde ServiceController@edit.
 * Como lo definimos así de claro, TypeScript sabe que "props.service"
 * tiene .id, .name y .price.
 */
const props = defineProps<{
    service: Service;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Servicios', href: '/services' },
    { title: 'Editar servicio', href: `/services/${props.service.id}/edit` },
];

/**
 * Inicializamos el formulario con los DATOS ACTUALES del servicio.
 */
const form = useForm({
    name: props.service.name,
    price: props.service.price,
});

/**
 * Al guardar, enviamos los datos modificados mediante PUT 
 * a la ruta de actualización (/services/id).
 */
const submit = () => {
    form.put(`/services/${props.service.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="`Editar Servicio: ${props.service.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col items-center justify-center gap-6 p-8">
            <Card class="w-full max-w-xl">
                <CardHeader>
                    <CardTitle class="text-lg">Editar Servicio</CardTitle>
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
                                autofocus
                                class="px-3 py-5"
                            />
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
                            
                            <!-- form.processing deshabilita mientras se envía y muestra que está cargando -->
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
