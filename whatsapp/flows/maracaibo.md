# Script WhatsApp Bot — Hotel Tibisay Del Lago

**Sede:** Hotel Tibisay Del Lago
**Estado:** Zulia (Maracaibo)
**Perfil:** Corporativo/negocios + turismo · Lago de Maracaibo · Puente sobre el Lago
**Tono:** Profesional, B2B-friendly
**Timing:** 2 horas post-checkout
**Alertas ≤3/5:** Flor Acosta + Eduardo Chediak

---

## Mensaje de Inicio

> Estimado/a {nombre}, soy el asistente de **Hotel Tibisay Del Lago** en Maracaibo. Nos gustaría conocer su opinión sobre su estadía. Solo le tomará 2 minutos. ¿Nos ayuda?
>
> 1️⃣ Sí, quiero responder
> 2️⃣ Ahora no

**Si elige 2:** "Entendido. Si en algún momento desea compartir su opinión, estamos a su disposición. ¡Buen viaje!"

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

> ¿Qué le pareció su habitación? (limpieza, comodidad, equipamiento, conectividad)
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 3 — Restaurante y Servicios

> ¿Cómo fue su experiencia con el restaurante y los servicios del hotel?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)
> 6️⃣ No los utilicé

---

## Pregunta 4 — Personal y Servicio

> ¿Cómo calificaría la atención del personal del hotel durante su estadía?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Pregunta 5 — Satisfacción General

> En general, ¿cómo calificaría su estadía en Hotel Tibisay Del Lago?
>
> 1️⃣ Excelente (5)
> 2️⃣ Muy buena (4)
> 3️⃣ Buena (3)
> 4️⃣ Regular (2)
> 5️⃣ Mala (1)

---

## Lógica de Branching

### Ruta Embajador (promedio ≥ 4.0)

> Nos complace saber que su estadía fue satisfactoria, {nombre}. Su opinión es muy valiosa para nosotros. 🏢
>
> ¿Le gustaría dejarnos una reseña en Google? Su feedback ayuda a otros profesionales a tomar mejores decisiones.
>
> [Link Google Review]
>
> Como agradecimiento, en su próxima reserva mencione el código **EMBAJADOR-MCB** y reciba una tarifa corporativa preferencial. ¡Será un placer recibirle nuevamente!

### Ruta Retención (promedio 3.0 - 3.9)

> Agradecemos su honestidad, {nombre}. Su feedback nos permite elevar nuestro estándar de servicio.
>
> ¿Hay algo específico que le gustaría que mejoráramos?
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Tomaremos nota de su comentario. Para su próxima visita a Maracaibo, le ofrecemos un **10% de descuento** con el código **VUELVE-MCB**. Estamos comprometidos con mejorar su experiencia.

### Ruta Rescate (promedio < 3.0)

> {nombre}, lamentamos que su experiencia no haya cumplido con sus expectativas. Esto no refleja el estándar de Hotel Tibisay Del Lago.
>
> ¿Podría indicarnos qué ocurrió? Queremos entender la situación para corregirla.
>
> *(Respuesta abierta → se loguea en Google Sheets)*
>
> Su caso será atendido personalmente por nuestro equipo directivo. Un representante le contactará en las próximas 24 horas.

**⚠️ ALERTA AUTOMÁTICA:** Enviar notificación inmediata a Flor Acosta y Eduardo Chediak con:
- Nombre del huésped
- Sede: Maracaibo (Del Lago)
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
| Sede | "Maracaibo" |
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

*Script v2026-03-25 · OVA VISION para Hotel Tibisay Del Lago (Maracaibo)*
