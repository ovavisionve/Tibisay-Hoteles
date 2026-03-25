# PMS Bridge — Puente PMS a Google Sheets · Hoteles Tibisay

**Version:** v2026-03-25
**Estado:** Diseno completado, implementacion pendiente
**Tipo de integracion:** Manual/semiautomatica (sin APIs disponibles)

---

## 1. Estado Actual de los PMS

Todas las sedes de Hoteles Tibisay utilizan sistemas PMS (Property Management System) de escritorio, sin interfaces web ni APIs documentadas. Esto imposibilita una integracion automatica directa.

### Inventario de PMS

| Sede | PMS | Tipo | API disponible | Exportacion de datos | Contacto soporte |
|------|-----|------|---------------|---------------------|-----------------|
| Merida | Hospes | Escritorio | No confirmada | No confirmada | Sr. Vizcaya — 0414 518 4092 |
| Margarita | Hospes | Escritorio | No confirmada | No confirmada | Sr. Vizcaya — 0414 518 4092 |
| Maracaibo | Hospes | Escritorio | No confirmada | No confirmada | Sr. Vizcaya — 0414 518 4092 |
| Maturin | Ratio | Escritorio | No confirmada | No confirmada | Sr. Rojas — 0414 640 0161 |
| Canaima | Ninguno | — | — | — | — |
| Morrocoy | New Hotel | Escritorio | No confirmada | No confirmada | Sr. Rafael Clemente — 0412 622 7724 |
| Catatumbo | Ninguno | — | — | — | — |

### Restricciones clave

1. **Sin APIs:** Los PMS son aplicaciones de escritorio Windows, no tienen APIs REST/SOAP documentadas
2. **Sin acceso a BD:** No se ha confirmado acceso a las bases de datos subyacentes (probablemente SQL Server, MySQL o SQLite local)
3. **Sin exportaciones automaticas:** No se ha confirmado si los PMS permiten exportar datos automaticamente (CSV, Excel, etc.)
4. **Decision del cliente:** Eduardo Chediak decidio que la integracion se maneje por separado — no instalar nada en los servidores/computadoras del hotel
5. **Dos sedes sin PMS:** Canaima y Catatumbo no tienen sistema de gestion hotelera

---

## 2. Solucion: Puente Manual via Google Sheets

Dado que no hay integracion directa posible, el flujo es **semimanual**: el recepcionista registra manualmente los datos del checkout en Google Sheets, lo cual dispara las automatizaciones.

### Flujo del puente

```
┌─────────────────────┐
│ Huesped hace        │
│ checkout en el      │
│ hotel               │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐     ┌─────────────────────┐
│ Recepcionista       │     │ Recepcionista        │
│ procesa checkout    │────▶│ registra datos en    │
│ en el PMS           │     │ Google Sheets        │
│ (Hospes/Ratio/      │     │ (navegador o app)    │
│  New Hotel)         │     │                      │
└─────────────────────┘     └──────────┬──────────┘
                                       │
                                       ▼
                            ┌─────────────────────┐
                            │ Make detecta nueva   │
                            │ fila (polling cada   │
                            │ 15 minutos)          │
                            └──────────┬──────────┘
                                       │
                          ┌────────────┼────────────┐
                          │            │            │
                          ▼            ▼            ▼
                    ┌──────────┐ ┌──────────┐ ┌──────────┐
                    │ WhatsApp │ │ Email    │ │ Dashboard│
                    │ (2h)     │ │ sequence │ │ update   │
                    └──────────┘ └──────────┘ └──────────┘
```

### Tiempo adicional para el recepcionista

- **Estimado:** 1-2 minutos por checkout
- **Datos a ingresar:** 8 campos (fecha, hora, nombre, telefono, email, habitacion, noches, tipo)
- **Herramienta:** Google Sheets en navegador web o app movil de Google Sheets

---

## 3. Datos que Cruzan el Puente

### Datos disponibles en el PMS (que el recepcionista puede extraer)

| Dato | Disponible en Hospes | Disponible en Ratio | Disponible en New Hotel |
|------|---------------------|--------------------|-----------------------|
| Nombre del huesped | Si | Si | Si |
| Telefono | Si | Si | Si |
| Email | Probablemente | Probablemente | Probablemente |
| Fecha check-in | Si | Si | Si |
| Fecha check-out | Si | Si | Si |
| Numero de habitacion | Si | Si | Si |
| Tipo de habitacion | Si | Si | Si |
| Noches | Calculable | Calculable | Calculable |
| Tarifa pagada | Si | Si | Si |
| Metodo de pago | Si | Si | Si |
| Nacionalidad | Probablemente | Probablemente | Probablemente |
| Motivo de viaje | Variable | Variable | Variable |

### Datos que se registran en el puente (Google Sheets)

Solo se transfieren los datos necesarios para las automatizaciones:

| Campo | Uso |
|-------|-----|
| Nombre | Personalizar WhatsApp y emails |
| Telefono | Enviar encuesta WhatsApp |
| Email | Enviar secuencia de email |
| Habitacion | Referencia en alertas de rescate |
| Noches | Segmentacion (estadia corta vs larga) |
| Tipo (nacional/intl/corp) | Segmentacion de email y tono de comunicacion |

> **Nota:** No se transfieren datos financieros (tarifa, metodo de pago) al puente por razones de privacidad y porque no son necesarios para las automatizaciones actuales.

---

## 4. Procedimiento por PMS

### 4.1 Hospes (Merida, Margarita, Maracaibo)

```
1. Completar el proceso de checkout normal en Hospes
2. Antes de cerrar la ficha del huesped, copiar:
   - Nombre completo
   - Telefono (verificar formato)
   - Email
   - Numero de habitacion
3. Abrir Google Sheets (mantener pestaña abierta en el navegador)
4. Ingresar los datos en la fila correspondiente
5. Verificar que el telefono tenga formato +58...
6. Continuar con el siguiente checkout
```

**Tip para Hospes:** Si Hospes permite mantener la ficha del huesped abierta mientras se usa el navegador, abrir ambas ventanas lado a lado para agilizar el proceso.

### 4.2 Ratio (Maturin)

```
1. Completar el proceso de checkout normal en Ratio
2. Desde la pantalla de checkout, anotar los datos del huesped
3. Abrir Google Sheets e ingresar los datos
4. Formato de telefono: +58...
```

**Contacto para dudas con Ratio:** Sr. Rojas — 0414 640 0161

### 4.3 New Hotel (Morrocoy)

```
1. Completar el proceso de checkout en New Hotel
2. Extraer datos del huesped de la ficha
3. Ingresar en Google Sheets
```

**Contacto para dudas con New Hotel:** Sr. Rafael Clemente — 0412 622 7724

### 4.4 Sin PMS (Canaima, Catatumbo)

```
1. Registrar el checkout en el libro/registro manual de la sede
2. Ingresar los datos directamente en Google Sheets
3. Para Canaima: verificar si el huesped prefiere comunicacion en ingles
   (marcar en observaciones: "Idioma: EN")
```

---

## 5. Plan Futuro: Integracion Semi-Automatica

### Fase 1 (actual): 100% manual

El recepcionista ingresa todos los datos manualmente. Es el flujo mas simple y no requiere modificaciones al PMS ni coordinacion con proveedores.

### Fase 2 (corto plazo): Exportacion CSV/Excel

**Objetivo:** Reducir la carga manual aprovechando exportaciones del PMS.

**Pasos para investigar:**

1. Contactar a cada proveedor de PMS y preguntar:
   - ¿El sistema permite exportar una lista de checkouts del dia en CSV o Excel?
   - ¿Con que frecuencia se puede exportar? (manual, programada)
   - ¿Que campos incluye la exportacion?
   - ¿Es necesario algun modulo adicional o licencia?

2. Si la exportacion es posible:
   - Configurar exportacion diaria (preferiblemente automatica a una carpeta)
   - Crear un flujo en Make que lea el archivo exportado y lo importe a Google Sheets
   - Reducir la carga del recepcionista a: exportar + verificar

### Fase 3 (mediano plazo): Acceso directo a base de datos

**Objetivo:** Lectura automatica de los checkouts directamente desde la base de datos del PMS.

**Requisitos:**

1. Permiso del proveedor de PMS para acceder a la base de datos en modo lectura
2. Documentacion del esquema de la base de datos (tablas, campos)
3. Conectividad: el servidor del PMS debe ser accesible (red local o remoto)
4. Seguridad: acceso solo de lectura, usuario con permisos minimos

**Preguntas para los proveedores:**

| Pregunta | Para |
|----------|------|
| ¿Que motor de base de datos usa el PMS? (SQL Server, MySQL, SQLite, Access) | Todos |
| ¿Es posible crear un usuario de solo lectura? | Todos |
| ¿La base de datos es local o en red? | Todos |
| ¿Tienen documentacion del esquema? | Todos |
| ¿Ofrecen algun tipo de API, webhook o integracion? | Todos |
| ¿Hay costo adicional por acceso a la base de datos? | Todos |

### Fase 4 (largo plazo): Integracion PMS nativa

**Objetivo:** Que el PMS notifique automaticamente al ecosistema cuando ocurre un checkout.

Esto depende completamente de la voluntad y capacidad tecnica de los proveedores de PMS. Es el escenario ideal pero el menos probable a corto plazo.

---

## 6. Contactos de Proveedores PMS

### Hospes (3 sedes: Merida, Margarita, Maracaibo)

| Campo | Detalle |
|-------|---------|
| Contacto | Sr. Vizcaya |
| Telefono | 0414 518 4092 |
| Sedes | Merida, Margarita, Maracaibo |
| Preguntas pendientes | Exportacion CSV, acceso a BD, esquema de datos |

### Ratio (1 sede: Maturin)

| Campo | Detalle |
|-------|---------|
| Contacto | Sr. Rojas |
| Telefono | 0414 640 0161 |
| Sede | Maturin |
| Preguntas pendientes | Exportacion CSV, acceso a BD, esquema de datos |

### New Hotel (1 sede: Morrocoy)

| Campo | Detalle |
|-------|---------|
| Contacto | Sr. Rafael Clemente |
| Telefono | 0412 622 7724 |
| Sede | Morrocoy |
| Preguntas pendientes | Exportacion CSV, acceso a BD, esquema de datos |

### Sin PMS (Canaima, Catatumbo)

Para estas sedes, considerar implementar una solucion ligera en el futuro:

- **Opcion 1:** Google Forms como "mini-PMS" para registro de huespedes
- **Opcion 2:** Hoja de calculo local sincronizada con Google Sheets
- **Opcion 3:** App movil simple (si hay conectividad confiable)

> **Nota sobre Canaima:** La conectividad a internet no esta confirmada. Si no hay internet estable, el registro en Google Sheets debera hacerse en lotes cuando haya conexion, o via SMS/offline-first approach.

---

## 7. Consideraciones de Seguridad y Privacidad

- Los datos de huespedes (nombre, telefono, email) son **datos personales**
- Solo se transfieren al puente los datos estrictamente necesarios para las automatizaciones
- No se transfieren datos financieros (tarifa, metodo de pago, datos de tarjeta)
- Google Sheets tiene permisos controlados (ver documentacion de Sheets)
- Las cuentas de acceso deben tener autenticacion de 2 factores habilitada
- En caso de solicitud de eliminacion de datos por un huesped, contactar a OVA VISION

---

## 8. Metricas del Puente

Para evaluar la efectividad del puente manual:

| Metrica | Como medir | Objetivo |
|---------|-----------|----------|
| Tasa de registro | Checkouts en Sheets / Checkouts en PMS | > 95% |
| Tiempo de registro | Tiempo entre checkout y registro en Sheets | < 15 min |
| Errores de formato | Filas con errores de validacion | < 5% |
| Cobertura de email | Checkouts con email registrado / Total | > 70% |
| Cobertura de telefono | Checkouts con telefono valido / Total | > 90% |

> Estas metricas deben revisarse semanalmente durante el primer mes y luego mensualmente.

---

*Documento generado por OVA VISION · v2026-03-25*
