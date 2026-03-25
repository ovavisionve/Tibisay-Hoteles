# PMS Bridge — Puente PMS a Google Sheets

**Version:** v2026-03-25
**Estado:** Diseno conceptual, pendiente de implementacion
**Dependencia:** Confirmacion de capacidades de exportacion de cada PMS

---

## Resumen

Los hoteles de la cadena Tibisay utilizan sistemas PMS (Property Management System) de escritorio que no disponen de APIs para integracion directa. Este documento describe la estrategia de puente manual y semiautomatico entre los PMS y Google Sheets, que es la base operativa central del ecosistema digital.

### El Problema

```
┌─────────────────────┐          ┌──────────────────┐
│   PMS de Escritorio │    X     │  Google Sheets   │
│   (sin API)         │─────────>│  (Base Operativa) │
│                     │  No hay  │                  │
│                     │  conexion│                  │
└─────────────────────┘ directa  └──────────────────┘
```

### La Solucion: Puente Manual

```
┌─────────────────────┐     ┌───────────────────┐     ┌──────────────────┐
│   PMS de Escritorio │     │  Recepcionista    │     │  Google Sheets   │
│                     │────>│  registra checkout│────>│  (Pestana        │
│  Checkout ocurre    │     │  manualmente      │     │   Checkouts)     │
└─────────────────────┘     └───────────────────┘     └────────┬─────────┘
                                                               │
                                                      ┌────────▼─────────┐
                                                      │  Make detecta    │
                                                      │  nueva fila      │
                                                      │  -> Flujo 1      │
                                                      └──────────────────┘
```

---

## Sistemas PMS por Sede

### Hospes (3 sedes)

| Dato | Detalle |
|------|---------|
| Sedes | Merida, Margarita, Maracaibo (Del Lago) |
| Tipo | Aplicacion de escritorio |
| Contacto tecnico | Sr. Vizcaya — 0414 518 4092 |
| API disponible | No confirmada |
| Exportacion | Pendiente de verificar (posible CSV/Excel) |
| Base de datos | Pendiente de verificar (posible SQL Server o Access) |

**Acciones pendientes con Sr. Vizcaya:**
1. Confirmar si Hospes permite exportar listado de checkouts diarios (CSV, Excel o similar)
2. Confirmar si la base de datos es accesible localmente (SQL Server, MySQL, Access)
3. Preguntar si existe algun modulo de reportes automaticos o programados
4. Evaluar si se puede crear un script local que lea la BD y suba a Sheets (requiere acceso al servidor)
5. Consultar sobre la version de Hospes instalada y si hay actualizaciones con funcionalidad web

### Ratio (1 sede)

| Dato | Detalle |
|------|---------|
| Sede | Maturin |
| Tipo | Aplicacion de escritorio |
| Contacto tecnico | Sr. Rojas — 0414 640 0161 |
| API disponible | No confirmada |
| Exportacion | Pendiente de verificar |
| Base de datos | Pendiente de verificar |

**Acciones pendientes con Sr. Rojas:**
1. Mismas preguntas que para Hospes
2. Adicionalmente: confirmar si Ratio tiene algun tipo de webhook o notificacion al completar un checkout

### New Hotel (1 sede)

| Dato | Detalle |
|------|---------|
| Sede | Morrocoy |
| Tipo | Aplicacion de escritorio |
| Contacto tecnico | Sr. Rafael Clemente — 0412 622 7724 |
| API disponible | No confirmada |
| Exportacion | Pendiente de verificar |
| Base de datos | Pendiente de verificar |

**Acciones pendientes con Sr. Rafael Clemente:**
1. Mismas preguntas que para Hospes
2. Consultar version del software y opciones de integracion

### Sin PMS (2 sedes)

| Sede | Estado |
|------|--------|
| Canaima | Sin PMS identificado — el registro es manual |
| Catatumbo | Sin PMS identificado — el registro es manual |

**Implicacion:** Para estas sedes, el input en Google Sheets es el unico registro de checkout. No hay puente porque no hay sistema de origen.

---

## Estrategias de Puente (de menor a mayor automatizacion)

### Nivel 1: Input 100% Manual (Implementacion inmediata)

**Como funciona:**
1. El recepcionista completa el checkout en el PMS normalmente
2. Inmediatamente despues, abre Google Sheets en el navegador o celular
3. Llena una fila en la pestana "Checkouts" con los datos del huesped
4. Make detecta la nueva fila y dispara los flujos automaticos

**Ventajas:**
- No requiere ningun acceso al PMS
- Funciona con cualquier PMS (o sin PMS)
- Se puede implementar hoy

**Desventajas:**
- Doble trabajo para el recepcionista
- Riesgo de olvido o errores de transcripcion
- Depende de la disciplina del personal

**Mitigaciones:**
- Formulario simplificado en Google Sheets (solo campos esenciales)
- Validacion de datos integrada (dropdowns, formatos)
- Recordatorio diario automatico si no hay checkouts registrados (Apps Script)
- Capacitacion al personal de recepcion

### Nivel 2: Exportacion Diaria CSV (Requiere confirmacion del PMS)

**Como funciona:**
1. Al final del dia (o turno), el recepcionista exporta los checkouts del dia desde el PMS como CSV/Excel
2. Sube el archivo a una carpeta especifica de Google Drive
3. Un Apps Script procesa el archivo y agrega las filas a la pestana Checkouts
4. Make continua el flujo normalmente

**Ventajas:**
- Menos input manual (solo exportar y subir)
- Los datos vienen directamente del PMS (menos errores)

**Desventajas:**
- Requiere que el PMS soporte exportacion (no confirmado)
- El delay entre el checkout real y el procesamiento puede ser de horas
- Aun requiere accion manual del recepcionista

**Prerequisitos:**
- Confirmar con cada proveedor de PMS que la exportacion es posible
- Definir formato y mapeo de campos CSV -> Sheets

### Nivel 3: Script Local de Lectura de BD (Requiere acceso al servidor)

**Como funciona:**
1. Se instala un script (Python/Node.js) en la PC donde corre el PMS
2. El script lee la base de datos local del PMS periodicamente (cada 15-30 min)
3. Detecta nuevos checkouts y los envia a Google Sheets via API
4. Make continua el flujo normalmente

**Ventajas:**
- Automatizacion real — sin intervencion humana
- Datos en tiempo real (o casi)
- Menor margen de error

**Desventajas:**
- Requiere acceso a la base de datos del PMS (no confirmado, posiblemente no permitido)
- Requiere instalar software adicional en la PC del hotel
- El cliente decidio explicitamente NO instalar nada en los servidores del hotel
- Riesgo de conflicto con el PMS si la BD se bloquea o modifica
- Mantenimiento continuo si el PMS se actualiza

**Nota del cliente:** Eduardo Chediak decidio manejar la integracion por separado y no instalar en servidores del hotel. Esta opcion queda documentada pero no se implementara sin autorizacion explicita.

### Nivel 4: Google Forms como Interfaz Alternativa (Opcion hibrida)

**Como funciona:**
1. Se crea un Google Form simple con los campos de checkout
2. El recepcionista llena el formulario desde el celular o PC (en lugar de abrir Sheets directamente)
3. Las respuestas van automaticamente a la pestana Checkouts en Sheets
4. Make continua el flujo normalmente

**Ventajas:**
- Interfaz mas amigable que Sheets para input rapido
- Funciona desde el celular (ideal para Canaima/Catatumbo con internet inestable — puede llenar offline y enviar cuando hay conexion)
- Validaciones integradas en el formulario

**Desventajas:**
- Aun es input manual
- No lee datos del PMS directamente

---

## Recomendacion

**Fase 1 (inmediata):** Implementar **Nivel 1** (input manual en Sheets) para todas las sedes. Complementar con **Nivel 4** (Google Forms) para Canaima y Catatumbo por la inestabilidad de internet.

**Fase 2 (semana 3-4):** Contactar a los proveedores de PMS (Vizcaya, Rojas, Clemente) para evaluar si **Nivel 2** (exportacion CSV) es viable. Si alguno lo soporta, implementarlo para esas sedes.

**Fase 3 (futuro):** Si el cliente autoriza y los proveedores de PMS colaboran, evaluar **Nivel 3** (script local) como solucion a largo plazo. Solo con aprobacion explicita de Eduardo Chediak.

---

## Contactos de Soporte PMS

| PMS | Sedes | Contacto | Telefono | Estado |
|-----|-------|----------|----------|--------|
| Hospes | Merida, Margarita, Maracaibo | Sr. Vizcaya | 0414 518 4092 | Pendiente de contactar |
| Ratio | Maturin | Sr. Rojas | 0414 640 0161 | Pendiente de contactar |
| New Hotel | Morrocoy | Sr. Rafael Clemente | 0412 622 7724 | Pendiente de contactar |
| — | Canaima | N/A | — | Sin PMS |
| — | Catatumbo | N/A | — | Sin PMS |

---

## Campos Minimos para el Puente

Independientemente del nivel de automatizacion, estos son los campos que deben llegar a Google Sheets desde el PMS (o manualmente):

| Campo | Obligatorio | Notas |
|-------|-------------|-------|
| Fecha/hora checkout | Si | Del PMS o manual |
| Nombre del huesped | Si | Nombre completo |
| Telefono | Si | Formato +58... para WhatsApp |
| Email | Deseable | Para email marketing |
| Habitacion | Si | Numero o nombre |
| Noches de estadia | Si | Para contexto en la encuesta |
| Tipo de huesped | Si | Nacional / Internacional / Corporativo |
| Sede | Si | Automatico si hay un Sheet por sede, o dropdown |
| Observaciones | Opcional | Notas relevantes del recepcionista |

---

## Riesgos y Mitigaciones

| Riesgo | Probabilidad | Impacto | Mitigacion |
|--------|-------------|---------|-----------|
| Recepcionista olvida registrar checkout | Alta | Alto | Recordatorios automaticos, revision diaria por sede |
| Datos incorrectos (telefono malo, nombre mal escrito) | Media | Medio | Validacion en Sheets, formato de telefono automatico |
| Internet inestable en sede | Media (Maracaibo, Maturin, Canaima) | Alto | Google Forms offline, sincronizacion posterior |
| PMS no soporta exportacion | Media | Bajo | Se mantiene input manual (Nivel 1) |
| Proveedor PMS no colabora | Baja | Bajo | No dependemos del PMS, el puente manual funciona |

---

*Documento generado por OVA VISION · v2026-03-25*
