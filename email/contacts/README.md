# Base de Contactos — Hoteles Tibisay

**Version:** v2026-03-30
**Estado:** Pendiente de carga

---

## Archivo: contactos-tibisay.csv

Template CSV listo para importar a Mailchimp. Las dos primeras filas son ejemplos — reemplazar con los datos reales de los +170 contactos recibidos del cliente.

### Columnas

| Columna | Descripcion | Requerido |
|---------|-------------|-----------|
| email | Correo electronico del contacto | Si |
| nombre | Nombre completo | Si |
| empresa | Nombre de la agencia o mayorista | Si |
| segmento | `Agencia` o `Mayorista` | Si |
| telefono | Numero de telefono | No |
| ciudad | Ciudad de la empresa | No |
| notas | Observaciones adicionales | No |

### Segmentos

- **Mayorista** (~50 contactos): Turismo Maso, Baredu, Omega, Globex, Hover Tours, etc.
- **Agencia** (~120 contactos): Agencias de viaje nacionales

### Instrucciones de importacion a Mailchimp

1. Completar el CSV con los datos reales de la base recibida
2. Verificar que no haya emails duplicados
3. En Mailchimp: Audience > Import contacts > Upload CSV
4. Mapear columnas: email, nombre, empresa, segmento
5. Crear tags: "Mayorista" y "Agencia" basados en la columna segmento
6. Verificar importacion exitosa

---

*Contactos v2026-03-30 · OVA VISION*
