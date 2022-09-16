import {Component, NgZone, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {AuthenticationService} from '../../services/authentication.service';
import {Router} from '@angular/router';
import {AlertController} from '@ionic/angular';



@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {
  formGroupUsuario: FormGroup;
  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthenticationService,
    private router: Router,
    public alertController: AlertController,
  ) {
    this.formGroupUsuario = this.formBuilder.group({
      email: ['', [Validators.required]],
      password: ['', [Validators.required]],
      name: ['', [Validators.required]],
      lastname: ['', [Validators.required]],
      phone: ['', [Validators.required]],
      ci: ['', [Validators.required]],
    });
  }

  ngOnInit() {

  }

  async save() {
    console.log(this.formGroupUsuario.value);

    this.authService.register(this.formGroupUsuario.value).subscribe(
      async (res) => {

        const alert = await this.alertController.create({
          cssClass: 'my-custom-class',
          header: 'Registrado Exitosamente',
          mode: 'ios',
          // subHeader: 'Subtitle',
          message: res?.message,
          buttons: ['Aceptar']
        });
        await alert.present();

        this.router.navigateByUrl('/login', {replaceUrl: true});

      },
      async (error) => {

        console.log(error);
        if (error.status === 422) {
          let meessaje = '';

          Object.entries(error.error).forEach(([key, value]) => {
            meessaje += `<ion-text color='danger'> ${value}</ion-text>`;
          });
          const alert = await this.alertController.create({
            cssClass: 'my-custom-class',
            header: 'Error',
            // subHeader: 'Subtitle',
            mode: 'ios',
            message: meessaje,
            buttons: ['Aceptar']
          });
          await alert.present();
        }

      }
    );
  }


}
