import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

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

  crearEmpleado(empleadoData: any): Observable<any> {
    return this.http.post(this.apiUrl, empleadoData);
  }

  actualizarEmpleado(id: number, empleadoData: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, empleadoData);
  }

  eliminarEmpleado(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
