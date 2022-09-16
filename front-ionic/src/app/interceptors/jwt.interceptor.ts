import {Injectable} from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor, HttpEventType
} from '@angular/common/http';
import {from, Observable} from 'rxjs';
import {AuthenticationService} from '../services/authentication.service';
import {Router} from "@angular/router";


@Injectable()
export class JwtInterceptor implements HttpInterceptor {
  constructor(
    private authenticationService: AuthenticationService,
    private router: Router,
  ) {
  }

  intercept(
    request: HttpRequest<unknown>,
    next: HttpHandler
  ): Observable<HttpEvent<unknown>> {

    console.log();
    // if (!this.authenticationService.isAuthenticated.value) {
    //   this.router.navigateByUrl('/login', {replaceUrl: true});
    // }

    if (this.authenticationService.isAuthenticated.value) {
      const token = this.authenticationService.tokens;
      request = request.clone({
        setHeaders: {
          Authorization: `Bearer ${token}`
        }
      });
    }
    return next.handle(request);
  }
}
