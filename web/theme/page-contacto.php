<?php
/**
 * Template Name: Contacto
 * Template Post Type: page
 *
 * Tibisay Hoteles — Pagina de contacto con formulario AJAX e informacion por sede.
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- HERO -->
<section class="hero" style="min-height:40vh;">
    <div class="hero-bg" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/hero-contacto.jpg');"></div>
    <div class="hero-content">
        <h1>Contactenos</h1>
        <p>Estamos aqui para ayudarle. Escribanos y nuestro equipo le respondera lo antes posible.</p>
    </div>
</section>

<!-- FORMULARIO DE CONTACTO -->
<section class="section">
    <div class="container">
        <div class="form-section" id="contacto-form-section">

            <div class="section-title">
                <h2>Envie su mensaje</h2>
                <p>Complete el formulario y nos comunicaremos con usted.</p>
            </div>

            <form id="contacto-form" novalidate>

                <div class="form-group">
                    <label for="contacto-nombre">Nombre completo <span class="required">*</span></label>
                    <input type="text" id="contacto-nombre" name="nombre" class="form-control" required placeholder="Su nombre y apellido">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contacto-email">Correo electronico <span class="required">*</span></label>
                        <input type="email" id="contacto-email" name="email" class="form-control" required placeholder="ejemplo@correo.com">
                    </div>
                    <div class="form-group">
                        <label for="contacto-telefono">Telefono</label>
                        <input type="tel" id="contacto-telefono" name="telefono" class="form-control" placeholder="0424 000 0000">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contacto-sede">Sede</label>
                        <select id="contacto-sede" name="sede" class="form-control">
                            <option value="">Consulta general</option>
                            <option value="merida">Hotel Tibisay Merida</option>
                            <option value="margarita">Hotel Tibisay Margarita</option>
                            <option value="maracaibo">Hotel Tibisay Del Lago (Maracaibo)</option>
                            <option value="maturin">Hotel Tibisay Maturin</option>
                            <option value="canaima">Campamento Tibisay Canaima</option>
                            <option value="morrocoy">Hotel Tibisay Morrocoy</option>
                            <option value="catatumbo">Tibisay Catatumbo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contacto-motivo">Motivo de contacto</label>
                        <select id="contacto-motivo" name="motivo" class="form-control">
                            <option value="Informacion general">Informacion general</option>
                            <option value="Reservas">Reservas</option>
                            <option value="Grupos y eventos">Grupos y eventos</option>
                            <option value="Corporativo">Viajes corporativos</option>
                            <option value="Comentarios">Comentarios y sugerencias</option>
                            <option value="Reclamo">Reclamo</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contacto-mensaje">Mensaje <span class="required">*</span></label>
                    <textarea id="contacto-mensaje" name="mensaje" class="form-control" rows="5" required placeholder="Escriba su mensaje aqui..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width:100%;padding:1rem;" id="contacto-submit">
                        Enviar Mensaje
                    </button>
                </div>

                <p id="contacto-error" class="hidden" style="color:#e74c3c;text-align:center;margin-top:1rem;" role="alert"></p>

            </form>

            <!-- Mensaje de exito -->
            <div class="form-success" id="contacto-success">
                <h3>Mensaje Enviado</h3>
                <p>Gracias por comunicarse con nosotros. Nuestro equipo revisara su mensaje y le respondera lo antes posible.</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary mt-2">Volver al Inicio</a>
            </div>

        </div>
    </div>
</section>

<!-- INFORMACION DE CONTACTO POR SEDE -->
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Nuestras Sedes</h2>
            <p>Contacte directamente la sede de su preferencia.</p>
        </div>

        <div class="sedes-grid">

            <div class="info-card">
                <h3 style="border-bottom-color:var(--color-merida);">Tibisay Merida</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.5rem;"><strong>Estado:</strong> Merida</li>
                    <li style="margin-bottom:0.5rem;"><strong>Telefono:</strong> <a href="tel:04247648679">0424 764 8679</a></li>
                    <li><strong>Perfil:</strong> Turismo de montana y aventura</li>
                </ul>
            </div>

            <div class="info-card">
                <h3 style="border-bottom-color:var(--color-margarita);">Tibisay Margarita</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.5rem;"><strong>Estado:</strong> Nueva Esparta</li>
                    <li style="margin-bottom:0.5rem;"><strong>Telefono:</strong> <a href="tel:04247648679">0424 764 8679</a></li>
                    <li><strong>Perfil:</strong> Resort de playa y Beach Club</li>
                </ul>
            </div>

            <div class="info-card">
                <h3 style="border-bottom-color:var(--color-maracaibo);">Tibisay Del Lago</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.5rem;"><strong>Estado:</strong> Zulia (Maracaibo)</li>
                    <li style="margin-bottom:0.5rem;"><strong>Telefono:</strong> <a href="tel:04126448918">0412 644 8918</a></li>
                    <li><strong>Perfil:</strong> Corporativo y turismo</li>
                </ul>
            </div>

            <div class="info-card">
                <h3 style="border-bottom-color:var(--color-maturin);">Tibisay Maturin</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.5rem;"><strong>Estado:</strong> Monagas</li>
                    <li style="margin-bottom:0.5rem;"><strong>Telefono:</strong> <a href="tel:04123582965">0412 358 2965</a></li>
                    <li><strong>Perfil:</strong> Ejecutivo y sector petrolero</li>
                </ul>
            </div>

            <div class="info-card">
                <h3 style="border-bottom-color:var(--color-canaima);">Tibisay Canaima</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.5rem;"><strong>Estado:</strong> Bolivar</li>
                    <li style="margin-bottom:0.5rem;"><strong>Telefono:</strong> <a href="tel:04248308891">0424 830 8891</a></li>
                    <li><strong>Perfil:</strong> Ecoturismo y Salto Angel</li>
                </ul>
            </div>

            <div class="info-card">
                <h3 style="border-bottom-color:var(--color-morrocoy);">Tibisay Morrocoy</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.5rem;"><strong>Estado:</strong> Falcon</li>
                    <li style="margin-bottom:0.5rem;"><strong>Telefono:</strong> <a href="tel:04226454665">0422 645 4665</a></li>
                    <li><strong>Perfil:</strong> Playa boutique y cayos</li>
                </ul>
            </div>

            <div class="info-card">
                <h3 style="border-bottom-color:var(--color-catatumbo);">Tibisay Catatumbo</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.5rem;"><strong>Estado:</strong> Zulia</li>
                    <li style="margin-bottom:0.5rem;"><strong>Telefono:</strong> <a href="tel:04247239935">0424 723 9935</a></li>
                    <li><strong>Perfil:</strong> Turismo de expedicion</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- MAPA GENERAL -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Encuentrenos en Venezuela</h2>
            <p>7 sedes en los destinos mas extraordinarios del pais.</p>
        </div>

        <div class="map-container" style="height:400px;">
            <!-- Placeholder para mapa general de Venezuela con las 7 sedes -->
            <div style="display:flex;align-items:center;justify-content:center;height:100%;background:var(--color-bg-alt);color:var(--color-text-light);">
                <p>Mapa interactivo con ubicacion de las 7 sedes — disponible proximamente.</p>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    'use strict';

    var form = document.getElementById('contacto-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        var submitBtn = document.getElementById('contacto-submit');
        var errorEl = document.getElementById('contacto-error');
        var successEl = document.getElementById('contacto-success');

        // Limpiar error previo
        errorEl.classList.add('hidden');
        errorEl.textContent = '';

        // Estado de carga
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enviando...';

        // Preparar datos
        var formData = new FormData();
        formData.append('action', 'tibisay_contacto');
        formData.append('nonce', tibisayAjax.nonce);
        formData.append('nombre', form.querySelector('[name="nombre"]').value);
        formData.append('email', form.querySelector('[name="email"]').value);
        formData.append('telefono', form.querySelector('[name="telefono"]').value);
        formData.append('sede', form.querySelector('[name="sede"]').value);
        formData.append('motivo', form.querySelector('[name="motivo"]').value);
        formData.append('mensaje', form.querySelector('[name="mensaje"]').value);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', tibisayAjax.url, true);

        xhr.onload = function() {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar Mensaje';

            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        form.style.display = 'none';
                        successEl.style.display = 'block';
                    } else {
                        errorEl.textContent = response.data.message || 'Ocurrio un error. Intente de nuevo.';
                        errorEl.classList.remove('hidden');
                    }
                } catch (err) {
                    errorEl.textContent = 'Error al procesar la respuesta. Intente de nuevo.';
                    errorEl.classList.remove('hidden');
                }
            } else {
                errorEl.textContent = 'Error de conexion. Verifique su internet e intente de nuevo.';
                errorEl.classList.remove('hidden');
            }
        };

        xhr.onerror = function() {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar Mensaje';
            errorEl.textContent = 'Error de conexion. Verifique su internet e intente de nuevo.';
            errorEl.classList.remove('hidden');
        };

        xhr.send(formData);
    });
})();
</script>

<?php get_footer(); ?>
