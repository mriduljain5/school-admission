import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';

import { HttpResponse, SchoolList } from './http.interface';

@Injectable()
export class HttpService {
  constructor(private httpClient: HttpClient) { }

  getSchoolList(formData: FormData): Observable<HttpResponse<SchoolList[]>> {
    if (environment.production) {
      return this.httpClient.post<HttpResponse<SchoolList[]>>(environment.schoolListUrl, formData);
    }

    return this.httpClient.get<HttpResponse<SchoolList[]>>(environment.schoolListUrl);
  }
}
