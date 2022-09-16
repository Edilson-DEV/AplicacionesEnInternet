import {Injectable} from '@angular/core';
import {BaseAPIClass} from './baseAPI.class';
import {HttpClient} from '@angular/common/http';
import {LocalStorageService} from './local-storage.service';

@Injectable({
  providedIn: 'root'
})
export class TiendaService extends BaseAPIClass {

  constructor(
    protected  httpClient: HttpClient,
    private localStorage: LocalStorageService
  ) {
    super(httpClient);
    this.baseUrl = '/tiendas';
  }
}
