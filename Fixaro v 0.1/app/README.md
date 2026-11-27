# Fixaro · App (Laravel)

Aplicación web de Fixaro: Laravel 13 + Livewire + Alpine + Tailwind 3, con SQLite en desarrollo.

La descripción del producto, el sistema visual y las capturas están en el [README principal](../../README.md).

## Levantar en local

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run build   # o npm run dev
php artisan serve
```

## Estructura útil

- `resources/views/livewire/`: pantallas (pedido, ofertas, feed del técnico, chat, reseña).
- `resources/views/components/`: componentes Blade (`x-icon`, `x-trade-icon`, `x-avatar`, `x-brand`, `x-flash`).
- `resources/css/app.css` y `tailwind.config.js`: colores y clases del sistema visual.
