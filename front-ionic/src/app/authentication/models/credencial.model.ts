export interface Credencial {
  status: string;
  data: Data;
}

export interface Data {
  access_token: string;
  user: User;
}

export interface User {
  id: number;
  email: string;
  email_verified_at: Date;
  enabled: boolean;
  rol_id: number;
  created_at: Date;
  updated_at: Date;
  rol: Role;

}

interface Role {
  id: number;
  name: string;
  state: boolean;
}

interface Pivot {
  user_id: number;
  role_id: number;
  created_at: string;
  updated_at: string;
}
