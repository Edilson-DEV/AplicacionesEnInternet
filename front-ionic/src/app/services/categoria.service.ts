import {Injectable} from '@angular/core';
import {BaseAPIClass} from './baseAPI.class';
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class CategoriaService extends BaseAPIClass {

  constructor(
    protected  httpClient: HttpClient,
  ) {
    super(httpClient);
    this.baseUrl = '/categorias';
  }
}
