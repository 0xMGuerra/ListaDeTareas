import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable, throwError, of } from 'rxjs';
import { catchError, retry, map } from 'rxjs/operators';
import { TodoComponent } from './todo/todo.component';
import { DatePipe } from '@angular/common';
import { Todo } from './todo';

@Injectable({
  providedIn: 'root'
})
export class BackendService {

  private apiUrl: string = '/api/';
  
  private headers = new HttpHeaders({
    'Content-Type': 'application/json',
  });
  private options = { headers: this.headers };   

  constructor(private http: HttpClient) { }

  addToDo(todoItem: Todo): Observable<any> {
    return this.http.post<Todo>(this.apiUrl + "addToDo", JSON.stringify(todoItem), this.options)
    .pipe(
      catchError((error) => {
        console.error("Hubo un error al crear el todo.", error);
        return throwError(() => error);
      })
    );
  }

  getToDos(): Observable<Todo[]> {
    return this.http.get(this.apiUrl + "ToDoList")
    .pipe(
      map(res => {
        return JSON.parse(JSON.stringify(res)).map(
          (item: { id: number; Nombre: string; Estado: string; FechaCreacion: string | undefined; }) => {
          var todo = new Todo(item.Nombre, item.Estado);
          todo.id = item.id;
          todo.FechaCreacion = item.FechaCreacion;
          return todo;
        })
      }))
    .pipe(
      catchError((error) => {
        console.error("Hubo un error al obtener los todos.", error);
        return throwError(() => error);
      })
    );
  }

  updateToDo(todoToAdd: Todo): Observable<any> {
    return this.http.put<Todo>(this.apiUrl + "updateToDo", JSON.stringify(todoToAdd), this.options)
    .pipe(
      catchError((error) => {
        console.error("Hubo un error al actualizar el todo.", error);
        return throwError(() => error);
      })
    );
  }

  deleteToDo(todoToDelete: Todo): Observable<any> {
    let id = todoToDelete.id ? todoToDelete.id : Number.MAX_VALUE;
    let options = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
      }),
      body: {
        id: id
      },
    };
    return this.http.delete<Todo>(this.apiUrl + "deleteToDo", options)
    .pipe(
      catchError((error) => {
        console.error("Hubo un error al intentar borrar el todo.", error);
        return throwError(() => error);
      })
    );
  }
  
}