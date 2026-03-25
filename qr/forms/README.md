# Formularios QR — Encuestas de Satisfacción por Sede

**Versión:** v2026-03-25
**Estado:** Pendiente de implementación

---

## Concepto

Cada sede tiene un código QR físico impreso (en habitaciones, recepción, restaurante) que dirige a un formulario web branded con el logo del hotel. El QR apunta a una URL intermedia que permite actualizar el destino sin cambiar el código físico.

---

## Estructura por Sede

| Sede | URL QR (dinámica) | Formulario | Estado |
|------|-------------------|------------|--------|
| Margarita | tibisayhoteles.com/qr/margarita | Google Forms branded | ❌ Pendiente |
| Mérida | tibisayhoteles.com/qr/merida | Google Forms branded | ❌ Pendiente |
| Maracaibo | tibisayhoteles.com/qr/maracaibo | Google Forms branded | ❌ Pendiente |
| Maturín | tibisayhoteles.com/qr/maturin | Google Forms branded | ❌ Pendiente |
| Canaima | tibisayhoteles.com/qr/canaima | Google Forms branded (ES/EN) | ❌ Pendiente |
| Morrocoy | tibisayhoteles.com/qr/morrocoy | Google Forms branded | ❌ Pendiente |
| Catatumbo | tibisayhoteles.com/qr/catatumbo | Google Forms branded | ❌ Pendiente |

---

## Preguntas del Formulario

### Datos del huésped
1. Nombre completo (texto)
2. Email (opcional)
3. Sede del hotel (auto-rellenado según QR)

### Escala de valoración (1-5 estrellas)
4. Check-in y recepción
5. Habitación (limpieza, comodidad)
6. Restaurante / servicios gastronómicos
7. Atención del personal
8. Satisfacción general

### Preguntas abiertas
9. ¿Qué fue lo mejor de tu estadía? (texto libre)
10. ¿Qué podemos mejorar? (texto libre)
11. ¿Nos recomendarías a un amigo o familiar? (Sí / Tal vez / No)

---

## Arquitectura QR Dinámica

```
QR físico impreso → tibisayhoteles.com/qr/{sede}
    → Redirección PHP/WordPress a Google Forms
    → Respuestas → Google Sheets (automático de Forms)
    → Dashboard consolidado
```

### Ventaja del QR dinámico
- El código QR impreso NUNCA cambia
- La URL de destino se puede actualizar desde WordPress
- Si se migra de Google Forms a otra solución, solo se cambia la redirección
- Se puede agregar tracking (UTM parameters) sin reimprimir

---

## Especificaciones de Impresión QR

- **Formato:** PNG 300 DPI mínimo
- **Tamaño mínimo:** 3 cm × 3 cm
- **Incluir:** Logo Tibisay + texto "Escanea y cuéntanos tu experiencia"
- **Material sugerido:** Sticker vinilo para habitaciones, tent card para restaurante
- **Ubicaciones sugeridas:**
  - Mesita de noche en habitación
  - Escritorio/desk en habitación
  - Mesa del restaurante (tent card)
  - Recepción (counter display)
  - Baño de habitación (sticker espejo)

---

## Datos Centralizados en Google Sheets

Todas las respuestas QR llegan a un Google Sheet centralizado con las columnas:

| Columna | Tipo | Fuente |
|---------|------|--------|
| Timestamp | Auto | Google Forms |
| Nombre | Texto | Formulario |
| Email | Texto | Formulario |
| Sede | Texto | Auto (según form) |
| P1 Check-in | 1-5 | Formulario |
| P2 Habitación | 1-5 | Formulario |
| P3 Restaurante | 1-5 | Formulario |
| P4 Personal | 1-5 | Formulario |
| P5 General | 1-5 | Formulario |
| Promedio | Calculado | Fórmula Sheet |
| Lo mejor | Texto | Formulario |
| Qué mejorar | Texto | Formulario |
| Recomendaría | Sí/Tal vez/No | Formulario |

---

## Checklist de Implementación

- [ ] Crear Google Forms por sede (7 formularios)
- [ ] Personalizar con logo y colores Tibisay
- [ ] Configurar Canaima bilingüe (ES/EN)
- [ ] Conectar cada Form a Google Sheets centralizado
- [ ] Crear redirects en WordPress (tibisayhoteles.com/qr/{sede})
- [ ] Generar QR codes (7 códigos)
- [ ] Diseñar material impreso (stickers, tent cards)
- [ ] Enviar archivos de impresión a cada sede
- [ ] Prueba end-to-end por sede
- [ ] Configurar alerta si promedio < 3 (Apps Script)

---

*Formularios QR v2026-03-25 · OVA VISION*
