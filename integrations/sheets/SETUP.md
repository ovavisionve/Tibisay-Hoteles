# Guía de Instalación — Google Sheets + Apps Script

**Versión:** v2026-03-25

---

## Paso 1: Crear el Google Sheet

1. Ve a [sheets.google.com](https://sheets.google.com)
2. Crea un nuevo Google Sheet
3. Nómbralo: **Hoteles Tibisay — Dashboard Operativo**
4. No necesitas crear hojas manualmente — el script las crea automáticamente

---

## Paso 2: Instalar el Apps Script

1. En el Google Sheet, ve a **Extensiones → Apps Script**
2. Se abre el editor de Apps Script
3. Borra todo el código que aparezca por defecto
4. Copia y pega el contenido completo de `apps-script.js`
5. Guarda (Ctrl+S)
6. Dale un nombre al proyecto: "Tibisay Backend"

---

## Paso 3: Desplegar como Web App

1. En Apps Script, haz clic en **Implementar → Nueva implementación**
2. Tipo: **Aplicación web**
3. Configuración:
   - **Descripción:** Backend Encuestas Hoteles Tibisay
   - **Ejecutar como:** Tu cuenta de Google
   - **Quién tiene acceso:** **Cualquier persona** (importante para que los formularios puedan enviar datos)
4. Haz clic en **Implementar**
5. **Copia la URL** que aparece — la necesitarás para los formularios
6. La URL se ve así: `https://script.google.com/macros/s/AKfycb.../exec`

---

## Paso 4: Conectar los Formularios HTML

1. Abre cada archivo HTML de encuesta (margarita.html, merida.html, etc.)
2. Busca la línea: `const APPS_SCRIPT_URL = 'PENDIENTE_CONFIGURAR';`
3. Reemplaza `PENDIENTE_CONFIGURAR` con la URL del Paso 3
4. Sube los archivos HTML a WordPress (ver Paso 5)

---

## Paso 5: Subir Formularios a WordPress

### Opción A: Como páginas HTML (recomendado)

1. Accede al cPanel: https://www.tibisayhoteles.com/cpanel
2. Ve al **Administrador de archivos**
3. Navega a `public_html/qr/`
4. Crea la carpeta `qr` si no existe
5. Sube cada archivo HTML:
   - `margarita.html` → `public_html/qr/margarita.html`
   - `merida.html` → `public_html/qr/merida.html`
   - etc.
6. Las URLs serán: `tibisayhoteles.com/qr/margarita.html`

### Opción B: Redirects en WordPress

1. En WordPress admin, instala el plugin **Redirection** (gratuito)
2. Crea redirects:
   - `/qr/margarita` → `/qr/margarita.html`
   - `/qr/merida` → `/qr/merida.html`
   - etc.
3. Así los QR apuntan a URLs limpias sin `.html`

---

## Paso 6: Configurar Triggers

1. En Apps Script, ejecuta la función `configurarTriggers()` una vez
2. Esto crea:
   - Actualización automática del dashboard cada hora
   - Resumen semanal por email los lunes a las 9am

---

## Paso 7: Configurar Alertas

1. En el código de Apps Script, busca la sección `CONFIG`
2. Actualiza `EMAILS_ALERTA` con los emails de Flor y Eduardo
3. Guarda y vuelve a desplegar (Implementar → Gestionar implementaciones → Editar)

---

## Paso 8: Prueba

1. Ejecuta `testRespuestaQR()` desde Apps Script para verificar que todo funciona
2. Revisa que se creó la hoja "Respuestas QR" con el dato de prueba
3. Abre uno de los formularios HTML en tu navegador
4. Llena la encuesta y envía
5. Verifica que la respuesta llegó al Google Sheet

---

## Paso 9: Generar QR Codes

1. Usa cualquier generador QR gratuito (ej: qr-code-generator.com)
2. Genera un QR para cada URL:
   - `https://tibisayhoteles.com/qr/margarita`
   - `https://tibisayhoteles.com/qr/merida`
   - `https://tibisayhoteles.com/qr/maracaibo`
   - `https://tibisayhoteles.com/qr/maturin`
   - `https://tibisayhoteles.com/qr/canaima`
   - `https://tibisayhoteles.com/qr/morrocoy`
   - `https://tibisayhoteles.com/qr/catatumbo`
3. Descarga en PNG a 300 DPI mínimo
4. Imprime y distribuye en las sedes

---

## Compartir el Google Sheet

Comparte el Sheet con las personas que necesitan acceso:

| Persona | Rol | Acceso |
|---------|-----|--------|
| Eduardo Chediak | Director | Editor |
| Flor Acosta | Operaciones | Editor |
| Roberto Chediak | Aprobador | Visor |
| OVA VISION | Agencia | Editor |
| Recepcionistas | Operativo | Editor (solo hoja Checkouts) |

---

## Solución de Problemas

| Problema | Solución |
|----------|----------|
| Formulario no envía datos | Verificar que la URL del Apps Script está correcta y que el despliegue permite "Cualquier persona" |
| No llegan alertas por email | Verificar EMAILS_ALERTA en CONFIG y que la cuenta de Google tiene permisos de MailApp |
| Dashboard no se actualiza | Ejecutar `configurarTriggers()` de nuevo |
| Error de permisos en Apps Script | Re-autorizar: ejecutar cualquier función manualmente y aceptar los permisos |

---

*Guía de instalación v2026-03-25 · OVA VISION*
