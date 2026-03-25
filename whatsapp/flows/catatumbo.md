# Script WhatsApp Bot — Tibisay Catatumbo

**Sede:** Tibisay Catatumbo
**Estado:** Zulia
**Perfil:** Fenómeno natural del Relámpago del Catatumbo · Turismo de expedición
**Tono:** Explorador, único en el mundo
**Timing:** 2 horas post-checkout
**Alertas ≤3/5:** Flor Acosta + Eduardo Chediak

---

## Mensaje de Inicio

> ¡Hola, {nombre}! ⚡ Soy el asistente de **Tibisay Catatumbo**. Esperamos que el Relámpago del Catatumbo te haya dejado una marca imborrable. ¿Nos compartes tu experiencia en 2 minutos?
>
> 1️⃣ Sí, quiero responder
> 2️⃣ Ahora no

**Si elige 2:** "¡Sin problema! Pocos pueden decir que vieron el fenómeno más eléctrico del planeta. Si en algún momento quieres compartir tu opinión, escríbenos. ⚡🌩️"

---

## Pregunta 1 — Llegada y Recepción

> ¿Cómo calificarías tu experiencia de llegada y la bienvenida del equipo?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 2 — Alojamiento

> ¿Qué te pareció tu alojamiento? (limpieza, comodidad, integración con el entorno)
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 3 — Expedición y Relámpago

> ¿Cómo fue tu experiencia con la expedición al Relámpago del Catatumbo y las actividades?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 4 — Guías y Personal

> ¿Cómo calificarías a los guías y al personal durante tu expedición?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 5 — Satisfacción General

> En general, ¿cómo calificarías tu experiencia en Tibisay Catatumbo?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Lógica de Branching

### Ruta Embajador (promedio ≥ 4.0)

> ¡Espectacular, {nombre}! Viviste algo que pocos en el mundo pueden contar: el Relámpago del Catatumbo en persona. ⚡🎉
>
> ¿Te gustaría dejarnos una reseña en Google? Tu historia puede inspirar a otros exploradores a vivir esta experiencia única.
>
> [Link Google Review]
>
> Como agradecimiento, en tu próxima expedición menciona el código **EMBAJADOR-CAT** y recibe un beneficio especial. ¡El Catatumbo siempre tiene más por mostrar! 🌩️

### Ruta Retención (promedio 3.0 - 3.9)

> Gracias por compartir tu opinión, {nombre}. Sabemos que una expedición al Catatumbo es una experiencia que debe ser perfecta de principio a fin.
>
> ¿Hay algo específico que podamos mejorar?
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Lo tomaremos muy en cuenta. Para tu próxima expedición, usa el código **VUELVE-CAT** para un **10% de descuento**. ¡El relámpago nunca es igual dos veces! ⚡

### Ruta Rescate (promedio < 3.0)

> {nombre}, lamentamos mucho que tu experiencia no haya estado a la altura de un destino tan extraordinario como el Catatumbo.
>
> ¿Podrías contarnos qué pasó? Queremos corregirlo para futuros exploradores.
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Tu caso será atendido personalmente. Alguien de nuestro equipo te contactará en las próximas 24 horas.

**⚠️ ALERTA AUTOMÁTICA:** Enviar notificación inmediata a Flor Acosta y Eduardo Chediak con:
- Nombre del huésped
- Sede: Catatumbo
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
| Sede | "Catatumbo" |
| P1 Llegada | 1-5 |
| P2 Alojamiento | 1-5 |
| P3 Expedición/Relámpago | 1-5 |
| P4 Guías/Personal | 1-5 |
| P5 General | 1-5 |
| Promedio | Calculado |
| Ruta | Embajador/Retención/Rescate |
| Comentario abierto | Texto |
| Google Review enviado | Sí/No |

---

*Script v2026-03-25 · OVA VISION para Tibisay Catatumbo*
