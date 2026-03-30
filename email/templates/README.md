# Templates HTML de Email — Hoteles Tibisay

**Version:** v2026-03-30
**Estado:** Completado
**Plataforma:** Mailchimp (free tier)

---

## Templates Creados

### 1. transaccional.html — Confirmacion de Reserva
- Confirmacion de reserva con detalles (fechas, habitacion, huespedes)
- Datos de contacto de la sede
- CTA a pagina de la sede
- Variables: `{{nombre}}`, `{{sede}}`, `{{fecha_checkin}}`, `{{fecha_checkout}}`, `{{tipo_habitacion}}`, `{{num_huespedes}}`, `{{num_noches}}`, `{{numero_reserva}}`

### 2. welcome.html — Bienvenida al Check-in
- Tabla de servicios del hotel (recepcion, restaurante, Wi-Fi)
- Seccion de descubrimiento local por sede
- Contacto rapido (telefono habitacion + WhatsApp)
- CTA a actividades
- Variables: `{{nombre}}`, `{{sede}}`, `{{wifi_red}}`, `{{wifi_clave}}`, `{{horario_restaurante}}`, `{{whatsapp_sede}}`, `{{destino}}`, `{{descripcion_local}}`

### 3. post-stay.html — Post-Estadia
- Agradecimiento personalizado
- CTA prominente a encuesta QR
- Link a Google Review
- Oferta de retorno con descuento
- Variables: `{{nombre}}`, `{{sede}}`, `{{link_encuesta}}`, `{{link_google_review}}`, `{{descuento_retorno}}`

### 4. newsletter.html — Newsletter Mensual
- Secciones modulares: noticia destacada, promociones (x2), tips de viaje, sedes
- Editable por OVA VISION (reemplazar variables por contenido real)
- Footer con cancelar suscripcion y preferencias
- Variables: `{{mes_ano}}`, `{{nombre}}`, `{{titulo_noticia}}`, `{{resumen_noticia}}`, `{{promo1_titulo}}`, `{{promo2_titulo}}`, `{{tip_titulo}}`, etc.

---

## Especificaciones Tecnicas

- **Ancho maximo:** 600px
- **Responsive:** Si (mobile-first con media queries)
- **Compatibilidad:** Gmail, Outlook (con VML fallbacks), Apple Mail, Yahoo
- **Peso:** < 20KB cada template (sin imagenes)
- **Plataforma:** Mailchimp (free tier: 500 contactos, 1,000 emails/mes)
- **Colores de marca:** Primary #1a5276, Secondary #e67e22, Accent #27ae60
- **Fuentes:** System font stack (sin dependencias externas)

---

## Checklist

- [x] Definir plataforma de email marketing (Mailchimp)
- [x] Disenar template base con branding Tibisay
- [x] Crear variante transaccional (confirmacion de reserva)
- [x] Crear variante welcome (bienvenida al check-in)
- [x] Crear variante post-stay (agradecimiento + encuesta + Google Review)
- [x] Crear variante newsletter (secciones modulares editables)
- [ ] Testear en Gmail, Outlook, Apple Mail
- [ ] Importar a Mailchimp
- [ ] Configurar variables de personalizacion en Mailchimp

---

*Templates v2026-03-30 · OVA VISION*
