import {Injectable} from '@angular/core';
import {AlertController, ToastController} from '@ionic/angular';

@Injectable({
  providedIn: 'root'
})
export class ToastService {
  // public toastInstance: Toast;
  private toastInstance: HTMLIonToastElement;

  constructor(
    private toastController: ToastController,
    public alertController: AlertController,
  ) {
  }

  async showToastSuccess(messaging: string, type = 'success') {
    this.toastInstance = await this.toastController.create({
      message: messaging,
      duration: 800,
      keyboardClose: false,
      position: 'bottom',
      animated: true,
      color: type
    });
    await this.toastInstance.present();
  }

  async showToastError(messaging: string, type = 'danger') {
    this.toastInstance = await this.toastController.create({
      message: messaging,
      duration: 800,
      keyboardClose: false,
      position: 'bottom',
      animated: true,
      color: type
    });
    await this.toastInstance.present();
  }

  async presentAlert() {
    const alert = await this.alertController.create({
      cssClass: 'my-custom-class',
      header: 'Alerta',
      mode: 'ios',
      subHeader: 'Subtitle',
      message: 'This is an alert message.',
      buttons: ['OK']
    });

    await alert.present();

    const { role } = await alert.onDidDismiss();
    console.log('onDidDismiss resolved with role', role);
  }

  async presentAlertMultipleButtons() {
    const alert = await this.alertController.create({
      cssClass: 'my-custom-class',
      header: 'Alert',
      mode: 'ios',
      subHeader: 'Subtitle',
      message: 'This is an alert message.',
      buttons: ['Cancel', 'Open Modal', 'Delete']
    });

    await alert.present();
  }
}
