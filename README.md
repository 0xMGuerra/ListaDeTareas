## Lista de Tareas

### Descripción

Aplicación de gestión de tareas con Angular como frontend, una API REST en Symfony para el backend y una BBDD MariaDB, cada servicio con su respectivo contenedor Docker.

### Uso

1. Clonar el repositorio:
~~~
git clone https://github.com/0xMGuerra/ListaDeTareas.git
cd ListaDeTareas
~~~

3. Iniciar Docker
   
5. Ejecutar el comando para crear y correr los contenedores:
~~~
docker-compose up --build -d
~~~
   
6. Cuando todos los contenedores estén corriendo, visitar la dirección <http://127.0.0.1:8080> para entrar en la aplicación.
   
8. Para parar los contenedores:
~~~
docker-compose down
~~~