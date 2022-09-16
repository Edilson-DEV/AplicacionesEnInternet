import {User} from '../authentication/models/credencial.model';

export interface ResponceAuth {
  ok: boolean;
  user: User;
  message?: string;
  access_token: string;
}
