# CLAUDE.md — Proyecto Hoteles Tibisay · OVA VISION

**Versión:** 2.0 · Marzo 2026 (actualizado 2026-03-30)
**Cliente:** Hoteles Tibisay (OTHTICA)
**Agencia:** OVA VISION · ovavision.ve@gmail.com · +58 424 578 1707
**Contacto cliente:** Eduardo Chediak · 0424 418 61 07
**Contacto operativo:** Flor Acosta (Dirección Corporativa) · 0412 116 68 11 · ghotelestibisay@gmail.com
**Aprobadores de contenido:** Eduardo Chediak, Roberto Chediak, Flor Acosta

---

## 1. CONTEXTO DEL PROYECTO

OVA VISION es una agencia de automatización digital venezolana. El cliente es Hoteles Tibisay, una cadena hotelera con 7 sedes en Venezuela. El proyecto consiste en diseñar e implementar un ecosistema digital integrado: página web, email marketing, encuestas WhatsApp y encuestas QR.

### Objetivos del ecosistema

- Presencia web profesional con identidad de marca unificada
- Captación y nutrición de leads vía email marketing automatizado
- Medición de satisfacción del huésped post-estadía vía WhatsApp bot
- Canal alternativo de feedback vía encuestas QR en las propiedades
- Dashboard operativo para monitoreo en tiempo real

### Restricciones Venezuela

- Stack 95% gratuito (presupuesto limitado, economía venezolana)
- Internet inestable en algunas sedes (Maracaibo, Maturín, Canaima sin confirmación)
- PMS de escritorio sin APIs — la integración será manual/semiautomática inicialmente
- No tienen correos corporativos @dominio (solo Gmail gratuito)
- No tienen Meta Business Manager

---

## 2. LAS 7 SEDES

| # | Sede | Estado | Teléfono (confirmado) | PMS | Internet | Razón Social |
|---|------|--------|----------------------|-----|----------|-------------|
| 1 | Hotel Tibisay Mérida | Mérida | 0424 764 8679 | Hospes | ✅ Estable | Tibisay Hotel Resort C.A. (J316011666) |
| 2 | Hotel Tibisay Margarita | Nueva Esparta | 0424 861 0339 | Hospes | ✅ Estable | Tibisay Beach Resort 2010 C.A. (J299550383) |
| 3 | Hotel Tibisay Del Lago | Zulia (Maracaibo) | 0412 644 8918 | Hospes | ⚠️ Sin confirmar | OTHTICA (J410155299) |
| 4 | Hotel Tibisay Maturín | Monagas | 0412 358 2965 | Ratio | ⚠️ Sin confirmar | OTHTICA (J410155299) |
| 5 | Campamento Tibisay Canaima | Bolívar | 0424 830 8891 | — | ⚠️ Sin confirmar | OTHTICA (J410155299) |
| 6 | Hotel Tibisay Morrocoy | Falcón | 0422 645 4665 | New Hotel | ⚠️ Sin confirmar | Hotel Tibisay Hotel Boutique Morrocoy C.A. (J507567036) |
| 7 | Tibisay Catatumbo | Zulia | 0424 723 9935 | — | ⚠️ Sin confirmar | (pendiente) |

### Datos Operativos Confirmados (2026-03-30)

- **Horario de operación:** 24 horas (todas las sedes)
- **Check-in:** 3:00 PM
- **Check-out:** 1:00 PM
- **Alertas de rescate:** Eduardo las recibe automáticamente por correo; Flor revisa plataformas diariamente

### Soporte técnico PMS

- **Hospes** (Mérida, Margarita, Maracaibo): Sr. Vizcaya — 0414 518 4092
- **Ratio** (Maturín): Sr. Rojas — 0414 640 0161
- **New Hotel** (Morrocoy): Sr. Rafael Clemente — 0412 622 7724
- **Canaima y Catatumbo:** Sin PMS identificado

### Perfil por sede (diferenciación obligatoria)

Cada sede tiene un perfil de huésped distinto. Nunca uses contenido genérico — todo debe estar localizado.

- **Mérida:** Turismo de montaña/aventura. Teleférico (verificar estado operativo), páramos, restaurante con personal conocido. Tono cálido, aventurero.
- **Margarita:** Resort de playa. Beach Club, experiencias acuáticas, turismo nacional e internacional. Tono vibrante, vacacional.
- **Maracaibo (Del Lago):** Perfil corporativo/negocios + turismo. Lago de Maracaibo, Puente sobre el Lago. Tono profesional, B2B-friendly.
- **Maturín:** Huéspedes corporativos frecuentes, sector petrolero. Tono eficiente, VIP recurrente.
- **Canaima:** Ecoturismo, Salto Ángel, turistas internacionales. Flujo bilingüe ES/EN obligatorio. Tono naturaleza, aventura premium.
- **Morrocoy:** Playa boutique, cayos, snorkeling. Tono exclusivo, íntimo, boutique.
- **Catatumbo:** Fenómeno natural del Relámpago del Catatumbo, turismo de expedición. Tono explorador, único en el mundo.

---

## 3. INFRAESTRUCTURA TÉCNICA ACTUAL

### Web

- **Dominio:** tibisayhoteles.com
- **Registrador:** Servicios Hosting
- **Hosting:** Servicios Hosting — Plan Caribe Pro
- **CMS actual:** WordPress
- **Panel:** https://www.tibisayhoteles.com/cpanel
- **Estado:** Sitio activo pero requiere rediseño completo

### Email

- Sin correos corporativos @tibisayhoteles.com (tienen el dominio pero no los correos) — **PENDIENTE configurar en cPanel**
- Gmail actual del cliente: ghotelestibisay@gmail.com (Dirección Corporativa)
- **Plataforma elegida:** Mailchimp (free tier: 500 contactos, 1,000 emails/mes)
- **Cuenta Mailchimp:** Creada 2026-03-30 por OVA VISION
- Base de contactos: **+170 contactos** de agencias de viaje y mayoristas (recibida 2026-03-30)
- Segmentos: Mayoristas, Agencias de viaje (segmentos principales de la base actual)

### WhatsApp

- **Meta Business Manager:** No tienen — hay que crear desde cero
- **Estructura decidida:** Un número diferente por cada hotel
- **Números:** Pendiente asignación de números nuevos/libres por sede
- **Timing encuesta:** 2 horas post-checkout
- **Áreas a evaluar:** Todas (check-in, habitación, restaurante, personal, limpieza)
- **Alertas calificación baja (≤3/5):** Flor Acosta + Eduardo Chediak

### PMS

- Todos son aplicaciones de escritorio (no web)
- Sin acceso confirmado a base de datos
- Sin exportaciones automáticas confirmadas
- Decisión del cliente: Manejar la integración por separado (no instalar en servidores del hotel)
- Implicación: El flujo de checkout → encuesta será semimanual vía Google Sheets como puente

---

## 4. MÓDULOS DEL PROYECTO

### Módulo 01: Página Web ($1.500) — Semanas 1-2

**Entregables:**

- Sitio web responsive a medida con identidad Hoteles Tibisay
- Páginas por sede: habitaciones, servicios, galería, tarifas
- SEO on-page básico
- Formulario de contacto/reserva funcional
- Integración Google Analytics + Google Maps
- 100% mobile-first
- Captación de emails integrada con módulo de email marketing

**Decisiones técnicas:**

- El sitio actual es WordPress — evaluar si se rediseña sobre WordPress (menor curva de aprendizaje para el cliente) o se migra a una solución estática/headless (mejor rendimiento para Venezuela)
- Considerar velocidad de carga en conexiones venezolanas (optimización agresiva de imágenes, lazy loading, CDN)
- Estructura de URLs: tibisayhoteles.com/merida, tibisayhoteles.com/margarita, etc.

### Módulo 02: Email Marketing ($500) — Semana 3

**Entregables:**

- Setup de plataforma (Brevo o Mailchimp — tier gratuito)
- Integración web → base de contactos automática
- Secuencia de bienvenida automática (3 emails)
- Email post-estadía (trigger desde encuesta o checkout)
- Template de newsletter mensual (editable por OVA VISION)
- Secuencias por sede: pre-arrival, welcome, post-stay

**Nota:** Ya existen scripts de email para Margarita, Mérida, Maracaibo y Maturín del trabajo previo. Hay que adaptar para Morrocoy, Canaima y Catatumbo, y conectar con la plataforma elegida.

### Módulo 03: Encuestas WhatsApp ($300) — Semanas 3-4

**Entregables:**

- Bot WhatsApp Business automatizado por sede
- Flujo de satisfacción 3-5 ítems con lógica de branching
- Respuestas logueadas en Google Sheets
- Dashboard de resultados en tiempo real
- Sistema de alertas para calificaciones bajas

**Nota:** Ya existen scripts completos para 5 sedes (Margarita, Mérida, Maracaibo, Maturín, Canaima) con rutas Embajador/Retención/Rescate. Hay que crear los de Morrocoy y Catatumbo, y configurar la infraestructura técnica (Meta Business Manager, números, Make automations).

### Módulo 04: Encuestas QR ($200) — Semanas 3-4

**Entregables:**

- Formulario branded con logo del hotel por sede
- Código QR personalizado por sede (imprimible)
- Escala de valoración + preguntas abiertas
- Datos centralizados en Google Sheets
- QR actualizable sin cambiar el código físico impreso

---

## 5. PLAN DE EJECUCIÓN

| Fase | Semana | Foco | Entregable principal |
|------|--------|------|---------------------|
| 01 | Sem 1 | Setup + Web Base | Backend configurado, estructura de páginas, DNS |
| 02 | Sem 2 | Diseño web completo | Frontend listo, responsive, contenido por sede |
| 03 | Sem 3 | Email Marketing + Automaciones | Plataforma configurada, secuencias activas |
| 04 | Sem 3-4 | WhatsApp Bot + QR | Bots desplegados, QR generados, Sheets conectados |
| 05 | Sem 5 | QA + Lanzamiento + Capacitación | Testing, correcciones, entrenamiento al equipo |

---

## 6. STACK TECNOLÓGICO

| Componente | Herramienta | Costo |
|-----------|-------------|-------|
| Web hosting | Servicios Hosting (existente) | Incluido |
| CMS | WordPress (existente) | $0 |
| Email marketing | Mailchimp (free tier) | $0 |
| Automatización | Make (formerly Integromat) | $0-9/mes |
| WhatsApp API | Meta Business Platform | ~$1-3/mes |
| Encuestas/Dashboard | Google Sheets + Apps Script | $0 |
| QR | Generador dinámico (custom) | $0 |
| Repositorio/Docs | GitHub (tibisay-digital/) | $0 |

---

## 7. ARQUITECTURA DE ARCHIVOS

```
tibisay-digital/
├── CLAUDE.md                    # Este archivo
├── web/
│   ├── README.md                # Documentación del sitio
│   ├── theme/                   # Tema WordPress custom o archivos del sitio
│   ├── assets/                  # Imágenes optimizadas, logos, iconos
│   └── content/                 # Copys por sede en markdown
├── email/
│   ├── sequences/               # Secuencias por sede (pre-arrival, welcome, post-stay)
│   │   ├── margarita/
│   │   ├── merida/
│   │   ├── maracaibo/
│   │   ├── maturin/
│   │   ├── canaima/
│   │   ├── morrocoy/           # NUEVO
│   │   └── catatumbo/          # NUEVO
│   └── templates/               # Templates HTML de email
├── whatsapp/
│   ├── flows/                   # Scripts de bot por sede
│   │   ├── margarita.md
│   │   ├── merida.md
│   │   ├── maracaibo.md
│   │   ├── maturin.md
│   │   ├── canaima.md
│   │   ├── morrocoy.md         # NUEVO
│   │   └── catatumbo.md        # NUEVO
│   └── config/                  # Configuración de números y Meta Business
├── qr/
│   ├── forms/                   # Formularios por sede
│   └── codes/                   # QR generados
├── integrations/
│   ├── make-flows/              # Diagramas y config de Make
│   ├── sheets/                  # Templates de Google Sheets + Apps Script
│   └── pms-bridge/              # Documentación del puente PMS → Sheets
└── docs/
    ├── ficha-tecnica.md         # Datos del cliente (este onboarding)
    ├── brand-guide.md           # Guía de marca (cuando entreguen assets)
    └── runbook.md               # Manual operativo para el equipo del hotel
```

---

## 8. CONVENCIONES Y REGLAS

### Patrón de dual-output

Cada entregable genera dos versiones:

1. **Visual/interactivo** → Para presentar al cliente (HTML demo, PDF, mockup)
2. **Markdown estructurado** → Para que Claude Code consuma vía GitHub

### Diferenciación por sede

- Nunca contenido genérico "Hoteles Tibisay"
- Cada sede tiene: tono propio, landmarks locales, perfil de huésped, detalles operativos específicos
- Canaima siempre bilingüe ES/EN

### Idioma

- Todo el contenido cliente-facing: español venezolano
- Documentación técnica: español (puede incluir términos técnicos en inglés)
- Canaima: español + inglés

### Versionado

- Archivos entregables se versionan con fecha: v2026-03-25
- ZIPs de entrega se numeran secuencialmente

### Comunicación interna OVA VISION

- Español venezolano informal
- Claude lidera secuenciación y decisiones de contenido
- OVA valida dirección y aprueba

---

## 9. FASE ACTUAL — ESTADO AL 2026-03-30

### Decisiones tomadas

- **Arquitectura web:** WordPress child theme custom (tema "Tibisay Hoteles")
- **Email marketing:** Mailchimp (free tier) — Venezuela no admitida en Brevo
- **Backend encuestas:** Google Apps Script + Google Sheets
- **Formularios QR:** HTML puro hosted en WordPress (no Google Forms)

### PENDIENTE — Requiere acción de OVA VISION

#### Prioridad ALTA (esta semana)

1. **Limpiar y subir base de contactos a Mailchimp**
   - CSV con +170 contactos de agencias/mayoristas recibidos del cliente
   - Segmentar: Mayoristas vs Agencias
   - Importar a Mailchimp

2. **Crear Google Sheet + instalar Apps Script**
   - Crear Sheet "Hoteles Tibisay — Dashboard Operativo"
   - Pegar código de `integrations/sheets/apps-script.js`
   - Desplegar como Web App → copiar URL
   - Seguir guía: `integrations/sheets/SETUP.md`

3. **Configurar correos corporativos en cPanel**
   - Crear: info@tibisayhoteles.com, reservas@tibisayhoteles.com
   - Acceso cPanel disponible (credenciales recibidas 2026-03-30)

4. **Subir formularios QR al hosting**
   - Actualizar `APPS_SCRIPT_URL` en cada HTML
   - Subir a `public_html/qr/` vía cPanel

5. **Subir tema WordPress al hosting**
   - Subir `web/theme/` a `wp-content/themes/tibisay/`
   - Activar tema en WordPress admin
   - Crear las 10 páginas y configurar permalinks

6. **Configurar primer email en Mailchimp**
   - Crear primera campaña con contenido de `email/sequences/`
   - Enviar prueba → lanzar a lista real

#### Prioridad MEDIA (próximas 2 semanas)

7. **Crear Meta Business Manager**
   - Necesita: RIF escaneado de OTHTICA (solicitar a Eduardo)
   - Verificación toma 2-7 días hábiles

8. **Configurar Make.com**
   - Crear cuenta
   - Implementar los 6 flujos documentados en `integrations/make-flows/README.md`
   - Conectar Sheets + WhatsApp API

#### Requiere assets del cliente

9. **Logo del hotel** en PNG/SVG (solicitado a Eduardo 2026-03-30)
10. **Fotos de cada sede** — mínimo 5-10 por hotel (solicitadas)
11. **Tarifas actualizadas** por tipo de habitación y temporada
12. **RIF escaneado** de OTHTICA para Meta Business Manager
13. **Razón social** de Tibisay Catatumbo (pendiente)

#### Cierre del proyecto

14. **Prueba end-to-end** de todos los módulos
15. **Capacitación** al equipo de cada sede
16. **Aprobación de contenido** por Eduardo, Roberto y Flor

---

## 10. TRABAJO COMPLETADO (al 2026-03-30)

### Desarrollo completo (70 archivos en GitHub)

- ✅ Scripts WhatsApp bot: **7/7 sedes** con rutas Embajador/Retención/Rescate (incluye Morrocoy y Catatumbo)
- ✅ Secuencias email: **7/7 sedes** × 3 secuencias × 3 emails = 63 emails (incluye Canaima bilingüe)
- ✅ Tema WordPress completo: CSS mobile-first + 7 PHP templates + JS vanilla (sin jQuery)
- ✅ Contenido web: 9 páginas (home, 7 sedes, contacto, reservas) con SEO
- ✅ Formularios QR: **7 HTML funcionales** branded por sede con star ratings
- ✅ Google Apps Script: Backend completo (registro QR/WhatsApp, alertas, dashboard, resumen semanal)
- ✅ Documentación Make: 6 flujos con diagramas ASCII
- ✅ Google Sheets: Estructura completa con 7 tabs + 5 funciones Apps Script
- ✅ PMS Bridge: Documentación de los 3 sistemas + flujo manual
- ✅ Docs: Ficha técnica, runbook operativo, guía de marca (placeholder)
- ✅ Configuración WhatsApp: Códigos embajador/retención por sede, flujo técnico
- ✅ QR: Especificaciones de impresión, URLs dinámicas
- ✅ Cuenta Mailchimp creada

### Pendiente de despliegue (código listo, falta subir/configurar)

- ❌ Subir tema WordPress al hosting y activar
- ❌ Crear páginas en WordPress (10 páginas)
- ❌ Subir formularios QR a `public_html/qr/`
- ❌ Crear Google Sheet + instalar Apps Script
- ❌ Importar contactos a Mailchimp y lanzar primer email
- ❌ Correos corporativos @tibisayhoteles.com
- ❌ Meta Business Manager + WhatsApp Business API
- ❌ Configuración real de Make (flujos documentados, no desplegados)
- ❌ Subir logo y fotos del cliente (pendiente assets)
- ❌ Capacitación al equipo

---

## 11. CONTACTOS Y ACCESOS

| Recurso | Dato |
|---------|------|
| Dominio | tibisayhoteles.com |
| cPanel | https://www.tibisayhoteles.com/cpanel |
| WordPress admin | https://tibisayhoteles.com/_master_ |
| Email corporativo cliente | ghotelestibisay@gmail.com |
| Email marketing | Mailchimp (cuenta OVA VISION) |
| Repositorio | github.com/ovavisionve/Tibisay-Hoteles |
| Contacto principal | Eduardo Chediak — 0424 418 6107 |
| Dirección Corporativa | Flor Acosta — 0412 116 68 11 |
| Alertas operativas | Eduardo (automático por correo) + Flor (revisa plataformas diario) |
| Aprobación contenido | Eduardo Chediak, Roberto Chediak, Flor Acosta |

> ⚠️ Credenciales de acceso (cPanel, WordPress, Mailchimp) NO se almacenan en este archivo. Se manejan por canal seguro separado.

---

## 12. BASE DE CONTACTOS

Base recibida del cliente el 2026-03-30 con +170 contactos de agencias de viaje y mayoristas.

- **Archivo:** `email/contacts/contactos-tibisay.csv` (por crear)
- **Segmentos:**
  - Mayoristas (~50 contactos): Turismo Maso, Baredu, Omega, Globex, Hover Tours, etc.
  - Agencias (~120 contactos): Agencias de viaje nacionales
- **Plataforma destino:** Mailchimp
- **Estado:** Pendiente limpieza y carga

---

*Documento generado por OVA VISION · Marzo 2026 · Actualizado 2026-03-30 · Para uso exclusivo en Claude Code como contexto de proyecto*
