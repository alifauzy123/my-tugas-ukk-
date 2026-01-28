import qz from 'qz-tray';

const DEFAULT_CONFIG = {
    printerName: 'Generic / Text Only',
    fallbackToDefault: true,
    paperConfig: {
        copies: 1,
        units: 'mm',
        size: { width: 58, height: 0 },
        margins: { top: 0, right: 0, bottom: 0, left: 0 }
    }
};

function setDevSecurity() {
    // Development-only: requires "Allow unsigned requests" in QZ Tray settings
    qz.security.setCertificatePromise(function (resolve, reject) {
        resolve(qz.security.defaultCertificate);
    });
    // QZ 2.2.5 expects a promise factory (function returning a function)
    qz.security.setSignaturePromise(function (toSign) {
        return function (resolve, reject) {
            resolve(toSign);
        };
    });
}

async function ensureConnection() {
    if (!qz.websocket.isActive()) {
        setDevSecurity();
        await qz.websocket.connect();
    }
}

async function findPrinter(preferredName = DEFAULT_CONFIG.printerName, fallbackToDefault = DEFAULT_CONFIG.fallbackToDefault) {
    const printers = await qz.printers.find();

    if (preferredName) {
        const target = printers.find((p) => p.toLowerCase().includes(preferredName.toLowerCase()));
        if (target) return target;
        if (!fallbackToDefault) {
            throw new Error(`Printer "${preferredName}" tidak ditemukan.`);
        }
    }

    return qz.printers.getDefault();
}

function formatNumber(value) {
    return (Number(value) || 0).toLocaleString('id-ID');
}

function convertReceiptToRaw(receipt) {
    const ESC = '\x1B';
    const CENTER = ESC + 'a\x01';
    const LEFT = ESC + 'a\x00';
    const BOLD_ON = ESC + 'E\x01';
    const BOLD_OFF = ESC + 'E\x00';
    const CUT = ESC + 'm';
    const NEWLINE = '\n';

    let output = '';
    output += CENTER + BOLD_ON + 'NOTA TRANSAKSI' + BOLD_OFF + NEWLINE;
    output += CENTER + (receipt.tanggal || '') + NEWLINE;
    output += CENTER + 'Kasir: ' + (receipt.kasir || '') + NEWLINE;
    output += LEFT + '--------------------------------' + NEWLINE;

    (receipt.items || []).forEach((item) => {
        const nama = (item.nama || '').substring(0, 20);
        const qty = item.qty || 0;
        const subtotal = formatNumber(item.subtotal || 0);

        output += LEFT + nama + NEWLINE;
        output += LEFT + `${qty} x ${formatNumber(item.harga || 0)} = ${subtotal}` + NEWLINE;
        output += LEFT + (item.tipe || '') + NEWLINE;
        output += NEWLINE;
    });

    output += '--------------------------------' + NEWLINE;
    output += `Total: ${formatNumber(receipt.total || 0)}` + NEWLINE;
    output += `Dibayar: ${formatNumber(receipt.dibayar || 0)}` + NEWLINE;
    output += `Kembali: ${formatNumber(receipt.kembalian || 0)}` + NEWLINE;
    output += '--------------------------------' + NEWLINE;
    output += CENTER + 'Terima kasih' + NEWLINE;
    output += CENTER + 'atas kunjungan Anda' + NEWLINE;
    output += NEWLINE + NEWLINE + NEWLINE;
    output += CUT;

    return output;
}

function convertKitchenToRaw(receipt) {
    const ESC = '\x1B';
    const CENTER = ESC + 'a\x01';
    const LEFT = ESC + 'a\x00';
    const BOLD_ON = ESC + 'E\x01';
    const BOLD_OFF = ESC + 'E\x00';
    const CUT = ESC + 'm';
    const NEWLINE = '\n';

    let output = '';
    output += CENTER + BOLD_ON + 'NOTA KITCHEN' + BOLD_OFF + NEWLINE;
    output += CENTER + (receipt.tanggal || '') + NEWLINE;
    output += CENTER + 'Kasir: ' + (receipt.kasir || '') + NEWLINE;
    output += LEFT + '--------------------------------' + NEWLINE;

    (receipt.items || []).forEach((item) => {
        const nama = (item.nama || '').substring(0, 24);
        const qty = item.qty || 0;
        const tipe = item.tipe || '';

        output += LEFT + `${qty}x ${nama}` + NEWLINE;
        if (tipe) {
            output += LEFT + `(${tipe})` + NEWLINE;
        }
        output += NEWLINE;
    });

    output += '--------------------------------' + NEWLINE;
    output += CENTER + 'SEGERA SIAPKAN' + NEWLINE;
    output += NEWLINE + NEWLINE + NEWLINE;
    output += CUT;

    return output;
}

async function printReceipt(receipt, configOverride = {}) {
    const config = { ...DEFAULT_CONFIG, ...configOverride };

    await ensureConnection();
    const printer = await findPrinter(config.printerName, config.fallbackToDefault);

    const qzConfig = qz.configs.create(printer, config.paperConfig);
    const data = [
        {
            type: 'raw',
            format: 'plain',
            data: convertReceiptToRaw(receipt)
        }
    ];

    return qz.print(qzConfig, data);
}

async function printKitchenReceipt(receipt, configOverride = {}) {
    const config = { ...DEFAULT_CONFIG, ...configOverride };

    await ensureConnection();
    const printer = await findPrinter(config.printerName, config.fallbackToDefault);

    const qzConfig = qz.configs.create(printer, config.paperConfig);
    const data = [
        {
            type: 'raw',
            format: 'plain',
            data: convertKitchenToRaw(receipt)
        }
    ];

    return qz.print(qzConfig, data);
}

export const qzPrint = {
    ensureConnection,
    findPrinter,
    printReceipt,
    printKitchenReceipt
};

export default qzPrint;
