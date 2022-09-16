import {Injectable} from '@angular/core';
import {BaseAPIClass} from './baseAPI.class';
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class OrdenService extends BaseAPIClass {
  userid = 1;
  tienda: any;

  constructor(
    protected  httpClient: HttpClient,
  ) {
    super(httpClient);
    this.baseUrl = '/ordenes';

  }

  getAllToUserId(id:any) {
    return this.httpClient.get<any>(this.baseUrl + `/all/user/${id}`);
  }

  notificar(id: any) {
    return this.httpClient.get<any>(this.baseUrl + `/notificate/${id}`);
  }
}
