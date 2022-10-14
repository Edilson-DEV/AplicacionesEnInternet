import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {AutoLoginGuard} from '../guards/auto-login.guard';

const routes: Routes = [
    {
      path: '',
      children: [
        {
          path: 'login',
          loadChildren: () => import('./login/login.module').then(m => m.LoginPageModule),
          canLoad: [AutoLoginGuard]
        },

        {
          path: 'recovery',
          loadChildren: () => import('./recovery/recovery.module').then( m => m.RecoveryPageModule)
        }


      ]
    },
  {
    path: 'register',
    loadChildren: () => import('./register/register.module').then( m => m.RegisterPageModule)
  },




  ]
;

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthenticationRoutingModule {
}
