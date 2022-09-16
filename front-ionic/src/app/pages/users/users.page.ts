import {Component, OnInit} from '@angular/core';
import {UserService} from '../../services/user.service';
import {User} from '../../models/User.model';
import {ToastService} from '../../services/toast.service';
import * as moment from 'moment';
import {AlertController, ModalController} from '@ionic/angular';
import {Router} from "@angular/router";

@Component({
  selector: 'app-users',
  templateUrl: './users.page.html',
  styleUrls: ['./users.page.scss'],
})
export class UsersPage implements OnInit {
  users: User[];
  now = moment();
  private refres: any;

  constructor(
    protected userService: UserService,
    protected toastService: ToastService,
    public modalController: ModalController,
    private router: Router,
    private alertController: AlertController,
  ) {
  }

  ngOnInit() {
    this.list();
  }

  list() {
    this.userService.getAll().subscribe(res => {
      this.users = res.data.map(res => {
        // console.log(res);
        const fa = this.now.diff(res.created_at, 'days');
        return {...res, esnuevo: (fa <= 7)};
      });
      // console.log(this.users);

    });
  }

  enabled(id: any) {
    console.log(id);
    this.userService.enabled(id).subscribe(value => {
      // console.log(value);
      this.toastService.showToastSuccess(value.message);
    });
  }

  doRefresh(event: any) {
    this.refres = event; //  no funciona
    setTimeout(() => {
      // this.getData();
      this.list();
      event.target.complete();
      // this.socios = [];
    }, 2000);
  }

  async openModal(user: User) {
      // rol/:id/update
      await this.router.navigateByUrl(`users/rol/${user.id}/update`);

  }

}
