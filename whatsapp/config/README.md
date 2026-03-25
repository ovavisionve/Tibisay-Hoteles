# Configuración WhatsApp Business — Hoteles Tibisay

**Versión:** v2026-03-25
**Estado:** Pendiente de configuración

---

## Prerequisitos

1. **Meta Business Manager** — No creado aún
   - Crear cuenta en business.facebook.com
   - Verificar negocio (2-7 días hábiles)
   - Razón social: OTHTICA (J410155299) o la correspondiente por sede

2. **WhatsApp Business API** — Pendiente
   - Solicitar acceso desde Meta Business Manager
   - Requiere verificación de negocio completada

3. **Números de teléfono** — Pendiente asignación
   - Se necesita un número diferente por cada hotel
   - Los números deben estar libres (sin WhatsApp personal activo)

---

## Estructura por Sede

| Sede | Número asignado | Estado API | Código embajador | Código retención |
|------|----------------|------------|-------------------|-------------------|
| Margarita | Pendiente | ❌ | EMBAJADOR-MGT | VUELVE-MGT |
| Mérida | Pendiente | ❌ | EMBAJADOR-MRD | VUELVE-MRD |
| Maracaibo | Pendiente | ❌ | EMBAJADOR-MCB | VUELVE-MCB |
| Maturín | Pendiente | ❌ | EMBAJADOR-MTR | VUELVE-MTR |
| Canaima | Pendiente | ❌ | EMBAJADOR-CAN | VUELVE-CAN |
| Morrocoy | Pendiente | ❌ | EMBAJADOR-MRC | VUELVE-MRC |
| Catatumbo | Pendiente | ❌ | EMBAJADOR-CAT | VUELVE-CAT |

---

## Flujo Técnico

```
PMS (checkout) → Recepcionista → Google Sheets → Make (webhook)
    → 2 horas de espera
    → Meta WhatsApp API → Mensaje al huésped
    → Respuestas → Google Sheets (logging)
    → Si promedio < 3 → Alerta a Flor + Eduardo
```

---

## Configuración Make (Integromat)

### Scenario: WhatsApp Dispatch
- **Trigger:** Webhook desde Google Sheets (nuevo checkout)
- **Delay:** 2 horas (módulo Sleep)
- **Action:** HTTP Request a Meta WhatsApp API
- **Template:** Seleccionar por sede (variable `sede`)
- **Fallback:** Si falla envío, reintentar 1 vez, luego loguear error

### Scenario: Response Logging
- **Trigger:** Webhook desde Meta (respuesta del huésped)
- **Action:** Parsear respuesta → Escribir en Google Sheets
- **Cálculo:** Promedio automático de las 5 preguntas
- **Branching:** Si promedio < 3 → trigger alerta rescate

---

## Alertas de Rescate

**Destinatarios:**
- Flor Acosta (número pendiente)
- Eduardo Chediak — 0424 418 6107

**Contenido de alerta:**
- Nombre del huésped
- Sede
- Promedio de calificación
- Comentario abierto (si aplica)
- Timestamp

**Canal:** WhatsApp directo al número de Flor y Eduardo

---

## Checklist de Setup

- [ ] Crear Meta Business Manager
- [ ] Verificar negocio en Meta
- [ ] Solicitar WhatsApp Business API
- [ ] Asignar números por sede (7 números)
- [ ] Registrar números en Meta Business
- [ ] Crear templates de mensajes en Meta (requiere aprobación)
- [ ] Configurar Make scenarios
- [ ] Conectar Google Sheets como trigger
- [ ] Prueba end-to-end por sede
- [ ] Activar en producción

---

*Configuración v2026-03-25 · OVA VISION*
