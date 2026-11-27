# Publicar Fixaro online (gratis)

La app corre en **Render** (plan gratuito, con Docker) y la base de datos es **Postgres en Neon** (plan gratuito).
Cada `git push` a `main` vuelve a desplegar la app sola.

## Archivos que intervienen

| Archivo | Para qué sirve |
| --- | --- |
| `Dockerfile` | Compila los assets de Vite, instala PHP 8.4 + Apache y las dependencias de Composer. |
| `deploy/start.sh` | Al arrancar: cachea config/rutas/vistas, corre `php artisan migrate --force` y levanta Apache. |
| `render.yaml` | Blueprint de Render: define el servicio web gratuito, el auto-deploy desde `main` y las variables de entorno. |
| `.dockerignore` | Deja afuera del build `node_modules`, `vendor`, el prototipo y los docs. |

## Variables de entorno

Las fija `render.yaml`, salvo las dos marcadas que se cargan a mano en Render.

| Variable | Valor | Nota |
| --- | --- | --- |
| `DB_URL` | URL de conexión de Neon (`postgresql://...`) | **A mano.** Es secreta: no va al repo. |
| `APP_URL` | `https://fixaro.onrender.com` (o la URL que te dé Render) | **A mano.** |
| `APP_KEY` | La genera Render | `deploy/start.sh` le agrega el prefijo `base64:` que espera Laravel. |
| `APP_ENV` / `APP_DEBUG` | `production` / `false` | |
| `DB_CONNECTION` / `DB_SSLMODE` | `pgsql` / `require` | |
| `SESSION_DRIVER` / `CACHE_STORE` | `database` | Usan tablas de Postgres. |
| `QUEUE_CONNECTION` | `sync` | No hay worker en el plan gratuito. |
| `LOG_CHANNEL` | `stderr` | Los logs se ven en la pestaña **Logs** de Render. |
| `MAIL_MAILER` | `log` | Por ahora los mails (ej. recuperar contraseña) solo quedan en los logs. |

## Límites del plan gratuito

- El servicio de Render **se duerme tras 15 minutos sin visitas**; la primera visita después tarda unos 30-60 segundos en despertar.
- El disco de Render se borra en cada deploy: **las fotos que suban los usuarios se pierden** al redesplegar. Más adelante conviene guardarlas en un storage externo (Cloudinary, Supabase Storage o Cloudflare R2, todos con plan gratuito).
- Neon gratis: 0,5 GB de datos, alcanza de sobra para el MVP.

## Probar el contenedor en tu compu (opcional)

```bash
docker build -t fixaro .
docker run -p 10000:10000 \
  -e APP_KEY="base64:$(openssl rand -base64 32)" \
  -e APP_ENV=production -e DB_CONNECTION=pgsql \
  -e DB_URL="postgresql://usuario:clave@host/db?sslmode=require" \
  fixaro
```

Después abrí http://localhost:10000.
