#!/usr/bin/env php
<?php

/**
 * Script de prueba para verificar configuración de Email
 * 
 * Ejecutar: php test-email.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║         PRUEBA DE CONFIGURACIÓN DE EMAIL                 ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";

// Mostrar configuración actual
echo "📋 Configuración actual:\n";
echo "   MAIL_MAILER: " . Config::get('mail.default') . "\n";
echo "   MAIL_HOST: " . Config::get('mail.mailers.smtp.host') . "\n";
echo "   MAIL_PORT: " . Config::get('mail.mailers.smtp.port') . "\n";
echo "   MAIL_FROM: " . Config::get('mail.from.address') . "\n";
echo "   MAIL_FROM_NAME: " . Config::get('mail.from.name') . "\n";
echo "\n";

// Preguntar email de destino
echo "📧 Ingresa el email de destino para la prueba: ";
$handle = fopen ("php://stdin","r");
$destinatario = trim(fgets($handle));

if (empty($destinatario) || !filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Email inválido!\n\n";
    exit(1);
}

echo "\n🚀 Enviando email de prueba a: $destinatario\n";
echo "⏳ Por favor espera...\n\n";

try {
    Mail::raw('¡Hola! 👋

Este es un email de prueba desde Pasanaco Digital.

Si estás leyendo esto, significa que la configuración de email está funcionando correctamente. ✅

Detalles de la configuración:
- Servidor: ' . Config::get('mail.mailers.smtp.host') . '
- Puerto: ' . Config::get('mail.mailers.smtp.port') . '
- Desde: ' . Config::get('mail.from.address') . '

¡Todo listo para enviar emails de recuperación de contraseña!

---
Pasanaco Digital
' . Config::get('app.url'), function ($message) use ($destinatario) {
        $message->to($destinatario)
                ->subject('✅ Prueba de Email - Pasanaco Digital');
    });

    echo "✅ ¡Email enviado exitosamente!\n\n";
    
    if (Config::get('mail.default') === 'smtp' && Config::get('mail.mailers.smtp.host') === 'mailpit') {
        echo "💡 TIP: Revisa el email en Mailpit: http://localhost:8025\n";
    }
    
    echo "\n";
    echo "╔═══════════════════════════════════════════════════════════╗\n";
    echo "║  ✅ La configuración de email está funcionando           ║\n";
    echo "║                                                           ║\n";
    echo "║  Ya puedes usar la recuperación de contraseña en:        ║\n";
    echo "║  " . Config::get('app.url') . "/password/reset             ║\n";
    echo "╚═══════════════════════════════════════════════════════════╝\n";
    echo "\n";

} catch (Exception $e) {
    echo "❌ ERROR al enviar el email:\n\n";
    echo "   " . $e->getMessage() . "\n\n";
    
    echo "🔧 Soluciones posibles:\n";
    echo "   1. Verifica las credenciales en el archivo .env\n";
    echo "   2. Ejecuta: php artisan config:clear\n";
    echo "   3. Revisa los logs: storage/logs/laravel.log\n";
    
    if (Config::get('mail.mailers.smtp.host') === 'mailpit') {
        echo "   4. Asegúrate de que Mailpit esté corriendo\n";
        echo "   5. Verifica que el puerto 1025 esté disponible\n";
    }
    
    echo "\n";
    exit(1);
}
