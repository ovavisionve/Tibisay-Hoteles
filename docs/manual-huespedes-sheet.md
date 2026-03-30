# Manual de Uso — Sistema de Emails y Encuestas
## Hoteles Tibisay · Para el Personal de Recepcion

---

## ¿Que hace este sistema?

Cuando registras un huesped en el Google Sheet:
- **Al hacer check-in** → el huesped recibe un email de bienvenida automatico
- **Al hacer checkout** → el huesped recibe un email con link a una encuesta de satisfaccion
- **Si el huesped califica bajo** → llega una alerta automatica por correo

---

## Paso a Paso

### 1. Abrir el Google Sheet

Abre el enlace del Google Sheet que les compartimos (guardalo en favoritos del navegador).

Ve a la hoja **"Huespedes"** (pestana en la parte inferior).

---

### 2. Registrar un huesped (cuando llega al hotel)

Llena una fila nueva con estos datos:

| Columna | Que escribir | Ejemplo |
|---------|-------------|---------|
| **Nombre** | Nombre completo del huesped | Maria Garcia |
| **Email** | Correo del huesped (preguntarle) | maria@gmail.com |
| **Sede** | Seleccionar del menu desplegable | Margarita |
| **Habitacion** | Numero o tipo de habitacion | 301 |
| **Fecha Check-in** | Fecha de llegada (dd/mm/aaaa) | 30/03/2026 |
| **Fecha Check-out** | Fecha de salida (dd/mm/aaaa) | 02/04/2026 |
| **Estado** | Seleccionar **Check-in** | Check-in |

**IMPORTANTE:** Cuando selecciones "Check-in" en la columna Estado, el email de bienvenida se envia automaticamente. La columna "Email Bienvenida" cambiara a "Enviado" en verde.

---

### 3. Registrar el checkout (cuando el huesped se va)

Busca la fila del huesped y cambia la columna **Estado** de "Check-in" a **"Checkout"**.

El sistema automaticamente:
- Envia un email de agradecimiento con un link a la encuesta de satisfaccion
- La columna "Email Post-Stay" cambia a "Enviado" en verde

---

### 4. ¿Que pasa si el huesped no tiene email?

Si el huesped no quiere dar su email, deja la columna Email vacia. No se enviara ningun correo pero puedes registrarlo igual para llevar el control.

---

## Preguntas Frecuentes

**¿Puedo editar los datos despues de llenarlos?**
Si, puedes corregir nombre, habitacion, fechas, etc. Solo ten cuidado de no cambiar el Estado por accidente.

**¿Que pasa si pongo "Check-in" por error?**
El email se envia inmediatamente. No se puede cancelar. Si fue un error, avisa al huesped.

**¿Puedo ver las respuestas de las encuestas?**
Si. En el mismo Google Sheet, ve a la hoja "Respuestas QR" para ver todas las encuestas respondidas.

**¿Que pasa si un huesped califica mal (1 o 2 estrellas)?**
El sistema envia una alerta automatica por correo a la Direccion Corporativa para que se atienda el caso en las proximas 24 horas.

**¿Funciona desde el celular?**
Si. Pueden abrir el Google Sheet desde la app de Google Sheets en el telefono.

---

## Resumen Rapido

```
Huesped llega  →  Llenar fila  →  Estado: "Check-in"   →  Email de bienvenida
Huesped se va  →  Cambiar      →  Estado: "Checkout"    →  Email con encuesta
```

---

## Soporte

Si algo no funciona o tienen dudas:
- **OVA VISION:** ovavision.ve@gmail.com · +58 424 578 1707
- **Flor Acosta:** 0412 116 68 11

---

*Manual v2026-03-30 · OVA VISION para Hoteles Tibisay*
