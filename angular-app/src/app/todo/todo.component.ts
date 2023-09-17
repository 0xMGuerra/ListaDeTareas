import { Component, Input, OnInit } from '@angular/core';
import { BackendService } from '../backend.service';
import { Todo } from '../todo';

@Component({
  selector: 'app-todo',
  templateUrl: './todo.component.html',
  styleUrls: ['./todo.component.css']
})
export class TodoComponent {

  nombre: string = "";
  estado: string = "";

  updateIndex: number = -1;
  updateNombre: string = "";
  updateEstado: string = "";

  listaToDos: Todo[] = [];
  
  constructor(private beService: BackendService) {  }

  ngOnInit() {
    this.getToDos();    
  }

  getToDos(): void {
    this.beService.getToDos().subscribe((data) => {
      this.listaToDos = data;
    });
    
  }

  addToDo(): void {
    var ToDoItem = new Todo(this.nombre, this.estado);
    this.beService
      .addToDo(ToDoItem)
      .subscribe(data => this.getToDos());
    this.nombre = "";
    this.estado = "";
  }

  updateToDo(updatedToDo:Todo): void {
    updatedToDo.Nombre = this.updateNombre;
    updatedToDo.Estado = this.updateEstado;
    this.beService.updateToDo(updatedToDo).subscribe(() => {
      this.updateIndex = -1;
    });
    this.getToDos();
    updatedToDo.Nombre = "";
    updatedToDo.Estado = "";
  }

  deleteToDo(todoToDelete: Todo):void {
    this.beService.deleteToDo(todoToDelete).subscribe(() => {
      this.getToDos();
    });
  }

  startUpdating(index: number): void {
    this.updateIndex = index;
    this.updateNombre = this.listaToDos[index].Nombre;
    this.updateEstado = this.listaToDos[index].Estado;
  }

  cancelEditing(): void {
    this.updateIndex = -1;
  }

  confirmDelete(todo: Todo): void {
    const confirmDelete = window.confirm("¿Está seguro de que desea eliminar este ToDo?");
    if (confirmDelete) {
      this.deleteToDo(todo);
    }
  }
  
}
