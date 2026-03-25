# Google Sheets — Base Operativa Hoteles Tibisay

**Version:** v2026-03-25
**Estado:** Estructura disenada, pendiente de despliegue
**Plataforma:** Google Sheets + Google Apps Script
**Costo:** $0 (Google Workspace gratuito)

---

## Resumen

Google Sheets funciona como la base de datos operativa central del ecosistema digital de Hoteles Tibisay. Todos los flujos de Make leen y escriben en estas hojas, y el dashboard consolidado se alimenta automaticamente de los datos registrados.

### Arquitectura

```
┌──────────────────────────────────────────────────────┐
│              GOOGLE SHEETS PRINCIPAL                  │
│         "Tibisay — Base Operativa"                   │
├──────────────────────────────────────────────────────┤
│                                                      │
│  ┌────────────┐  ┌──────────────┐  ┌──────────────┐ │
│  │ Checkouts  │  │ Respuestas   │  │ Respuestas   │ │
│  │ (manual)   │  │ WhatsApp     │  │ QR           │ │
│  └─────┬──────┘  └──────┬───────┘  └──────┬───────┘ │
│        │                │                  │         │
│        └────────────────┼──────────────────┘         │
│                         │                            │
│               ┌─────────▼──────────┐                 │
│               │    Dashboard       │                 │
│               │  (formulas +       │                 │
│               │   Apps Script)     │                 │
│               └────────────────────┘                 │
│                                                      │
│  ┌────────────┐  ┌──────────────┐  ┌──────────────┐ │
│  │ Config     │  │ Alertas      │  │ Errores      │ │
│  │ (Kill      │  │ (rescate)    │  │ (log)        │ │
│  │  Switch)   │  │              │  │              │ │
│  └────────────┘  └──────────────┘  └──────────────┘ │
│                                                      │
└──────────────────────────────────────────────────────┘
```

---

## Pestana 1: Checkouts (Input Manual)

### Proposito

Los recepcionistas de cada sede registran manualmente cada checkout en esta hoja. Es el punto de entrada que dispara todo el ecosistema de encuestas y email.

### Columnas

| Columna | Tipo | Obligatorio | Descripcion |
|---------|------|-------------|------------|
| A: Timestamp | Fecha/hora | Auto | Se genera automaticamente al ingresar la fila |
| B: Sede | Texto (dropdown) | Si | Lista desplegable con las 7 sedes |
| C: Nombre Huesped | Texto | Si | Nombre completo del huesped |
| D: Telefono | Texto | Si | Formato +58... (validacion por formato) |
| E: Email | Texto | No | Email del huesped (si se tiene) |
| F: Habitacion | Texto | Si | Numero o nombre de la habitacion |
| G: Noches | Numero | Si | Cantidad de noches de estadia |
| H: Tipo Huesped | Texto (dropdown) | Si | Nacional / Internacional / Corporativo |
| I: Observaciones | Texto | No | Notas del recepcionista |
| J: Estado Envio WA | Texto | Auto | PENDIENTE / ENVIADO / ERROR / OMITIDO |
| K: Estado Envio Email | Texto | Auto | PENDIENTE / ENVIADO / ERROR / OMITIDO |
| L: Fecha Envio | Fecha/hora | Auto | Timestamp del envio de encuesta |

### Validaciones

- **Telefono:** Regex para formato venezolano (+58 4XX XXX XXXX)
- **Email:** Validacion de formato basica
- **Sede:** Solo valores del dropdown (7 sedes)
- **Tipo Huesped:** Solo valores del dropdown
- **Noches:** Numero entero mayor a 0

### Proteccion

- Columnas J, K, L: Protegidas (solo Make puede modificarlas via API)
- Fila 1 (encabezados): Protegida
- Rango de datos: Libre para los recepcionistas

---

## Pestana 2: Respuestas WhatsApp

### Proposito

Registra automaticamente (via Make — Flujo 5) todas las respuestas de las encuestas enviadas por WhatsApp.

### Columnas

| Columna | Tipo | Descripcion |
|---------|------|------------|
| A: Timestamp | Fecha/hora | Fecha y hora de la respuesta |
| B: Sede | Texto | Sede del hotel |
| C: Nombre | Texto | Nombre del huesped |
| D: Telefono | Texto | Numero del huesped |
| E: Calif. General | Numero (1-5) | Calificacion general de la estadia |
| F: Calif. Check-in | Numero (1-5) | Calificacion del proceso de check-in |
| G: Calif. Habitacion | Numero (1-5) | Calificacion de la habitacion |
| H: Calif. Restaurante | Numero (1-5) | Calificacion del restaurante |
| I: Calif. Personal | Numero (1-5) | Calificacion de la atencion del personal |
| J: Calif. Limpieza | Numero (1-5) | Calificacion de la limpieza |
| K: Comentario | Texto | Comentario libre del huesped |
| L: Tags | Texto | Palabras clave detectadas automaticamente |
| M: Ruta | Texto | Embajador / Retencion / Rescate |
| N: Estado | Texto | Pendiente / Atendido |
| O: Atendido Por | Texto | Nombre de quien atendio (si aplica) |
| P: Fecha Atencion | Fecha/hora | Cuando se marco como atendido |

---

## Pestana 3: Respuestas QR

### Proposito

Registra automaticamente las respuestas de las encuestas QR (formularios web por sede).

### Columnas

| Columna | Tipo | Descripcion |
|---------|------|------------|
| A: Timestamp | Fecha/hora | Fecha y hora del envio del formulario |
| B: Sede | Texto | Sede donde se escaneo el QR |
| C: Nombre | Texto | Nombre del huesped (opcional en QR) |
| D: Calif. General | Numero (1-5) | Calificacion general |
| E: Calif. Habitacion | Numero (1-5) | Calificacion de la habitacion |
| F: Calif. Restaurante | Numero (1-5) | Calificacion del restaurante |
| G: Calif. Personal | Numero (1-5) | Calificacion del personal |
| H: Calif. Limpieza | Numero (1-5) | Calificacion de la limpieza |
| I: Lo Mejor | Texto | "Que fue lo mejor de tu estadia?" |
| J: A Mejorar | Texto | "Que podemos mejorar?" |
| K: Recomendaria | Si/No | "Recomendarias este hotel?" |
| L: Tags | Texto | Palabras clave detectadas |

### Diferencia con WhatsApp

- QR no tiene campo de telefono (el huesped es anonimo salvo que deje su nombre)
- QR tiene preguntas abiertas especificas ("Lo mejor" y "A mejorar")
- QR no tiene ruta Embajador/Retencion/Rescate (se evalua solo por calificacion)

---

## Pestana 4: Dashboard

### Proposito

Panel consolidado con metricas en tiempo real. Usa formulas de Google Sheets y Apps Script para calcular automaticamente.

### Secciones

#### 4.1 Resumen General

| Metrica | Formula/Fuente |
|---------|---------------|
| Total respuestas (mes) | COUNTIFS sobre Respuestas WA + QR |
| Calificacion promedio general | AVERAGEIFS sobre columna Calif. General |
| % Embajadores (5/5) | COUNTIFS(Ruta="Embajador") / Total |
| % Rescate (<=3/5) | COUNTIFS(Ruta="Rescate") / Total |
| Tasa de respuesta WA | Enviados con respuesta / Total enviados |
| Alertas pendientes | COUNTIFS(Estado="Pendiente", Ruta="Rescate") |

#### 4.2 Metricas por Sede

Tabla con una fila por sede (7 filas) y columnas:
- Sede
- Total respuestas
- Promedio general
- Promedio por area (check-in, habitacion, restaurante, personal, limpieza)
- % Embajadores
- % Rescate
- Tendencia semanal (sparkline)

#### 4.3 Promedio Semanal con Alertas

Calculo automatico del promedio de la ultima semana. Si el promedio semanal cae por debajo de 3.5, se activa un indicador visual (celda en rojo) y se envia alerta via Apps Script.

#### 4.4 Frecuencia de Tags

Tabla dinamica que cuenta las palabras clave mas frecuentes en los comentarios:
- Tag
- Frecuencia (total)
- Frecuencia por sede
- Sentimiento (positivo/negativo — clasificacion manual inicial)

---

## Pestana 5: Alertas

### Proposito

Log de todas las alertas de rescate generadas por el Flujo 4 de Make.

### Columnas

| Columna | Tipo | Descripcion |
|---------|------|------------|
| A: Timestamp | Fecha/hora | Cuando se genero la alerta |
| B: Sede | Texto | Sede del hotel |
| C: Huesped | Texto | Nombre del huesped |
| D: Telefono | Texto | Telefono del huesped |
| E: Calificacion | Numero | Calificacion que disparo la alerta |
| F: Area Critica | Texto | Area con menor calificacion |
| G: Comentario | Texto | Comentario del huesped |
| H: Notificado A | Texto | Flor Acosta, Eduardo Chediak |
| I: Estado | Texto | Pendiente / Atendido / Escalado |
| J: Atendido Por | Texto | Quien atendio |
| K: Fecha Atencion | Fecha/hora | Cuando se resolvio |
| L: Notas Resolucion | Texto | Como se resolvio |

---

## Pestana 6: Errores

### Proposito

Log de errores de los flujos de Make para diagnostico.

### Columnas

| Columna | Tipo | Descripcion |
|---------|------|------------|
| A: Timestamp | Fecha/hora | Cuando ocurrio el error |
| B: Flujo | Texto | Nombre del flujo de Make que fallo |
| C: Sede | Texto | Sede afectada |
| D: Tipo Error | Texto | Validacion / API / Timeout / Otro |
| E: Descripcion | Texto | Detalle del error |
| F: Datos | Texto | Datos de la fila que causo el error (JSON) |
| G: Estado | Texto | Pendiente / Resuelto |

---

## Pestana 7: Config (Kill Switch)

### Proposito

Control de activacion/desactivacion del sistema. Consultada por todos los flujos de Make antes de ejecutar.

### Estructura

| Fila | A: Parametro | B: Valor |
|------|-------------|----------|
| 1 | (Encabezado) | (Encabezado) |
| 2 | Sistema Global | TRUE |
| 3 | Merida | TRUE |
| 4 | Margarita | TRUE |
| 5 | Maracaibo | TRUE |
| 6 | Maturin | TRUE |
| 7 | Canaima | TRUE |
| 8 | Morrocoy | TRUE |
| 9 | Catatumbo | TRUE |
| 10 | Delay WhatsApp (horas) | 2 |
| 11 | Umbral Rescate | 3 |
| 12 | Email OVA VISION | ovavision.ve@gmail.com |

---

## Apps Script — Funciones Principales

### Funcion 1: onEdit Trigger

```
Cuando se modifica la pestana Checkouts:
  -> Validar formato de telefono
  -> Validar campos obligatorios
  -> Marcar Estado Envio como PENDIENTE
```

### Funcion 2: calcularTagFrequency()

```
Ejecutar semanalmente (time-driven trigger):
  -> Leer columna Comentario de Respuestas WA y QR
  -> Extraer palabras clave frecuentes
  -> Actualizar tabla de Tags en Dashboard
```

### Funcion 3: alertaPromedioSemanal()

```
Ejecutar cada lunes a las 8 AM:
  -> Calcular promedio general de la semana anterior
  -> Si promedio < 3.5 -> Enviar email a Flor + Eduardo + OVA VISION
  -> Registrar en pestana Alertas
```

### Funcion 4: limpiarDatosAntiguos()

```
Ejecutar mensualmente:
  -> Mover filas con mas de 6 meses a un Sheet de archivo
  -> Mantener Sheets principal liviano
```

### Funcion 5: exportarReporteMensual()

```
Ejecutar el 1ro de cada mes:
  -> Generar PDF con resumen del mes anterior
  -> Enviar por email a Eduardo Chediak + OVA VISION
```

---

## Permisos

| Rol | Acceso |
|-----|--------|
| OVA VISION | Editor (todas las pestanas) |
| Eduardo Chediak | Editor (todas las pestanas) |
| Flor Acosta | Editor (Checkouts, Alertas) / Viewer (resto) |
| Recepcionistas | Editor (solo Checkouts de su sede) |
| Make (Service Account) | Editor (via API — todas las pestanas) |

---

## Notas de Implementacion

- Crear un Google Sheet por funcionalidad o un solo Sheet con multiples pestanas. **Recomendacion:** Un solo Sheet con pestanas, para simplificar las conexiones de Make.
- Usar Data Validation para todos los dropdowns (prevenir errores de input manual).
- Proteger celdas de formulas y columnas automaticas para evitar borrado accidental.
- Configurar notificaciones nativas de Google Sheets como respaldo a las alertas de Make.
- El Sheet debe estar en una cuenta de Google controlada por OVA VISION (no en cuenta personal del cliente) para garantizar continuidad.

---

*Documento generado por OVA VISION · v2026-03-25*
