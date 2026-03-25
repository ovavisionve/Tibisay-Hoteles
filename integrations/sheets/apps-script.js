/**
 * Google Apps Script — Backend para Encuestas QR y WhatsApp
 * Hoteles Tibisay · OVA VISION
 * v2026-03-25
 *
 * INSTRUCCIONES DE INSTALACIÓN:
 * 1. Crear un Google Sheet nuevo (o usar el existente del dashboard)
 * 2. Ir a Extensiones → Apps Script
 * 3. Pegar este código completo
 * 4. Desplegar como Web App:
 *    - Ejecutar como: Tu cuenta
 *    - Acceso: Cualquier persona
 * 5. Copiar la URL del despliegue y pegarla en los formularios HTML
 *    (reemplazar PENDIENTE_CONFIGURAR)
 */

// ============================================================
// CONFIGURACIÓN
// ============================================================

const CONFIG = {
  // Nombres de las hojas en el Google Sheet
  SHEET_QR: 'Respuestas QR',
  SHEET_WHATSAPP: 'Respuestas WhatsApp',
  SHEET_CHECKOUTS: 'Checkouts',
  SHEET_DASHBOARD: 'Dashboard',
  SHEET_ALERTAS: 'Alertas',

  // Umbral para alerta de rescate
  UMBRAL_RESCATE: 3.0,

  // Emails para alertas (separados por coma)
  EMAILS_ALERTA: 'ovavision.ve@gmail.com',

  // Teléfonos para alerta WhatsApp (futuro, vía Make)
  TELEFONO_FLOR: '',       // Pendiente
  TELEFONO_EDUARDO: '',    // 0424 418 6107
};

// ============================================================
// WEB APP: Recibir datos de formularios QR
// ============================================================

/**
 * Maneja peticiones POST desde los formularios HTML
 */
function doPost(e) {
  try {
    const data = JSON.parse(e.postData.contents);
    const result = registrarRespuestaQR(data);

    return ContentService
      .createTextOutput(JSON.stringify({ status: 'ok', row: result }))
      .setMimeType(ContentService.MimeType.JSON);

  } catch (error) {
    return ContentService
      .createTextOutput(JSON.stringify({ status: 'error', message: error.toString() }))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

/**
 * Maneja peticiones GET (para verificar que el script funciona)
 */
function doGet(e) {
  return ContentService
    .createTextOutput(JSON.stringify({
      status: 'ok',
      message: 'Backend Hoteles Tibisay activo',
      version: 'v2026-03-25'
    }))
    .setMimeType(ContentService.MimeType.JSON);
}

// ============================================================
// REGISTRO DE RESPUESTAS QR
// ============================================================

/**
 * Registra una respuesta de encuesta QR en Google Sheets
 * @param {Object} data - Datos del formulario
 * @returns {number} Número de fila donde se registró
 */
function registrarRespuestaQR(data) {
  const sheet = getOrCreateSheet(CONFIG.SHEET_QR, [
    'Timestamp', 'Sede', 'Nombre', 'Email',
    'Check-in', 'Habitación', 'Restaurante/Servicios', 'Personal', 'General',
    'Promedio', 'Lo mejor', 'Qué mejorar', 'Recomendaría', 'Fuente'
  ]);

  const promedio = calcularPromedio([data.q1, data.q2, data.q3, data.q4, data.q5]);

  const row = [
    data.timestamp || new Date().toISOString(),
    data.sede || '',
    data.nombre || '',
    data.email || '',
    data.q1 || 0,
    data.q2 || 0,
    data.q3 || 0,
    data.q4 || 0,
    data.q5 || 0,
    promedio,
    data.lo_mejor || '',
    data.que_mejorar || '',
    data.recomienda || '',
    'QR'
  ];

  sheet.appendRow(row);
  const lastRow = sheet.getLastRow();

  // Verificar si necesita alerta de rescate
  if (promedio > 0 && promedio < CONFIG.UMBRAL_RESCATE) {
    enviarAlertaRescate(data, promedio, 'QR');
  }

  // Actualizar dashboard
  actualizarDashboard();

  return lastRow;
}

// ============================================================
// REGISTRO DE RESPUESTAS WHATSAPP (llamado desde Make)
// ============================================================

/**
 * Registra una respuesta de encuesta WhatsApp
 * Puede ser llamado desde Make vía webhook o directamente
 * @param {Object} data - Datos de la encuesta WhatsApp
 */
function registrarRespuestaWhatsApp(data) {
  const sheet = getOrCreateSheet(CONFIG.SHEET_WHATSAPP, [
    'Timestamp', 'Sede', 'Nombre', 'Teléfono',
    'Check-in', 'Habitación', 'Restaurante/Servicios', 'Personal', 'General',
    'Promedio', 'Ruta', 'Comentario', 'Google Review', 'Fuente'
  ]);

  const promedio = calcularPromedio([data.q1, data.q2, data.q3, data.q4, data.q5]);

  // Determinar ruta
  let ruta = 'Retención';
  if (promedio >= 4.0) ruta = 'Embajador';
  else if (promedio < 3.0) ruta = 'Rescate';

  const row = [
    data.timestamp || new Date().toISOString(),
    data.sede || '',
    data.nombre || '',
    data.telefono || '',
    data.q1 || 0,
    data.q2 || 0,
    data.q3 || 0,
    data.q4 || 0,
    data.q5 || 0,
    promedio,
    ruta,
    data.comentario || '',
    data.google_review || 'No',
    'WhatsApp'
  ];

  sheet.appendRow(row);

  // Alerta si rescate
  if (ruta === 'Rescate') {
    enviarAlertaRescate(data, promedio, 'WhatsApp');
  }

  actualizarDashboard();

  return { ruta: ruta, promedio: promedio };
}

// ============================================================
// REGISTRO DE CHECKOUTS (manual o desde Make)
// ============================================================

/**
 * Registra un checkout para disparar la encuesta WhatsApp
 * @param {Object} data - Datos del checkout
 */
function registrarCheckout(data) {
  const sheet = getOrCreateSheet(CONFIG.SHEET_CHECKOUTS, [
    'Timestamp', 'Sede', 'Nombre Huésped', 'Teléfono', 'Email',
    'Habitación', 'Fecha Check-in', 'Fecha Check-out',
    'Encuesta Enviada', 'Notas'
  ]);

  const row = [
    new Date().toISOString(),
    data.sede || '',
    data.nombre || '',
    data.telefono || '',
    data.email || '',
    data.habitacion || '',
    data.fecha_checkin || '',
    data.fecha_checkout || new Date().toISOString().split('T')[0],
    'Pendiente',
    data.notas || ''
  ];

  sheet.appendRow(row);
  return sheet.getLastRow();
}

// ============================================================
// ALERTAS DE RESCATE
// ============================================================

/**
 * Envía alerta cuando un huésped califica bajo (< 3.0)
 * @param {Object} data - Datos del huésped
 * @param {number} promedio - Promedio de calificación
 * @param {string} fuente - 'QR' o 'WhatsApp'
 */
function enviarAlertaRescate(data, promedio, fuente) {
  // Registrar en hoja de alertas
  const sheet = getOrCreateSheet(CONFIG.SHEET_ALERTAS, [
    'Timestamp', 'Sede', 'Nombre', 'Contacto', 'Promedio',
    'Fuente', 'Comentario', 'Estado', 'Atendido por', 'Resolución'
  ]);

  sheet.appendRow([
    new Date().toISOString(),
    data.sede || '',
    data.nombre || '',
    data.telefono || data.email || '',
    promedio,
    fuente,
    data.que_mejorar || data.comentario || '',
    'Pendiente',
    '',
    ''
  ]);

  // Enviar email de alerta
  if (CONFIG.EMAILS_ALERTA) {
    const subject = `⚠️ ALERTA RESCATE — ${data.sede} — Promedio: ${promedio}`;
    const body = `
ALERTA DE CALIFICACIÓN BAJA
============================

Sede: ${data.sede}
Huésped: ${data.nombre}
Contacto: ${data.telefono || data.email || 'No proporcionado'}
Promedio: ${promedio}/5.0
Fuente: ${fuente}

Calificaciones:
- Check-in: ${data.q1}/5
- Habitación: ${data.q2}/5
- Restaurante/Servicios: ${data.q3}/5
- Personal: ${data.q4}/5
- General: ${data.q5}/5

Comentario del huésped:
${data.que_mejorar || data.comentario || 'Sin comentario'}

⏰ Este caso requiere atención en las próximas 24 horas.

---
Sistema de Alertas · Hoteles Tibisay · OVA VISION
    `.trim();

    MailApp.sendEmail(CONFIG.EMAILS_ALERTA, subject, body);
  }
}

// ============================================================
// DASHBOARD
// ============================================================

/**
 * Actualiza el dashboard consolidado con métricas
 */
function actualizarDashboard() {
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const dashboard = getOrCreateSheet(CONFIG.SHEET_DASHBOARD, [
    'Métrica', 'Margarita', 'Mérida', 'Maracaibo', 'Maturín',
    'Canaima', 'Morrocoy', 'Catatumbo', 'Total'
  ]);

  const sedes = ['Margarita', 'Mérida', 'Maracaibo', 'Maturín',
                 'Canaima', 'Morrocoy', 'Catatumbo'];

  // Obtener todos los datos
  const datosQR = getSheetData(CONFIG.SHEET_QR);
  const datosWA = getSheetData(CONFIG.SHEET_WHATSAPP);
  const todosLosDatos = datosQR.concat(datosWA);

  // Calcular métricas por sede
  const metricas = [
    'Total respuestas',
    'Promedio general',
    'Respuestas QR',
    'Respuestas WhatsApp',
    'Embajadores (≥4.0)',
    'Retención (3.0-3.9)',
    'Rescate (<3.0)',
    'Recomendarían (Sí)',
    'Promedio check-in',
    'Promedio habitación',
    'Promedio restaurante',
    'Promedio personal',
    'Promedio general (P5)',
    'Última respuesta'
  ];

  // Limpiar dashboard (mantener headers)
  if (dashboard.getLastRow() > 1) {
    dashboard.getRange(2, 1, dashboard.getLastRow() - 1, 9).clearContent();
  }

  metricas.forEach((metrica, i) => {
    const row = [metrica];
    let total = 0;
    let totalCount = 0;

    sedes.forEach(sede => {
      const sedeData = todosLosDatos.filter(d => d.sede === sede);
      let valor = 0;

      switch (metrica) {
        case 'Total respuestas':
          valor = sedeData.length;
          total += valor;
          break;
        case 'Promedio general':
          valor = sedeData.length > 0
            ? (sedeData.reduce((s, d) => s + (d.promedio || 0), 0) / sedeData.length).toFixed(2)
            : '-';
          if (sedeData.length > 0) {
            total += sedeData.reduce((s, d) => s + (d.promedio || 0), 0);
            totalCount += sedeData.length;
          }
          break;
        case 'Respuestas QR':
          valor = sedeData.filter(d => d.fuente === 'QR').length;
          total += valor;
          break;
        case 'Respuestas WhatsApp':
          valor = sedeData.filter(d => d.fuente === 'WhatsApp').length;
          total += valor;
          break;
        case 'Embajadores (≥4.0)':
          valor = sedeData.filter(d => d.promedio >= 4.0).length;
          total += valor;
          break;
        case 'Retención (3.0-3.9)':
          valor = sedeData.filter(d => d.promedio >= 3.0 && d.promedio < 4.0).length;
          total += valor;
          break;
        case 'Rescate (<3.0)':
          valor = sedeData.filter(d => d.promedio > 0 && d.promedio < 3.0).length;
          total += valor;
          break;
        case 'Recomendarían (Sí)':
          valor = sedeData.filter(d => d.recomienda === 'Sí').length;
          total += valor;
          break;
        case 'Promedio check-in':
        case 'Promedio habitación':
        case 'Promedio restaurante':
        case 'Promedio personal':
        case 'Promedio general (P5)':
          const field = {
            'Promedio check-in': 'q1',
            'Promedio habitación': 'q2',
            'Promedio restaurante': 'q3',
            'Promedio personal': 'q4',
            'Promedio general (P5)': 'q5'
          }[metrica];
          const valid = sedeData.filter(d => d[field] > 0);
          valor = valid.length > 0
            ? (valid.reduce((s, d) => s + d[field], 0) / valid.length).toFixed(2)
            : '-';
          break;
        case 'Última respuesta':
          valor = sedeData.length > 0
            ? sedeData[sedeData.length - 1].timestamp.split('T')[0]
            : '-';
          break;
      }
      row.push(valor);
    });

    // Total column
    if (metrica === 'Promedio general') {
      row.push(totalCount > 0 ? (total / totalCount).toFixed(2) : '-');
    } else if (metrica.startsWith('Promedio') || metrica === 'Última respuesta') {
      row.push('-');
    } else {
      row.push(total);
    }

    dashboard.getRange(i + 2, 1, 1, 9).setValues([row]);
  });
}

// ============================================================
// UTILIDADES
// ============================================================

/**
 * Obtiene o crea una hoja con headers
 */
function getOrCreateSheet(name, headers) {
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  let sheet = ss.getSheetByName(name);

  if (!sheet) {
    sheet = ss.insertSheet(name);
    sheet.appendRow(headers);
    sheet.getRange(1, 1, 1, headers.length)
      .setFontWeight('bold')
      .setBackground('#1a73e8')
      .setFontColor('white');
    sheet.setFrozenRows(1);
  }

  return sheet;
}

/**
 * Obtiene datos de una hoja como array de objetos
 */
function getSheetData(sheetName) {
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const sheet = ss.getSheetByName(sheetName);

  if (!sheet || sheet.getLastRow() < 2) return [];

  const data = sheet.getDataRange().getValues();
  const headers = data[0];

  return data.slice(1).map(row => {
    const obj = {};
    headers.forEach((h, i) => {
      const key = h.toLowerCase()
        .replace(/[áà]/g, 'a').replace(/[éè]/g, 'e')
        .replace(/[íì]/g, 'i').replace(/[óò]/g, 'o').replace(/[úù]/g, 'u')
        .replace(/[^a-z0-9]/g, '_').replace(/_+/g, '_');

      // Map known column names to standard keys
      if (h === 'Check-in') obj.q1 = Number(row[i]) || 0;
      else if (h === 'Habitación') obj.q2 = Number(row[i]) || 0;
      else if (h.includes('Restaurante')) obj.q3 = Number(row[i]) || 0;
      else if (h === 'Personal') obj.q4 = Number(row[i]) || 0;
      else if (h === 'General') obj.q5 = Number(row[i]) || 0;
      else if (h === 'Promedio') obj.promedio = Number(row[i]) || 0;
      else if (h === 'Sede') obj.sede = row[i];
      else if (h === 'Fuente') obj.fuente = row[i];
      else if (h === 'Timestamp') obj.timestamp = row[i];
      else if (h === 'Recomendaría') obj.recomienda = row[i];
      else if (h === 'Ruta') obj.ruta = row[i];
      else obj[key] = row[i];
    });
    return obj;
  });
}

/**
 * Calcula promedio de un array de valores, ignorando ceros
 */
function calcularPromedio(valores) {
  const valid = valores.filter(v => v > 0).map(Number);
  if (valid.length === 0) return 0;
  return Number((valid.reduce((a, b) => a + b, 0) / valid.length).toFixed(2));
}

// ============================================================
// FUNCIONES DE MANTENIMIENTO
// ============================================================

/**
 * Configura triggers automáticos
 * Ejecutar una vez después de instalar
 */
function configurarTriggers() {
  // Trigger para actualizar dashboard cada hora
  ScriptApp.newTrigger('actualizarDashboard')
    .timeBased()
    .everyHours(1)
    .create();

  // Trigger para resumen semanal (lunes 9am)
  ScriptApp.newTrigger('enviarResumenSemanal')
    .timeBased()
    .onWeekDay(ScriptApp.WeekDay.MONDAY)
    .atHour(9)
    .create();

  Logger.log('Triggers configurados correctamente.');
}

/**
 * Envía resumen semanal por email
 */
function enviarResumenSemanal() {
  actualizarDashboard();

  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const dashboard = ss.getSheetByName(CONFIG.SHEET_DASHBOARD);

  if (!dashboard) return;

  const data = dashboard.getDataRange().getValues();
  let body = 'RESUMEN SEMANAL — HOTELES TIBISAY\n';
  body += '='.repeat(40) + '\n\n';

  data.forEach(row => {
    body += row.join(' | ') + '\n';
  });

  body += '\n---\nVer dashboard completo: ' + ss.getUrl();

  MailApp.sendEmail(
    CONFIG.EMAILS_ALERTA,
    '📊 Resumen Semanal — Encuestas Hoteles Tibisay',
    body
  );
}

/**
 * Función de prueba: simula una respuesta QR
 */
function testRespuestaQR() {
  const testData = {
    sede: 'Margarita',
    nombre: 'Juan Pérez (TEST)',
    email: 'test@test.com',
    q1: 5,
    q2: 4,
    q3: 5,
    q4: 4,
    q5: 5,
    lo_mejor: 'El Beach Club es espectacular',
    que_mejorar: 'Nada, todo perfecto',
    recomienda: 'Sí',
    timestamp: new Date().toISOString()
  };

  const result = registrarRespuestaQR(testData);
  Logger.log('Respuesta registrada en fila: ' + result);
}

/**
 * Función de prueba: simula una alerta de rescate
 */
function testAlertaRescate() {
  const testData = {
    sede: 'Mérida',
    nombre: 'María García (TEST)',
    email: 'test@test.com',
    q1: 2,
    q2: 1,
    q3: 2,
    q4: 3,
    q5: 2,
    que_mejorar: 'La habitación no estaba limpia y el agua caliente no funcionaba',
    timestamp: new Date().toISOString()
  };

  enviarAlertaRescate(testData, 2.0, 'QR');
  Logger.log('Alerta de rescate enviada.');
}
