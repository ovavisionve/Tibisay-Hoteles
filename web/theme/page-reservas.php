<?php
/**
 * Template Name: Reservas
 * Template Post Type: page
 *
 * Tibisay Hoteles — Formulario de reservas con envio AJAX.
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Pre-seleccionar sede si viene por parametro GET
$sede_preseleccionada = isset( $_GET['sede'] ) ? sanitize_text_field( wp_unslash( $_GET['sede'] ) ) : '';
$tipo_preseleccionado = isset( $_GET['tipo'] ) ? sanitize_text_field( wp_unslash( $_GET['tipo'] ) ) : '';
?>

<!-- HERO -->
<section class="hero" style="min-height:40vh;">
    <div class="hero-bg" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/hero-reservas.jpg');"></div>
    <div class="hero-content">
        <h1>Reservaciones</h1>
        <p>Complete el formulario y nuestro equipo se pondra en contacto para confirmar su reserva.</p>
    </div>
</section>

<!-- FORMULARIO DE RESERVAS -->
<section class="section">
    <div class="container">
        <div class="form-section" id="reserva-form-section">

            <form id="reserva-form" novalidate>

                <div class="form-group">
                    <label for="reserva-nombre">Nombre completo <span class="required">*</span></label>
                    <input type="text" id="reserva-nombre" name="nombre" class="form-control" required placeholder="Su nombre y apellido">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="reserva-email">Correo electronico <span class="required">*</span></label>
                        <input type="email" id="reserva-email" name="email" class="form-control" required placeholder="ejemplo@correo.com">
                    </div>
                    <div class="form-group">
                        <label for="reserva-telefono">Telefono</label>
                        <input type="tel" id="reserva-telefono" name="telefono" class="form-control" placeholder="0424 000 0000">
                    </div>
                </div>

                <div class="form-group">
                    <label for="reserva-sede">Sede <span class="required">*</span></label>
                    <select id="reserva-sede" name="sede" class="form-control" required>
                        <option value="">Seleccione una sede</option>
                        <option value="merida"<?php selected( $sede_preseleccionada, 'merida' ); ?>>Hotel Tibisay Merida</option>
                        <option value="margarita"<?php selected( $sede_preseleccionada, 'margarita' ); ?>>Hotel Tibisay Margarita</option>
                        <option value="maracaibo"<?php selected( $sede_preseleccionada, 'maracaibo' ); ?>>Hotel Tibisay Del Lago (Maracaibo)</option>
                        <option value="maturin"<?php selected( $sede_preseleccionada, 'maturin' ); ?>>Hotel Tibisay Maturin</option>
                        <option value="canaima"<?php selected( $sede_preseleccionada, 'canaima' ); ?>>Campamento Tibisay Canaima</option>
                        <option value="morrocoy"<?php selected( $sede_preseleccionada, 'morrocoy' ); ?>>Hotel Tibisay Morrocoy</option>
                        <option value="catatumbo"<?php selected( $sede_preseleccionada, 'catatumbo' ); ?>>Tibisay Catatumbo</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="reserva-llegada">Fecha de llegada <span class="required">*</span></label>
                        <input type="date" id="reserva-llegada" name="llegada" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="reserva-salida">Fecha de salida <span class="required">*</span></label>
                        <input type="date" id="reserva-salida" name="salida" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="reserva-adultos">Adultos</label>
                        <select id="reserva-adultos" name="adultos" class="form-control">
                            <option value="1">1 adulto</option>
                            <option value="2" selected>2 adultos</option>
                            <option value="3">3 adultos</option>
                            <option value="4">4 adultos</option>
                            <option value="5">5 adultos</option>
                            <option value="6">6+ adultos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reserva-ninos">Ninos</label>
                        <select id="reserva-ninos" name="ninos" class="form-control">
                            <option value="0" selected>Sin ninos</option>
                            <option value="1">1 nino</option>
                            <option value="2">2 ninos</option>
                            <option value="3">3 ninos</option>
                            <option value="4">4+ ninos</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reserva-habitacion">Tipo de habitacion</label>
                    <select id="reserva-habitacion" name="habitacion" class="form-control">
                        <option value="">Seleccione tipo de habitacion</option>
                        <option value="estandar"<?php selected( $tipo_preseleccionado, 'estandar' ); ?>>Habitacion Estandar</option>
                        <option value="superior"<?php selected( $tipo_preseleccionado, 'superior' ); ?>>Habitacion Superior</option>
                        <option value="suite"<?php selected( $tipo_preseleccionado, 'suite' ); ?>>Suite</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reserva-comentarios">Comentarios o solicitudes especiales</label>
                    <textarea id="reserva-comentarios" name="comentarios" class="form-control" rows="4" placeholder="Cuentenos si tiene alguna solicitud especial para su estadia..."></textarea>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="reserva-corporativo" name="corporativo" value="1">
                        <label for="reserva-corporativo">Es un viaje corporativo</label>
                    </div>
                </div>

                <div class="form-group hidden" id="empresa-group">
                    <label for="reserva-empresa">Nombre de la empresa</label>
                    <input type="text" id="reserva-empresa" name="empresa" class="form-control" placeholder="Nombre de su empresa">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width:100%;padding:1rem;" id="reserva-submit">
                        Enviar Solicitud de Reserva
                    </button>
                </div>

                <p id="reserva-error" class="hidden" style="color:#e74c3c;text-align:center;margin-top:1rem;" role="alert"></p>

            </form>

            <!-- Mensaje de exito -->
            <div class="form-success" id="reserva-success">
                <h3>Solicitud Enviada</h3>
                <p>Hemos recibido su solicitud de reserva. Nuestro equipo revisara la disponibilidad y se comunicara con usted en las proximas horas.</p>
                <p style="color:var(--color-text-light);font-size:0.9rem;">Si tiene alguna urgencia, puede contactarnos directamente por telefono.</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary mt-2">Volver al Inicio</a>
            </div>

        </div>
    </div>
</section>

<script>
(function() {
    'use strict';

    // Mostrar/ocultar campo empresa segun checkbox corporativo
    var checkCorporativo = document.getElementById('reserva-corporativo');
    var empresaGroup = document.getElementById('empresa-group');

    if (checkCorporativo && empresaGroup) {
        checkCorporativo.addEventListener('change', function() {
            empresaGroup.classList.toggle('hidden', !this.checked);
        });
    }

    // Envio del formulario via AJAX
    var form = document.getElementById('reserva-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        var submitBtn = document.getElementById('reserva-submit');
        var errorEl = document.getElementById('reserva-error');
        var successEl = document.getElementById('reserva-success');

        // Limpiar error previo
        errorEl.classList.add('hidden');
        errorEl.textContent = '';

        // Estado de carga
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enviando...';

        // Preparar datos
        var formData = new FormData();
        formData.append('action', 'tibisay_reserva');
        formData.append('nonce', tibisayAjax.nonce);
        formData.append('nombre', form.querySelector('[name="nombre"]').value);
        formData.append('email', form.querySelector('[name="email"]').value);
        formData.append('telefono', form.querySelector('[name="telefono"]').value);
        formData.append('sede', form.querySelector('[name="sede"]').value);
        formData.append('llegada', form.querySelector('[name="llegada"]').value);
        formData.append('salida', form.querySelector('[name="salida"]').value);
        formData.append('adultos', form.querySelector('[name="adultos"]').value);
        formData.append('ninos', form.querySelector('[name="ninos"]').value);
        formData.append('habitacion', form.querySelector('[name="habitacion"]').value);
        formData.append('comentarios', form.querySelector('[name="comentarios"]').value);
        formData.append('corporativo', checkCorporativo.checked ? '1' : '0');
        formData.append('empresa', form.querySelector('[name="empresa"]').value);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', tibisayAjax.url, true);

        xhr.onload = function() {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar Solicitud de Reserva';

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
            submitBtn.textContent = 'Enviar Solicitud de Reserva';
            errorEl.textContent = 'Error de conexion. Verifique su internet e intente de nuevo.';
            errorEl.classList.remove('hidden');
        };

        xhr.send(formData);
    });
})();
</script>

<?php get_footer(); ?>
