import { CommonModule } from '@angular/common';
import { Component, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './modal.component.html',
})
export class ModalComponent {
  @Input() showModal = false;
  @Input() mode: 'add' | 'edit' = 'add';
  @Output() showModalChange = new EventEmitter<boolean>();
  @Output() save = new EventEmitter<void>();

  get title() {
    return this.mode === 'edit' ? 'Editar Empleado' : 'Agregar Nuevo Empleado';
  }

  toggleModal() {
    this.showModal = !this.showModal;
    this.showModalChange.emit(this.showModal);
  }

  onSave() {
    this.save.emit();
  }
}
