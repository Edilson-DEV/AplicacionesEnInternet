import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
// import { BASEAPI_PATH } from '@core/class/baseAPI.const';
// import { paramsNext } from '@core/constants/paginacion.const';
import {BASEAPI_PATH} from './baseAPI.const';

@Injectable()
export abstract class BaseAPIClass {
  baseUrl: string;

  protected constructor(protected httpClient: HttpClient) {
    // super(httpClient);
  }

  getAll(filterObject?: any): Observable<any> {
    let queryString = '';
    if (filterObject) {
      const fitlerKeys: any[] = Object.keys(filterObject);
      if (fitlerKeys.length > 0) {
        queryString = '?';
      }
      fitlerKeys.forEach((key: any, index) => {
        if (filterObject[key] !== undefined && filterObject[key] !== null) {
          if (filterObject[key].toString().length) {
            queryString += `${key}=${filterObject[key]}&`;
          }
        }
      });
      if (
        fitlerKeys.length > 0 &&
        queryString[queryString.length - 1] === '&'
      ) {
        queryString = queryString.slice(0, -1);
      }
    }
    return this.httpClient.get(`${this.baseUrl}${queryString}`).pipe(
      map((body: any) => body)
    );
  }

  getById(id: string, filterObject?: any): Observable<any> {
    let queryString = '';
    if (filterObject) {
      const fitlerKeys: any[] = Object.keys(filterObject);
      if (fitlerKeys.length > 0) {
        queryString = '?';
      }
      fitlerKeys.forEach((key: any, index) => {
        if (filterObject[key] !== undefined && filterObject[key] !== null) {
          if (filterObject[key].toString().length) {
            queryString += `${key}=${filterObject[key]}&`;
          }
        }
      });
      if (
        fitlerKeys.length > 0 &&
        queryString[queryString.length - 1] === '&'
      ) {
        queryString = queryString.slice(0, -1);
      }
    }
    return this.httpClient.get(`${this.baseUrl}/${id}${queryString}`).pipe(
      map((body: any) => body)
    );
  }

  create(payload: any): Observable<any> {
    return this.httpClient.post(this.baseUrl, payload).pipe(
      map((body: any) => body)
    );
  }

  update(id: string, payload: any): Observable<any> {
    return this.httpClient.put(`${this.baseUrl}/${id}`, payload).pipe(
      map((body: any) => body)
    );
  }

  delete(id: string): Observable<any> {
    return this.httpClient.delete(`${this.baseUrl}/${id}`).pipe(
      map((body: any) => body)
    );
  }

  deleteAll(): Observable<any> {
    return this.httpClient.delete(`${this.baseUrl}/all`).pipe(
      map((body: any) => body)
    );
  }

  enabled(id: any) {
    return this.httpClient
      .get(`${this.baseUrl}/${BASEAPI_PATH.ENABLED}/${id}`)
      .pipe(
        map((body: any) => body)
      );
  }

/*  nextPage(url: string) {
    console.log('URL', url);
    const headers = new HttpHeaders()
      .set('paginate', String(true))
      .set('totalPagina', String(10));
    return this.httpClient.get(url, { headers: headers, params: paramsNext });
  }

  nextPage2(url: string, buzon: string) {
    console.log('URL', url);
    const headers = new HttpHeaders()
      .set('paginate', String(true))
      .set('totalPagina', String(10));
    return this.httpClient.get(url, {
      headers: headers,
      params: {
        paginacion: '17',
        buzon: buzon
      }
    });
  }*/

  getEnabledList() {
    return this.httpClient.get<any>(
      `${this.baseUrl}/${BASEAPI_PATH.ENABLEDALL}`
    );
    // .pipe(
    //   map((body: any) => {
    //     return body;
    //   }));
  }

  search(term: string) {
    const params = new HttpParams().set('term', term);
    return this.httpClient.get<any>(`${this.baseUrl}${BASEAPI_PATH.SEARCH}`, {
      params
    });
  }
}
