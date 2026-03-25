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
