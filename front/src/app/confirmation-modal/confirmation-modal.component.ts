import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-confirmation-modal',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './confirmation-modal.component.html',
  styleUrl: './confirmation-modal.component.css',
})
export class ConfirmationModalComponent {
  @Input() showModal: boolean = false;
  @Input() message: string = 'Are you sure you want to delete this item?';
  @Output() confirm = new EventEmitter<boolean>();

  onClose(confirm: boolean) {
    this.confirm.emit(confirm);
    this.showModal = false; // Automatically close the modal after emitting
  }
}
