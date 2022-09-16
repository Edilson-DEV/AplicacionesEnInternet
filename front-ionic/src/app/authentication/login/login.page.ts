import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {AuthenticationService} from '../../services/authentication.service';
import {AlertController} from '@ionic/angular';
import {Router} from '@angular/router';
import {ToastService} from '../../services/toast.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  formGroup: FormGroup;
  hidepassword = false;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthenticationService,
    private alertController: AlertController,
    private router: Router,
    protected toastService: ToastService
  ) {
    this.formGroup = this.formBuilder.group({
      email: ['', [Validators.required]],
      password: ['', [Validators.required]],
    });
  }

  ngOnInit() {
  }


  async login() {

    this.authService.login(this.formGroup.value).subscribe(
      async (res) => {
        await this.router.navigateByUrl('/home', {replaceUrl: true});
      },
      async (res) => {
        if (res.status === 409 && res.error === 'Usuario no habilitado') {
          const alert = await this.alertController.create({
            header: 'Fallo al iniciar',
            message: 'Estimado, el usuario se encuentra inactivo, para habilitar debe comunicarse con el adminitrador',
            mode: 'ios',
            buttons: ['Aceptar'],
          });
          await alert.present();
        } else {
          await this.toastService.showToastError(res.error);
        }
      }
    );
  }

  get email() {
    return this.formGroup.get('email');
  }

  get password() {
    return this.formGroup.get('password');
  }
}
