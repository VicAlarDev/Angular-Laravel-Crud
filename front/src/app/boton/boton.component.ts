import { Component, EventEmitter, Output } from '@angular/core';

@Component({
  selector: 'app-boton',
  standalone: true,
  imports: [],
  templateUrl: './boton.component.html',
  styleUrl: './boton.component.css',
})
export class BotonComponent {
  @Output() open = new EventEmitter<void>();

  openModal() {
    this.open.emit();
  }
}
