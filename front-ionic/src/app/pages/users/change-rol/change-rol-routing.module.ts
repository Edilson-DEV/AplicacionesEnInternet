import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ChangeRolPage } from './change-rol.page';

const routes: Routes = [
  {
    path: '',
    component: ChangeRolPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ChangeRolPageRoutingModule {}
