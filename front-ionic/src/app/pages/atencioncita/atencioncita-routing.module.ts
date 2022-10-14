import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AtencioncitaPage } from './atencioncita.page';

const routes: Routes = [
  {
    path: '',
    component: AtencioncitaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AtencioncitaPageRoutingModule {}
