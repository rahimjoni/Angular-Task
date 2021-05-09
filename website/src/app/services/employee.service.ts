import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient, HttpHeaders, HttpResponse } from '@angular/common/http';
import { BehaviorSubject, Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';

import { environment } from '@environments/environment';
import { Employee } from '@app/models';

@Injectable({ providedIn: 'root' })
export class EmployeeService {
  constructor(private http: HttpClient) {}

  create(object) {
    return this.http
      .post(`${environment.apiUrl}employees`, object)
      .pipe(catchError(this.handleError));
  }
  handleError(error) {
    return throwError(error);
  }

  getAll() {
    return this.http.get<Employee[]>(`${environment.apiUrl}employees`);
  }

  getById(id: string) {
    return this.http.get<Employee>(`${environment.apiUrl}employees/${id}`);
  }

  update(id, params) {
    return this.http
      .post<Employee>(`${environment.apiUrl}employee-update/${id}`, params)
      .pipe(
        map((x) => {
          return x;
        })
      );
  }

  delete(id: string) {
    return this.http
      .delete<Employee>(`${environment.apiUrl}employees/${id}`)
      .pipe(
        map((x) => {
          return x;
        })
      );
  }
}
