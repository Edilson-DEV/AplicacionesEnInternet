import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ChangeRolPageRoutingModule } from './change-rol-routing.module';

import { ChangeRolPage } from './change-rol.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ChangeRolPageRoutingModule,
    ReactiveFormsModule
  ],
  declarations: [ChangeRolPage]
})
export class ChangeRolPageModule {}
