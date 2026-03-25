# Modulo Web — Hoteles Tibisay

**Version:** v2026-03-25
**Modulo:** 01 — Pagina Web
**Presupuesto:** $1.500
**Timeline:** Semanas 1-2
**URL actual:** https://tibisayhoteles.com
**Admin:** https://tibisayhoteles.com/master

---

## 1. Estado Actual

El sitio web actual en tibisayhoteles.com esta montado sobre WordPress en un hosting de Servicios Hosting (Plan Caribe Pro). El sitio esta activo pero requiere un **rediseno completo** para:

- Unificar la identidad visual de las 7 sedes
- Implementar diseno mobile-first (actualmente no optimizado)
- Mejorar velocidad de carga para conexiones venezolanas
- Integrar captacion de leads para el modulo de email marketing
- Incorporar las nuevas sedes (Morrocoy, Catatumbo)

### Infraestructura existente

| Componente | Detalle |
|-----------|---------|
| Dominio | tibisayhoteles.com |
| Registrador | Servicios Hosting |
| Hosting | Servicios Hosting — Plan Caribe Pro |
| CMS | WordPress |
| cPanel | https://www.tibisayhoteles.com/cpanel |
| SSL | Verificar estado actual |

---

## 2. Decision de Arquitectura

### Recomendacion: Opcion B — WordPress con tema ligero (Kadence o GeneratePress)

Se recomienda **mantener WordPress** con un tema starter profesional ligero. Las opciones evaluadas:

| Opcion | Pros | Contras | Veredicto |
|--------|------|---------|-----------|
| **A: Tema custom (child theme)** | Control total, unico | Mayor tiempo de desarrollo, dificil de mantener | Descartada |
| **B: Tema ligero (Kadence/GeneratePress)** | Rapido, mantenible, $0, client-friendly | Menos personalizable que custom | **Recomendada** |
| **C: Estatico (Hugo/Astro)** | Maximo rendimiento, seguro | Dificil para el cliente, requiere deploy pipeline | Descartada para este cliente |

### Justificacion

1. **Familiaridad:** El cliente ya tiene WordPress — no hay curva de aprendizaje nueva
2. **Costo:** $0 — tanto Kadence como GeneratePress tienen versiones gratuitas robustas
3. **Hosting existente:** Plan Caribe Pro ya soporta WordPress, no se requiere migracion
4. **Mantenimiento:** El equipo de OVA VISION (o eventualmente el cliente) puede editar contenido sin conocimientos tecnicos
5. **Rendimiento:** Kadence y GeneratePress son los temas mas ligeros del ecosistema WordPress — rendimiento comparable a soluciones estaticas con cache adecuado
6. **Presupuesto limitado:** La economia venezolana exige que la solucion sea sostenible a costo minimo

### Temas recomendados (en orden de preferencia)

1. **Kadence** — Builder integrado, starter templates, schema markup, excelente rendimiento
2. **GeneratePress** — Ultraligero (~30KB), hooks system, ideal para desarrolladores

### Plugins esenciales (minimos)

- **Kadence Blocks** o **GenerateBlocks** — Page builder ligero
- **WP Super Cache** o **LiteSpeed Cache** — Cache de paginas
- **Smush** o **ShortPixel** — Optimizacion de imagenes
- **Yoast SEO** o **Rank Math** — SEO on-page
- **WPForms Lite** — Formularios de contacto/reserva
- **Google Site Kit** — Analytics + Search Console
- **UpdraftPlus** — Backups automaticos

> **Regla critica:** Maximo 10-12 plugins. Cada plugin adicional degrada rendimiento. En Venezuela, donde las conexiones son inestables, esto es aun mas critico.

---

## 3. Estructura de Paginas

```
/                    → Home (cadena completa, hero rotativo por sede)
/merida              → Hotel Tibisay Merida
/margarita           → Hotel Tibisay Margarita
/maracaibo           → Hotel Tibisay Del Lago
/maturin             → Hotel Tibisay Maturin
/canaima             → Campamento Tibisay Canaima (bilingue ES/EN)
/morrocoy            → Hotel Tibisay Morrocoy
/catatumbo           → Tibisay Catatumbo
/contacto            → Formulario centralizado + datos por sede
/reservas            → Formulario de reservas (centralizado o por sede)
/politica-privacidad → Requerido para email marketing y WhatsApp
/terminos            → Terminos de servicio
```

### Estructura interna por sede

Cada pagina de sede incluye las siguientes secciones (single page, scroll):

1. **Hero** — Imagen principal + CTA de reserva
2. **Descripcion** — Sobre el hotel, tono localizado
3. **Habitaciones** — Tipos, capacidad, amenidades
4. **Servicios** — Restaurante, piscina, spa, etc. (segun sede)
5. **Galeria** — Grid de imagenes optimizadas
6. **Tarifas** — Tabla de precios (actualizable por el cliente)
7. **Ubicacion** — Google Maps embed + como llegar
8. **Testimonios** — Reseñas destacadas (alimentadas por el sistema de encuestas)
9. **CTA Final** — Reserva + captacion de email

### Diferenciacion por sede (obligatorio)

- **Merida:** Tono calido/aventurero. Referencia a paramos, teleferico, montaña.
- **Margarita:** Tono vibrante/vacacional. Beach Club, experiencias acuaticas.
- **Maracaibo (Del Lago):** Tono profesional/B2B. Lago, Puente sobre el Lago, salones de eventos.
- **Maturin:** Tono eficiente/VIP. Perfil corporativo, sector petrolero.
- **Canaima:** Tono naturaleza/aventura premium. Salto Angel. **Bilingue ES/EN obligatorio.**
- **Morrocoy:** Tono exclusivo/boutique. Cayos, snorkeling, intimidad.
- **Catatumbo:** Tono explorador/unico. Relampago del Catatumbo, expedicion.

---

## 4. Optimizacion de Rendimiento para Venezuela

La velocidad de carga es critica. Muchas sedes tienen internet inestable y los usuarios finales pueden tener conexiones lentas (3G/4G).

### Checklist de rendimiento

- [ ] **Imagenes:** Todas en formato WebP, max 200KB por imagen, lazy loading nativo
- [ ] **Plugins:** Maximo 10-12 activos
- [ ] **Cache:** WP Super Cache o LiteSpeed Cache configurado
- [ ] **Minificacion:** CSS y JS minificados y combinados
- [ ] **Fonts:** Maximo 2 familias tipograficas, preferir system fonts donde sea posible
- [ ] **CDN:** Evaluar Cloudflare (gratis) — puede mejorar latencia para usuarios en Venezuela
- [ ] **Base de datos:** Limpieza de revisiones y transients periodica
- [ ] **Above the fold:** CSS critico inline para primer render rapido
- [ ] **Hosting:** Verificar PHP 8.x en Plan Caribe Pro
- [ ] **GZIP:** Verificar compresion habilitada en cPanel

### Objetivos de rendimiento

| Metrica | Objetivo |
|---------|----------|
| First Contentful Paint | < 2.5s |
| Largest Contentful Paint | < 4.0s |
| Time to Interactive | < 5.0s |
| PageSpeed Insights (mobile) | > 70 |
| Peso total de pagina | < 1.5MB |

---

## 5. SEO On-Page — Checklist

### Por cada pagina

- [ ] Title tag unico y descriptivo (< 60 caracteres)
- [ ] Meta description unica (< 160 caracteres)
- [ ] H1 unico por pagina
- [ ] Jerarquia de headings correcta (H1 > H2 > H3)
- [ ] URLs limpias y descriptivas (slug en español sin acentos)
- [ ] Alt text en todas las imagenes
- [ ] Schema markup (Hotel, LocalBusiness) via plugin o manual
- [ ] Open Graph tags para compartir en redes
- [ ] Canonical URLs configuradas
- [ ] Sitemap XML generado automaticamente
- [ ] robots.txt configurado

### Keywords principales por sede

| Sede | Keywords objetivo |
|------|------------------|
| Merida | hotel merida venezuela, hotel tibisay merida, alojamiento merida |
| Margarita | hotel margarita isla, resort margarita, hotel playa margarita |
| Maracaibo | hotel maracaibo, hotel lago maracaibo, hotel negocios maracaibo |
| Maturin | hotel maturin, hotel corporativo maturin, alojamiento maturin |
| Canaima | campamento canaima, canaima camp, angel falls accommodation |
| Morrocoy | hotel morrocoy, hotel boutique morrocoy, hotel playa morrocoy |
| Catatumbo | hotel catatumbo, relampago catatumbo tour, catatumbo lightning |

---

## 6. Enfoque Mobile-First

- Diseno se construye primero para movil, luego escala a desktop
- Breakpoints: 375px (movil), 768px (tablet), 1024px (desktop), 1440px (wide)
- Menu hamburguesa en movil con acceso rapido a: Reservar, Llamar, WhatsApp
- Botones de CTA con tamaño minimo de 44x44px (touch target)
- Formularios simplificados en movil (campos minimos necesarios)
- Galeria en formato carousel/swipe en movil
- Google Maps con link a app nativa en movil

---

## 7. Integracion de Captacion de Email

La captacion de leads alimenta el Modulo 02 (Email Marketing). Puntos de captura:

### Formularios de captacion

1. **Header/navbar:** CTA "Recibe ofertas exclusivas" → popup/slide-in
2. **Footer global:** Formulario de suscripcion (email + sede de interes)
3. **Pagina de sede:** CTA contextual ("Recibe ofertas de Hotel Tibisay Merida")
4. **Exit intent popup:** Solo en desktop, 1 vez por sesion
5. **Post-reserva:** Checkbox de opt-in en formulario de reserva

### Datos a capturar

- Email (obligatorio)
- Nombre (opcional)
- Sede de interes (dropdown o auto-detectado por pagina)
- Tipo: turista nacional / internacional / corporativo (opcional)

### Integracion tecnica

- Formularios conectan via API a Brevo o Mailchimp (segun eleccion final)
- Alternativa sin API: Formularios envian a Google Sheets via webhook → Make sincroniza con plataforma de email
- Doble opt-in habilitado (requerido por GDPR/buenas practicas)
- Pagina de confirmacion post-suscripcion con branding

---

## 8. Google Analytics + Maps

### Google Analytics 4

- [ ] Crear propiedad GA4 para tibisayhoteles.com
- [ ] Instalar via Google Site Kit (plugin WordPress)
- [ ] Configurar eventos personalizados:
  - `form_submit_reserva` — Envio de formulario de reserva
  - `form_submit_contacto` — Envio de formulario de contacto
  - `email_signup` — Suscripcion a newsletter
  - `click_whatsapp` — Click en boton de WhatsApp
  - `click_phone` — Click en numero telefonico
- [ ] Configurar conversiones para los eventos criticos
- [ ] Vincular con Google Search Console

### Google Maps

- [ ] API Key de Google Maps (verificar si el hosting ya tiene una)
- [ ] Embed de mapa por cada sede con pin personalizado
- [ ] Fallback: Link directo a Google Maps si el embed falla (importante para conexiones lentas)
- [ ] Direcciones completas en formato schema.org

### Mapas por sede

| Sede | Direccion (pendiente confirmacion) |
|------|-----------------------------------|
| Merida | Pendiente |
| Margarita | Pendiente |
| Maracaibo | Pendiente |
| Maturin | Pendiente |
| Canaima | Pendiente |
| Morrocoy | Pendiente |
| Catatumbo | Pendiente |

> Las direcciones exactas deben ser confirmadas por Eduardo Chediak antes de publicar.

---

## 9. Entregables del Modulo

| # | Entregable | Formato | Estado |
|---|-----------|---------|--------|
| 1 | Sitio web responsive completo | WordPress live | Pendiente |
| 2 | 7 paginas de sede + home + contacto + reservas | HTML/WordPress | Pendiente |
| 3 | SEO on-page configurado | Yoast/Rank Math | Pendiente |
| 4 | Google Analytics 4 integrado | GA4 | Pendiente |
| 5 | Formularios de captacion de email | WPForms + API | Pendiente |
| 6 | Optimizacion de rendimiento | Cache + CDN | Pendiente |
| 7 | Backup automatico configurado | UpdraftPlus | Pendiente |

---

## 10. Proximos Pasos (Semana 1)

1. Auditar el sitio actual: plugins, tema, contenido reutilizable
2. Elegir tema definitivo (Kadence vs GeneratePress) tras pruebas en staging
3. Definir paleta de colores y tipografia con assets de marca del cliente
4. Recopilar contenido fotografico por sede (solicitar a Eduardo Chediak)
5. Configurar entorno de staging para desarrollo sin afectar el sitio actual
6. Confirmar direcciones fisicas de las 7 sedes

---

*Documento generado por OVA VISION · v2026-03-25*
