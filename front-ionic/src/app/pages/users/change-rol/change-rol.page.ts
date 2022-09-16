import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ActivatedRoute} from "@angular/router";
import {AlertController, NavController} from "@ionic/angular";
import {TransaccionService} from "../../../services/transaccion.service";
import {UserService} from "../../../services/user.service";

@Component({
  selector: 'app-change-rol',
  templateUrl: './change-rol.page.html',
  styleUrls: ['./change-rol.page.scss'],
})
export class ChangeRolPage implements OnInit {
  formGroup: FormGroup;

  user_id: string;
  constructor(
    private formBuilder: FormBuilder,
    private activatedRoute: ActivatedRoute,
    public navCtrl: NavController,
    private userService: UserService,
    private alertController: AlertController,
  ) {

    this.formGroup = this.formBuilder.group({
      user_id: ['', [Validators.required]],
      rol_id: ['', [Validators.required]],
    });
  }

  ngOnInit() {
    this.activatedRoute.paramMap.subscribe(
      (data) => {
        this.user_id = data.get('id');
        this.formGroup.patchValue({
          user_id: this.user_id,
        });

      }
    );
  }

  save() {
    console.log(this.formGroup.value);
    this.userService.changeRol(this.formGroup.value).subscribe(async (res: any) => {
      console.log(res);
      const alert = await this.alertController.create({
        cssClass: 'my-custom-class',
        header: 'Alerta',
        subHeader: res.message,
        mode: 'ios',
        buttons: [
          {
            text: 'Aceptar',
            handler: async () => {
              this.navCtrl.back();
              // await this.router.navigateByUrl('/users', {replaceUrl: true});
              console.log('Confirm Okay');
            }
          }
        ]
      });

      await alert.present();
    }, async (error) => {

      const alert = await this.alertController.create({
        cssClass: 'my-custom-class',
        header: 'Alerta',
        subHeader: error.message,
        mode: 'ios',
        buttons: ['Aceptar']
      });

      await alert.present();
    });
  }

}
