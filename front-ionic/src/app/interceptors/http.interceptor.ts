import {Injectable} from '@angular/core';
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {from, Observable} from 'rxjs';
import {LoadingController} from '@ionic/angular';
import {finalize} from 'rxjs/operators';
import {environment} from '../../environments/environment';

const POST = 'POST';

@Injectable()
export class HttpInterceptors implements HttpInterceptor {
  // loading: any;
  private loading: HTMLIonLoadingElement | null;

  constructor(
    public loadingController: LoadingController
  ) {
  }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {


    // console.log('httpInterceptor', request);
    if (request.method === POST) {
      this.presentLoading();
    }
    request = request.clone({
      headers: request.headers.set('Accept', 'application/json')
    });
    // request = request.clone({ url: environment.serverBaseUrl + request.url });
    // console.log('httpInterceptor', request);
    request = request.clone({ url: environment.serverUrl + request.url });
    return from(next.handle(request))
      .pipe(
        finalize(async () => {
          // console.log(this.loading.backdropDismiss = true);
          if (this.loading) {
            await this.loading.dismiss();
          }
        })
      );
  }

  // loader

  async presentLoading() {
    this.loading = await this.loadingController.create({
      cssClass: 'my-custom-class',
      message: 'por favor, espere...',
      // duration: 2000
      // backdropDismiss: true
    });
    await this.loading.present();

    // const {role, data} = await this.loading.onDidDismiss();
    // console.log('Loading dismissed!');
  }

}
