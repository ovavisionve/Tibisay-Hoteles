/**
 * Tibisay Hoteles — JavaScript Principal
 * v2026-03-25 · OVA VISION
 *
 * Mobile-first, vanilla JS (sin jQuery para rendimiento)
 */

(function () {
    'use strict';

    // ============================================================
    // MOBILE MENU
    // ============================================================

    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');

    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function () {
            this.classList.toggle('active');
            mainNav.classList.toggle('open');
            document.body.style.overflow = mainNav.classList.contains('open') ? 'hidden' : '';
        });

        // Close menu when clicking a link
        mainNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                menuToggle.classList.remove('active');
                mainNav.classList.remove('open');
                document.body.style.overflow = '';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (mainNav.classList.contains('open') &&
                !mainNav.contains(e.target) &&
                !menuToggle.contains(e.target)) {
                menuToggle.classList.remove('active');
                mainNav.classList.remove('open');
                document.body.style.overflow = '';
            }
        });
    }

    // ============================================================
    // HEADER SCROLL EFFECT
    // ============================================================

    var header = document.querySelector('.site-header');
    var lastScroll = 0;

    if (header) {
        window.addEventListener('scroll', function () {
            var currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    // ============================================================
    // LAZY LOADING IMAGES
    // ============================================================

    if ('IntersectionObserver' in window) {
        var lazyImages = document.querySelectorAll('img[data-src]');

        var imageObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src;
                    if (img.dataset.srcset) {
                        img.srcset = img.dataset.srcset;
                    }
                    img.classList.remove('lazy-placeholder');
                    imageObserver.unobserve(img);
                }
            });
        }, {
            rootMargin: '200px'
        });

        lazyImages.forEach(function (img) {
            imageObserver.observe(img);
        });
    }

    // ============================================================
    // RESERVATION FORM — Dynamic room types by sede
    // ============================================================

    var roomTypes = {
        'Margarita': ['Estándar Vista Jardín', 'Superior Vista Mar', 'Suite Caribeña'],
        'Mérida': ['Estándar', 'Superior', 'Suite Andina'],
        'Maracaibo': ['Ejecutiva Estándar', 'Ejecutiva Superior', 'Suite Corporativa'],
        'Maturín': ['Ejecutiva', 'VIP', 'Suite Corporativa'],
        'Canaima': ['Churuata Estándar', 'Churuata Superior', 'Churuata Premium'],
        'Morrocoy': ['Boutique Estándar', 'Boutique Superior', 'Suite Morrocoy'],
        'Catatumbo': ['Cabaña Explorador', 'Cabaña Premium']
    };

    var sedeSelect = document.querySelector('select[name="sede"]');
    var roomSelect = document.querySelector('select[name="tipo_habitacion"]');

    if (sedeSelect && roomSelect) {
        sedeSelect.addEventListener('change', function () {
            var sede = this.value;
            var rooms = roomTypes[sede] || [];

            // Clear current options
            roomSelect.innerHTML = '<option value="">Selecciona tipo de habitación</option>';

            rooms.forEach(function (room) {
                var option = document.createElement('option');
                option.value = room;
                option.textContent = room;
                roomSelect.appendChild(option);
            });

            roomSelect.disabled = rooms.length === 0;
        });
    }

    // Corporate toggle
    var corporateCheck = document.querySelector('input[name="corporativo"]');
    var empresaGroup = document.querySelector('.empresa-group');

    if (corporateCheck && empresaGroup) {
        corporateCheck.addEventListener('change', function () {
            empresaGroup.style.display = this.checked ? 'block' : 'none';
        });
    }

    // ============================================================
    // FORM SUBMISSIONS (AJAX)
    // ============================================================

    /**
     * Generic form submission handler
     */
    function handleFormSubmit(formId, endpoint) {
        var form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var btn = form.querySelector('button[type="submit"]');
            var btnText = btn.textContent;
            var formData = new FormData(form);

            // Add WordPress AJAX action
            formData.append('action', endpoint);

            // Add nonce if available
            var nonceField = form.querySelector('input[name="_wpnonce"]');
            if (nonceField) {
                formData.append('_wpnonce', nonceField.value);
            }

            // Loading state
            btn.disabled = true;
            btn.textContent = 'Enviando...';

            // Get AJAX URL
            var ajaxUrl = (typeof tibisayAjax !== 'undefined' && tibisayAjax.url)
                ? tibisayAjax.url
                : '/wp-admin/admin-ajax.php';

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.success) {
                        // Show success message
                        form.style.display = 'none';
                        var successMsg = document.querySelector('#' + formId + '-success');
                        if (successMsg) {
                            successMsg.style.display = 'block';
                        }
                    } else {
                        alert(data.data || 'Hubo un error. Por favor intenta de nuevo.');
                        btn.disabled = false;
                        btn.textContent = btnText;
                    }
                })
                .catch(function () {
                    alert('Error de conexión. Por favor intenta de nuevo.');
                    btn.disabled = false;
                    btn.textContent = btnText;
                });
        });
    }

    // Initialize form handlers
    handleFormSubmit('form-reservas', 'tibisay_reserva');
    handleFormSubmit('form-contacto', 'tibisay_contacto');

    // ============================================================
    // NEWSLETTER SUBSCRIPTION
    // ============================================================

    var newsletterForms = document.querySelectorAll('.newsletter-form');

    newsletterForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var btn = form.querySelector('button');
            var emailInput = form.querySelector('input[type="email"]');
            var sedeInput = form.querySelector('select');
            var btnText = btn.textContent;

            if (!emailInput || !emailInput.value) return;

            btn.disabled = true;
            btn.textContent = 'Suscribiendo...';

            var formData = new FormData();
            formData.append('action', 'tibisay_newsletter');
            formData.append('email', emailInput.value);
            if (sedeInput) {
                formData.append('sede', sedeInput.value);
            }

            var ajaxUrl = (typeof tibisayAjax !== 'undefined' && tibisayAjax.url)
                ? tibisayAjax.url
                : '/wp-admin/admin-ajax.php';

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.success) {
                        emailInput.value = '';
                        btn.textContent = '¡Suscrito!';
                        setTimeout(function () {
                            btn.textContent = btnText;
                            btn.disabled = false;
                        }, 3000);
                    } else {
                        btn.textContent = btnText;
                        btn.disabled = false;
                    }
                })
                .catch(function () {
                    btn.textContent = btnText;
                    btn.disabled = false;
                });
        });
    });

    // ============================================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ============================================================

    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var targetId = this.getAttribute('href');
            if (targetId === '#') return;

            var target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                var headerHeight = header ? header.offsetHeight : 0;
                var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ============================================================
    // GALLERY LIGHTBOX (Simple)
    // ============================================================

    var galleryItems = document.querySelectorAll('.gallery-item');

    if (galleryItems.length > 0) {
        // Create lightbox element
        var lightbox = document.createElement('div');
        lightbox.className = 'lightbox';
        lightbox.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;cursor:pointer;justify-content:center;align-items:center;';

        var lightboxImg = document.createElement('img');
        lightboxImg.style.cssText = 'max-width:90%;max-height:90%;object-fit:contain;';

        lightbox.appendChild(lightboxImg);
        document.body.appendChild(lightbox);

        galleryItems.forEach(function (item) {
            item.addEventListener('click', function () {
                var img = this.querySelector('img');
                if (img) {
                    lightboxImg.src = img.src;
                    lightbox.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        lightbox.addEventListener('click', function () {
            this.style.display = 'none';
            document.body.style.overflow = '';
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && lightbox.style.display === 'flex') {
                lightbox.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    }

    // ============================================================
    // SCROLL ANIMATIONS (Intersection Observer)
    // ============================================================

    if ('IntersectionObserver' in window) {
        var animatedElements = document.querySelectorAll('.sede-card, .feature, .info-card, .room-card');

        // Add initial hidden state
        animatedElements.forEach(function (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s, transform 0.5s';
        });

        var animObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    animObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });

        animatedElements.forEach(function (el) {
            animObserver.observe(el);
        });
    }

    // ============================================================
    // DATE PICKER — Set min date to today
    // ============================================================

    var dateInputs = document.querySelectorAll('input[type="date"]');
    var today = new Date().toISOString().split('T')[0];

    dateInputs.forEach(function (input) {
        input.setAttribute('min', today);
    });

    // Ensure checkout is after checkin
    var checkinInput = document.querySelector('input[name="fecha_llegada"]');
    var checkoutInput = document.querySelector('input[name="fecha_salida"]');

    if (checkinInput && checkoutInput) {
        checkinInput.addEventListener('change', function () {
            checkoutInput.setAttribute('min', this.value);
            if (checkoutInput.value && checkoutInput.value <= this.value) {
                checkoutInput.value = '';
            }
        });
    }

})();
