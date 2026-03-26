/**
 * Types for the podiatry appointment system models.
 *
 * Each "type" here represents the shape of the data that Laravel
 * sends to the frontend through Inertia.
 */

export type Service = {
    id: number;
    name: string;
    price: number;
};

export type Patient = {
    id: number;
    name: string;
    phone: string;
    sex: string;
};

export type Appointment = {
    id: number;
    patient_id: number;
    date: string;       // Laravel devuelve las fechas como string ('2026-03-26')
    time: string;       // Igual el time ('14:30:00')
    total_price: number;
    created_at: string;
    updated_at: string;

    // Relaciones
    // Laravel manda las relaciones anidadas dentro del mismo objeto.
    // En TypeScript las tipamos igual, referenciando los tipos que ya definimos.
    patient: Patient;       // objeto único (belongsTo)
    services: Service[];    // array (belongsToMany)
};
