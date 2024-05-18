import { Component, EventEmitter, Output, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { EmpleadosService } from '../empleados.service';
import { ModalComponent } from '../modal/modal.component';
import { FormEmpleadoComponent } from '../form-reactive/form-reactive.component';
import { ConfirmationModalComponent } from '../confirmation-modal/confirmation-modal.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    CommonModule,
    ModalComponent,
    FormEmpleadoComponent,
    ConfirmationModalComponent,
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css',
})
export class HomeComponent implements OnInit {
  empleados: any[] = [];
  showModal = false;
  confirmDeleteModalVisible = false;
  employeeToDelete: number | null = null;
  currentEmployee: any = null;
  currentPage = 1;
  totalItems = 0;
  itemsPerPage = 10;
  totalPages = 0;
  mode: 'add' | 'edit' = 'add';

  constructor(private empleadosService: EmpleadosService) {}

  ngOnInit() {
    this.cargarEmpleados(this.currentPage);
  }

  cargarEmpleados(page: number) {
    this.empleadosService
      .empleadosPaginados(page, this.itemsPerPage)
      .subscribe({
        next: (response) => {
          this.empleados = response.data.data;
          this.totalItems = response.data.total;
          this.currentPage = response.data.current_page;
          this.totalPages = Math.ceil(this.totalItems / this.itemsPerPage);
        },
        error: (error) => {
          console.error('Error al obtener empleados', error);
        },
      });
  }

  onPageChange(page: number) {
    this.cargarEmpleados(page);
  }

  toggleModal() {
    this.showModal = !this.showModal;
  }

  addEmployee() {
    this.currentEmployee = null;
    this.mode = 'add';
    this.toggleModal();
  }

  editEmployee(employee: any) {
    this.currentEmployee = employee;
    this.mode = 'edit';
    this.toggleModal();
  }

  deleteEmpleado(id: number) {
    this.empleadosService.eliminarEmpleado(id).subscribe({
      next: () => {
        this.empleados = this.empleados.filter(
          (empleado) => empleado.id !== id
        );
        console.log('Empleado deleted successfully');
      },
      error: (error) => console.error('Error deleting empleado', error),
    });
  }

  promptDeleteEmpleado(id: number) {
    this.employeeToDelete = id;
    this.confirmDeleteModalVisible = true;
  }

  handleDeleteConfirm(confirm: boolean) {
    if (confirm && this.employeeToDelete) {
      this.deleteEmpleado(this.employeeToDelete);
    }
    this.confirmDeleteModalVisible = false;
    this.employeeToDelete = null;
  }
}
