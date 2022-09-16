import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';

import {UsersPage} from './users.page';

const routes: Routes = [
  {
    path: '',
    component: UsersPage,
  },
  {
    path: 'rol/:id/update',
    loadChildren: () => import('./change-rol/change-rol.module').then( m => m.ChangeRolPageModule)
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class UsersPageRoutingModule {
}
