import {Role} from './Rol.model';

export interface User {
  id: number;
  name: string;
  last_name?: any;
  celular: string;
  username: string;
  enabled: boolean;
  roles: Role[];
  tiendas?: any[];
  esnuevo: number;
}
