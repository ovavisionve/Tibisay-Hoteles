# CLAUDE.md — Proyecto Hoteles Tibisay · OVA VISION

**Versión:** 1.0 · Marzo 2026
**Cliente:** Hoteles Tibisay (OTHTICA)
**Agencia:** OVA VISION · ovavision.ve@gmail.com · +58 424 578 1707
**Contacto cliente:** Eduardo Chediak · 0424 418 61 07
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

| # | Sede | Estado | Teléfono | PMS | Internet | Razón Social |
|---|------|--------|----------|-----|----------|-------------|
| 1 | Hotel Tibisay Mérida | Mérida | 0424 764 8679 | Hospes | ✅ Estable | Tibisay Hotel Resort C.A. (J316011666) |
| 2 | Hotel Tibisay Margarita | Nueva Esparta | 0424 764 8679 | Hospes | ✅ Estable | Tibisay Beach Resort 2010 C.A. (J299550383) |
| 3 | Hotel Tibisay Del Lago | Zulia (Maracaibo) | 0412 644 8918 | Hospes | ⚠️ Sin confirmar | OTHTICA (J410155299) |
| 4 | Hotel Tibisay Maturín | Monagas | 0412 358 2965 | Ratio | ⚠️ Sin confirmar | OTHTICA (J410155299) |
| 5 | Campamento Tibisay Canaima | Bolívar | 0424 830 8891 | — | ⚠️ Sin confirmar | OTHTICA (J410155299) |
| 6 | Hotel Tibisay Morrocoy | Falcón | 0422 645 4665 | New Hotel | ⚠️ Sin confirmar | Hotel Tibisay Hotel Boutique Morrocoy C.A. (J507567036) |
| 7 | Tibisay Catatumbo | Zulia | 0424 723 9935 | — | ⚠️ Sin confirmar | (pendiente) |

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

- Sin correos corporativos @tibisayhoteles.com (tienen el dominio pero no los correos)
- Gmail gratuito es lo que usan actualmente
- Base de contactos: En proceso de construcción (formato Excel/CSV)
- Segmentos: Turistas nacionales, internacionales, corporativos, grupos/eventos, recurrentes

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
| Email marketing | Brevo o Mailchimp (free tier) | $0-5/mes |
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

## 9. FASE ACTUAL: SEMANA 1 — SETUP + WEB BASE

### Tareas inmediatas

1. **Auditoría del sitio actual**
   - Revisar tibisayhoteles.com actual (estructura, contenido, plugins, tema)
   - Evaluar qué se puede reutilizar vs. qué se rehace
   - Documentar estado actual en web/README.md

2. **Decisión de arquitectura web**
   - Opción A: Rediseño sobre WordPress (tema custom child theme)
   - Opción B: Tema starter profesional (Starter Templates, Kadence, etc.)
   - Opción C: Migración a solución estática (Hugo/Astro + deploy en mismo hosting)
   - Criterios: velocidad en Venezuela, facilidad de mantenimiento, costo

3. **Estructura de páginas**
   ```
   / (Home — cadena completa)
   /merida
   /margarita
   /maracaibo
   /maturin
   /canaima (bilingüe)
   /morrocoy
   /catatumbo
   /contacto
   /reservas (formulario centralizado o por sede)
   ```

4. **Setup de correos corporativos** (prerequisito para email marketing)
   - Configurar al menos: reservas@tibisayhoteles.com, info@tibisayhoteles.com
   - Opciones: Google Workspace ($6/user/mes), Zoho Mail (free tier), o configuración en cPanel

5. **Google Sheets base operativa**
   - Crear estructura de sheets para el puente PMS → encuestas
   - Sheet de checkouts (manual input por recepcionistas)
   - Sheet de respuestas WhatsApp
   - Sheet de respuestas QR
   - Dashboard consolidado

6. **Meta Business Manager**
   - Crear cuenta
   - Verificar negocio
   - Solicitar acceso WhatsApp Business API
   - Timeline: verificación toma 2-7 días hábiles

---

## 10. TRABAJO PREVIO COMPLETADO

Estos entregables ya existen de fases anteriores y deben integrarse, no rehacerse.

- ✅ Scripts WhatsApp bot: Margarita, Mérida, Maracaibo, Maturín, Canaima (con rutas Embajador/Retención/Rescate)
- ✅ Secuencias email: Margarita, Mérida, Maracaibo, Maturín (pre-arrival, welcome, post-stay × 3 emails c/u)
- ✅ Documentación Make: 6 flujos (checkout trigger, WhatsApp dispatch, email dispatch, rescue alerts, response logging, kill switch)
- ✅ Google Sheets dashboard con fórmulas + Apps Script (tag frequency, weekly average alerts)
- ✅ Demo HTML interactivo (journey completo Margarita)
- ✅ Ficha técnica (PDF + Word editable)
- ✅ Repositorio GitHub tibisay-digital/ con estructura markdown

### Pendiente por crear

- ❌ Scripts WhatsApp: Morrocoy, Catatumbo
- ❌ Secuencias email: Canaima, Morrocoy, Catatumbo
- ❌ Sitio web completo
- ❌ Formularios QR por sede
- ❌ Correos corporativos @tibisayhoteles.com
- ❌ Meta Business Manager + WhatsApp Business API
- ❌ Configuración real de Make (los flujos están documentados, no desplegados)
- ❌ Capacitación al equipo

---

## 11. CONTACTOS Y ACCESOS

| Recurso | Dato |
|---------|------|
| Dominio | tibisayhoteles.com |
| cPanel | https://www.tibisayhoteles.com/cpanel |
| WordPress admin | https://tibisayhoteles.com/master |
| Contacto principal | Eduardo Chediak — 0424 418 6107 |
| Alertas operativas | Flor Acosta + Eduardo Chediak |
| Aprobación contenido | Eduardo Chediak, Roberto Chediak, Flor Acosta |

> ⚠️ Credenciales de acceso NO se almacenan en este archivo. Se manejan por canal seguro separado.

---

*Documento generado por OVA VISION · Marzo 2026 · Para uso exclusivo en Claude Code como contexto de proyecto*
