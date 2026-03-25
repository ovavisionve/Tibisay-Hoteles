# Script WhatsApp Bot — Hotel Tibisay Mérida

**Sede:** Hotel Tibisay Mérida
**Estado:** Mérida
**Perfil:** Turismo de montaña/aventura · Teleférico · Páramos
**Tono:** Cálido, aventurero
**Timing:** 2 horas post-checkout
**Alertas ≤3/5:** Flor Acosta + Eduardo Chediak

---

## Mensaje de Inicio

> ¡Hola, {nombre}! 🏔️ Soy el asistente de **Hotel Tibisay Mérida**. Queremos saber cómo fue tu experiencia en nuestra tierra andina. Solo te tomará 2 minutos. ¿Nos ayudas?
>
> 1️⃣ Sí, quiero responder
> 2️⃣ Ahora no

**Si elige 2:** "¡Sin problema! Si en algún momento quieres compartir tu opinión, escríbenos. ¡Que disfrutes el camino de regreso! 🌄"

---

## Pregunta 1 — Check-in y Recepción

> ¿Cómo calificarías tu experiencia de check-in y la atención en recepción?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 2 — Habitación

> ¿Qué te pareció tu habitación? (limpieza, comodidad, equipamiento)
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 3 — Restaurante

> ¿Cómo fue tu experiencia en nuestro restaurante? La cocina merideña es parte de lo que nos hace especiales.
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)
> 6️⃣ No lo utilicé

---

## Pregunta 4 — Personal y Servicio

> ¿Cómo calificarías la atención del personal del hotel durante tu estadía?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 5 — Satisfacción General

> En general, ¿cómo calificarías tu estadía en Hotel Tibisay Mérida?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Lógica de Branching

### Ruta Embajador (promedio ≥ 4.0)

> ¡Qué bueno saber eso, {nombre}! Nos llena de alegría que hayas disfrutado la montaña con nosotros. 🎉🏔️
>
> ¿Te gustaría dejarnos una reseña en Google? Tu opinión ayuda a otros viajeros a descubrir Mérida.
>
> [Link Google Review]
>
> Como agradecimiento, en tu próxima reserva menciona el código **EMBAJADOR-MRD** y recibe un upgrade de habitación (sujeto a disponibilidad). ¡Los páramos te esperan de vuelta! ☕

### Ruta Retención (promedio 3.0 - 3.9)

> Gracias por tu honestidad, {nombre}. Sabemos que hay cosas que podemos mejorar y tu feedback nos ayuda mucho.
>
> ¿Hay algo específico que te gustaría que mejoráramos?
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Vamos a trabajar en eso. Para tu próxima visita a Mérida, te ofrecemos un **10% de descuento** con el código **VUELVE-MRD**. ¡Queremos que vuelvas a sentir el calor andino! 🌄

### Ruta Rescate (promedio < 3.0)

> {nombre}, lamentamos mucho que tu experiencia no haya sido la esperada. Esto no refleja el estándar de Hotel Tibisay Mérida.
>
> ¿Podrías contarnos qué pasó? Queremos entender para corregirlo.
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Tu caso será atendido personalmente por nuestro equipo. Alguien te contactará en las próximas 24 horas.

**⚠️ ALERTA AUTOMÁTICA:** Enviar notificación inmediata a Flor Acosta y Eduardo Chediak con:
- Nombre del huésped
- Sede: Mérida
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
| Sede | "Mérida" |
| P1 Check-in | 1-5 |
| P2 Habitación | 1-5 |
| P3 Restaurante | 1-5 / N/A |
| P4 Personal | 1-5 |
| P5 General | 1-5 |
| Promedio | Calculado |
| Ruta | Embajador/Retención/Rescate |
| Comentario abierto | Texto |
| Google Review enviado | Sí/No |

---

*Script v2026-03-25 · OVA VISION para Hotel Tibisay Mérida*
