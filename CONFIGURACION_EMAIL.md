# 📧 Configuración de Recuperación de Contraseña por Email

## 🎯 Estado Actual

Tu aplicación ya tiene:
- ✅ Rutas de autenticación habilitadas (`Auth::routes()`)
- ✅ Migraciones de password_reset_tokens
- ✅ Vista personalizada de recuperación (`email.blade.php`)
- ✅ Mailpit configurado para desarrollo local

## 🚀 Pasos para Habilitar Completamente

### 1️⃣ **Verificar las Migraciones**

Asegúrate de que las tablas estén creadas en la base de datos:

```bash
php artisan migrate
```

Esto creará la tabla `password_reset_tokens` necesaria para almacenar los tokens de recuperación.

---

### 2️⃣ **Configuración para DESARROLLO LOCAL (Mailpit)**

**Ya está configurado** ✅ en tu `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### **Cómo usar Mailpit:**

1. **Iniciar Mailpit** (si usas Laragon, ya debería estar corriendo)
   
2. **Acceder a la interfaz web:**
   - Abre tu navegador en: `http://localhost:8025`
   - Aquí verás todos los emails que tu aplicación envíe

3. **Probar la recuperación:**
   - Ve a: `https://pasanaco.test/password/reset`
   - Ingresa un email registrado
   - Revisa el email en `http://localhost:8025`
   - Copia el enlace de recuperación y úsalo

---

### 3️⃣ **Configuración para PRODUCCIÓN**

Cuando despliegues en producción, necesitarás un servicio de email real. Aquí las opciones:

#### **Opción A: Gmail (Gratis, Fácil)**

1. Habilita "Contraseñas de aplicaciones" en tu cuenta Google:
   - Ve a: https://myaccount.google.com/security
   - Activa "Verificación en 2 pasos"
   - Genera una "Contraseña de aplicación"

2. Actualiza tu `.env` en producción:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pasanaco.com"
MAIL_FROM_NAME="Pasanaco Digital"
```

#### **Opción B: Mailtrap (Desarrollo/Testing)**

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu-username-mailtrap
MAIL_PASSWORD=tu-password-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pasanaco.com"
MAIL_FROM_NAME="Pasanaco Digital"
```

#### **Opción C: SendGrid (Producción profesional)**

1. Crea cuenta gratuita en SendGrid (100 emails/día gratis)
2. Genera una API Key

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu-api-key-de-sendgrid
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pasanaco.com"
MAIL_FROM_NAME="Pasanaco Digital"
```

#### **Opción D: Mailgun (Recomendado para Laravel)**

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=tu-dominio.mailgun.org
MAILGUN_SECRET=tu-api-key
MAIL_FROM_ADDRESS="noreply@pasanaco.com"
MAIL_FROM_NAME="Pasanaco Digital"
```

---

### 4️⃣ **Personalizar el Email de Recuperación (Opcional)**

Laravel envía emails en formato Markdown. Para personalizarlos:

```bash
php artisan vendor:publish --tag=laravel-mail
```

Luego edita las plantillas en:
- `resources/views/vendor/mail/html/`
- `resources/views/vendor/mail/text/`

Para personalizar específicamente el email de reset:

```bash
php artisan vendor:publish --tag=laravel-notifications
```

Edita: `resources/views/vendor/notifications/email.blade.php`

---

### 5️⃣ **Configurar el APP_URL Correctamente**

**MUY IMPORTANTE:** El enlace de recuperación usa `APP_URL` del `.env`

**Para desarrollo:**
```env
APP_URL=https://pasanaco.test
```

**Para producción:**
```env
APP_URL=https://tudominio.com
```

---

### 6️⃣ **Probar el Sistema Completo**

#### **Prueba Local con Mailpit:**

1. Inicia tu servidor: `php artisan serve` o usa Laragon
2. Ve a: `https://pasanaco.test/password/reset`
3. Ingresa un email de un usuario existente
4. Abre Mailpit: `http://localhost:8025`
5. Verás el email con el enlace de recuperación
6. Haz clic en el enlace o cópialo
7. Cambia tu contraseña
8. Inicia sesión con la nueva contraseña

#### **Prueba desde Terminal:**

```bash
php artisan tinker
```

```php
// Enviar un email de prueba
Mail::raw('Prueba de email', function ($message) {
    $message->to('test@example.com')
            ->subject('Prueba');
});
```

---

### 7️⃣ **Configuración de Colas (Opcional pero Recomendado)**

Para que los emails se envíen en segundo plano (más rápido):

1. Cambia en `.env`:
```env
QUEUE_CONNECTION=database
```

2. Crea la tabla de trabajos:
```bash
php artisan queue:table
php artisan migrate
```

3. Inicia el worker:
```bash
php artisan queue:work
```

En producción, usa Supervisor para mantener el worker corriendo.

---

## 🔧 Solución de Problemas Comunes

### ❌ "Please wait before retrying"

**Causa:** Límite de intentos excedido.

**Solución:** Espera 60 segundos o limpia la tabla:
```sql
DELETE FROM password_reset_tokens WHERE email = 'tu@email.com';
```

### ❌ "This password reset token is invalid"

**Causa:** Token expirado (por defecto 60 minutos) o ya usado.

**Solución:** Solicita un nuevo enlace.

### ❌ El email no llega

**Verificar:**
1. `php artisan config:clear`
2. `php artisan cache:clear`
3. Revisa los logs: `storage/logs/laravel.log`
4. Verifica credenciales SMTP en `.env`

### ❌ Error de conexión SMTP

**Solución:** Verifica firewall, puerto y que el servicio esté corriendo.

---

## 📋 Checklist Final

- [ ] Migraciones ejecutadas (`password_reset_tokens` existe)
- [ ] `.env` configurado con credenciales de email
- [ ] `APP_URL` configurado correctamente
- [ ] Mailpit corriendo en desarrollo
- [ ] Probado el flujo completo de recuperación
- [ ] Email de prueba recibido en Mailpit
- [ ] Enlace de recuperación funciona
- [ ] Cambio de contraseña exitoso

---

## 🎨 Personalización del Email (Opcional)

Si quieres cambiar el contenido del email, publica las notificaciones:

```bash
php artisan vendor:publish --tag=laravel-notifications
```

Luego edita: `app/Notifications/ResetPasswordNotification.php` (si existe) o crea una personalizada.

---

## 📞 Recursos Adicionales

- [Laravel Mail Documentation](https://laravel.com/docs/10.x/mail)
- [Laravel Password Reset](https://laravel.com/docs/10.x/passwords)
- [Mailpit GitHub](https://github.com/axllent/mailpit)
- [SendGrid Laravel](https://sendgrid.com/solutions/laravel/)

---

## ✅ Conclusión

Para **desarrollo local**, solo necesitas:
1. Ejecutar migraciones
2. Verificar que Mailpit esté corriendo
3. Probar en `http://localhost:8025`

Para **producción**, configura un proveedor de email real (Gmail, SendGrid, Mailgun, etc.)

¡Listo! 🚀
