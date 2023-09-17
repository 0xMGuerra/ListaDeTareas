export class Todo {
    id?: number;
    Nombre: string = "";
    Estado: string = "";
    FechaCreacion?: string;

    constructor(nombre:string, estado:string) {
        this.Nombre = nombre;
        this.Estado = estado;
    }
}

