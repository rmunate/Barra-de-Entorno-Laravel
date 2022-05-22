# Barra-de-Entorno-Laravel
## _Una simple barra de aviso de entorno_

[![N|Solid](https://i.ibb.co/ZLzQTpm/Firma-Git-Hub.png)](#)

Esta clase permite generar una barra en la parte inferior de nuestro sistema web, con el fin de mostrar a nuestros clientes, usuarios y compañeros de desarrollo los datos del entorno en el que corre la herramienta y si deseamos su infraestructura.

## Salida de Barra
[![N|Solid](https://i.ibb.co/KmVMP9X/BarraPHP.png)](#)

## Características

-	Mostrar la version de PHP y Laravel
-	Mostrar el Dominio
-	Mostrar el entorno del sistema.
-	Indicar al usuario la URL del Sistema en Produccion.
-	La barra del Front solo es visible si el APP_DEBUG en el ENV está en estado TRUE (Comúnmente en producción está en False, por lo cual en este entorno no será visible, De igual manera si se está empleando en otro tipo de Front como Vue, React ó Angular, la petición al servidor no retornaría datos.)

## Instalación

Descargue el contenido del repositorio a su equipo.
Cree un directorio en la carpeta App de laravel con el nombre *Clases*

```sh
App\Clases\EnvironmentMessage.php
```

Esta carpeta se carga por defecto dentro del Framework, por lo cual podremos llamar la clase en cualquier controlador con total libertad.

Llamado y uso de Clase

```sh
<?php
use App\Clases\EnvironmentMessage;
```

## Métodos

Podrá invocar el método que requiera de la clase.
Listado Actual de Métodos

METODOS PARA USO EN CONTROLADORES

| METODO | DESCRIPCIÓN |
| ------ | ------ |
| EnvironmentMessage::all() | Retorna un objeto con los datos del entorno en Uso. |

METODOS PARA USO EN BLADE O EN FRONT
| METODO | DESCRIPCIÓN |
| ------ | ------ |
| EnvironmentMessage::html([inf,dev,pro]) | Método para generar la barra HTML en el Front de Blade, tambien se puede generar una peticion en el layaut al back para generar esta barra en cualquier otro tipo de Front como Vue, React ó Angular |

En este último método se podrá, enviar como primer argumento una combinación de máximo cuatro letras las cuales devolverán la siguiente información de manera correspondiente.

Argumento#1 (Opcional) | 
P = Versión de PHP, 
L = Versión de Laravel, 
E = Entorno (Local, QA, Producción), 
H = Protocolo HTTP ó HTTPS, 

Argumento#2 (Opcional) | 
String Nombre Desarrollador o Casa de Desarrollo

Argumento#3 (Opcional) | 
URL de Producción


_Código Plantila Blade Laravel_
```sh
{!! App\Clases\EnvironmentMessage::html('PLEH','Altum Digital','strategy4.com.co') !!}
```

## Desarrollador

Ingeniero, Raúl Mauricio Uñate Castro
sacon-raulmauricio@hotmail.com

## Licencia
MIT
