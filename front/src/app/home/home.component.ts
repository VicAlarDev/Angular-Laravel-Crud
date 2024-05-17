import { Component, type OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { EmpleadosService } from '../empleados.service';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css',
})
export class HomeComponent implements OnInit {
  empleados: any[] = [];

  constructor(private empleadosService: EmpleadosService) {}

  ngOnInit() {
    this.cargarEmpleados();
  }

  cargarEmpleados() {
    this.empleadosService.obtenerTodosLosEmpleados().subscribe({
      next: (data) => {
        this.empleados = data.data;
      },
      error: (error) => {
        console.error('Error al obtener empleados', error);
      },
    });
  }
}
