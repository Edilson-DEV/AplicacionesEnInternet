
export interface Role {
  id: number;
  name: string;
  // eslint-disable-next-line @typescript-eslint/naming-convention
  display_name: string;
  pivot: Pivot;
}

interface Pivot {
  user_id: number;
  role_id: number;
  created_at: string;
  updated_at: string;
}
