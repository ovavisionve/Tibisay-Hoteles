# Flujos de Make (Integromat) — Hoteles Tibisay

**Version:** v2026-03-25
**Estado:** Documentados, pendientes de despliegue
**Plataforma:** Make (formerly Integromat) — https://www.make.com
**Plan:** Free tier inicialmente, evaluar Pro si se exceden operaciones

---

## Resumen

El ecosistema de automatizacion de Hoteles Tibisay se compone de **6 flujos de Make** que conectan Google Sheets, WhatsApp Business API, la plataforma de email marketing (Brevo o Mailchimp) y el sistema de alertas.

### Arquitectura general

```
                    ┌─────────────────────────────────┐
                    │        GOOGLE SHEETS             │
                    │   (Base operativa central)       │
                    └──────────┬──────────────────────┘
                               │
                    ┌──────────▼──────────────────────┐
                    │     FLUJO 1: CHECKOUT TRIGGER     │
                    │  (Detecta nueva fila en Sheets)   │
                    └──────────┬──────────────────────┘
                               │
              ┌────────────────┼────────────────┐
              │                │                │
    ┌─────────▼────────┐ ┌────▼─────────┐ ┌────▼──────────┐
    │ FLUJO 2:         │ │ FLUJO 3:     │ │ FLUJO 6:      │
    │ WHATSAPP         │ │ EMAIL        │ │ KILL SWITCH   │
    │ DISPATCH         │ │ DISPATCH     │ │ (Override)    │
    └─────────┬────────┘ └────┬─────────┘ └───────────────┘
              │               │
    ┌─────────▼────────┐      │
    │ Huesped responde │      │
    └─────────┬────────┘      │
              │               │
    ┌─────────▼────────────────▼──────────┐
    │       FLUJO 5: RESPONSE LOGGING      │
    │  (Registra respuestas en Sheets)     │
    └─────────┬───────────────────────────┘
              │
              │ Si calificacion <= 3/5
              │
    ┌─────────▼────────────────────────────┐
    │       FLUJO 4: RESCUE ALERTS         │
    │  (Notifica a Flor + Eduardo)         │
    └──────────────────────────────────────┘
```

---

## Flujo 1: Checkout Trigger

### Proposito

Detectar cuando un recepcionista registra un nuevo checkout en Google Sheets y disparar los flujos subsiguientes.

### Diagrama

```
┌───────────────┐     ┌──────────────┐     ┌───────────────┐     ┌──────────────────┐
│ Google Sheets │────▶│ Webhook      │────▶│ Validar datos │────▶│ Esperar 2 horas  │
│ Nueva fila    │     │ (trigger)    │     │ (formato OK?) │     │ (delay module)   │
└───────────────┘     └──────────────┘     └───────┬───────┘     └────────┬─────────┘
                                                   │                      │
                                           ┌───────▼───────┐     ┌───────▼──────────┐
                                           │ Error:        │     │ Disparar         │
                                           │ Notificar a   │     │ Flujo 2 + 3      │
                                           │ OVA VISION    │     │ (WhatsApp+Email) │
                                           └───────────────┘     └──────────────────┘
```

### Configuracion

| Parametro | Valor |
|-----------|-------|
| Trigger | Google Sheets — Watch New Rows |
| Hoja | "Checkouts" (pestaña de la sede correspondiente) |
| Frecuencia de polling | Cada 15 minutos |
| Delay antes de envio | 2 horas (configurable) |
| Validaciones | Telefono en formato +58..., email valido, campos obligatorios completos |

### Campos que captura

- Fecha y hora del checkout
- Nombre del huesped
- Telefono (+58...)
- Email
- Habitacion
- Noches de estadia
- Tipo de huesped (nacional/internacional/corporativo)
- Sede
- Observaciones

### Manejo de errores

- Si faltan campos obligatorios: registra error en pestaña "Errores" y notifica a OVA VISION
- Si el formato de telefono es incorrecto: intenta corregir automaticamente (agregar +58 si falta)
- Si el delay module falla: reintentar 1 vez, luego notificar

---

## Flujo 2: WhatsApp Dispatch

### Proposito

Enviar la encuesta de satisfaccion por WhatsApp al huesped, 2 horas despues del checkout.

### Diagrama

```
┌──────────────────┐     ┌─────────────────┐     ┌──────────────────┐
│ Recibe datos     │────▶│ Seleccionar     │────▶│ Enviar mensaje   │
│ del Flujo 1      │     │ template por    │     │ via Meta API     │
│                  │     │ sede            │     │ (WhatsApp BSP)   │
└──────────────────┘     └─────────────────┘     └────────┬─────────┘
                                                          │
                                                 ┌────────▼─────────┐
                                                 │ Registrar envio  │
                                                 │ en Sheets        │
                                                 │ (estado: ENVIADO)│
                                                 └──────────────────┘
```

### Configuracion

| Parametro | Valor |
|-----------|-------|
| API | Meta WhatsApp Business API |
| Tipo de mensaje | Template message (aprobado por Meta) |
| Templates | 1 por sede (7 templates en total) |
| Idioma | Español (Canaima: español + ingles) |
| Numero remitente | Diferente por sede (pendiente asignacion) |

### Templates por sede

Cada sede tiene su propio template con el nombre del hotel, tono apropiado y preguntas contextualizadas. Los templates deben ser aprobados por Meta antes de poder usarse.

| Sede | Template ID | Estado |
|------|------------|--------|
| Merida | tibisay_merida_survey | Pendiente |
| Margarita | tibisay_margarita_survey | Pendiente |
| Maracaibo | tibisay_dellago_survey | Pendiente |
| Maturin | tibisay_maturin_survey | Pendiente |
| Canaima | tibisay_canaima_survey | Pendiente |
| Morrocoy | tibisay_morrocoy_survey | Pendiente |
| Catatumbo | tibisay_catatumbo_survey | Pendiente |

### Logica de branching (post-respuesta)

```
Huesped responde calificacion
        │
        ├── 5/5 ──▶ Ruta EMBAJADOR
        │           "¡Que alegria! ¿Te gustaria compartir tu experiencia?"
        │           → Link a Google Reviews / TripAdvisor
        │
        ├── 4/5 ──▶ Ruta RETENCION
        │           "Gracias por tu feedback. ¿Que podemos mejorar?"
        │           → Oferta de regreso personalizada
        │
        └── 1-3/5 ▶ Ruta RESCATE
                    "Lamentamos mucho tu experiencia..."
                    → Disculpa + alerta al equipo (Flujo 4)
```

---

## Flujo 3: Email Dispatch

### Proposito

Disparar las secuencias de email automaticas segun el momento del journey del huesped.

### Diagrama

```
┌──────────────────┐     ┌─────────────────┐     ┌──────────────────┐
│ Recibe datos     │────▶│ Determinar      │────▶│ Agregar contacto │
│ del Flujo 1      │     │ secuencia:      │     │ a lista en       │
│ (o registro web) │     │ - pre-arrival   │     │ Brevo/Mailchimp  │
│                  │     │ - welcome       │     │                  │
│                  │     │ - post-stay     │     └────────┬─────────┘
└──────────────────┘     └─────────────────┘              │
                                                 ┌────────▼─────────┐
                                                 │ Activar          │
                                                 │ automation en    │
                                                 │ plataforma       │
                                                 └────────┬─────────┘
                                                          │
                                                 ┌────────▼─────────┐
                                                 │ Registrar en     │
                                                 │ Sheets (estado)  │
                                                 └──────────────────┘
```

### Configuracion

| Parametro | Valor |
|-----------|-------|
| Plataforma | Brevo o Mailchimp (free tier) |
| Conexion | API key de la plataforma |
| Segmentacion | Por sede + tipo de huesped |
| Frecuencia | Segun secuencia (ver tabla abajo) |

### Secuencias por sede

| Secuencia | Trigger | Email 1 | Email 2 | Email 3 |
|-----------|---------|---------|---------|---------|
| Pre-arrival | Reserva confirmada | Dia -3 | Dia -1 | Dia del check-in |
| Welcome | Check-in registrado | Dia 0 | — | — |
| Post-stay | Checkout registrado | Dia +1 | Dia +3 | Dia +7 |

### Sedes con secuencias listas

- Margarita, Merida, Maracaibo, Maturin (completadas en fase anterior)

### Sedes pendientes

- Canaima (bilingue ES/EN), Morrocoy, Catatumbo

---

## Flujo 4: Rescue Alerts

### Proposito

Notificar inmediatamente a Flor Acosta y Eduardo Chediak cuando un huesped da una calificacion baja (<=3/5).

### Diagrama

```
┌──────────────────┐     ┌─────────────────┐     ┌──────────────────────┐
│ Flujo 5 detecta  │────▶│ Calificacion    │────▶│ Enviar alerta        │
│ calificacion     │     │ <= 3/5?         │     │ WhatsApp a:          │
│ baja             │     │                 │     │ - Flor Acosta        │
│                  │     │ SI ──▶          │     │ - Eduardo Chediak    │
└──────────────────┘     └────────┬────────┘     └──────────┬───────────┘
                                  │ NO                       │
                                  ▼                 ┌────────▼───────────┐
                           (No hacer nada)          │ Registrar alerta   │
                                                    │ en Sheets          │
                                                    │ (pestaña Alertas)  │
                                                    └──────────┬─────────┘
                                                               │
                                                    ┌──────────▼─────────┐
                                                    │ Programar          │
                                                    │ recordatorio       │
                                                    │ si no hay respuesta│
                                                    │ en 2 horas         │
                                                    └────────────────────┘
```

### Configuracion

| Parametro | Valor |
|-----------|-------|
| Umbral de alerta | Calificacion <= 3 en cualquier area |
| Destinatarios | Flor Acosta, Eduardo Chediak |
| Canal de alerta | WhatsApp (mismo numero de la sede) |
| Recordatorio | 2 horas si no se marca como atendida |
| Escalamiento | 4 horas → segundo recordatorio a Eduardo Chediak |

### Contenido de la alerta

```
🚨 ALERTA DE RESCATE — [Sede]

Huesped: [Nombre]
Habitacion: [Numero]
Checkout: [Fecha y hora]
Calificacion: [X/5]
Area critica: [Area con menor calificacion]
Comentario: "[Texto del huesped]"

Accion requerida: Contactar al huesped dentro de 2 horas.
Telefono: [+58...]
```

---

## Flujo 5: Response Logging

### Proposito

Registrar automaticamente todas las respuestas de encuestas (WhatsApp y QR) en Google Sheets.

### Diagrama

```
┌──────────────────┐     ┌──────────────────┐
│ Respuesta        │     │ Respuesta        │
│ WhatsApp         │     │ QR (Google Forms) │
└────────┬─────────┘     └────────┬─────────┘
         │                        │
         └────────┬───────────────┘
                  │
         ┌────────▼───────────────┐
         │ Normalizar datos      │
         │ (formato estandar)    │
         └────────┬──────────────┘
                  │
         ┌────────▼───────────────┐     ┌───────────────────┐
         │ Escribir en Sheets    │────▶│ Actualizar        │
         │ (pestaña correcta)    │     │ Dashboard         │
         └────────┬──────────────┘     │ (automatico via   │
                  │                     │ formulas/script)  │
                  │                     └───────────────────┘
                  │
         ┌────────▼───────────────┐
         │ Evaluar calificacion  │
         │ <= 3? → Flujo 4      │
         └───────────────────────┘
```

### Configuracion

| Parametro | Valor |
|-----------|-------|
| Fuentes | WhatsApp bot responses + QR form submissions |
| Destino | Google Sheets — pestaña "Respuestas WhatsApp" y "Respuestas QR" |
| Formato | Estandarizado (mismas columnas para ambas fuentes) |
| Trigger para alertas | Si cualquier calificacion <= 3/5, disparar Flujo 4 |

### Columnas registradas

| Columna | Descripcion |
|---------|------------|
| Timestamp | Fecha y hora de la respuesta |
| Sede | Nombre de la sede |
| Fuente | "WhatsApp" o "QR" |
| Nombre | Nombre del huesped |
| Telefono | Numero del huesped |
| Calif. General | 1-5 |
| Calif. Check-in | 1-5 |
| Calif. Habitacion | 1-5 |
| Calif. Restaurante | 1-5 |
| Calif. Personal | 1-5 |
| Calif. Limpieza | 1-5 |
| Comentario | Texto libre |
| Tags | Palabras clave detectadas (auto) |
| Ruta | Embajador / Retencion / Rescate |
| Estado | Pendiente / Atendido |

---

## Flujo 6: Kill Switch

### Proposito

Permitir pausar manualmente todas las automatizaciones en caso de emergencia o mantenimiento.

### Diagrama

```
┌──────────────────┐     ┌──────────────────┐     ┌──────────────────────┐
│ Celda "ACTIVO"   │────▶│ Make verifica    │────▶│ Si ACTIVO = FALSE:   │
│ en Sheet de      │     │ estado antes de  │     │ Pausar TODOS los     │
│ configuracion    │     │ cada ejecucion   │     │ flujos               │
└──────────────────┘     └──────────────────┘     └──────────┬───────────┘
                                                              │
                                                   ┌──────────▼───────────┐
                                                   │ Notificar a          │
                                                   │ OVA VISION:          │
                                                   │ "Sistema pausado"    │
                                                   └──────────────────────┘
```

### Configuracion

| Parametro | Valor |
|-----------|-------|
| Control | Celda en Google Sheets (pestaña "Config") |
| Celda | B2 (valor: TRUE o FALSE) |
| Verificacion | Cada flujo consulta esta celda antes de ejecutar |
| Notificacion al pausar | WhatsApp a OVA VISION |
| Granularidad | Global (pausa todo) o por sede (pestaña Config tiene 1 fila por sede) |

### Cuando usar el kill switch

- Mantenimiento del sistema
- Error masivo en envios
- Solicitud del cliente de pausar temporalmente
- Problemas con Meta WhatsApp API
- Cualquier situacion que requiera detener envios inmediatamente

### Como activar/desactivar

1. Abrir Google Sheets → pestaña "Config"
2. Celda B2: cambiar a `FALSE` para pausar, `TRUE` para reactivar
3. Para pausar solo una sede: cambiar el valor en la fila correspondiente a esa sede
4. Los cambios surten efecto en el proximo ciclo de polling (maximo 15 minutos)

---

## Requisitos Previos para Despliegue

| Requisito | Estado | Bloqueante |
|-----------|--------|-----------|
| Cuenta de Make creada | Pendiente | Si |
| Google Sheets estructura lista | Completado | Si |
| Meta Business Manager verificado | Pendiente | Si (para Flujo 2) |
| WhatsApp Business API activa | Pendiente | Si (para Flujo 2) |
| Numeros de WhatsApp asignados | Pendiente | Si (para Flujo 2) |
| Templates aprobados por Meta | Pendiente | Si (para Flujo 2) |
| Brevo/Mailchimp configurado | Pendiente | Si (para Flujo 3) |
| Apps Script del dashboard | Completado | Si (para Flujo 5) |

---

## Limites del Free Tier de Make

| Recurso | Limite gratuito | Estimacion mensual |
|---------|----------------|-------------------|
| Operaciones | 1.000/mes | ~500-800 (7 sedes, ~20 checkouts/dia promedio) |
| Escenarios activos | 2 | Necesitamos 6 → **requiere plan Pro ($9/mes)** |
| Intervalo minimo | 15 minutos | Suficiente para este caso |
| Transferencia | 100 MB/mes | Suficiente |

> **Nota:** El free tier probablemente no sera suficiente para los 6 flujos. Evaluar agrupar flujos para reducir escenarios activos o pasar al plan Pro ($9/mes).

---

*Documento generado por OVA VISION · v2026-03-25*
