import { Injectable } from '@angular/core';
import { HttpClient, type HttpErrorResponse } from '@angular/common/http';
import { catchError, Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class EmpleadosService {
  private apiUrl = 'http://127.0.0.1:8000/api/empleados';

  constructor(private http: HttpClient) {}

  obtenerTodosLosEmpleados(): Observable<any> {
    return this.http.get(this.apiUrl);
  }

  obtenerEmpleado(id: number): Observable<any> {
    return this.http.get(`${this.apiUrl}/${id}`);
  }

  crearEmpleado(empleadoData: any) {
    return this.http
      .post(`${this.apiUrl}`, empleadoData)
      .pipe(catchError((error) => throwError(error)));
  }

  actualizarEmpleado(id: number, empleadoData: any) {
    return this.http
      .patch(`${this.apiUrl}/${id}`, empleadoData)
      .pipe(catchError((error) => throwError(error)));
  }

  eliminarEmpleado(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }

  empleadosPaginados(page: number, perPage: number = 10): Observable<any> {
    return this.http.get(`${this.apiUrl}/paged/${perPage}?page=${page}`);
  }
}
