import {Injectable} from '@angular/core';
import {BehaviorSubject} from 'rxjs';
import {HttpClient} from '@angular/common/http';
import {map, tap} from 'rxjs/operators';
import {ResponceAuth} from '../models/responce-auth.model';
import {Data, User} from '../authentication/models/credencial.model';

// eslint-disable-next-line @typescript-eslint/naming-convention
const Storage = window.localStorage;
const TOKEN_KEY = 'credencial';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  isAuthenticated: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(null);
  private token = '';
  private credencial: Data | null;
  private baseUrl = '';


  constructor(
    private http: HttpClient
  ) {
    // this.baseUrl += '/'; // todo aqui poner end-point para login
    this.loadToken();
  }

  async loadToken() {
    // const token = await Storage.get({key: TOKEN_KEY}); // Storage.getItem(key)
    this.credencial = (JSON.parse(Storage.getItem(TOKEN_KEY))); // Storage.getItem(key)
    // console.log('Token:', this.credencial);
    if (this.credencial && this.credencial.access_token) {
      // console.log('set token: ', this.credencial);
      // credencial = JSON.parse(credencial);
      this.token = this.credencial.access_token;
      // this.token = token;
      this.isAuthenticated.next(true);
    } else {
      this.isAuthenticated.next(false);
    }
  }

  login(credentials: { email: string; password: string }) {

    return this.http.post<ResponceAuth>(this.baseUrl + `/auth/login`, credentials)
      .pipe(
        map((res) => {
          console.log(res);
          this.setCredencial = (res);
          return res;
        }),
        // switchMap(token => {
        //   Storage.setItem('TOKEN_KEY', token);
        //   //   console.log('Token:  ', token);
        //   return from<any>(Storage.setItem('TOKEN_KEY', token));
        // }),
        tap(_ => {
          this.isAuthenticated.next(true);
        }));
  }

  logout() {
    this.isAuthenticated.next(false);
     Storage.removeItem(TOKEN_KEY);

    // storage.removeItem(key)
  }

  public get user(): User | null {
    return this.credencial?.user;
  }

  public get userId(): number | null | string {
    // console.log(this.user.id);
    return this?.user.id;
  }

  public get tokens(): string | null {
    return this.credencial?.access_token;
  }

  // public async isAdmin() {
  //   const rol = await this.user.roles.find(value => value.name === 'administrador');
  //   // console.log('es', rol);
  //   return !!rol;
  // }

  private set setCredencial(credencial: Data) {
    Storage.setItem(TOKEN_KEY, JSON.stringify(credencial));
    this.credencial = credencial;
  }

  register(value: any) {
    return this.http.post<ResponceAuth>(this.baseUrl + `/auth/register`, value)
      .pipe(
        map((res) => res),
        // switchMap(token => {
        //   Storage.setItem('TOKEN_KEY', token);
        //   //   console.log('Token:  ', token);
        //   return from<any>(Storage.setItem('TOKEN_KEY', token));
        // }),
        tap(_ => {
          // this.isAuthenticated.next(true);
        }));
  }
}
