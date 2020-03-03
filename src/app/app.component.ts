import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Subscription } from 'rxjs';

import { HttpService } from './http.service';
import { SchoolList } from './http.interface';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnDestroy, OnInit {
  group: FormGroup;
  subscription: Subscription[] = [];
  schoolList: SchoolList[] = [];

  constructor(private fb: FormBuilder, private httpService: HttpService) { }

  ngOnInit() {
    this.group = this.fb.group({
      board: [''],
      medium: [''],
      nearDistance: [''],
    });

    this.getList();
  }

  ngOnDestroy() {
    this.subscription.forEach(sub => sub.unsubscribe());
  }

  getList() {
    this.schoolList = [];
    this.subscription.push(
      this.httpService.getSchoolList(this.group.getRawValue()).subscribe(resp => {
        if (resp && resp.status === 200) {
          this.schoolList = resp.data;
        }
      })
    );
  }
}
