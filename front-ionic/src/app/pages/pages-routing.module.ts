import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';

import {PagesPage} from './pages.page';

const routes: Routes = [
  {
    path: '',
    component: PagesPage,
    children:[

      {
        path: 'folder/:id',
        loadChildren: () => import('../folder/folder.module').then( m => m.FolderPageModule)
      },
      {
        path: 'users',
        loadChildren: () => import('../pages/users/users.module').then( m => m.UsersPageModule)
      },
      {
        path: 'home',
        loadChildren: () => import('./home/home.module').then( m => m.HomePageModule)
      },


    ]
  },
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full'
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PagesPageRoutingModule {}
