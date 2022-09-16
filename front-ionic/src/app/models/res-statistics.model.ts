export interface ResStatistics {
  total: number;
  evento: string;
  fecha: string;
  multa: string;
  habilitado: number;
  finalizado: number;
  controles: Controle[];
}

interface Controle {
  numero: string;
  nombre: string;
  habilitado: number;
  finalizado: number;
  asistentes: number;
  faltantes: number;
  presentes: number;
}
