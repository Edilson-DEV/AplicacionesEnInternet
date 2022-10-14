import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AtencioncitaPageRoutingModule } from './atencioncita-routing.module';

import { AtencioncitaPage } from './atencioncita.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    AtencioncitaPageRoutingModule
  ],
  declarations: [AtencioncitaPage]
})
export class AtencioncitaPageModule {}
