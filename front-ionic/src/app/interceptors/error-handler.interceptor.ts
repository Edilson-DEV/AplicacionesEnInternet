import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Router} from '@angular/router';
import {Observable} from 'rxjs';
import {catchError} from 'rxjs/operators';
import {LocalStorageService} from '../services/local-storage.service';
import {environment} from '../../environments/environment';
import {AlertController, NavController} from '@ionic/angular';
import {AuthenticationService} from '../services/authentication.service';

const credentialsKey = 'credencial';

/**
 * Adds a default error handler to all requests.
 */
@Injectable()
export class ErrorHandlerInterceptor implements HttpInterceptor {
  constructor(
    private router: Router,
    private localStorageService: LocalStorageService,
    private alertController: AlertController,
    public navCtrl: NavController,
    private authenticationService: AuthenticationService,

    // private errorMessageService: ErrorMessageService
  ) {
  }

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    return next
      .handle(request)
      .pipe(catchError(error => this.errorHandler(error)));
  }

  // Customize the default error handler here if needed
  private errorHandler(
    response: HttpResponse<any>
  ): Observable<HttpEvent<any>> {
    if (response.ok === false) {
      // si pasa algo mandar a un db
      // this.errorMessageService.sendError(response);

    }

    if (response.status === 401) {
      this.presentError('La session a caducado.');

    } else if (response.status === 400) {
      const errorResponse: any = response;
      if (errorResponse.error) {
        if (errorResponse.error.validation) {
          errorResponse.error.validation.keys.forEach((key: string) => {
            /*  this.errorMessageService.set(
                errorResponse.error.validation.errors[key],
                key,
                response.url
              );*/
          });
        } else {
          /*  this.errorMessageService.set(
              errorResponse.error.error,
              '_GLOBAL_',
              response.url
            );*/
        }
      }
    } else if (response.status === 0) {
      this.router.navigate(['/0']);
    }

    if (!environment.production) {
      // Do something with the error
      console.error('Request error', response);
    }
    throw response;
  }

  // eslint-disable-next-line @typescript-eslint/member-ordering
  async presentError(menssage: string) {
    const alert = await this.alertController.create({
      header: 'Error',
      message: menssage,
      mode: 'ios',
      buttons: [
        {
          text: 'Aceptar',
          handler: async () => {
            this.authenticationService.logout();
            // this.localStorageService.clearItem(credentialsKey);

            await this.router.navigate(['/login'], {
              replaceUrl: true
            });
            // await this.router.navigateByUrl('/login', {replaceUrl: true});
            console.log('Confirm Okay');
          }
        }
      ]
    });
    await alert.present();
  }
}
