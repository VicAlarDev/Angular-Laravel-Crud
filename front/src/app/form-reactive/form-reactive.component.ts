import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import {
  FormBuilder,
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { CommonModule } from '@angular/common';
import { EmpleadosService } from '../empleados.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-form-reactive',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './form-reactive.component.html',
  styleUrl: './form-reactive.component.css',
})
export class FormEmpleadoComponent implements OnInit {
  @Input() employeeData: any;
  @Output() operationSuccess = new EventEmitter<void>();
  showModel = false;
  submitted = false;
  form: FormGroup = new FormGroup({
    primer_nombre: new FormControl(''),
    otros_nombres: new FormControl(''),
    primer_apellido: new FormControl(''),
    segundo_apellido: new FormControl(''),
    tipo_de_identificacion: new FormControl(''),
    numero_de_identificacion: new FormControl(''),
    fecha_de_ingreso: new FormControl(''),
    pais_del_empleo: new FormControl(''),
    area: new FormControl(''),
  });

  constructor(
    private formBuilder: FormBuilder,
    private empleadosService: EmpleadosService,
    private router: Router
  ) {
    this.form = this.formBuilder.group({
      primer_nombre: [
        '',
        [
          Validators.required,
          Validators.minLength(3),
          Validators.maxLength(20),
          Validators.pattern(/^[A-Z]{3,20}$/),
        ],
      ],
      otros_nombres: [
        '',
        [
          Validators.minLength(3),
          Validators.maxLength(50),
          Validators.pattern(/^[A-Z\s]{3,50}$/),
        ],
      ],
      primer_apellido: [
        '',
        [
          Validators.required,
          Validators.minLength(3),
          Validators.maxLength(20),
          Validators.pattern(/^[A-Z]{3,20}$/),
        ],
      ],
      segundo_apellido: [
        '',
        [
          Validators.required,
          Validators.minLength(3),
          Validators.maxLength(20),
          Validators.pattern(/^[A-Z]{3,20}$/),
        ],
      ],
      tipo_de_identificacion: ['', [Validators.required]],
      numero_de_identificacion: [
        '',
        [
          Validators.required,
          Validators.minLength(9),
          Validators.maxLength(20),
          Validators.pattern(/^[a-zA-Z0-9\-]+$/),
        ],
      ],
      fecha_de_ingreso: ['', [Validators.required]],
      pais_del_empleo: ['', [Validators.required]],
      area: ['', [Validators.required]],
    });
  }

  ngOnInit(): void {
    if (this.employeeData) {
      this.form.patchValue(this.employeeData);
    }
  }

  ngOnChanges() {
    if (this.employeeData) {
      this.form.patchValue(this.employeeData);
    }
  }

  get f() {
    return this.form.controls;
  }

  onSubmit() {
    this.submitted = true;
    if (this.form.valid) {
      const operation =
        this.employeeData && this.employeeData.id
          ? this.empleadosService.actualizarEmpleado(
              this.employeeData.id,
              this.form.value
            )
          : this.empleadosService.crearEmpleado(this.form.value);

      operation.subscribe({
        next: (data) => {
          console.log(
            this.employeeData ? 'Empleado actualizado:' : 'Empleado creado:',
            data
          );
          this.operationSuccess.emit();
          this.onReset();
        },
        error: (response) => {
          console.log('Error al guardar empleado', response);
          if (response.error && response.error.data) {
            this.handleApiErrors(response.error.data);
          }
        },
      });
    } else {
      console.error('Form is invalid');
    }
  }

  private handleApiErrors(errors: any) {
    Object.keys(errors).forEach((key) => {
      if (this.form.controls[key]) {
        this.form.controls[key].setErrors({ serverError: errors[key][0] });
      }
    });
  }

  onReset() {
    this.submitted = false;
    this.form.reset();
  }
}
