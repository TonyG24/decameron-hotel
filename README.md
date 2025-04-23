# Proyecto Full Stack - Sistema de Registro

Este proyecto es una aplicación web full-stack con un **frontend en React + Tailwind** 
un **backend en Laravel**
usando **PostgreSQL** como base de datos principal y **XAMPP** 


## Requisitos

- PHP ^8.1
- Composer
- Node.js ^18
- NPM
- PostgreSQL
- XAMPP (opcional para Apache/MySQL)
- Git (para clonar el repositorio)

## Instalación de Backend (Laravel)

1. Clonar el repositorio backend:
   - git clone https://github.com/TonyG24/decameron-hotel.git

2. Configurar codigo:
    - En package.json esta coinfigurada la bd de postgresql, en caso que el usuario y la contraseña sea distinta debe cambiarse
    - Normalmente en xampp debe habilitarse la extension extension=pdo_pgsql para postgre, por defecto viene deshabilitada

2. Instalar backend:
    - cd rutalocal/decameron-hotel
    - composer install
    - cp .env.example .env
    - php artisan key:generate
    - php artisan migrate
    - php artisan serve
    - abrir en el navegador [http](http://localhost:8000/)

3. Clonar repositorio frontend:
    - git clone https://github.com/TonyG24/decameron-front.git

4. Instalar frontend:
    - cd rutalocal/decameron-front
    - npm install
    - npm run dev
    - http://localhost:3000/hotels



