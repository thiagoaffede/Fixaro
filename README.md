
<p align="center">
  <img src="https://raw.githubusercontent.com/thiagoaffede/Fixaro/main/Fixaro%20v%200.1/app/public/favicon.svg" alt="Fixaro" width="100" />
</p>

<h1 align="center">Fixaro</h1>

<p align="center">
  <strong>Marketplace inverso de servicios del hogar</strong>
</p>

<p align="center">
  <em>Los usuarios publican su problema — los profesionales responden con presupuestos</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 13" />
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php" alt="PHP 8.3" />
  <img src="https://img.shields.io/badge/Livewire-4-4E56A6?style=for-the-badge&logo=livewire" alt="Livewire" />
  <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpinedotjs" alt="Alpine.js" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql" alt="MySQL" />
  <img src="https://img.shields.io/badge/React_18-61DAFB?style=for-the-badge&logo=react" alt="React 18" />
</p>

<br />

---

## 📋 Descripción

**Fixaro** es un marketplace inverso de servicios del hogar enfocado en **Argentina**. A diferencia de las plataformas tradicionales donde los usuarios buscan profesionales, en Fixaro los usuarios **publican su problema** y los profesionales registrados reciben la notificación y responden con presupuestos.

El objetivo es hacer que contratar un servicio del hogar sea tan fácil como enviar un mensaje de WhatsApp.

---

## 🔄 Cómo Funciona

```
1. Usuario publica su problema
        ↓
2. Sistema categoriza automáticamente
        ↓
3. Profesionales ven problemas abiertos
        ↓
4. Profesionales envían presupuestos
        ↓
5. Usuario acepta la mejor oferta
        ↓
6. Chat directo entre ambas partes
        ↓
7. Al finalizar, reseña y valoración
```

---

## ✨ Funcionalidades

### 📝 Publicación de Problemas
- **Wizard multi-paso** (3 pasos):
  - Subir foto (opcional, max 5MB)
  - Describir el problema + marcar como urgente
  - Geolocalización con OpenStreetMap Nominatim
- **Categorización automática** por palabras clave (Plomero, Electricista, Gasista, Cerrajero, Albañil, Aire Acondicionado, General)

### 👥 Usuarios Duales
- **Registro como Cliente**: nombre, teléfono
- **Registro como Profesional**: incluye matrícula/licencia, hasta 3 rubros
- Verificación de email y recuperación de contraseña

### 🔐 Privacidad por Diseño
- Ubicación aproximada (offset de 300-500m) para proteger la privacidad
- Dirección exacta solo se revela al profesional cuando se acepta su oferta
- Mapa con Leaflet.js + OpenStreetMap

### 💰 Sistema de Presupuestos
- Profesionales envían: precio estimado, tiempo estimado, mensaje
- Prevención de ofertas duplicadas
- El cliente ve todas las ofertas en su dashboard
- Aceptación con un clic — rechaza automáticamente las demás

### 💬 Chat Directo
- Se habilita solo entre cliente y profesional cuando se acepta una oferta
- Protección anti-mensajes duplicados (mismo mensaje en menos de 2 segundos)
- Indicadores de leído/no leído
- Badges de mensajes no leídos

### ⭐ Reseñas
- Valoración de 1 a 5 estrellas con comentario
- Una reseña por problema (constraint único en DB)
- Las valoraciones se muestran en el perfil del profesional

### 📊 Dashboard
- **Cliente**: lista de problemas con estados (Abierto, Asignado, Resuelto), ofertas pendientes, chat activo
- **Profesional**: feed de problemas abiertos (ordenados por urgentes primero), ofertas enviadas, trabajos activos
- Badges de mensajes no leídos

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| **Backend** | Laravel 13 (PHP 8.3+) |
| **Frontend** | Blade + Livewire + Alpine.js |
| **Build** | Vite 8 |
| **CSS** | Tailwind CSS 3 |
| **Base de Datos** | SQLite (dev) / MySQL (prod) |
| **Mapas** | OpenStreetMap + Leaflet.js + Nominatim |
| **Colas** | Database-driven |
| **Prototipo UI** | React 18 + Vite + shadcn/ui (exportado de Figma) |

---

## 📁 Estructura del Proyecto

```
Fixaro/
├── Fixaro v 0.1/
│   └── app/                    # Aplicación Laravel principal
│       ├── app/                 # Models, Controllers, Livewire
│       ├── resources/views/     # Blade templates
│       ├── database/migrations/ # 11 migraciones
│       ├── routes/              # web.php, rutas de autenticación
│       └── .env                 # Configuración local
├── Prototipo/                   # Prototipo UI en React (desde Figma)
│   ├── src/
│   │   └── components/          # Componentes + shadcn/ui
│   └── package.json
└── README.md
```

---

## 🗄️ Base de Datos

| Tabla | Descripción |
|-------|-------------|
| `users` | Clientes y profesionales (con role: client/professional) |
| `professionals` | Datos extra: rubros, matrícula |
| `problems` | Problemas publicados con ubicación aproximada |
| `responses` | Presupuestos enviados por profesionales |
| `messages` | Mensajes del chat |
| `reviews` | Reseñas y valoraciones (unique por problema) |

---

## 🚀 Getting Started

### Requisitos
- PHP 8.3+
- Composer
- Node.js 20+
- npm

### Backend (Laravel)

```bash
cd "Fixaro v 0.1/app"
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
```

### Prototipo (React)

```bash
cd Prototipo
npm install
npm run dev
```

---

## 📄 Licencia

Proyecto privado.
