import { NgModule } from '@angular/core';

import { HomeRoutingModule } from './home-routing.module';
import { HeaderComponent } from './header/header.component';
import { HomeComponent } from './home.component';
import { BodyComponent } from './body/body.component';

@NgModule({
  declarations: [
    HeaderComponent,
    HomeComponent,
    BodyComponent,
  ],
  imports: [
    HomeRoutingModule,
  ],
})
export class HomeModule { }
