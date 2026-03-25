# Google Sheets — Estructura Operativa · Hoteles Tibisay

**Version:** v2026-03-25
**Estado:** Estructura definida, Apps Script completado
**Plataforma:** Google Sheets + Google Apps Script

---

## Resumen

Google Sheets es la **base operativa central** del ecosistema digital de Hoteles Tibisay. Funciona como:

1. Puente entre el PMS de escritorio y las automatizaciones
2. Repositorio de respuestas de encuestas (WhatsApp + QR)
3. Dashboard de monitoreo en tiempo real
4. Hoja de configuracion del sistema (kill switch, parametros)

---

## Estructura del Workbook

El workbook principal contiene las siguientes hojas (pestañas):

```
📊 Hoteles Tibisay — Base Operativa
├── Checkouts          → Input manual por recepcionistas
├── Respuestas WA      → Auto-poblado desde WhatsApp bot
├── Respuestas QR      → Auto-poblado desde formularios QR
├── Dashboard          → Formulas, promedios, alertas
├── Alertas            → Casos de rescate pendientes
├── Config             → Kill switch y parametros del sistema
├── Errores            → Log de errores de automatizacion
└── Sedes              → Datos de referencia de las 7 sedes
```

---

## Sheet 1: Checkouts

### Proposito

Registro manual de cada checkout realizado por los recepcionistas. Esta hoja es el **trigger** de todas las automatizaciones.

### Estructura de columnas

| Columna | Nombre | Tipo | Formato | Obligatorio | Ejemplo |
|---------|--------|------|---------|-------------|---------|
| A | Fecha | Fecha | DD/MM/AAAA | Si | 25/03/2026 |
| B | Hora | Hora | HH:MM | Si | 11:30 |
| C | Nombre | Texto | Libre | Si | Maria Garcia Lopez |
| D | Telefono | Texto | +58XXXXXXXXXX | Si | +584141234567 |
| E | Email | Texto | email@dominio.com | Si* | maria@gmail.com |
| F | Habitacion | Texto | Numero | Si | 205 |
| G | Noches | Numero | Entero | Si | 3 |
| H | Tipo | Lista | Nacional/Internacional/Corporativo | Si | Nacional |
| I | Sede | Texto | Auto (segun pestaña) | Automatico | Merida |
| J | Observaciones | Texto | Libre | No | Celebraba aniversario |
| K | WA Enviado | Texto | Auto | Automatico | SI / NO / ERROR |
| L | Email Enviado | Texto | Auto | Automatico | SI / NO / ERROR |
| M | Timestamp | Timestamp | Auto | Automatico | 2026-03-25T11:30:00Z |

> *Email es obligatorio si esta disponible. Sin email, la secuencia de email no se dispara pero la de WhatsApp si.

### Validaciones

- **Columna D (Telefono):** Validacion de datos que acepta solo formato +58 seguido de 10 digitos
- **Columna H (Tipo):** Lista desplegable con 3 opciones
- **Columna A (Fecha):** Validacion de fecha valida
- **Columnas K-M:** Protegidas contra edicion manual (se llenan automaticamente)

### Organizacion por sede

Opcion A (recomendada): **Una pestaña por sede**
- Checkouts_Merida
- Checkouts_Margarita
- Checkouts_Maracaibo
- Checkouts_Maturin
- Checkouts_Canaima
- Checkouts_Morrocoy
- Checkouts_Catatumbo

Opcion B: **Una sola pestaña con columna de filtro por sede**
- Mas simple pero mas propenso a errores si recepcionistas no seleccionan la sede correcta

---

## Sheet 2: Respuestas WhatsApp

### Proposito

Registro automatico de todas las respuestas recibidas del bot de WhatsApp. Esta hoja se llena automaticamente via el Flujo 5 de Make (Response Logging).

### Estructura de columnas

| Columna | Nombre | Tipo | Formato | Fuente |
|---------|--------|------|---------|--------|
| A | Timestamp | Timestamp | ISO 8601 | Auto (Make) |
| B | Sede | Texto | Nombre de sede | Auto (del checkout) |
| C | Nombre | Texto | Libre | Auto (del checkout) |
| D | Telefono | Texto | +58... | Auto (del checkout) |
| E | Calif_General | Numero | 1-5 | Respuesta del huesped |
| F | Calif_Checkin | Numero | 1-5 | Respuesta del huesped |
| G | Calif_Habitacion | Numero | 1-5 | Respuesta del huesped |
| H | Calif_Restaurante | Numero | 1-5 | Respuesta del huesped |
| I | Calif_Personal | Numero | 1-5 | Respuesta del huesped |
| J | Calif_Limpieza | Numero | 1-5 | Respuesta del huesped |
| K | Comentario | Texto | Libre | Respuesta del huesped |
| L | Tags | Texto | Separados por coma | Auto (Apps Script) |
| M | Ruta | Texto | Embajador/Retencion/Rescate | Auto (Make) |
| N | Promedio | Numero | 1.0-5.0 | Formula |
| O | Alerta | Texto | SI/NO | Formula |

### Formulas automaticas

- **Columna N (Promedio):** `=AVERAGE(E2:J2)`
- **Columna O (Alerta):** `=IF(MIN(E2:J2)<=3,"SI","NO")`

### Proteccion

- Toda la hoja esta protegida contra edicion manual
- Solo la cuenta de servicio de Make tiene permisos de escritura
- OVA VISION tiene permisos de administrador

---

## Sheet 3: Respuestas QR

### Proposito

Registro automatico de las respuestas enviadas a traves de los formularios QR. Se llena automaticamente desde Google Forms (linked) o via Make.

### Estructura de columnas

| Columna | Nombre | Tipo | Formato | Fuente |
|---------|--------|------|---------|--------|
| A | Timestamp | Timestamp | ISO 8601 | Auto (Google Forms) |
| B | Sede | Texto | Nombre de sede | Seleccion del huesped |
| C | Nombre | Texto | Libre (opcional) | Respuesta del huesped |
| D | Email | Texto | email (opcional) | Respuesta del huesped |
| E | Calif_General | Numero | 1-5 | Respuesta del huesped |
| F | Calif_Checkin | Numero | 1-5 | Respuesta del huesped |
| G | Calif_Habitacion | Numero | 1-5 | Respuesta del huesped |
| H | Calif_Restaurante | Numero | 1-5 | Respuesta del huesped |
| I | Calif_Personal | Numero | 1-5 | Respuesta del huesped |
| J | Calif_Limpieza | Numero | 1-5 | Respuesta del huesped |
| K | Comentario | Texto | Libre | Respuesta del huesped |
| L | Tags | Texto | Separados por coma | Auto (Apps Script) |
| M | Promedio | Numero | 1.0-5.0 | Formula |
| N | Alerta | Texto | SI/NO | Formula |

### Diferencias con Sheet 2 (WhatsApp)

- No tiene columna de Telefono (el QR no lo captura obligatoriamente)
- No tiene columna de Ruta (no hay branching en QR)
- Nombre y Email son opcionales (el huesped puede responder anonimamente)
- La sede se selecciona en el formulario (no se auto-detecta)

---

## Sheet 4: Dashboard

### Proposito

Visualizacion en tiempo real de los resultados de satisfaccion de todas las sedes. Se actualiza automaticamente con formulas y Apps Script.

### Secciones del Dashboard

#### 4.1 Resumen Ejecutivo

| Metrica | Formula | Descripcion |
|---------|---------|------------|
| Promedio general (todas las sedes) | `=AVERAGE(...)` de ambas hojas de respuestas | Calificacion promedio global |
| Total respuestas (mes actual) | `=COUNTIFS(...)` con filtro de fecha | Volumen de feedback recibido |
| Tasa de respuesta WhatsApp | Respuestas WA / Checkouts registrados | Porcentaje de huespedes que respondieron |
| Alertas activas | `=COUNTIF(Alertas!F:F,"Pendiente")` | Casos de rescate sin resolver |

#### 4.2 Promedios por Sede

Tabla automatica con promedio de cada area por sede:

| Sede | General | Check-in | Habitacion | Restaurante | Personal | Limpieza | Tendencia |
|------|---------|----------|-----------|-------------|----------|----------|-----------|
| (cada sede) | formula | formula | formula | formula | formula | formula | formula |

Formula tipo: `=AVERAGEIFS(Respuestas_WA!E:E, Respuestas_WA!B:B, "Merida")`

#### 4.3 Promedio Semanal con Tendencia

- Calculo del promedio de los ultimos 7 dias
- Comparacion con la semana anterior
- Indicador visual: ↑ (mejorando), → (estable), ↓ (empeorando)
- Formula de tendencia: compara `AVERAGEIFS` de esta semana vs semana anterior

#### 4.4 Tag Frequency (Frecuencia de Palabras Clave)

Tabla de las 20 palabras/frases mas mencionadas en los comentarios:

| Tag | Frecuencia | Sentimiento |
|-----|-----------|------------|
| (palabra) | (conteo) | Positivo/Negativo/Neutro |

> Esta seccion se actualiza via Apps Script (ver seccion de funciones).

#### 4.5 Alertas Resumen

Vista resumida de la pestaña Alertas:

| Sede | Alertas pendientes | Ultima alerta | Tiempo promedio de respuesta |
|------|-------------------|--------------|----------------------------|

### Formato condicional

| Rango | Regla | Color |
|-------|-------|-------|
| Calificaciones | >= 4.0 | Verde (#00C853) |
| Calificaciones | 3.0 - 3.9 | Amarillo (#FFD600) |
| Calificaciones | < 3.0 | Rojo (#FF1744) |
| Alertas pendientes | > 0 | Rojo (#FF1744) |
| Tendencia ↑ | Mejorando | Verde |
| Tendencia ↓ | Empeorando | Rojo |

---

## Apps Script — Funciones Documentadas

### Archivo: `Code.gs`

#### Funcion 1: `updateTagFrequency()`

```
Proposito: Analiza todos los comentarios y actualiza la tabla de tags frecuentes
Trigger: Cada vez que se agrega una nueva respuesta (onEdit trigger)
Hojas que lee: Respuestas_WA, Respuestas_QR
Hoja que escribe: Dashboard (seccion Tag Frequency)
Logica:
  1. Recopila todos los comentarios de ambas hojas
  2. Tokeniza y normaliza (minusculas, elimina stopwords)
  3. Cuenta frecuencia de cada token
  4. Clasifica sentimiento basico (lista de palabras positivas/negativas)
  5. Escribe los top 20 en el dashboard
```

#### Funcion 2: `checkWeeklyAverage()`

```
Proposito: Calcula promedios semanales y envia alerta si caen por debajo de 3.5
Trigger: Tiempo (cada lunes a las 8:00 AM)
Hojas que lee: Respuestas_WA, Respuestas_QR
Accion: Si promedio semanal de cualquier sede < 3.5, envia email a OVA VISION
```

#### Funcion 3: `formatNewRow()`

```
Proposito: Auto-formatea nuevas filas ingresadas en Checkouts
Trigger: onEdit (cuando se detecta nueva fila)
Logica:
  1. Valida formato de telefono (+58...)
  2. Agrega timestamp automatico (columna M)
  3. Resalta fila si hay datos faltantes
```

#### Funcion 4: `generateWeeklyReport()`

```
Proposito: Genera un reporte semanal en PDF y lo envia por email
Trigger: Tiempo (cada lunes a las 9:00 AM)
Destinatarios: Eduardo Chediak, Flor Acosta, OVA VISION
Contenido: Promedio por sede, alertas de la semana, tags mas frecuentes
```

#### Funcion 5: `cleanupDuplicates()`

```
Proposito: Detecta y marca filas duplicadas en Checkouts
Trigger: Manual (menu personalizado)
Logica: Compara telefono + fecha para detectar duplicados
Accion: Agrega "DUPLICADO" en observaciones, resalta fila en amarillo
```

---

## Permisos de Acceso

### Estructura de permisos

| Rol | Acceso | Hojas editables | Hojas solo lectura |
|-----|--------|-----------------|-------------------|
| **Recepcionista** | Editor limitado | Checkouts (su sede) | Dashboard |
| **Gerente de sede** | Editor limitado | Checkouts (su sede), Alertas (su sede) | Dashboard, Respuestas |
| **Flor Acosta** | Editor | Alertas (todas) | Todas |
| **Eduardo Chediak** | Editor | Todas excepto Config | Todas |
| **OVA VISION** | Administrador | Todas | Todas |
| **Make (servicio)** | Editor API | Respuestas WA, Respuestas QR, Alertas, Errores | Checkouts, Config |

### Como asignar permisos

1. Compartir el workbook con el email de Google del usuario
2. Usar la funcion "Proteger hoja" para limitar edicion por pestaña
3. Crear vistas filtradas por sede para que cada recepcionista vea solo su sede
4. La cuenta de servicio de Make se agrega como editor con acceso API

### Cuentas necesarias

| Sede | Email de acceso | Estado |
|------|----------------|--------|
| Merida | Pendiente | — |
| Margarita | Pendiente | — |
| Maracaibo | Pendiente | — |
| Maturin | Pendiente | — |
| Canaima | Pendiente | — |
| Morrocoy | Pendiente | — |
| Catatumbo | Pendiente | — |
| OVA VISION | ovavision.ve@gmail.com | Listo |
| Make (servicio) | Pendiente (crear cuenta de servicio) | — |

> Los emails de acceso de cada sede deben ser proporcionados por Eduardo Chediak. Preferiblemente Gmail para compatibilidad con Google Sheets.

---

## Backups

- Google Sheets tiene historial de versiones nativo (Archivo → Historial de versiones)
- Apps Script esta versionado en el editor de Apps Script
- OVA VISION exporta backup mensual en formato .xlsx como respaldo externo
- En caso de error grave: restaurar desde historial de versiones o backup .xlsx

---

## Limites de Google Sheets

| Recurso | Limite | Impacto |
|---------|--------|---------|
| Celdas por workbook | 10 millones | No se alcanzara en años |
| Filas por hoja | 10 millones | Suficiente |
| Peticiones API/min | 60 (lectura), 60 (escritura) | Podria ser limitante con alto volumen |
| Apps Script ejecucion | 6 min/ejecucion, 90 min/dia | Suficiente para funciones actuales |

> Si el volumen de checkouts supera 500/dia (muy improbable), considerar migrar a base de datos real (Supabase o Firebase).

---

*Documento generado por OVA VISION · v2026-03-25*
