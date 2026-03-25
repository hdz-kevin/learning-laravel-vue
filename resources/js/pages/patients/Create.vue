<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, useForm, Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
	{
		title: 'Pacientes',
		href: '/patients',
	},
	{
		title: 'Nuevo Paciente',
		href: '/patients/create',
	},
];

const form = useForm({
	name: '',
	phone: '',
	sex: '',
});

const submit = () => {
	form.post('/patients');
};
</script>

<template>
	<Head title="Nuevo Paciente" />

	<AppLayout :breadcrumbs="breadcrumbs">
		<div class="flex flex-1 flex-col items-center justify-center gap-6 p-8">
			<Card class="w-full max-w-xl">
				<CardHeader>
					<CardTitle class="text-lg"
						>Agregar Nuevo Paciente</CardTitle
					>
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
							<Label class="text-base" for="phone"
								>Telefono</Label
							>
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
						<div class="flex items-center justify-end gap-4 mt-8">
                            <Button variant="outline" size="lg" as-child>
                                <Link href="/patients">Cancelar</Link>
                            </Button>

							<!-- form.processing disables the button while Laravel responds -->
							<Button
								type="submit"
								size="lg"
								:disabled="form.processing"
							>
								Guardar Paciente
							</Button>
						</div>
					</form>
				</CardContent>
			</Card>
		</div>
	</AppLayout>
</template>
