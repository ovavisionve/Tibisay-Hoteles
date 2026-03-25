# Script WhatsApp Bot — Hotel Tibisay Maturín

**Sede:** Hotel Tibisay Maturín
**Estado:** Monagas
**Perfil:** Huéspedes corporativos frecuentes · Sector petrolero
**Tono:** Eficiente, VIP recurrente
**Timing:** 2 horas post-checkout
**Alertas ≤3/5:** Flor Acosta + Eduardo Chediak

---

## Mensaje de Inicio

> Estimado/a {nombre}, soy el asistente de **Hotel Tibisay Maturín**. Valoramos mucho su preferencia y queremos asegurar que cada estadía supere la anterior. ¿Puede regalarnos 2 minutos de su tiempo?
>
> 1️⃣ Sí, quiero responder
> 2️⃣ Ahora no

**Si elige 2:** "Entendido, sabemos que su agenda es apretada. Si en otro momento desea compartir su opinión, aquí estamos. ¡Buen viaje!"

---

## Pregunta 1 — Check-in y Recepción

> ¿Cómo calificaría su experiencia de check-in y la atención en recepción?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 2 — Habitación

> ¿Qué le pareció su habitación? (limpieza, comodidad, conectividad Wi-Fi, espacio de trabajo)
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 3 — Restaurante y Servicios

> ¿Cómo fue su experiencia con el restaurante y servicios del hotel?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)
> 6️⃣ No los utilicé

---

## Pregunta 4 — Personal y Servicio

> ¿Cómo calificaría la atención del personal del hotel?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 5 — Satisfacción General

> En general, ¿cómo calificaría su estadía en Hotel Tibisay Maturín?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Lógica de Branching

### Ruta Embajador (promedio ≥ 4.0)

> Excelente, {nombre}. Nos alegra saber que cumplimos con sus expectativas una vez más. 🏢✨
>
> ¿Le gustaría dejarnos una reseña en Google? Su experiencia ayuda a otros profesionales.
>
> [Link Google Review]
>
> Como cliente frecuente, en su próxima reserva mencione el código **EMBAJADOR-MTR** para acceder a nuestra tarifa VIP recurrente. ¡Será un placer recibirle de nuevo!

### Ruta Retención (promedio 3.0 - 3.9)

> Agradecemos su feedback, {nombre}. Para nosotros es prioritario que cada estadía sea mejor que la anterior.
>
> ¿Hay algo específico que podamos mejorar para su próxima visita?
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Lo tendremos en cuenta. Para su próxima estadía en Maturín, aplique el código **VUELVE-MTR** para obtener un **10% de descuento**. Nos comprometemos a mejorar.

### Ruta Rescate (promedio < 3.0)

> {nombre}, lamentamos profundamente que su experiencia no haya sido satisfactoria. Como cliente que nos ha elegido, merecía más.
>
> ¿Podría indicarnos qué ocurrió? Queremos corregirlo antes de su próxima visita.
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Su caso será escalado directamente a la gerencia. Un representante le contactará en las próximas 24 horas.

**⚠️ ALERTA AUTOMÁTICA:** Enviar notificación inmediata a Flor Acosta y Eduardo Chediak con:
- Nombre del huésped
- Sede: Maturín
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
| Sede | "Maturín" |
| P1 Check-in | 1-5 |
| P2 Habitación | 1-5 |
| P3 Restaurante/Servicios | 1-5 / N/A |
| P4 Personal | 1-5 |
| P5 General | 1-5 |
| Promedio | Calculado |
| Ruta | Embajador/Retención/Rescate |
| Comentario abierto | Texto |
| Google Review enviado | Sí/No |

---

*Script v2026-03-25 · OVA VISION para Hotel Tibisay Maturín*
