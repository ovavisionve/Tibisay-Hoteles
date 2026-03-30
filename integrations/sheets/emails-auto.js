/**
 * Google Apps Script — Emails Automaticos de Bienvenida y Post-Estadia
 * Hoteles Tibisay · OVA VISION
 * v2026-03-30
 *
 * INSTRUCCIONES:
 * 1. En el mismo Google Sheet del dashboard, ir a Extensiones → Apps Script
 * 2. Crear un nuevo archivo (+ al lado de Archivos) llamado "EmailsAuto"
 * 3. Pegar este codigo completo
 * 4. Ejecutar configurarTriggersEmail() UNA VEZ para activar la automatizacion
 * 5. Crear la hoja "Huespedes" manualmente o ejecutar crearHojaHuespedes()
 *
 * USO POR EL PERSONAL DEL HOTEL:
 * - Cuando llega un huesped: llenar fila en hoja "Huespedes" con sus datos
 * - El email de bienvenida se envia automaticamente al detectar la nueva fila
 * - Cuando el huesped hace checkout: cambiar columna "Estado" a "Checkout"
 * - El email post-estadia con link a encuesta se envia automaticamente
 */

// ============================================================
// CONFIGURACION
// ============================================================

const EMAIL_CONFIG = {
  SHEET_HUESPEDES: 'Huespedes',

  // Remitente (se usa el email de la cuenta de Google que ejecuta el script)
  NOMBRE_REMITENTE: 'Hoteles Tibisay',

  // SEDES ACTIVAS — solo estas reciben emails automaticos
  // Agregar sedes a medida que se activen: 'Merida', 'Maracaibo', etc.
  SEDES_ACTIVAS: ['Margarita'],

  // URLs de encuestas QR por sede
  URLS_ENCUESTA: {
    'Merida':    'https://tibisayhoteles.com/qr/merida.html',
    'Margarita': 'https://tibisayhoteles.com/qr/margarita.html',
    'Maracaibo': 'https://tibisayhoteles.com/qr/maracaibo.html',
    'Maturin':   'https://tibisayhoteles.com/qr/maturin.html',
    'Canaima':   'https://tibisayhoteles.com/qr/canaima.html',
    'Morrocoy':  'https://tibisayhoteles.com/qr/morrocoy.html',
    'Catatumbo': 'https://tibisayhoteles.com/qr/catatumbo.html',
  },

  // Telefonos por sede
  TELEFONOS: {
    'Merida':    '0424 764 8679',
    'Margarita': '0424 861 0339',
    'Maracaibo': '0412 644 8918',
    'Maturin':   '0412 358 2965',
    'Canaima':   '0424 830 8891',
    'Morrocoy':  '0422 645 4665',
    'Catatumbo': '0424 723 9935',
  },

  // Taglines por sede
  TAGLINES: {
    'Merida':    'Tu aventura andina comienza aqui',
    'Margarita': 'Tu paraiso en la Isla de Margarita',
    'Maracaibo': 'Negocios y turismo frente al Lago',
    'Maturin':   'Servicio ejecutivo de primera',
    'Canaima':   'A las puertas del Salto Angel',
    'Morrocoy':  'Exclusividad boutique entre cayos cristalinos',
    'Catatumbo': 'El unico lugar para ver el Relampago',
  },

  // Color por sede (para email)
  COLORES: {
    'Merida':    '#2d6a4f',
    'Margarita': '#0077b6',
    'Maracaibo': '#1d3557',
    'Maturin':   '#264653',
    'Canaima':   '#006d37',
    'Morrocoy':  '#00b4d8',
    'Catatumbo': '#7b2cbf',
  },
};

// ============================================================
// CREAR HOJA DE HUESPEDES
// ============================================================

/**
 * Crea la hoja "Huespedes" con las columnas necesarias
 * Ejecutar una vez
 */
function crearHojaHuespedes() {
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  let sheet = ss.getSheetByName(EMAIL_CONFIG.SHEET_HUESPEDES);

  if (sheet) {
    Logger.log('La hoja "Huespedes" ya existe.');
    return;
  }

  sheet = ss.insertSheet(EMAIL_CONFIG.SHEET_HUESPEDES);

  const headers = [
    'Nombre',           // A
    'Email',            // B
    'Sede',             // C
    'Habitacion',       // D
    'Fecha Check-in',   // E
    'Fecha Check-out',  // F
    'Estado',           // G: "Check-in" o "Checkout"
    'Email Bienvenida', // H: "Enviado" o vacio
    'Email Post-Stay',  // I: "Enviado" o vacio
    'Notas',            // J
  ];

  sheet.appendRow(headers);
  sheet.getRange(1, 1, 1, headers.length)
    .setFontWeight('bold')
    .setBackground('#1a5276')
    .setFontColor('white');
  sheet.setFrozenRows(1);

  // Ancho de columnas
  sheet.setColumnWidth(1, 180); // Nombre
  sheet.setColumnWidth(2, 220); // Email
  sheet.setColumnWidth(3, 120); // Sede
  sheet.setColumnWidth(4, 100); // Habitacion
  sheet.setColumnWidth(5, 130); // Check-in
  sheet.setColumnWidth(6, 130); // Check-out
  sheet.setColumnWidth(7, 100); // Estado
  sheet.setColumnWidth(8, 130); // Email Bienvenida
  sheet.setColumnWidth(9, 130); // Email Post-Stay
  sheet.setColumnWidth(10, 200); // Notas

  // Validacion de datos para columna Sede (solo sedes activas)
  const sedeRule = SpreadsheetApp.newDataValidation()
    .requireValueInList(EMAIL_CONFIG.SEDES_ACTIVAS)
    .build();
  sheet.getRange('C2:C1000').setDataValidation(sedeRule);

  // Validacion para columna Estado
  const estadoRule = SpreadsheetApp.newDataValidation()
    .requireValueInList(['Check-in', 'Checkout'])
    .build();
  sheet.getRange('G2:G1000').setDataValidation(estadoRule);

  // Formato de fecha
  sheet.getRange('E2:F1000').setNumberFormat('dd/mm/yyyy');

  Logger.log('Hoja "Huespedes" creada exitosamente.');
}

// ============================================================
// TRIGGER: DETECTAR CAMBIOS EN LA HOJA
// ============================================================

/**
 * Se ejecuta cada vez que se edita la hoja
 * Detecta nuevos check-ins y checkouts
 */
function onEditHuespedes(e) {
  const sheet = e.source.getActiveSheet();

  // Solo procesar cambios en la hoja Huespedes
  if (sheet.getName() !== EMAIL_CONFIG.SHEET_HUESPEDES) return;

  const range = e.range;
  const row = range.getRow();

  // Ignorar header
  if (row < 2) return;

  const col = range.getColumn();
  const value = range.getValue();

  // Columna G (Estado) cambio a "Check-in" → enviar bienvenida
  if (col === 7 && value === 'Check-in') {
    procesarCheckin(sheet, row);
  }

  // Columna G (Estado) cambio a "Checkout" → enviar post-stay
  if (col === 7 && value === 'Checkout') {
    procesarCheckout(sheet, row);
  }
}

// ============================================================
// PROCESAR CHECK-IN → EMAIL BIENVENIDA
// ============================================================

function procesarCheckin(sheet, row) {
  const data = obtenerDatosHuesped(sheet, row);

  // Validar que la sede este activa
  if (!EMAIL_CONFIG.SEDES_ACTIVAS.includes(data.sede)) {
    sheet.getRange(row, 8).setValue('Sede no activa');
    sheet.getRange(row, 8).setBackground('#fff3cd');
    return;
  }

  // Validar que tenga email y no se haya enviado ya
  if (!data.email || data.emailBienvenida === 'Enviado') return;

  try {
    enviarEmailBienvenida(data);
    // Marcar como enviado
    sheet.getRange(row, 8).setValue('Enviado');
    sheet.getRange(row, 8).setBackground('#d4edda');
  } catch (error) {
    sheet.getRange(row, 8).setValue('Error: ' + error.message);
    sheet.getRange(row, 8).setBackground('#f8d7da');
  }
}

// ============================================================
// PROCESAR CHECKOUT → EMAIL POST-ESTADIA
// ============================================================

function procesarCheckout(sheet, row) {
  const data = obtenerDatosHuesped(sheet, row);

  // Validar que la sede este activa
  if (!EMAIL_CONFIG.SEDES_ACTIVAS.includes(data.sede)) {
    sheet.getRange(row, 9).setValue('Sede no activa');
    sheet.getRange(row, 9).setBackground('#fff3cd');
    return;
  }

  // Validar que tenga email y no se haya enviado ya
  if (!data.email || data.emailPostStay === 'Enviado') return;

  try {
    enviarEmailPostStay(data);
    // Marcar como enviado
    sheet.getRange(row, 9).setValue('Enviado');
    sheet.getRange(row, 9).setBackground('#d4edda');
  } catch (error) {
    sheet.getRange(row, 9).setValue('Error: ' + error.message);
    sheet.getRange(row, 9).setBackground('#f8d7da');
  }
}

// ============================================================
// OBTENER DATOS DEL HUESPED
// ============================================================

function obtenerDatosHuesped(sheet, row) {
  const values = sheet.getRange(row, 1, 1, 10).getValues()[0];
  return {
    nombre:          values[0] || '',
    email:           values[1] || '',
    sede:            values[2] || '',
    habitacion:      values[3] || '',
    fechaCheckin:    values[4] ? Utilities.formatDate(new Date(values[4]), 'America/Caracas', 'dd/MM/yyyy') : '',
    fechaCheckout:   values[5] ? Utilities.formatDate(new Date(values[5]), 'America/Caracas', 'dd/MM/yyyy') : '',
    estado:          values[6] || '',
    emailBienvenida: values[7] || '',
    emailPostStay:   values[8] || '',
    notas:           values[9] || '',
  };
}

// ============================================================
// EMAIL DE BIENVENIDA
// ============================================================

function enviarEmailBienvenida(data) {
  const sede = data.sede;
  const color = EMAIL_CONFIG.COLORES[sede] || '#1a5276';
  const tagline = EMAIL_CONFIG.TAGLINES[sede] || '';
  const telefono = EMAIL_CONFIG.TELEFONOS[sede] || '';
  const nombre = data.nombre.split(' ')[0]; // Solo primer nombre

  const asunto = 'Bienvenido a Hotel Tibisay ' + sede + ', ' + nombre + '!';

  const IMG_BASE = 'https://tibisayhoteles.com/img';

  const htmlBody = `
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f5f5f5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5;">
<tr><td align="center" style="padding:24px 0;">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

  <!-- Logo -->
  <tr><td style="background:#fff;padding:24px 40px;text-align:center;">
    <img src="${IMG_BASE}/logo-margarita.png" alt="Hotel Tibisay Margarita" width="220" style="max-width:220px;height:auto;">
  </td></tr>

  <!-- Hero Image -->
  <tr><td style="padding:0;">
    <img src="${IMG_BASE}/hero-margarita.jpg" alt="Hotel Tibisay ${sede}" width="600" style="width:100%;height:auto;display:block;">
  </td></tr>

  <!-- Contenido -->
  <tr><td style="padding:40px;">
    <h2 style="margin:0 0 6px;font-size:24px;color:${color};font-family:Georgia,serif;">Bienvenido, ${nombre}!</h2>
    <p style="margin:0 0 20px;font-size:14px;color:#999;">${tagline}</p>

    <p style="font-size:16px;line-height:1.6;color:#2c3e50;">
      Ya estas aqui y eso nos alegra muchisimo. Queremos que cada momento de tu estadia en
      <strong>Hotel Tibisay ${sede}</strong> sea inolvidable.
    </p>

    <!-- Info de estadia -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;">
      <tr style="background:${color};">
        <td colspan="2" style="padding:12px 16px;color:#fff;font-weight:700;font-size:15px;">Tu estadia</td>
      </tr>
      <tr style="background:#f8f9fa;">
        <td style="padding:10px 16px;font-weight:600;border-bottom:1px solid #e0e0e0;width:40%;">Check-in</td>
        <td style="padding:10px 16px;border-bottom:1px solid #e0e0e0;">${data.fechaCheckin} — 3:00 PM</td>
      </tr>
      <tr>
        <td style="padding:10px 16px;font-weight:600;border-bottom:1px solid #e0e0e0;">Check-out</td>
        <td style="padding:10px 16px;border-bottom:1px solid #e0e0e0;">${data.fechaCheckout} — 1:00 PM</td>
      </tr>
      <tr style="background:#f8f9fa;">
        <td style="padding:10px 16px;font-weight:600;border-bottom:1px solid #e0e0e0;">Habitacion</td>
        <td style="padding:10px 16px;border-bottom:1px solid #e0e0e0;">${data.habitacion || 'Consultar en recepcion'}</td>
      </tr>
      <tr>
        <td style="padding:10px 16px;font-weight:600;">Recepcion</td>
        <td style="padding:10px 16px;">24 horas</td>
      </tr>
    </table>

    <!-- Servicios destacados -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;">
      <tr>
        <td width="33%" style="text-align:center;padding:12px;">
          <div style="font-size:28px;margin-bottom:4px;">&#127754;</div>
          <p style="margin:0;font-size:13px;font-weight:600;color:${color};">Beach Club</p>
          <p style="margin:2px 0 0;font-size:12px;color:#999;">8:00 AM – 6:00 PM</p>
        </td>
        <td width="33%" style="text-align:center;padding:12px;">
          <div style="font-size:28px;margin-bottom:4px;">&#127869;</div>
          <p style="margin:0;font-size:13px;font-weight:600;color:${color};">Restaurante</p>
          <p style="margin:2px 0 0;font-size:12px;color:#999;">7:00 AM – 10:00 PM</p>
        </td>
        <td width="33%" style="text-align:center;padding:12px;">
          <div style="font-size:28px;margin-bottom:4px;">&#127946;</div>
          <p style="margin:0;font-size:13px;font-weight:600;color:${color};">Piscina</p>
          <p style="margin:2px 0 0;font-size:12px;color:#999;">7:00 AM – 9:00 PM</p>
        </td>
      </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;background:#f0f7ff;border-radius:8px;border-left:4px solid ${color};">
      <tr><td style="padding:20px;">
        <p style="margin:0 0 4px;font-weight:700;font-size:15px;color:${color};">Necesitas algo?</p>
        <p style="margin:0;font-size:14px;color:#555;">
          Marca <strong>0</strong> desde el telefono de tu habitacion o escribenos al WhatsApp <strong>${telefono}</strong>.
        </p>
      </td></tr>
    </table>

    <p style="margin-top:24px;text-align:center;font-style:italic;color:#7f8c8d;">
      Disfruta tu estadia!<br>
      El equipo de <strong>Hotel Tibisay ${sede}</strong>
    </p>
  </td></tr>

  <!-- Footer -->
  <tr><td style="padding:24px 40px;background:#1a1a2e;text-align:center;">
    <p style="margin:0 0 4px;font-size:14px;color:rgba(255,255,255,0.7);">Hotel Tibisay ${sede}</p>
    <p style="margin:0 0 8px;font-size:12px;color:rgba(255,255,255,0.5);">Tel: ${telefono}</p>
    <p style="margin:0;font-size:11px;color:rgba(255,255,255,0.35);">© 2026 Hoteles Tibisay — OTHTICA. Todos los derechos reservados.</p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>`;

  MailApp.sendEmail({
    to: data.email,
    subject: asunto,
    htmlBody: htmlBody,
    name: EMAIL_CONFIG.NOMBRE_REMITENTE,
  });
}

// ============================================================
// EMAIL POST-ESTADIA (CON LINK A ENCUESTA)
// ============================================================

function enviarEmailPostStay(data) {
  const sede = data.sede;
  const color = EMAIL_CONFIG.COLORES[sede] || '#1a5276';
  const tagline = EMAIL_CONFIG.TAGLINES[sede] || '';
  const linkEncuesta = EMAIL_CONFIG.URLS_ENCUESTA[sede] || '#';
  const nombre = data.nombre.split(' ')[0];

  const IMG_BASE = 'https://tibisayhoteles.com/img';
  const asunto = 'Gracias por tu visita, ' + nombre + ' — Cuentanos como fue tu experiencia';

  const htmlBody = `
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f5f5f5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5;">
<tr><td align="center" style="padding:24px 0;">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

  <!-- Logo -->
  <tr><td style="background:#fff;padding:24px 40px;text-align:center;">
    <img src="${IMG_BASE}/logo-margarita.png" alt="Hotel Tibisay Margarita" width="220" style="max-width:220px;height:auto;">
  </td></tr>

  <!-- Header con color -->
  <tr><td style="background:${color};padding:28px 40px;text-align:center;">
    <h1 style="margin:0;font-family:Georgia,serif;font-size:26px;color:#fff;">Gracias, ${nombre}!</h1>
    <p style="margin:8px 0 0;font-size:14px;color:rgba(255,255,255,0.85);">Esperamos que hayas disfrutado tu estadia en ${sede}</p>
  </td></tr>

  <!-- Contenido -->
  <tr><td style="padding:40px;">

    <p style="font-size:16px;line-height:1.6;color:#2c3e50;">
      Fue un placer tenerte con nosotros en <strong>Hotel Tibisay ${sede}</strong>. Tu visita es
      importante para nosotros y queremos seguir mejorando para ti.
    </p>

    <!-- Resumen de estadia -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;">
      <tr style="background:${color};">
        <td colspan="2" style="padding:12px 16px;color:#fff;font-weight:700;font-size:15px;">Resumen de tu estadia</td>
      </tr>
      <tr style="background:#f8f9fa;">
        <td style="padding:10px 16px;font-weight:600;border-bottom:1px solid #e0e0e0;width:40%;">Check-in</td>
        <td style="padding:10px 16px;border-bottom:1px solid #e0e0e0;">${data.fechaCheckin}</td>
      </tr>
      <tr>
        <td style="padding:10px 16px;font-weight:600;border-bottom:1px solid #e0e0e0;">Check-out</td>
        <td style="padding:10px 16px;border-bottom:1px solid #e0e0e0;">${data.fechaCheckout}</td>
      </tr>
      <tr style="background:#f8f9fa;">
        <td style="padding:10px 16px;font-weight:600;">Habitacion</td>
        <td style="padding:10px 16px;">${data.habitacion || 'N/A'}</td>
      </tr>
    </table>

    <!-- CTA Encuesta -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:32px 0;background:linear-gradient(135deg,#f0f7ff,#e8f4fd);border-radius:8px;border:1px solid #d0e4f5;">
      <tr><td style="padding:32px;text-align:center;">
        <p style="margin:0 0 4px;font-size:28px;">&#11088;</p>
        <p style="margin:0 0 8px;font-size:20px;font-weight:700;color:${color};">
          Tu opinion nos importa
        </p>
        <p style="margin:0 0 24px;font-size:15px;color:#555;">
          Cuentanos como fue tu experiencia. Solo toma 2 minutos y nos ayuda a mejorar.
        </p>
        <a href="${linkEncuesta}" style="display:inline-block;background:${color};color:#fff;font-size:17px;font-weight:700;text-decoration:none;padding:16px 48px;border-radius:8px;letter-spacing:0.5px;">
          Responder encuesta
        </a>
      </td></tr>
    </table>

    <!-- PROMO CANAIMA 5% -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:32px 0;border-radius:8px;overflow:hidden;border:2px solid #006d37;">
      <tr><td style="background:#006d37;padding:20px 24px;text-align:center;">
        <p style="margin:0;font-size:12px;font-weight:700;color:rgba(255,255,255,0.8);letter-spacing:2px;text-transform:uppercase;">Oferta exclusiva para ti</p>
      </td></tr>
      <tr><td style="padding:28px 24px;text-align:center;background:#f0faf4;">
        <p style="margin:0 0 4px;font-size:36px;font-weight:800;color:#006d37;">5% OFF</p>
        <p style="margin:0 0 12px;font-size:18px;font-weight:700;color:#2c3e50;">Campamento Tibisay Canaima</p>
        <p style="margin:0 0 20px;font-size:14px;color:#555;line-height:1.6;">
          Vive la experiencia del Salto Angel y la Gran Sabana. Porque ya eres parte de la familia Tibisay,
          te ofrecemos un <strong>5% de descuento</strong> en tu proxima aventura en Canaima.
        </p>
        <p style="margin:0 0 8px;font-size:13px;color:#006d37;font-weight:600;">
          Contactanos para reservar: 0424 830 8891
        </p>
        <p style="margin:0;font-size:11px;color:#999;">
          Menciona el codigo <strong>TIBISAY-CANAIMA5</strong> al reservar
        </p>
      </td></tr>
    </table>

    <!-- 7 Destinos Banner -->
    <tr><td style="padding:0 40px 20px;">
      <img src="${IMG_BASE}/7destinos.jpg" alt="7 Destinos Tibisay" width="520" style="width:100%;max-width:520px;height:auto;display:block;border-radius:8px;">
    </td></tr>

    <p style="margin-top:16px;text-align:center;font-style:italic;color:#7f8c8d;">
      Te esperamos de vuelta pronto!<br>
      El equipo de <strong>Hotel Tibisay ${sede}</strong>
    </p>
  </td></tr>

  <!-- Footer -->
  <tr><td style="padding:24px 40px;background:#1a1a2e;text-align:center;">
    <p style="margin:0 0 4px;font-size:14px;color:rgba(255,255,255,0.7);">Hotel Tibisay ${sede}</p>
    <p style="margin:0 0 8px;font-size:12px;color:rgba(255,255,255,0.5);">Tel: ${EMAIL_CONFIG.TELEFONOS[sede] || ''}</p>
    <p style="margin:0;font-size:11px;color:rgba(255,255,255,0.35);">© 2026 Hoteles Tibisay — OTHTICA. Todos los derechos reservados.</p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>`;

  MailApp.sendEmail({
    to: data.email,
    subject: asunto,
    htmlBody: htmlBody,
    name: EMAIL_CONFIG.NOMBRE_REMITENTE,
  });
}

// ============================================================
// ACTIVAR NUEVA SEDE (ejecutar cuando se cobre un hotel nuevo)
// ============================================================

/**
 * Actualiza el dropdown de sedes en la hoja Huespedes
 * Ejecutar despues de agregar una sede a SEDES_ACTIVAS
 */
function actualizarSedesActivas() {
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const sheet = ss.getSheetByName(EMAIL_CONFIG.SHEET_HUESPEDES);
  if (!sheet) {
    Logger.log('Error: No se encontro la hoja "Huespedes"');
    return;
  }

  const sedeRule = SpreadsheetApp.newDataValidation()
    .requireValueInList(EMAIL_CONFIG.SEDES_ACTIVAS)
    .build();
  sheet.getRange('C2:C1000').setDataValidation(sedeRule);

  Logger.log('Sedes activas actualizadas: ' + EMAIL_CONFIG.SEDES_ACTIVAS.join(', '));
}

// ============================================================
// CONFIGURAR TRIGGERS (ejecutar UNA VEZ)
// ============================================================

/**
 * Configura el trigger onEdit para detectar cambios automaticamente
 * EJECUTAR ESTA FUNCION UNA SOLA VEZ
 */
function configurarTriggersEmail() {
  // Eliminar triggers existentes de esta funcion
  const triggers = ScriptApp.getProjectTriggers();
  triggers.forEach(trigger => {
    if (trigger.getHandlerFunction() === 'onEditHuespedes') {
      ScriptApp.deleteTrigger(trigger);
    }
  });

  // Crear nuevo trigger onEdit
  ScriptApp.newTrigger('onEditHuespedes')
    .forSpreadsheet(SpreadsheetApp.getActiveSpreadsheet())
    .onEdit()
    .create();

  Logger.log('Trigger de emails configurado. Cuando cambien el Estado a "Check-in" o "Checkout" se enviara el email automaticamente.');
}

// ============================================================
// FUNCIONES DE PRUEBA
// ============================================================

/**
 * Prueba el email de bienvenida (cambiar email antes de ejecutar)
 */
function testEmailBienvenida() {
  const testData = {
    nombre: 'Juan Perez',
    email: 'ovavision.ve@gmail.com',  // CAMBIAR por tu email para probar
    sede: 'Margarita',
    habitacion: '301',
    fechaCheckin: '30/03/2026',
    fechaCheckout: '02/04/2026',
  };
  enviarEmailBienvenida(testData);
  Logger.log('Email de bienvenida enviado a ' + testData.email);
}

/**
 * Prueba el email post-estadia (cambiar email antes de ejecutar)
 */
function testEmailPostStay() {
  const testData = {
    nombre: 'Juan Perez',
    email: 'ovavision.ve@gmail.com',  // CAMBIAR por tu email para probar
    sede: 'Margarita',
    habitacion: '301',
    fechaCheckin: '30/03/2026',
    fechaCheckout: '02/04/2026',
  };
  enviarEmailPostStay(testData);
  Logger.log('Email post-estadia enviado a ' + testData.email);
}
