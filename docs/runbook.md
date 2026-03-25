# Manual Operativo — Hoteles Tibisay

**Version:** v2026-03-25
**Dirigido a:** Equipo operativo de Hoteles Tibisay (recepcionistas, gerentes de sede, administracion)
**Soporte tecnico:** OVA VISION — ovavision.ve@gmail.com · +58 424 578 1707

---

## Indice

1. [Sistema de Encuestas WhatsApp](#1-sistema-de-encuestas-whatsapp)
2. [Registro de Checkouts en Google Sheets](#2-registro-de-checkouts-en-google-sheets)
3. [Dashboard de Resultados](#3-dashboard-de-resultados)
4. [Alertas de Rescate (Calificaciones Bajas)](#4-alertas-de-rescate-calificaciones-bajas)
5. [Formularios QR](#5-formularios-qr)
6. [Secuencias de Email](#6-secuencias-de-email)
7. [Solucion de Problemas Comunes](#7-solucion-de-problemas-comunes)
8. [Contactos de Soporte](#8-contactos-de-soporte)

---

## 1. Sistema de Encuestas WhatsApp

### Como funciona

El sistema envia automaticamente una encuesta de satisfaccion por WhatsApp a cada huesped **2 horas despues del checkout**. El huesped recibe un mensaje y responde directamente en el chat.

### Flujo completo

```
Checkout del huesped
        |
        v
Recepcionista registra checkout en Google Sheets (ver seccion 2)
        |
        v
[2 horas despues — automatico]
        |
        v
WhatsApp envia encuesta al huesped
        |
        v
Huesped responde (3-5 preguntas)
        |
        v
Sistema clasifica la respuesta:
   - Puntuacion 5/5 → Ruta EMBAJADOR (invitacion a dejar reseña publica)
   - Puntuacion 4/5 → Ruta RETENCION (agradecimiento + oferta de regreso)
   - Puntuacion 1-3/5 → Ruta RESCATE (alerta al equipo + disculpa al huesped)
```

### Que debe hacer el recepcionista

1. **Al momento del checkout:** Registrar los datos en Google Sheets (ver seccion 2)
2. **No es necesario enviar nada manualmente** — el sistema hace el envio automaticamente
3. **Si un huesped pregunta sobre la encuesta:** Explicar que recibira un breve cuestionario por WhatsApp para mejorar el servicio

### Areas que se evaluan

- Check-in y recepcion
- Habitacion (limpieza, comodidad, equipamiento)
- Restaurante y alimentos
- Atencion del personal
- Limpieza general
- Satisfaccion general

### Que NO debe hacer el recepcionista

- No enviar la encuesta manualmente
- No presionar al huesped para que responda
- No dar el numero del bot a los huespedes directamente
- No modificar las respuestas en Google Sheets

---

## 2. Registro de Checkouts en Google Sheets

### Acceso

La hoja de calculo esta en Google Sheets. Cada sede tiene su propia pestaña. El link de acceso sera proporcionado a cada recepcionista.

> **Importante:** Necesita una cuenta de Google (Gmail) para acceder. Usar la cuenta asignada por la gerencia.

### Columnas a llenar (por cada checkout)

| Columna | Que llenar | Ejemplo | Obligatorio |
|---------|-----------|---------|-------------|
| A: Fecha | Fecha del checkout | 25/03/2026 | Si |
| B: Hora | Hora del checkout | 11:30 | Si |
| C: Nombre | Nombre completo del huesped | Maria Garcia | Si |
| D: Telefono | Numero con codigo de pais | +58 414 123 4567 | Si |
| E: Email | Correo electronico | maria@gmail.com | Si (si disponible) |
| F: Habitacion | Numero de habitacion | 205 | Si |
| G: Noches | Cantidad de noches | 3 | Si |
| H: Tipo | Nacional / Internacional / Corporativo | Nacional | Si |
| I: Sede | Nombre de la sede | Merida | Automatico |
| J: Observaciones | Notas especiales | Celebraba aniversario | Opcional |

### Paso a paso

1. Abrir Google Sheets desde el navegador (o la app en el celular)
2. Ir a la pestaña de su sede
3. Ubicar la primera fila vacia
4. Llenar las columnas A hasta H (minimo)
5. Verificar que el numero de telefono tenga el formato correcto: +58 seguido del numero
6. No modificar filas anteriores
7. No borrar ni mover columnas

### Formato del numero de telefono

El formato correcto es fundamental para que el WhatsApp se envie correctamente:

| Formato correcto | Formato incorrecto |
|-----------------|-------------------|
| +584141234567 | 0414-123-4567 |
| +584241234567 | 04241234567 |
| +584121234567 | 412-123-4567 |

**Regla:** Siempre empezar con +58, eliminar el 0 inicial, sin guiones ni espacios.

### Que pasa si cometo un error

- **Error en un dato:** Corregirlo directamente en la celda. Si la encuesta ya fue enviada al numero anterior, contactar a OVA VISION.
- **Fila duplicada:** No borrar la fila. Agregar "DUPLICADO" en la columna de Observaciones y contactar a OVA VISION.
- **Olvide registrar un checkout:** Ingresarlo lo antes posible. El sistema enviara la encuesta igualmente, pero el timing puede no ser exacto.

---

## 3. Dashboard de Resultados

### Que es

El dashboard es una pestaña especial en Google Sheets que muestra automaticamente los resultados de todas las encuestas (WhatsApp y QR) en tiempo real.

### Como acceder

Abrir el mismo enlace de Google Sheets y buscar la pestaña **"Dashboard"**.

### Que muestra

| Seccion | Descripcion |
|---------|------------|
| Promedio general | Calificacion promedio de la sede (1-5) actualizada en tiempo real |
| Promedio semanal | Promedio de la ultima semana con tendencia (sube/baja) |
| Desglose por area | Calificacion promedio por cada area (habitacion, restaurante, personal, etc.) |
| Tags frecuentes | Palabras clave mas mencionadas por los huespedes (positivas y negativas) |
| Alertas activas | Casos de rescate pendientes de seguimiento |
| Volumen de respuestas | Cantidad de encuestas respondidas por semana |

### Como leer los colores

| Color | Significado |
|-------|------------|
| Verde | Calificacion >= 4.0 — Excelente |
| Amarillo | Calificacion 3.0-3.9 — Requiere atencion |
| Rojo | Calificacion < 3.0 — Critico, accion inmediata |

### Frecuencia de actualizacion

El dashboard se actualiza automaticamente cada vez que se registra una nueva respuesta. No es necesario refrescar manualmente (aunque puede hacer clic en "Actualizar" si desea forzar la actualizacion).

---

## 4. Alertas de Rescate (Calificaciones Bajas)

### Cuando se activa una alerta

Cada vez que un huesped da una calificacion de **3 o menos (sobre 5)** en cualquier area, el sistema:

1. Envia un **mensaje de disculpa automatico** al huesped por WhatsApp
2. Envia una **alerta inmediata** a:
   - Flor Acosta
   - Eduardo Chediak
3. Registra el caso como **"Rescate pendiente"** en el dashboard

### Que debe hacer el equipo del hotel

**Dentro de las primeras 2 horas de recibir la alerta:**

1. **Revisar la alerta:** Ver que area fue mal calificada y los comentarios del huesped
2. **Identificar al huesped:** Buscar en el registro de checkouts
3. **Evaluar la situacion:** Determinar si el problema es puntual o recurrente
4. **Contactar al huesped (si aplica):**
   - Llamar por telefono (preferible) o enviar WhatsApp personalizado
   - Disculparse genuinamente
   - Ofrecer solucion concreta (descuento en proxima estadia, upgrade, etc.)
5. **Documentar la accion tomada:** Responder en el hilo de alerta o actualizar la hoja de seguimiento
6. **Corregir el problema internamente:** Si el problema es operativo (limpieza, aire acondicionado, etc.), coordinar con el departamento correspondiente

### Protocolo de escalamiento

| Tiempo sin respuesta | Accion |
|---------------------|--------|
| 0-2 horas | Gerente de sede revisa y responde |
| 2-4 horas | Recordatorio automatico a Flor Acosta |
| 4+ horas | Escalamiento a Eduardo Chediak |

### Que NO hacer

- No ignorar las alertas — cada alerta es un huesped insatisfecho que puede dejar una mala reseña
- No responder de forma defensiva al huesped
- No prometer compensaciones que no pueda cumplir
- No borrar ni modificar las respuestas del huesped en el sistema

---

## 5. Formularios QR

### Que son

Son formularios de encuesta impresos en codigo QR que se colocan en las habitaciones y areas comunes del hotel. El huesped escanea el QR con su celular y completa una encuesta rapida.

### Donde colocar los QR

| Ubicacion | Tipo de QR |
|----------|-----------|
| Escritorio de la habitacion | Tarjeta de mesa con QR |
| Recepcion | Poster o acrilico con QR |
| Restaurante (mesas) | Sticker o tarjeta |
| Lobby / areas comunes | Poster o pantalla digital |

### Mantenimiento de los QR

- **Los codigos QR NO cambian** — son dinamicos, lo que significa que el formulario puede actualizarse sin cambiar el QR fisico impreso
- Si un QR se daña o se pierde, reimprimir el mismo archivo (solicitar a OVA VISION)
- Si el formulario necesita cambios (nuevas preguntas, etc.), contactar a OVA VISION — se actualiza remotamente sin cambiar el QR

### Si un huesped tiene problemas con el QR

1. Verificar que el huesped tiene conexion a internet (WiFi del hotel)
2. Sugerir que use la camara del celular directamente (sin apps adicionales)
3. Si el QR no funciona, ofrecer el enlace directo (proporcionado por OVA VISION por sede)
4. Reportar QR danados o ilegibles a OVA VISION

### Donde van las respuestas

Las respuestas se registran automaticamente en Google Sheets, en la pestaña **"Respuestas QR"**, y se reflejan en el dashboard.

---

## 6. Secuencias de Email

### Que son

Son correos electronicos automaticos que se envian a los huespedes en diferentes momentos:

| Secuencia | Cuando se envia | Contenido |
|-----------|----------------|-----------|
| **Pre-arrival** | 2-3 dias antes del check-in | Bienvenida, informacion util de la sede, recomendaciones locales |
| **Welcome** | Dia del check-in | Datos del WiFi, servicios disponibles, horarios, contacto de recepcion |
| **Post-stay** | 1 dia despues del checkout | Agradecimiento, invitacion a dejar reseña, oferta de regreso |

### Cada secuencia tiene 3 emails

Ejemplo de secuencia post-stay:

1. **Email 1 (dia 1 post-checkout):** "Gracias por hospedarte con nosotros" + resumen de la experiencia
2. **Email 2 (dia 3 post-checkout):** Invitacion a dejar reseña en Google/TripAdvisor
3. **Email 3 (dia 7 post-checkout):** Oferta especial para una proxima visita

### Que debe saber el equipo

- Los emails se envian **automaticamente** — no es necesario enviarlos manualmente
- Para que funcionen, el email del huesped **debe estar registrado** en Google Sheets (columna E)
- Si un huesped pide que no le envien mas emails, contactar a OVA VISION para agregarlo a la lista de exclusion
- Los emails se envian desde una direccion @tibisayhoteles.com (cuando se configure) o desde la plataforma de email marketing

### Como solicitar cambios en los emails

Si el equipo necesita actualizar promociones, tarifas o informacion en los emails:

1. Enviar el cambio solicitado a OVA VISION (ovavision.ve@gmail.com)
2. Especificar: que sede, que email (pre-arrival/welcome/post-stay), que cambio
3. OVA VISION actualiza el template en 24-48 horas

---

## 7. Solucion de Problemas Comunes

### El huesped no recibio la encuesta de WhatsApp

| Posible causa | Solucion |
|--------------|----------|
| Numero mal ingresado en Sheets | Verificar formato (+58...) y corregir |
| Huesped tiene WhatsApp bloqueado para desconocidos | No hay solucion — ofrecer el QR como alternativa |
| Aun no han pasado 2 horas desde el checkout | Esperar — el envio es automatico a las 2 horas |
| El sistema esta pausado (kill switch activo) | Contactar a OVA VISION |

### No puedo acceder a Google Sheets

| Posible causa | Solucion |
|--------------|----------|
| No tiene permisos | Solicitar acceso a OVA VISION con su email de Gmail |
| Internet caido | Verificar conexion del hotel |
| Link incorrecto | Solicitar el link actualizado a OVA VISION |

### El QR no funciona

| Posible causa | Solucion |
|--------------|----------|
| QR dañado o borroso | Reimprimir el QR (solicitar archivo a OVA VISION) |
| Huesped sin internet | Verificar WiFi del hotel |
| Formulario caido | Contactar a OVA VISION inmediatamente |

### El dashboard muestra datos incorrectos

| Posible causa | Solucion |
|--------------|----------|
| Datos duplicados en Sheets | Marcar como "DUPLICADO" y contactar a OVA VISION |
| Falta actualizacion | Refrescar la pagina o esperar unos minutos |
| Error en formulas | No modificar formulas — contactar a OVA VISION |

### Un huesped quiere que borren sus datos

1. No borrar nada directamente de Google Sheets
2. Anotar la solicitud (nombre, email, telefono del huesped)
3. Contactar a OVA VISION inmediatamente
4. OVA VISION procedera con la eliminacion segun normativas de privacidad

---

## 8. Contactos de Soporte

### Soporte tecnico general (ecosistema digital)

| Contacto | Detalle |
|----------|---------|
| **OVA VISION** | ovavision.ve@gmail.com |
| Telefono / WhatsApp | +58 424 578 1707 |
| Horario | Lunes a viernes, 9:00 AM - 6:00 PM |
| Tiempo de respuesta | Hasta 24 horas (urgencias: mismo dia) |

### Administracion Hoteles Tibisay

| Contacto | Detalle |
|----------|---------|
| Eduardo Chediak | 0424 418 6107 |
| Flor Acosta | Contactar via Eduardo |

### Soporte PMS (por sistema)

| PMS | Contacto | Telefono | Sedes |
|-----|----------|----------|-------|
| Hospes | Sr. Vizcaya | 0414 518 4092 | Merida, Margarita, Maracaibo |
| Ratio | Sr. Rojas | 0414 640 0161 | Maturin |
| New Hotel | Sr. Rafael Clemente | 0412 622 7724 | Morrocoy |

### Cuando contactar a cada uno

| Situacion | Contactar a |
|----------|------------|
| Problema con WhatsApp bot, QR, emails, dashboard | OVA VISION |
| Problema con el PMS (Hospes/Ratio/New Hotel) | Soporte PMS correspondiente |
| Problema con internet del hotel | Proveedor de internet local |
| Problema con la pagina web | OVA VISION |
| Solicitud de cambios en contenido/precios | Eduardo Chediak → OVA VISION |
| Alerta de rescate urgente | Flor Acosta + Eduardo Chediak |

---

## Glosario de Terminos

| Termino | Significado |
|---------|------------|
| **Checkout** | Momento en que el huesped deja el hotel |
| **Dashboard** | Panel de control con resultados en tiempo real |
| **Ruta Embajador** | Huesped muy satisfecho — se le invita a dejar reseña publica |
| **Ruta Retencion** | Huesped moderadamente satisfecho — se le agradece y ofrece regreso |
| **Ruta Rescate** | Huesped insatisfecho — se activa alerta y protocolo de recuperacion |
| **Kill Switch** | Boton de emergencia para pausar todos los envios automaticos |
| **QR Dinamico** | Codigo QR que redirige a un formulario actualizable sin cambiar el codigo impreso |
| **Pre-arrival** | Secuencia de emails que se envia antes de la llegada del huesped |
| **Post-stay** | Secuencia de emails que se envia despues de la estadia |
| **PMS** | Property Management System — software de gestion hotelera |

---

*Manual operativo generado por OVA VISION · v2026-03-25*
*Para distribucion al equipo de Hoteles Tibisay*
