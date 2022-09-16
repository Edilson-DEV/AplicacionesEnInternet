import {ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {AuthenticationService} from '../services/authentication.service';
import {Router} from '@angular/router';

@Component({
  selector: 'app-pages',
  templateUrl: './pages.page.html',
  styleUrls: ['./pages.page.scss'],
  // changeDetection: ChangeDetectionStrategy.OnPush
})
export class PagesPage implements OnInit {
  public appPages = [
    // {title: 'Usuarios', url: '/users', icon: 'people', rol: 'admin'},
    {title: 'Usuarios', url: '/users', icon: 'people', rol: 'Admin'},
    {title: 'Home', url: '/home', icon: 'document-text', rol: ''},
  ];
  public labels = [];
  usuario: any;
  rol: any;

  constructor(
    private authenticationService: AuthenticationService,
    private router: Router,
    private cd: ChangeDetectorRef
  ) {
    if (this.authenticationService.isAuthenticated.value) {

      this.usuario = this.authenticationService.user;
      this.rol = this.authenticationService.user.rol;

    }

  }

  ngOnInit(): void {

  }
  async logout() {
    this.authenticationService.logout();
    await this.router.navigateByUrl('/login', {replaceUrl: true});
  }


}
