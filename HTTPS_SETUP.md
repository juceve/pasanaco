# Configuración HTTPS para PWA

## ⚠️ IMPORTANTE: HTTPS es OBLIGATORIO para PWA

Las Progressive Web Apps **requieren HTTPS** para funcionar correctamente. Los Service Workers y muchas APIs web modernas no funcionan en HTTP por razones de seguridad.

## Opciones de Configuración:

### 1. **Desarrollo Local (Laravel Valet/Herd)**
```bash
# Con Laravel Valet
valet secure pasanaco

# Con Laravel Herd
herd secure pasanaco
```

### 2. **Desarrollo Local (Laragon)**
1. Abrir Laragon
2. Ir a Menu → SSL → Create Certificate for pasanaco.test
3. Reiniciar Apache
4. Acceder via https://pasanaco.test

### 3. **Producción (Recomendado)**
- **Cloudflare**: SSL gratuito y automático
- **Let's Encrypt**: Certificado SSL gratuito
- **Hosting Provider**: Muchos proveedores incluyen SSL

## Verificación HTTPS:
1. Abrir la aplicación en navegador
2. Verificar que la URL inicie con `https://`
3. Verificar que aparezca el candado de seguridad
4. No debe haber advertencias de contenido mixto

## Prueba PWA:
1. En Chrome DevTools → Application → Manifest
2. Verificar que no haya errores
3. En Service Workers, verificar que esté registrado
4. Probar la opción "Add to Home Screen"

## URLs de Prueba:
- **Desarrollo**: https://pasanaco.test (con Laragon SSL)
- **Producción**: https://tudominio.com

⚠️ **Sin HTTPS, la PWA NO funcionará en dispositivos móviles reales.**