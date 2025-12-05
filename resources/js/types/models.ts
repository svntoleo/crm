// Shared frontend model types for Volar/vue-tsc
export interface User {
  id: number;
  name?: string;
  email?: string;
  role?: string;
}

export interface Stage {
  id: number;
  label: string;
  // order used by kanban rendering and persistence
  order?: number;
}

export interface Document {
  id: number;
  title: string;
  number?: string;
  customer?: { name?: string } | null;
  // kanban positioning
  stage_id: number;
  position: number;
  total: number;
  items?: Array<any>;
}

export interface Quotation extends Document {
  customer_id?: number;
  stage?: Stage | null;
}

export interface ServiceOrder extends Document {
  customer_id?: number;
  stage?: Stage | null;
}

export interface QuotationsIndexPageProps {
  quotations: { data: Quotation[] };
  stages: Stage[];
}

export interface ServiceOrdersIndexPageProps {
  service_orders: { data: ServiceOrder[] };
  stages: Stage[];
}
