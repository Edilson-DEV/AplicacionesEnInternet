import {Injectable} from '@angular/core';
import {BaseAPIClass} from './baseAPI.class';
import {HttpClient} from '@angular/common/http';
import {LocalStorageService} from './local-storage.service';

@Injectable({
  providedIn: 'root'
})
export class TransaccionService extends BaseAPIClass {

  constructor(
    protected  httpClient: HttpClient,
    private localStorage: LocalStorageService
  ) {
    super(httpClient);
    this.baseUrl = '/transaccions';
  }

  getAllByTiendaID(id: any) {
    return this.httpClient.get<any>(this.baseUrl + '/tienda/' + id);
  }
}
