/**
 * Tipos para los modelos del sistema de citas de podología.
 *
 * Cada "type" aquí representa la forma de los datos que Laravel
 * envía al frontend a través de Inertia.
 */

export type Service = {
    id: number;
    name: string;
    price: number;
    created_at: string;
    updated_at: string;
};
