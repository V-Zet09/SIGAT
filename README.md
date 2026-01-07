# Proyecto SIGAT (Sistema Integral de Gestion de Actividades de Tlapehuala)

<p align="center">
  <img src="https://github.com/user-attachments/assets/bb6ad6fe-8ce6-43fe-935a-8ef3ee108bf3" alt="SIGAT Logo" width="250"/>
</p>



Este proyecto fue desarrollado por estudiantes del **Instituto Tecnologico de Ciudad Altamirano** para el **Honorable Ayuntamiento de Tlapehuala**, con el propósito de **agilizar la elaboración de informes de gobierno**.  
El sistema está construido bajo tecnologías modernas para garantizar eficiencia, escalabilidad y facilidad de uso.  

---

## Estudiantes a cargo del proyecto  

- **Maico Zaet Pérez Valencia**  
- **Jorge Campos Albarado**  
- **Mariana Lilibeth Antúnez García**  
- **José Ángel Alonso León**  

---
## Para crear el proyecto Laravel
- **composer create-project laravel/laravel nombre_del_proyecto**
## Configura el entorno
- **cp .env.example .env**
## Generacion de la clave de aplicación:
- php artisan key:generate




## Que hacer para clonar el proyecto

1. Crea una carpeta donde vaya a clonar dicho repositorio.  
2. Ejecuta un **cmd** en dirección a la carpeta de destino.  
3. Inicializar el repositorio con:  

   ```bash
   git init

   para que el destino sea apto para la clonación.

Ejecutar:

git clone https://github.com/usuario/repositorio-sigat.git

##  Pasos para construir Laravel API
- 1 Configuración del archivo php.ini

Dependiendo de la versión de PHP instalada en el sistema, debe habilitarse la carga de las siguientes extensiones:

extension=fileinfo

extension=openssl

extension=pdo_mysql

- 2 Instalación de dependencias

Dentro de la carpeta del proyecto, ejecutar:

composer install
npm install

- 3 Configuración del archivo .env

Copiar el archivo de ejemplo:

cp .env.example .env


**Configurar la conexión a la base de datos en el archivo .env:**

  ```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sigat
DB_USERNAME=root
DB_PASSWORD=


4. Generar la clave de la aplicación
php artisan key:generate

5. Ejecutar migraciones y seeders (si existen)
php artisan migrate --seed

## Ejecución del proyecto

Para iniciar el servidor de Laravel:

php artisan serve


Para compilar los assets con Vite y Tailwind:

npm run dev

## Tecnologías utilizadas

Laravel (Framework PHP)

TailwindCSS (Framework CSS)

MySQL (Gestor de base de datos)

## Licencia

Este proyecto es de uso académico y fue desarrollado como parte de un proyecto universitario.
No está autorizado su uso con fines comerciales sin la aprobación de los autores.

## Créditos

Proyecto desarrollado por:

Maico Zaet Pérez Valencia

Jorge Campos Albarado

Link Dowland Manual de usuario
https://drive.google.com/drive/folders/1BzCQSm86FQ27z0-mYAHEA2X7nWRdV7ft?usp=sharing

Mariana Lilibeth Antúnez García

José Ángel Alonso León

Con el apoyo del Honorable Ayuntamiento de Tlapehuala.
