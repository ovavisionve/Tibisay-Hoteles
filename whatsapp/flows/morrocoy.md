# Script WhatsApp Bot — Hotel Tibisay Morrocoy

**Sede:** Hotel Tibisay Morrocoy
**Estado:** Falcón
**Perfil:** Playa boutique · Cayos · Snorkeling
**Tono:** Exclusivo, íntimo, boutique
**Timing:** 2 horas post-checkout
**Alertas ≤3/5:** Flor Acosta + Eduardo Chediak

---

## Mensaje de Inicio

> ¡Hola, {nombre}! 🐚 Soy el asistente de **Hotel Tibisay Morrocoy**. Esperamos que los cayos y el mar cristalino te hayan regalado momentos inolvidables. ¿Nos compartes tu experiencia en 2 minutos?
>
> 1️⃣ Sí, quiero responder
> 2️⃣ Ahora no

**Si elige 2:** "¡Perfecto! Si en algún momento quieres compartir tu opinión, escríbenos. ¡Que el azul del mar te acompañe! 🌊"

---

## Pregunta 1 — Check-in y Recepción

> ¿Cómo calificarías tu experiencia de check-in y la bienvenida en recepción?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 2 — Habitación

> ¿Qué te pareció tu habitación? (limpieza, comodidad, ambiente boutique)
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 3 — Experiencias de Playa y Cayos

> ¿Cómo fue tu experiencia con las actividades de playa? (cayos, snorkeling, paseos en lancha)
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)
> 6️⃣ No las utilicé

---

## Pregunta 4 — Personal y Servicio

> ¿Cómo calificarías la atención del personal del hotel? Nos enorgullecemos de ofrecer un trato personalizado.
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 5 — Satisfacción General

> En general, ¿cómo calificarías tu estadía en Hotel Tibisay Morrocoy?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Lógica de Branching

### Ruta Embajador (promedio ≥ 4.0)

> ¡Qué alegría, {nombre}! Nos encanta saber que Morrocoy te atrapó tanto como a nosotros. 🎉🐚
>
> ¿Te gustaría dejarnos una reseña en Google? Tu experiencia inspira a otros a descubrir este rincón boutique del Caribe.
>
> [Link Google Review]
>
> Como agradecimiento, en tu próxima reserva menciona el código **EMBAJADOR-MRC** y recibe una experiencia especial de bienvenida (sujeto a disponibilidad). ¡Los cayos te esperan! 🏝️

### Ruta Retención (promedio 3.0 - 3.9)

> Gracias por tu sinceridad, {nombre}. Morrocoy merece una experiencia perfecta y tu feedback nos ayuda a lograrlo.
>
> ¿Hay algo específico que te gustaría que mejoráramos?
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Lo tendremos en cuenta. Para tu próxima escapada a Morrocoy, usa el código **VUELVE-MRC** para un **10% de descuento**. ¡Queremos que sea perfecto! 🌅

### Ruta Rescate (promedio < 3.0)

> {nombre}, lamentamos mucho que tu experiencia no haya sido lo que esperabas. Un destino tan especial como Morrocoy merece un servicio a la altura.
>
> ¿Podrías contarnos qué pasó? Queremos corregirlo.
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Tu caso será atendido personalmente por nuestro equipo. Alguien te contactará en las próximas 24 horas.

**⚠️ ALERTA AUTOMÁTICA:** Enviar notificación inmediata a Flor Acosta y Eduardo Chediak con:
- Nombre del huésped
- Sede: Morrocoy
- Promedio de calificación
- Respuesta abierta del huésped
- Fecha y hora

---

## Datos Logueados en Google Sheets

| Campo | Tipo |
|-------|------|
| Timestamp | Auto |
| Nombre huésped | Texto |
| Teléfono | Texto |
| Sede | "Morrocoy" |
| P1 Check-in | 1-5 |
| P2 Habitación | 1-5 |
| P3 Playa/Cayos | 1-5 / N/A |
| P4 Personal | 1-5 |
| P5 General | 1-5 |
| Promedio | Calculado |
| Ruta | Embajador/Retención/Rescate |
| Comentario abierto | Texto |
| Google Review enviado | Sí/No |

---

*Script v2026-03-25 · OVA VISION para Hotel Tibisay Morrocoy*
