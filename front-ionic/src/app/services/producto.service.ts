import {Injectable} from '@angular/core';
import {BaseAPIClass} from './baseAPI.class';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {LocalStorageService} from './local-storage.service';
import {map} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ProductoService extends BaseAPIClass {

  constructor(
    protected  httpClient: HttpClient,
    private localStorage: LocalStorageService
  ) {
    super(httpClient);
    this.baseUrl = '/productos';
  }

  public getAll(filterObject?: any): Observable<any> {

    if (this.localStorage.getWithExpiry('productos')) {
      return of(this.localStorage.getWithExpiry('productos'));
    }

    return super.getAll(filterObject).pipe(
      map((body: any) => {
        this.localStorage.setWithExpiry('productos', body, 1);
        return body;
      })
    );
  }

  setPrice(value: any) {
    return this.httpClient.post(this.baseUrl+'/set-precio-base',value);
  }
}
