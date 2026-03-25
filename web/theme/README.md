# Tema WordPress — Hoteles Tibisay

**Versión:** 1.0.0
**Parent Theme:** Starter genérico (o ninguno si se instala standalone)

---

## Instalación

### Opción A: Como child theme (recomendado)

1. Instalar un tema starter ligero (Flavor, GeneratePress, o similar)
2. Subir esta carpeta como `tibisay/` en `/wp-content/themes/`
3. Activar "Tibisay Hoteles" desde Apariencia → Temas
4. Si no se usa parent theme, cambiar `Template: flavor` en style.css

### Opción B: Como tema standalone

1. Eliminar la línea `Template: flavor` de style.css
2. Agregar un `index.php` básico (ver abajo)
3. Subir a `/wp-content/themes/tibisay/`
4. Activar

### index.php mínimo (si standalone):
```php
<?php get_header(); ?>
<main class="container section">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
```

---

## Estructura del Tema

```
tibisay/
├── style.css           # Estilos principales (mobile-first)
├── functions.php       # Funciones, CPT, AJAX handlers
├── header.php          # Header + navegación responsive
├── footer.php          # Footer + newsletter
├── front-page.php      # Página de inicio (home)
├── page-sede.php       # Template: Página de Sede (individual)
├── page-reservas.php   # Template: Reservas
├── page-contacto.php   # Template: Contacto
├── js/
│   └── tibisay.js      # JavaScript principal
└── README.md           # Este archivo
```

---

## Configuración Post-Instalación

### 1. Crear Páginas en WordPress

| Página | Template | URL |
|--------|----------|-----|
| Inicio | Front Page | / |
| Hotel Tibisay Mérida | Página de Sede | /merida |
| Hotel Tibisay Margarita | Página de Sede | /margarita |
| Hotel Tibisay Del Lago | Página de Sede | /maracaibo |
| Hotel Tibisay Maturín | Página de Sede | /maturin |
| Campamento Tibisay Canaima | Página de Sede | /canaima |
| Hotel Tibisay Morrocoy | Página de Sede | /morrocoy |
| Tibisay Catatumbo | Página de Sede | /catatumbo |
| Reservas | Reservas | /reservas |
| Contacto | Contacto | /contacto |

### 2. Configurar Permalinks

En Ajustes → Enlaces permanentes → seleccionar "Nombre de la entrada"

### 3. Configurar Menú

1. Ir a Apariencia → Menús
2. Crear menú "Principal"
3. Agregar páginas en orden
4. Asignar a ubicación "Menú Principal"

### 4. Subir Logo

Ir a Apariencia → Personalizar → Identidad del sitio → Logo

---

## Optimización para Venezuela

- Google Fonts con `font-display: swap` (texto visible mientras carga la fuente)
- Imágenes con lazy loading nativo + IntersectionObserver
- Sin jQuery (vanilla JS puro)
- Sin emojis de WordPress (desactivados)
- CSS minificado en producción
- Sin plugins pesados recomendados

---

## Formularios

Los formularios de Reservas, Contacto y Newsletter envían datos vía AJAX a WordPress.
Los datos se guardan como opciones en la base de datos de WordPress y opcionalmente
se envían a Google Sheets vía Apps Script.

---

*Tema v1.0.0 · OVA VISION para Hoteles Tibisay*
