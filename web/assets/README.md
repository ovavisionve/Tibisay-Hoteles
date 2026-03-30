# Assets — Hoteles Tibisay

**Version:** v2026-03-30
**Estado:** Pendiente de assets del cliente

---

## Estructura esperada

```
assets/
├── logo/
│   ├── logo-tibisay.png          # Logo principal (PNG transparente)
│   ├── logo-tibisay.svg          # Logo vectorial
│   └── logo-tibisay-white.png    # Logo blanco para fondos oscuros
├── sedes/
│   ├── merida/                   # 5-10 fotos optimizadas
│   ├── margarita/
│   ├── maracaibo/
│   ├── maturin/
│   ├── canaima/
│   ├── morrocoy/
│   └── catatumbo/
├── icons/
│   ├── favicon.ico               # 32x32
│   ├── apple-touch-icon.png      # 180x180
│   └── og-image.jpg              # 1200x630 para redes sociales
└── hero/
    ├── home-hero.jpg             # Hero de la pagina principal
    └── {sede}-hero.jpg           # Hero por cada sede
```

## Especificaciones de optimizacion

- **Formato:** WebP con fallback JPG (para compatibilidad Venezuela)
- **Hero images:** Max 1200px ancho, < 150KB
- **Fotos de sedes:** Max 800px ancho, < 100KB
- **Logo:** SVG preferido, PNG como fallback
- **Lazy loading:** Todas las imagenes debajo del fold

## Assets pendientes del cliente

- [ ] Logo del hotel en PNG/SVG (solicitado a Eduardo 2026-03-30)
- [ ] Fotos de cada sede — minimo 5-10 por hotel
- [ ] Imagen para Open Graph / redes sociales

## Procesamiento

Una vez recibidas las fotos, optimizar con:
- Redimensionar al tamano maximo requerido
- Comprimir con calidad 80-85%
- Generar versiones WebP
- Agregar alt text descriptivo por sede

---

*Assets v2026-03-30 · OVA VISION*
