import {Socio} from './socio.model';

export interface Paginate {
  current_page: number;
  data: Data[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  next_page_url: string;
  path: string;
  per_page: number;
  prev_page_url?: any;
  to: number;
  total: number;
}

export interface Data {
  id: number;
  fecha: string;
  multa: string;
  socio_id: number;
  evento_id: number;
  estado_id: number;
  user_id: number;
  created_at: string;
  updated_at: string;
  estado: Estado;
  socio: Socio;
}
export interface Estado {
  estado_id: number;
  nombre: string;
  letra: string;
  created_at: string;
  updated_at: string;
}
