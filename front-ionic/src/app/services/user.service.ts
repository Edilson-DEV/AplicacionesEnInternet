import {Injectable} from '@angular/core';
import {BaseAPIClass} from './baseAPI.class';
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class UserService extends BaseAPIClass {

  constructor(protected  httpClient: HttpClient) {
    super(httpClient);
    this.baseUrl = '/users';
  }

  changeRol(value: any) {
    return  this.httpClient.post(this.baseUrl + '/change/rol', value);
  }

}
