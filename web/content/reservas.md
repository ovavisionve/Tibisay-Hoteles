# Reservas — Hoteles Tibisay

**URL:** tibisayhoteles.com/reservas
**Versión:** v2026-03-25

---

## Hero Section

### Headline
**Reserva tu experiencia Tibisay**

### Subheadline
Selecciona tu destino, elige tus fechas y asegura tu estadía en cualquiera de nuestras 7 sedes.

---

## Formulario de Reserva

| Campo | Tipo | Obligatorio |
|-------|------|------------|
| Nombre completo | Texto | ✅ |
| Email | Email | ✅ |
| Teléfono | Tel | ✅ |
| Sede | Dropdown (7 sedes) | ✅ |
| Fecha de llegada | Datepicker | ✅ |
| Fecha de salida | Datepicker | ✅ |
| Número de huéspedes | Adultos + Niños | ✅ |
| Tipo de habitación | Dropdown (varía por sede) | ✅ |
| Comentarios adicionales | Textarea | Opcional |
| ¿Es viaje corporativo? | Checkbox | Opcional |
| Empresa (si corporativo) | Texto | Condicional |

---

## Flujo de Reserva

```
Huésped llena formulario
    → Datos llegan a reservas@tibisayhoteles.com
    → Copia a Google Sheets (respaldo)
    → Email automático al huésped: "Recibimos tu solicitud"
    → Recepción de la sede confirma disponibilidad (manual)
    → Email de confirmación al huésped
    → Inicia secuencia pre-arrival (7 días antes)
```

> **Nota:** No es un motor de reservas en tiempo real. Es un formulario de solicitud que el equipo confirma manualmente. Esto se debe a que los PMS son de escritorio y no tienen API para consultar disponibilidad en vivo.

---

## Tipos de Habitación por Sede

### Margarita
- Estándar Vista Jardín
- Superior Vista Mar
- Suite Caribeña

### Mérida
- Estándar
- Superior
- Suite Andina

### Maracaibo (Del Lago)
- Ejecutiva Estándar
- Ejecutiva Superior
- Suite Corporativa

### Maturín
- Ejecutiva
- VIP
- Suite Corporativa

### Canaima
- Churuata Estándar
- Churuata Superior
- Churuata Premium

### Morrocoy
- Boutique Estándar
- Boutique Superior
- Suite Morrocoy

### Catatumbo
- Cabaña Explorador
- Cabaña Premium

---

## Email Automático de Confirmación de Solicitud

> **Asunto:** Solicitud de reserva recibida — Hotel Tibisay {sede}
>
> Estimado/a {nombre},
>
> Hemos recibido su solicitud de reserva para **Hotel Tibisay {sede}**:
>
> - **Fecha de llegada:** {fecha_llegada}
> - **Fecha de salida:** {fecha_salida}
> - **Huéspedes:** {adultos} adultos, {niños} niños
> - **Habitación solicitada:** {tipo_habitacion}
>
> Nuestro equipo verificará la disponibilidad y le confirmará en un plazo máximo de 24 horas hábiles.
>
> ¡Gracias por elegir Hoteles Tibisay!
>
> Atentamente,
> Equipo de Reservas
> Hotel Tibisay {sede}

---

## SEO

- **Title:** Reservas | Hoteles Tibisay Venezuela
- **Meta description:** Reserva tu estadía en Hoteles Tibisay. 7 destinos en Venezuela: Mérida, Margarita, Maracaibo, Maturín, Canaima, Morrocoy, Catatumbo.
- **H1:** Reserva tu experiencia Tibisay

---

*Contenido web v2026-03-25 · OVA VISION*
