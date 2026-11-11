<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pemilik - BeanByte</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  :root{--brown:#5a3425;--brown2:#6b3f2d;--nav:#7a4d37;--bg:#f7f1e9;--card:#fffdfa;--line:#eadfd2;--head:#f3e9de;--ink:#2b1a12;--muted:#8b7467;
        --w:#fff;--soft:#f1e7dc;--topbg:#fbf7f1;--sbg:#fff9f1;--hcol:#5a3425}
  *{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
  body{font-family:"Open Sans",system-ui,sans-serif;background:var(--bg);color:var(--ink);font-size:14px}
  button{font:inherit;color:inherit;background:none;border:0;cursor:pointer}
  input,select,textarea{font:inherit;color:var(--ink)}
  button:disabled{opacity:.4;cursor:default}
  h1,h2,h3{font-family:"Outfit",sans-serif}
  svg{display:block}
  .grow{flex:1}
  .empty{text-align:center;padding:40px 16px;color:var(--muted)}

  /* ===== Kerangka ===== */
  .app{display:grid;grid-template-columns:255px minmax(0,1fr);min-height:100vh}
  .app.collapsed{grid-template-columns:76px minmax(0,1fr)}
  .side{position:sticky;top:0;height:100vh;overflow:hidden;display:flex;flex-direction:column;color:#f3e6da;background:linear-gradient(180deg,#3b2217 0%,#2a170e 100%)}
  .brand{display:flex;align-items:center;gap:10px;padding:22px 20px 18px;position:relative;z-index:1}
  .brand svg{width:46px;height:46px;flex:none}
  .bt b{display:block;font-family:"Outfit",sans-serif;font-size:1.45rem;font-weight:700;line-height:1.1}
  .bt small{font-size:.74rem;opacity:.8}
  .side nav{padding:8px 10px;position:relative;z-index:1}
  .nv{display:flex;align-items:center;gap:14px;width:100%;padding:12px 16px;border-radius:10px;text-align:left;color:#f3e6da;font-size:.92rem;margin-bottom:6px}
  .nv svg{width:24px;height:24px;flex:none}
  .nv:hover{background:rgba(255,255,255,.06)}
  .nv.on{background:var(--nav);color:#fff}
  .leaf{position:absolute;left:-14px;bottom:110px;width:230px;opacity:.13;pointer-events:none}
  .sfoot{margin-top:auto;border-top:1px solid rgba(255,255,255,.14);padding:14px 12px;position:relative;z-index:1}
  .me{display:flex;align-items:center;gap:12px;padding:6px 8px 10px}
  .me .bt b{font-size:.95rem;font-family:"Open Sans",sans-serif;font-weight:700}
  .av{width:34px;height:34px;border-radius:50%;background:#e8cdb6;color:var(--brown);display:grid;place-items:center;flex:none}
  .av svg{width:20px;height:20px}
  .av.big{width:44px;height:44px}
  .collapsed .nv span,.collapsed .bt,.collapsed .leaf{display:none}
  .collapsed .nv{justify-content:center;padding:12px 0}
  .collapsed .brand{justify-content:center;padding:22px 0 18px}
  .collapsed .me{justify-content:center}

  .main{min-width:0}
  .top{display:flex;align-items:center;gap:16px;padding:12px 24px;background:var(--topbg);border-bottom:1px solid var(--line);position:sticky;top:0;z-index:5}
  .ibtn{width:38px;height:38px;border-radius:10px;display:grid;place-items:center;position:relative}
  .ibtn svg{width:24px;height:24px}
  .ibtn:hover{background:var(--soft)}
  .bell b{position:absolute;top:2px;right:2px;background:#d9531e;color:#fff;border-radius:50%;width:16px;height:16px;font-size:.62rem;display:grid;place-items:center}
  .wrapdd{position:relative}
  .usr{display:flex;align-items:center;gap:10px;cursor:pointer;font-size:.88rem;font-weight:600}
  .usr svg{width:14px;height:14px}
  .dd{position:absolute;right:0;top:46px;background:var(--w);border:1px solid var(--line);border-radius:10px;box-shadow:0 6px 18px rgba(60,30,15,.18);padding:6px;min-width:230px;z-index:8}
  .dd button{width:100%;display:flex;gap:10px;align-items:center;text-align:left;padding:10px 12px;border-radius:8px;font-size:.82rem}
  .dd button svg{width:18px;height:18px;color:var(--brown2)}
  .dd button:hover{background:var(--soft)}
  .content{padding:22px 26px 40px}

  /* ===== Komponen ===== */
  .ph{display:flex;align-items:center;gap:14px;margin-bottom:18px;flex-wrap:wrap}
  .ph .pi{width:50px;height:50px;border-radius:13px;background:var(--brown2);color:#fff;display:grid;place-items:center;flex:none}
  .ph .pi svg{width:28px;height:28px}
  .ph h1{font-size:1.95rem;font-weight:700;color:var(--hcol);line-height:1.1}
  .ph p{color:var(--muted);margin-top:4px;font-size:.86rem}
  .ph .acts{display:flex;gap:12px;align-items:center}
  .card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px;box-shadow:0 1px 3px rgba(80,50,30,.05)}
  .card h2{font-size:1.05rem;font-weight:700}
  .ch{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;gap:10px;flex-wrap:wrap}
  .ch h2{display:flex;align-items:center;gap:10px}
  .ch h2 svg{width:22px;height:22px;color:var(--brown2)}
  .lnk{display:flex;align-items:center;gap:6px;font-size:.74rem;font-weight:600}
  .lnk svg{width:14px;height:14px}
  .btn{display:inline-flex;align-items:center;gap:8px;background:var(--brown);color:#fff;border-radius:10px;padding:10px 18px;font-weight:600;font-size:.86rem}
  .btn svg{width:18px;height:18px}
  .btn:hover{background:#47281c}
  .btn.ghost{background:var(--w);color:var(--ink);border:1px solid var(--line)}
  .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:14px;margin-bottom:16px}
  .st{display:flex;gap:12px;align-items:flex-start;background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px}
  .st i{width:48px;height:48px;border-radius:13px;background:#f1e0cf;color:var(--brown2);display:grid;place-items:center;flex:none}
  .st i.dk{background:var(--brown2);color:#fff}
  .st i svg{width:25px;height:25px}
  .st > div{min-width:0;flex:1}
  .st small{display:block;font-size:.76rem;color:var(--ink)}
  .st b{display:block;font-family:"Outfit",sans-serif;font-size:1.65rem;font-weight:600;line-height:1.3;white-space:nowrap}
  .st .sub{font-size:.74rem;color:var(--muted);display:block}
  .up{color:#2c9a4d;font-size:.78rem;font-weight:600}
  .dn{color:#c0392b;font-size:.78rem;font-weight:600}
  .up svg,.dn svg{display:inline;width:12px;height:12px;vertical-align:-1px}
  .suf{font-size:.72rem;color:var(--muted);font-weight:400}
  .sb{display:flex;align-items:center;gap:10px;background:var(--w);border:1px solid var(--line);border-radius:10px;padding:0 14px;height:42px;min-width:0}
  .sb svg{width:20px;height:20px;color:var(--muted);flex:none}
  .sb input{flex:1;min-width:0;border:0;outline:0;background:transparent;font-size:.84rem}
  .sb.wide{flex:1;max-width:620px;background:var(--sbg)}
  .sb.range select{border:0;outline:0;background:transparent;font-weight:600;font-size:.84rem;cursor:pointer}
  .sb.range svg{color:var(--brown2)}
  .sel{height:42px;border:1px solid var(--line);border-radius:10px;padding:0 12px;background:var(--w);font-size:.82rem}
  .sel.mini{height:32px;font-size:.72rem;padding:0 8px;border-radius:8px}

  /* Tabel */
  .tbw{overflow-x:auto;border:1px solid var(--line);border-radius:12px}
  .tb{width:100%;border-collapse:collapse;min-width:560px}
  .tb th{background:var(--head);text-align:left;font-weight:600;padding:12px 10px;font-size:.78rem;white-space:nowrap}
  .tb td{padding:10px;border-bottom:1px solid var(--line);font-size:.8rem;vertical-align:middle}
  .tb tr:last-child td{border-bottom:0}
  .tb tbody tr.clk{cursor:pointer}
  .tb tbody tr.clk:hover{background:var(--head)}
  .pn{display:flex;align-items:center;gap:10px}
  .th{position:relative;width:40px;height:40px;border-radius:9px;overflow:hidden;background:linear-gradient(135deg,#ead9c8,#c9a58a);display:grid;place-items:center;font-size:1.2rem;flex:none}
  .th img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
  .th.l{width:56px;height:56px;font-size:1.6rem}
  .th.s{width:34px;height:34px;font-size:1rem;border-radius:7px}

  /* Badge */
  .bd{display:inline-block;padding:3px 12px;border-radius:7px;font-size:.72rem;font-weight:600;white-space:nowrap}
  .s-selesai{background:#d6f0da;color:#2c7a3d}
  .s-diproses{background:#fbebc0;color:#a67712}
  .mt{display:inline-flex;align-items:center;gap:6px;font-size:.78rem}
  .mt svg{width:16px;height:16px}
  .mt.m-qris svg{color:#2b5db5}
  .mt.m-tunai svg{color:#7b5230}
  .mt.m-transfer svg{color:#6a4cb0}
  .mb{display:inline-block;padding:3px 12px;border-radius:7px;font-size:.72rem;font-weight:600}
  .mb.m-qris{background:#dbe7fb;color:#2b5db5}
  .mb.m-tunai{background:#d6f0da;color:#2c7a3d}
  .mb.m-transfer{background:#e3dcf7;color:#6a4cb0}

  /* Layout halaman */
  .dash{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:16px;align-items:start}
  .colf{display:flex;flex-direction:column;gap:16px;min-width:0}
  .two{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(0,1fr);gap:16px}
  .three{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,1fr) minmax(0,1fr);gap:16px;margin-bottom:16px}
  .bottom{display:grid;grid-template-columns:minmax(0,1.9fr) minmax(0,1fr);gap:16px;align-items:start}
  .hero{border-radius:16px;padding:26px 28px;color:#fff;min-height:150px;display:flex;flex-direction:column;justify-content:center;gap:8px}
  .hero h2{font-size:1.9rem;font-weight:700}
  .hero p{font-size:.95rem}
  .hero .sb.range{background:rgba(255,255,255,.14);border-color:rgba(255,255,255,.35);color:#fff;width:fit-content;margin-top:6px}
  .hero .sb.range svg{color:#fff}
  .hero .sb.range select{color:#fff}
  .hero option{color:#000}
  .leg{display:flex;gap:14px;font-size:.7rem;color:var(--muted);margin-bottom:4px}
  .leg i{display:inline-block;width:9px;height:9px;margin-right:5px;background:#5a3425}
  .leg i.b{background:#c9a285}
  .rk{display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid var(--line)}
  .rk:last-child{border-bottom:0}
  .rk .no{width:28px;height:28px;border-radius:50%;background:var(--head);display:grid;place-items:center;font-size:.78rem;flex:none}
  .rk .nm{flex:1;min-width:0}
  .rk b{display:block;font-size:.84rem;font-weight:600}
  .rk small{color:var(--muted);font-size:.72rem}
  .rk .rt{font-size:.8rem;font-weight:600;text-align:right}
  .bar{height:9px;border-radius:5px;background:var(--head);overflow:hidden;flex:1}
  .bar i{display:block;height:100%;border-radius:5px;background:var(--brown2)}
  .donut{display:flex;align-items:center;gap:14px}
  .donut .lg{flex:1;min-width:0}
  .donut .lr{display:flex;align-items:center;gap:8px;font-size:.8rem;margin-bottom:9px}
  .donut .lr i{width:10px;height:10px;border-radius:50%;flex:none}
  .donut .lr em{font-style:normal;margin-left:auto;font-weight:600}
  .sumbox{border:1px solid var(--line);border-radius:10px;padding:10px 12px;margin-top:12px}
  .sumbox h4{font-size:.8rem;margin-bottom:8px}
  .srow2{display:flex;align-items:center;gap:10px;padding:6px 0;font-size:.78rem}
  .srow2 svg{width:16px;height:16px;color:var(--brown2);flex:none}
  .srow2 span.v{margin-left:auto}
  .srow2 span.p{width:40px;text-align:right}
  .mini4{display:grid;grid-template-columns:1fr 1fr;gap:10px}
  .mini4 div{border:1px solid var(--line);border-radius:10px;padding:10px;background:var(--w)}
  .mini4 small{display:block;font-size:.66rem;color:var(--muted)}
  .mini4 b{display:block;font-family:"Outfit",sans-serif;font-size:1.05rem;margin:2px 0}
  .lrow{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--line);font-size:.82rem}
  .lrow:last-child{border-bottom:0}
  .lrow b{font-weight:600}
  .cr{display:flex;align-items:center;gap:12px;padding:9px 0}
  .cr i{width:42px;height:42px;border-radius:11px;background:var(--head);color:var(--brown2);display:grid;place-items:center;flex:none}
  .cr i svg{width:22px;height:22px}
  .cr .mid{flex:1;min-width:0;font-size:.8rem}
  .cr .mid small{color:var(--muted);font-size:.72rem}
  .cr .pc{font-size:.78rem}

  /* Modal */
  .mbg{position:fixed;inset:0;background:rgba(30,15,8,.5);display:grid;place-items:center;z-index:20;padding:16px}
  .modal{background:var(--card);border-radius:16px;width:min(480px,100%);padding:22px;max-height:92vh;overflow:auto}
  .modal h2{font-size:1.3rem;color:var(--hcol);margin-bottom:14px}
  .mfoot{display:flex;justify-content:flex-end;gap:10px;margin-top:10px}
  .dtl{display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--line);font-size:.84rem;gap:12px}
  .dtl span:first-child{color:var(--muted)}
  .toast{position:fixed;left:50%;bottom:30px;transform:translateX(-50%);background:#2b1d16;color:#fff;padding:10px 18px;border-radius:20px;font-size:.85rem;opacity:0;pointer-events:none;transition:opacity .25s;z-index:30}
  .toast.show{opacity:1}

  @media (max-width:1180px){
    .dash,.two,.three,.bottom{grid-template-columns:1fr}
    .stats{grid-template-columns:repeat(2,minmax(0,1fr))}
  }
  @media (max-width:760px){
    .content{padding:16px}
    .top{padding:10px 14px}
    .usr span.nm{display:none}
  }
  @media print{
    .side,.top,.noprint,.toast{display:none!important}
    .app{grid-template-columns:1fr!important}
    .content{padding:0}
    body{background:#fff}
  }
</style>
</head>
<body>

<div id="app"></div>
<div id="modal"></div>
<div class="toast" id="toast"></div>

<script>
/* ===================== KONFIGURASI & HELPER ===================== */
// Foto diambil dari public/foto (nama file = nama produk, mis. latte.jpg). Jika belum ada, tampil emoji.
const IMG = "{{ asset('foto') }}";

// ---- FOTO: otomatis dicari dengan ekstensi .jpg, .jpeg, .png, atau .webp di folder public/foto ----
const EXT = ['jpg', 'jpeg', 'png', 'webp'];
// Kalau nama file fotomu berbeda dari nama menu, tambahkan di sini:
//   'id-menu': ['nama-file-foto-tanpa-ekstensi']
const ALIAS = {'nasi-goreng-spesial':['nasgor'], 'nasi-goreng':['nasgor']};
function fotoTry(img) {
  const names = img.dataset.n.split(','), i = parseInt(img.dataset.i, 10) + 1;
  if (i >= names.length * EXT.length) { img.remove(); return; }
  img.dataset.i = i;
  img.src = IMG + '/' + names[Math.floor(i / EXT.length)] + '.' + EXT[i % EXT.length];
}
const imgTag = (id, file, alt) => {
  const names = [String(file).replace(/\.[a-z]+$/i, '')].concat(ALIAS[id] || []);
  return `<img src="${IMG}/${names[0]}.${EXT[0]}" data-n="${names.join(',')}" data-i="0" alt="${alt || ''}" onerror="fotoTry(this)">`;
};
const bgUrls = name => EXT.map(e => `url('${IMG}/${name}.${e}') center/cover`).join(',');
const BLN = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sept','Okt','Nov','Des'];

const pad = n => String(n).padStart(2, '0');
const $ = s => document.querySelector(s);
const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
const num = n => n.toLocaleString('id-ID');
const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const slug = s => String(s).normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') || 'item';
function rng(seed) { let s = seed >>> 0; return () => { s = (Math.imul(s, 1664525) + 1013904223) >>> 0; return s / 4294967296; }; }

/* ===================== DATA DARI DATABASE ===================== */
const EMO = { 'Kopi':'☕', 'Minuman':'🧋', 'Makanan':'🍽️' };
const KCOLOR = ['#472a1c', '#8a5a41', '#c9a285', '#b88b6b', '#d8b99b'];
const API_PEMILIK = "{{ url('/pemilik/data/dashboard') }}";
let PROD = [], PMAP = {}, TRX = [], DAYS = [];
// Status tampilan dashboard Pemilik
let collapsed = false;
let page = 'dashboard';
let q = '';
let userMenu = false;
let bellOpen = false;
let terAll = false;

let period = '7d';
let chartN = 7;
let topRange = '7d';
let dataLoading = true, dataLoadError = '';
const prodBy = id => PMAP[String(id)] || {id:String(id), nama:'Menu tidak tersedia', harga:0, emoji:'🍽️', kat:'Lainnya', foto:'x.jpg'};

function parseDbDate(value) {
  if (!value) return NaN;
  const text = String(value).trim();
  const normalized = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}/.test(text) ? text.replace(' ', 'T') : text;
  return new Date(normalized).getTime();
}
function ageInDays(ts) {
  const d = new Date(ts), now = new Date();
  const a = new Date(now.getFullYear(), now.getMonth(), now.getDate()).getTime();
  const b = new Date(d.getFullYear(), d.getMonth(), d.getDate()).getTime();
  return Math.floor((a - b) / 86400000);
}
function paidStatus(status) {
  return ['berhasil','lunas','success','paid','selesai'].includes(String(status || '').toLowerCase());
}
function statusLabel(status) {
  const s = String(status || '-').toLowerCase();
  return s ? s.charAt(0).toUpperCase() + s.slice(1) : '-';
}
function rebuild(payload) {
  const menus = Array.isArray(payload?.menus) ? payload.menus : [];
  PROD = menus.map(m => {
    const nama = String(m.nama_menu || 'Menu');
    const kat = String(m.nama_kategori || 'Lainnya');
    return {id:String(m.id_menu), nama, kat, harga:Number(m.harga || 0), emoji:EMO[kat] || '🍽️', foto:slug(nama) + '.jpg'};
  });
  PMAP = {};
  PROD.forEach(p => PMAP[p.id] = p);

  const grouped = new Map();
  (Array.isArray(payload?.transaksi) ? payload.transaksi : []).forEach(row => {
    const id = String(row.id_transaksi);
    let t = grouped.get(id);
    if (!t) {
      const ts = parseDbDate(row.tanggal_transaksi);
      t = {
        trx:'TRX-' + String(row.id_transaksi).padStart(4, '0'),
        idDatabase:Number(row.id_transaksi), idPesanan:Number(row.id_pesanan),
        ts, nama:row.nama_pelanggan || 'Pelanggan tidak diketahui',
        metode:row.nama_metode || 'Tidak diketahui',
        status:statusLabel(row.status_transaksi), kasir:'-', items:[],
        totalDatabase:Number(row.total_bayar || 0), d:ageInDays(ts)
      };
      grouped.set(id, t);
    }
    if (row.id_menu !== null && row.id_menu !== undefined) {
      const menuId = String(row.id_menu);
      if (!PMAP[menuId]) {
        const nama = String(row.nama_menu || 'Menu tidak tersedia');
        PMAP[menuId] = {id:menuId, nama, kat:String(row.nama_kategori || 'Lainnya'), harga:Number(row.harga_menu || 0), emoji:EMO[row.nama_kategori] || '🍽️', foto:slug(nama) + '.jpg'};
        PROD.push(PMAP[menuId]);
      }
      t.items.push({id:menuId, qty:Number(row.jumlah || 0), harga:Number(row.harga_satuan || 0), subtotal:Number(row.subtotal || 0)});
    }
  });

  TRX = Array.from(grouped.values())
    .filter(t => Number.isFinite(t.ts) && t.d >= 0 && t.d < 60 && paidStatus(t.status))
    .map(t => {
      const qty = t.items.reduce((sum, item) => sum + item.qty, 0);
      const sub = t.items.reduce((sum, item) => sum + (item.subtotal || item.harga * item.qty), 0);
      t.c = {qty, sub, diskon:Math.max(0, sub - t.totalDatabase), total:t.totalDatabase};
      return t;
    })
    .sort((a, b) => b.ts - a.ts);

  DAYS = Array.from({length:60}, () => ({rev:0, count:0, qty:0}));
  TRX.forEach(t => {
    const day = DAYS[t.d];
    if (day) { day.rev += t.c.total; day.count++; day.qty += t.c.qty; }
  });
}
async function loadDashboardData() {
  dataLoading = true;
  dataLoadError = '';
  try {
    const response = await fetch(API_PEMILIK, {headers:{Accept:'application/json'}, credentials:'same-origin', cache:'no-store'});
    const payload = await response.json().catch(() => ({}));
    if (!response.ok) throw new Error(payload.message || `Gagal mengambil data (HTTP ${response.status})`);
    rebuild(payload);
  } catch (error) {
    dataLoadError = error.message || 'Gagal mengambil data dari database.';
    console.error('Gagal memuat dashboard pemilik:', error);
    PROD = []; PMAP = {}; TRX = [];
    DAYS = Array.from({length:60}, () => ({rev:0, count:0, qty:0}));
  } finally {
    dataLoading = false;
    if (typeof render === 'function') render();
  }
}

/* ===================== PERIODE & RINGKASAN ===================== */
const PER = {today:{len:1, label:'Hari Ini'}, '7d':{len:7, label:'7 Hari Terakhir'}, '30d':{len:30, label:'30 Hari Terakhir'}};
const dstr = d => `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()}`;
const dAgo = n => { const d = new Date(); d.setDate(d.getDate() - n); return d; };
const rangeText = k => `${dstr(dAgo(PER[k].len - 1))} - ${dstr(dAgo(0))}`;
const rangeTrx = (k, shift) => { const len = PER[k].len, from = (shift || 0) * len; return TRX.filter(t => t.d >= from && t.d < from + len); };
const fmtTgl = ts => { const d = new Date(ts); return `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()} • ${pad(d.getHours())}:${pad(d.getMinutes())}`; };
const fmtJam = ts => { const d = new Date(ts); return `${pad(d.getHours())}:${pad(d.getMinutes())}`; };
const sufLabel = () => period === 'today' ? 'dari kemarin' : 'dari periode sebelumnya';

function summ(list) {
  const s = {rev:0, count:list.length, qty:0, cust:new Set(), metode:{}, kat:{}, prod:{}};
  list.forEach(t => {
    s.rev += t.c.total; s.qty += t.c.qty; s.cust.add(t.nama);
    s.metode[t.metode] = (s.metode[t.metode] || 0) + t.c.total;
    t.items.forEach(i => {
      const p = prodBy(i.id), rv = Number(i.subtotal || (i.harga * i.qty) || 0);
      s.kat[p.kat] = (s.kat[p.kat] || 0) + rv;
      const e = s.prod[i.id] || (s.prod[i.id] = {p, qty:0, rev:0});
      e.qty += i.qty; e.rev += rv;
    });
  });
  s.avg = s.count ? s.rev / s.count : 0;
  s.top = Object.values(s.prod).sort((a, b) => b.qty - a.qty || b.rev - a.rev);
  return s;
}
const gr = (a, b) => b ? Math.round((a - b) / b * 100) : 0;
const sumDays = (from, len) => { let r = 0; for (let d = from; d < from + len; d++) r += DAYS[d] ? DAYS[d].rev : 0; return r; };

function seriesFor(n) {
  const labels = [], revs = [], cnts = [];

  for (let d = n - 1; d >= 0; d--) {
    const dt = dAgo(d);

    labels.push(`${dt.getDate()} ${BLN[dt.getMonth()]}`);

    const dataHari = DAYS[d] || { rev: 0, count: 0 };

    revs.push(Number(dataHari.rev) || 0);
    cnts.push(Number(dataHari.count) || 0);
  }

  return { labels, revs, cnts };
}
const nice = v => { const p = Math.pow(10, Math.floor(Math.log10(v))); const f = v / p; return (f <= 1 ? 1 : f <= 2 ? 2 : f <= 4 ? 4 : f <= 8 ? 8 : 10) * p; };

/* ===================== IKON ===================== */
const ic = (p, x = '') => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ${x}>${p}</svg>`;
const I = {
  home:ic('<path d="M3 11l9-8 9 8M5 10v10h5v-6h4v6h5V10"/>'),
  report:ic('<rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h4"/>'),
  star:ic('<path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1-4.4-4.3 6.1-.9z"/>'),
  box:ic('<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9zM4 7.5l8 4.5 8-4.5M12 12v9"/>'),
  logout:ic('<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>'),
  search:ic('<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>','stroke-width="2"'),
  bell:ic('<path d="M6 16v-5a6 6 0 0 1 12 0v5l2 2H4zM10 21a2 2 0 0 0 4 0"/>'),
  menu:ic('<path d="M4 6h16M4 12h16M4 18h16"/>','stroke-width="2.2"'),
  chevD:ic('<path d="M5 9l7 7 7-7"/>','stroke-width="2.2"'),
  arrow:ic('<path d="M4 12h16M14 6l6 6-6 6"/>','stroke-width="2"'),
  cal:ic('<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>'),
  wallet:ic('<path d="M3 7a2 2 0 0 1 2-2h13v3M3 7v11a2 2 0 0 0 2 2h15V8H5a2 2 0 0 1-2-1zM16 14h2"/>'),
  cup:ic('<path d="M5 11h12v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6zM17 12h1.5a2.5 2.5 0 0 1 0 5H16M3 21h18M9 3c-1 1.5 1 2.5 0 4M13 3c-1 1.5 1 2.5 0 4"/>'),
  drink:ic('<path d="M6 8h12l-1.5 12h-9zM6 12h12M13 8l2-5h3"/>'),
  food:ic('<circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="2.6"/><path d="M3.5 4v6a1.5 1.5 0 0 0 3 0V4M5 4v16M20.5 4c-1.5 1-2.5 3-2.5 6h2.5V20"/>'),
  bag:ic('<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V4h6v3M3 13h18"/>'),
  user:ic('<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-6 8-6s8 2 8 6"/>'),
  users:ic('<circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-4 3-6 7-6s7 2 7 6M16 4.5a3.5 3.5 0 0 1 0 7M18 14c2.5.6 4 2.5 4 6"/>'),
  up:ic('<path d="M12 19V5M5 12l7-7 7 7"/>','stroke-width="2.4"'),
  down:ic('<path d="M12 5v14M5 12l7 7 7-7"/>','stroke-width="2.4"'),
  download:ic('<path d="M12 4v11M7 11l5 5 5-5M4 20h16"/>'),
  coin:ic('<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3.5"/>'),
  qr:ic('<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM19 14h2M14 19h2M18 18h3v3h-3z"/>','stroke-width="1.6"'),
  bank:ic('<path d="M3 10l9-6 9 6M5 10v8M9 10v8M15 10v8M19 10v8M3 20h18"/>'),
  percent:ic('<path d="M19 5L5 19"/><circle cx="7" cy="7" r="2.5"/><circle cx="17" cy="17" r="2.5"/>'),
  cart:ic('<path d="M2 3h3l2.6 12.2a2 2 0 0 0 2 1.6h8.3a2 2 0 0 0 2-1.5L21.5 8H6"/><circle cx="10" cy="20.5" r="1.3"/><circle cx="18" cy="20.5" r="1.3"/>'),
  printer:ic('<path d="M6 9V3h12v6M6 18H4a1 1 0 0 1-1-1v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1h-2"/><rect x="6" y="14" width="12" height="7"/>')
};
const KATICON = {'Kopi':I.cup, 'Minuman':I.drink, 'Non-Kopi':I.drink, 'Makanan':I.food};

const LOGO = `<svg viewBox="0 0 100 100" fill="#ffefd5">
  <g fill="none" stroke="#ffefd5" stroke-width="2.6" stroke-linecap="round">
    <path d="M36 6c-4 4 4 7 0 12s-4 6 0 8"/><path d="M50 2c-4 5 4 8 0 14s-4 8 0 10"/><path d="M64 6c-4 4 4 7 0 12s-4 6 0 8"/>
  </g>
  <path d="M12 38h62v8c0 16-9 27-22 27H36C22 73 12 62 12 46z"/>
  <path d="M74 44h6c8 0 11 4 11 8 0 7-8 14-17 14v-5c6 0 11-4 11-8 0-2-2-3-5-3h-6z"/>
  <path d="M24 44c1 12 8 20 16 22-9-3-13-12-12-22z" fill="#2f1b12"/>
  <ellipse cx="46" cy="83" rx="44" ry="6"/></svg>`;
const LEAF = `<svg class="leaf" viewBox="0 0 200 260" fill="none" stroke="#c89b7b" stroke-width="2.2"><path d="M30 240c-20-60 10-120 70-150 10 60-10 120-70 150z"/><path d="M30 240c20-50 40-90 70-150"/><path d="M110 250c-10-50 20-100 70-120 5 50-20 100-70 120z"/><path d="M110 250c20-40 40-80 70-120"/><circle cx="60" cy="150" r="14"/><circle cx="150" cy="190" r="12"/></svg>`;

/* ===================== KOMPONEN KECIL ===================== */
const thumb = (o, c = '') => `<div class="th ${c}"><span>${o.emoji || '🍽️'}</span>${imgTag(o.id, o.foto)}</div>`;
const stBadge = s => `<span class="bd s-${slug(s)}">${s}</span>`;
const METICON = {Tunai:I.coin, QRIS:I.qr, Transfer:I.bank};
const mIcon = m => `<span class="mt m-${m.toLowerCase()}">${METICON[m] || ''}${m}</span>`;
const mBadge = m => `<span class="mb m-${m.toLowerCase()}">${m}</span>`;
const trend = (v, suf) => `<span class="${v >= 0 ? 'up' : 'dn'}">${v >= 0 ? I.up : I.down} ${Math.abs(v)}%</span>${suf ? ` <span class="suf">${suf}</span>` : ''}`;
const stat = (icon, label, val, extra, dark) => `<div class="st"><i class="${dark ? 'dk' : ''}">${icon}</i><div><small>${label}</small><b>${val}</b>${extra || ''}</div></div>`;
const pageHead = (icon, title, sub, acts) => `<div class="ph"><span class="pi">${icon}</span><div class="grow"><h1>${title}</h1><p>${sub}</p></div><div class="acts">${acts || ''}</div></div>`;
const rangeSel = () => `<label class="sb range noprint">${I.cal}<select onchange="setPeriod(this.value)">${Object.keys(PER).map(k => `<option value="${k}" ${period === k ? 'selected' : ''}>${rangeText(k)}</option>`).join('')}</select></label>`;
const periodNames = (cur, fn) => `<select class="sel mini" onchange="${fn}(this.value)">${Object.keys(PER).map(k => `<option value="${k}" ${cur === k ? 'selected' : ''}>${PER[k].label}</option>`).join('')}</select>`;
const pct = (v, t) => t ? Math.round(100 * v / t) : 0;

/* ===================== GRAFIK ===================== */
function chartBars(labels, revs, cnts) {
  const W = 560, H = 250, L = 66, R = 12, T = 12, B = 30, w = W - L - R, h = H - T - B;
  const max = nice(Math.max(...revs, 1) * 1.05), cmax = Math.max(...cnts, 1) * 1.25;
  const step = w / labels.length, bw = Math.min(step * 0.5, 36), k = Math.ceil(labels.length / 8);
  let g = '';
  for (let i = 0; i <= 4; i++) {
    const y = T + h - h * i / 4;
    g += `<line x1="${L}" x2="${W - R}" y1="${y}" y2="${y}" style="stroke:var(--line)"/><text x="${L - 8}" y="${y + 4}" text-anchor="end" font-size="10" style="fill:var(--muted)">${num(max * i / 4)}</text>`;
  }
  const bars = revs.map((v, i) => { const bh = h * v / max; return `<rect x="${L + step * i + (step - bw) / 2}" y="${T + h - bh}" width="${bw}" height="${bh}" rx="3" fill="#c9a285"/>`; }).join('');
  const pts = cnts.map((v, i) => [L + step * i + step / 2, T + h - h * v / cmax]);
  const line = `<polyline points="${pts.map(p => p.join(',')).join(' ')}" fill="none" stroke="#5a3425" stroke-width="2"/>` + pts.map(p => `<circle cx="${p[0]}" cy="${p[1]}" r="3.3" fill="#5a3425"/>`).join('');
  const lab = labels.map((d, i) => i % k === 0 ? `<text x="${L + step * i + step / 2}" y="${H - 9}" text-anchor="middle" font-size="10" style="fill:var(--muted)">${d}</text>` : '').join('');
  return `<svg viewBox="0 0 ${W} ${H}" width="100%">${g}${bars}${line}${lab}</svg>`;
}

function donut(parts, total, l1, l2, l3) {
  const R = 58, C = 2 * Math.PI * R;
  let off = 0, segs = '';
  parts.forEach(p => {
    const len = total ? C * p.v / total : 0;
    segs += `<circle cx="80" cy="80" r="${R}" fill="none" stroke="${p.c}" stroke-width="26" stroke-dasharray="${len} ${C - len}" stroke-dashoffset="${-off}" transform="rotate(-90 80 80)"/>`;
    off += len;
  });
  return `<svg viewBox="0 0 160 160" width="165" height="165" style="flex:none"><circle cx="80" cy="80" r="${R}" fill="none" stroke="#eadfd2" stroke-width="26" opacity=".5"/>${segs}
    <text x="80" y="72" text-anchor="middle" font-size="8.5" style="fill:var(--muted)">${l1}</text>
    <text x="80" y="88" text-anchor="middle" font-size="12" font-weight="700" style="fill:var(--ink)">${l2}</text>
    ${l3 ? `<text x="80" y="101" text-anchor="middle" font-size="8.5" style="fill:var(--muted)">${l3}</text>` : ''}</svg>`;
}

/* ===================== KERANGKA ===================== */
const NAV = [['dashboard','Dashboard',I.home],['laporan','Laporan Penjualan',I.report],['terlaris','Produk Terlaris',I.star]];

function sidebar() {
  return `<aside class="side">
    <div class="brand">${LOGO}<div class="bt"><b>BeanByte</b><small>Kopi • Rasa • Cerita</small></div></div>
    <nav>${NAV.map(([k, l, i]) => `<button class="nv ${page === k ? 'on' : ''}" onclick="nav('${k}')" title="${l}">${i}<span>${l}</span></button>`).join('')}</nav>
    ${LEAF}
    <div class="sfoot">
      <div class="me"><span class="av big">${I.user}</span><div class="bt"><b>Pemilik</b><small>Owner</small></div></div>
      <button class="nv" style="margin:0" onclick="logout()" title="Logout">${I.logout}<span>Logout</span></button>
    </div></aside>`;
}

function topbar() {
  return `<header class="top noprint">
    <button class="ibtn" onclick="toggleSide()" aria-label="Menu">${I.menu}</button>
    <div class="sb wide">${I.search}<input data-q value="${esc(q)}" placeholder="Cari produk terlaris atau kategori..." oninput="setQ(this.value)" onkeydown="topEnter(event)"></div>
    <span class="grow"></span>
    <div class="wrapdd"><button class="ibtn bell" onclick="toggleBell(event)" aria-label="Notifikasi">${I.bell}<b>1</b></button>
      ${bellOpen ? `<div class="dd"><button onclick="nav('laporan')">${I.report}Laporan penjualan hari ini siap</button></div>` : ''}</div>
    <div class="wrapdd"><div class="usr" onclick="toggleUser(event)"><span class="av">${I.user}</span><span class="nm">Pemilik</span>${I.chevD}</div>
      ${userMenu ? `<div class="dd" style="min-width:140px"><button onclick="logout()">${I.logout}Logout</button></div>` : ''}</div>
  </header>`;
}

/* ===================== HALAMAN: DASHBOARD ===================== */
function pDashboard() {
  const c = summ(rangeTrx(period)), pv = summ(rangeTrx(period, 1)), suf = sufLabel();
  const sr = seriesFor(chartN);
  const topR = summ(rangeTrx(topRange)).top.slice(0, 5);
  const w7 = summ(rangeTrx('7d')), w7p = summ(rangeTrx('7d', 1));
  const parts = Object.keys(c.kat).map((k, i) => ({n:k, c:KCOLOR[i % KCOLOR.length], v:c.kat[k] || 0}));
  const katTotal = parts.reduce((s, p) => s + p.v, 0);
  return `<div class="dash"><div class="colf">
    <div class="hero" style="background:linear-gradient(90deg,rgba(35,18,10,.92) 0%,rgba(35,18,10,.65) 50%,rgba(35,18,10,.15) 100%),${bgUrls('banner')},#4a2b1c">
      <h2>Selamat Datang, Pemilik!</h2><p>Pantau perkembangan bisnis BeanByte secara real-time.</p>${dataLoadError ? `<p style="color:#ffd7c2">Data belum dapat dimuat: ${esc(dataLoadError)}</p>` : (dataLoading ? '<p>Memuat data database...</p>' : '')}${rangeSel()}</div>
    <div class="stats" style="margin:0">
      ${stat(I.wallet, 'Total Pendapatan', rp(c.rev), trend(gr(c.rev, pv.rev), suf), true)}
      ${stat(I.report, 'Total Transaksi', c.count, trend(gr(c.count, pv.count), suf), true)}
      ${stat(I.cup, 'Total Pesanan', c.qty, trend(gr(c.qty, pv.qty), suf), true)}
      ${stat(I.users, 'Pelanggan', num(c.cust.size), trend(gr(c.cust.size, pv.cust.size), suf), true)}
    </div>
    <div class="two">
      <div class="card"><div class="ch"><h2>${I.bag}Grafik Penjualan</h2>
        <select class="sel mini" onchange="setChartN(this.value)">${[7, 14, 30].map(n => `<option value="${n}" ${chartN === n ? 'selected' : ''}>${n} Hari Terakhir</option>`).join('')}</select></div>
        <div class="leg"><span><i class="b"></i>Pendapatan</span><span><i></i>Jumlah Transaksi</span></div>${chartBars(sr.labels, sr.revs, sr.cnts)}</div>
      <div class="card"><div class="ch"><h2>Produk Terlaris</h2>${periodNames(topRange, 'setTopRange')}</div>
        ${topR.map((e, i) => `<div class="rk"><span class="no">${i + 1}</span>${thumb(e.p, 's')}<div class="nm"><b>${esc(e.p.nama)}</b><small>${num(e.qty)} Terjual</small></div><div class="rt">${rp(e.rev)}</div></div>`).join('') || '<p class="empty">Belum ada data</p>'}</div>
    </div>
  </div>
  <div class="colf">
    <div class="card"><div class="ch"><h2>${I.cal}Ringkasan Penjualan</h2>${periodNames(period, 'setPeriod')}</div>
      <div class="donut">${donut(parts, katTotal, 'Total Penjualan', rp(c.rev), '')}<div class="lg">${parts.map(p => `<div class="lr"><i style="background:${p.c}"></i>${p.n}<em>${pct(p.v, katTotal)}%</em></div>`).join('')}</div></div>
      <div class="sumbox"><h4>Transaksi ${PER[period].label}</h4>
        ${Object.keys(c.metode).map(m => `<div class="srow2">${METICON[m] || I.wallet}${esc(m)}<span class="v">${rp(c.metode[m] || 0)}</span><span class="p">${pct(c.metode[m] || 0, c.rev)}%</span></div>`).join('') || '<p class="empty">Belum ada transaksi berhasil</p>'}</div></div>
    <div class="card"><div class="ch"><h2>${I.report}Laporan Singkat</h2><button class="lnk" onclick="nav('laporan')">Lihat Detail ${I.arrow}</button></div>
      <div class="mini4">
        <div><small>Total Penjualan (7 Hari)</small><b>${rp(w7.rev)}</b>${trend(gr(w7.rev, w7p.rev))}</div>
        <div><small>Jumlah Transaksi (7 Hari)</small><b>${num(w7.count)}</b>${trend(gr(w7.count, w7p.count))}</div>
        <div><small>Produk Terjual (7 Hari)</small><b>${num(w7.qty)}</b>${trend(gr(w7.qty, w7p.qty))}</div>
        <div><small>Rata-rata per Transaksi</small><b>${rp(w7.avg)}</b>${trend(gr(w7.avg, w7p.avg))}</div>
      </div></div>
  </div></div>`;
}

/* ===================== HALAMAN: LAPORAN PENJUALAN ===================== */
function pLaporan() {
  const c = summ(rangeTrx(period)), pv = summ(rangeTrx(period, 1)), suf = 'dari periode sebelumnya';
  const n = Math.max(7, PER[period].len), sr = seriesFor(n);
  const parts = Object.keys(c.metode).map((m, i) => ({n:m, c:KCOLOR[i % KCOLOR.length], v:c.metode[m] || 0}));
  const top = c.top.slice(0, 5), list = rangeTrx(period).slice(0, 8);
  const t0 = DAYS[0].rev, t1 = DAYS[1].rev;
  return `${pageHead(I.report, 'Laporan Penjualan', 'Lihat ringkasan dan detail penjualan berdasarkan periode yang dipilih', rangeSel() + `<button class="btn noprint" onclick="exportPdf()">${I.download}Export PDF</button>`)}
    <div class="stats">
      ${stat(I.wallet, 'Total Penjualan', rp(c.rev), trend(gr(c.rev, pv.rev), suf))}
      ${stat(I.report, 'Jumlah Transaksi', num(c.count), trend(gr(c.count, pv.count), suf))}
      ${stat(I.cart, 'Rata-rata Transaksi', rp(c.avg), trend(gr(c.avg, pv.avg), suf))}
      ${stat(I.box, 'Produk Terjual', num(c.qty), trend(gr(c.qty, pv.qty), suf))}
    </div>
    <div class="dash"><div class="colf">
      <div class="two" style="grid-template-columns:minmax(0,1.5fr) minmax(0,1fr)">
        <div class="card"><div class="ch"><h2 style="font-size:1rem">Tren Penjualan</h2><div class="leg"><span><i class="b"></i>Total Penjualan</span><span><i></i>Jumlah Transaksi</span></div></div>${chartBars(sr.labels, sr.revs, sr.cnts)}</div>
        <div class="card"><div class="ch"><h2 style="font-size:1rem">Penjualan per Metode Pembayaran</h2></div>
          <div class="donut" style="flex-direction:column;align-items:stretch">
            <div style="display:flex;justify-content:center">${donut(parts, c.rev, 'Total', rp(c.rev), '')}</div>
            <div class="lg">${parts.map(p => `<div class="lr"><i style="background:${p.c}"></i>${p.n}<em>${pct(p.v, c.rev)}%</em></div>`).join('')}</div></div></div>
      </div>
      <div class="card"><div class="ch"><h2 style="font-size:1rem">Detail Transaksi Penjualan</h2></div>
        <div class="tbw"><table class="tb"><thead><tr><th>No.</th><th>Tanggal &amp; Waktu</th><th>No. Transaksi</th><th>Nama Pelanggan</th><th>Produk</th><th>Jumlah</th><th>Total</th><th>Metode Pembayaran</th></tr></thead><tbody>
          ${list.map((t, i) => `<tr class="clk" onclick="openTrx('${t.trx}')"><td>${i + 1}</td><td>${fmtTgl(t.ts).replace('•', '')}</td><td>${t.trx}</td><td>${esc(t.nama)}</td><td>${esc(t.items.map(x => prodBy(x.id).nama).join(', ') || '-')}</td><td>${t.c.qty}</td><td>${rp(t.c.total)}</td><td>${mBadge(t.metode)}</td></tr>`).join('') || '<tr><td colspan="8" class="empty">Belum ada transaksi berhasil pada periode ini</td></tr>'}
        </tbody></table></div></div>
    </div>
    <div class="colf">
      <div class="card"><div class="ch"><h2>${I.cal}Ringkasan Penjualan</h2></div>
        <div class="lrow"><span>Penjualan Hari Ini</span><span><b>${rp(t0)}</b> &nbsp;${trend(gr(t0, t1))}</span></div>
        <div class="lrow"><span>Penjualan Kemarin</span><b>${rp(t1)}</b></div>
        <div class="lrow"><span>Penjualan 7 Hari Terakhir</span><b>${rp(sumDays(0, 7))}</b></div>
        <div class="lrow"><span>Penjualan 30 Hari Terakhir</span><b>${rp(sumDays(0, 30))}</b></div></div>
      <div class="card"><div class="ch"><h2>${I.report}Perbandingan Penjualan</h2></div>
        <div class="lrow"><span>Hari Ini vs Kemarin</span>${trend(gr(t0, t1))}</div>
        <div class="lrow"><span>Minggu Ini vs Minggu Lalu</span>${trend(gr(sumDays(0, 7), sumDays(7, 7)))}</div>
        <div class="lrow"><span>Bulan Ini vs Bulan Lalu</span>${trend(gr(sumDays(0, 30), sumDays(30, 30)))}</div></div>
      <div class="card"><div class="ch"><h2 style="font-size:.95rem">${I.star}Produk dengan Penjualan Terbanyak</h2><button class="lnk" onclick="nav('terlaris')">Lihat Semua</button></div>
        ${top.map((e, i) => `<div class="rk"><span class="no">${i + 1}</span>${thumb(e.p, 's')}<div class="nm"><b>${esc(e.p.nama)}</b><small>${num(e.qty)} terjual</small></div><div class="rt">${rp(e.rev)}</div></div>`).join('') || '<p class="empty">Belum ada data</p>'}</div>
    </div></div>`;
}

/* ===================== HALAMAN: PRODUK TERLARIS ===================== */
function terDetail() {
  const c = summ(rangeTrx(period)), pv = summ(rangeTrx(period, 1)), kw = q.trim().toLowerCase();
  let list = c.top;
  list = kw ? list.filter(e => (e.p.nama + ' ' + e.p.kat).toLowerCase().includes(kw)) : list.slice(0, terAll ? 15 : 5);
  if (!list.length) return '<p class="empty">Produk tidak ditemukan</p>';
  return `<div class="tbw"><table class="tb"><thead><tr><th>No.</th><th>Produk</th><th>Kategori</th><th>Jumlah Terjual</th><th>Total Penjualan</th><th>Kontribusi</th><th>Trend</th></tr></thead><tbody>
    ${list.map(e => { const pq = pv.prod[e.p.id] ? pv.prod[e.p.id].qty : 0; return `<tr><td>${c.top.indexOf(e) + 1}</td><td><div class="pn">${thumb(e.p, 's')}${esc(e.p.nama)}</div></td><td>${esc(e.p.kat)}</td><td>${num(e.qty)}</td><td>${rp(e.rev)}</td><td>${pct(e.qty, c.qty)}%</td><td>${trend(gr(e.qty, pq))}</td></tr>`; }).join('')}
  </tbody></table></div>`;
}

function pTerlaris() {
  const c = summ(rangeTrx(period)), pv = summ(rangeTrx(period, 1));
  const top = c.top, t5 = top.slice(0, 5), t5q = t5.reduce((s, e) => s + e.qty, 0);
  const w = summ(rangeTrx('7d')), wp = summ(rangeTrx('7d', 1));
  const cols = ['#472a1c', '#6b3f2d', '#a8785c', '#c9a285', '#dcc3ad'];
  const parts = t5.map((e, i) => ({n:e.p.nama, c:cols[i], v:e.qty})).concat([{n:'Produk Lainnya', c:'#d3cbc3', v:Math.max(0, c.qty - t5q)}]);
  const kats = {};
  top.forEach(e => { kats[e.p.kat] = (kats[e.p.kat] || 0) + e.qty; });
  const katList = Object.keys(kats).sort((a, b) => kats[b] - kats[a]);
  const max = t5.length ? t5[0].qty : 1;
  return `${pageHead(I.star, 'Produk Terlaris', 'Produk yang paling banyak terjual dalam periode yang dipilih', rangeSel() + `<button class="btn noprint" onclick="exportPdf()">${I.download}Export PDF</button>`)}
    <div class="stats">
      ${stat(I.box, 'Total Produk Terjual', num(c.qty), trend(gr(c.qty, pv.qty), 'dari periode sebelumnya'))}
      ${stat(I.cart, 'Produk Terlaris', t5.length ? esc(t5[0].p.nama) : '-', `<span class="sub">Terjual ${t5.length ? num(t5[0].qty) : 0} cup</span>`)}
      ${stat(I.percent, 'Kontribusi Top 5 Produk', pct(t5q, c.qty) + '%', '<span class="sub">dari total penjualan produk</span>')}
      ${stat(I.bag, 'Rata-rata per Produk', top.length ? num(Math.round(c.qty / top.length)) : 0, '<span class="sub">unit per produk</span>')}
    </div>
    <div class="three">
      <div class="card"><div class="ch"><h2 style="font-size:1.05rem">Top 5 Produk Terlaris</h2></div>
        ${t5.map((e, i) => `<div class="rk"><span class="no">${i + 1}</span>${thumb(e.p, 'l')}<div class="nm" style="max-width:130px"><b>${esc(e.p.nama)}</b><small>${num(e.qty)} terjual</small></div><div class="bar"><i style="width:${Math.round(100 * e.qty / max * 0.95)}%"></i></div><span style="width:34px;text-align:right;font-size:.78rem">${pct(e.qty, c.qty)}%</span></div>`).join('') || '<p class="empty">Belum ada data</p>'}</div>
      <div class="card"><div class="ch"><h2 style="font-size:1.05rem">Persentase Penjualan Produk</h2></div>
        <div style="display:flex;justify-content:center;margin:8px 0">${donut(parts, c.qty, 'Total Penjualan', num(c.qty), 'produk')}</div>
        ${parts.map(p => `<div class="lr" style="display:flex;align-items:center;gap:8px;font-size:.8rem;margin-bottom:8px"><i style="width:10px;height:10px;border-radius:50%;background:${p.c};flex:none"></i>${esc(p.n)}<em style="font-style:normal;margin-left:auto;font-weight:600">${pct(p.v, c.qty)}%</em></div>`).join('')}</div>
      <div class="card"><div class="ch"><h2 style="font-size:1.05rem">${I.cal}Produk Terlaris Minggu Ini</h2></div>
        ${w.top.slice(0, 5).map((e, i) => { const prevQ = wp.prod[e.p.id] ? wp.prod[e.p.id].qty : 0; return `<div class="rk"><span class="no">${i + 1}</span>${thumb(e.p, 's')}<div class="nm"><b>${esc(e.p.nama)}</b><small>${num(e.qty)} terjual</small></div>${trend(gr(e.qty, prevQ))}</div>`; }).join('') || '<p class="empty">Belum ada data</p>'}</div>
    </div>
    <div class="bottom">
      <div class="card"><div class="ch"><h2>${I.box}Detail Produk Terlaris</h2><button class="lnk" onclick="toggleTerAll()">${terAll ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua'} ${I.arrow}</button></div>
        <div id="tbl">${terDetail()}</div></div>
      <div class="card"><div class="ch"><h2 style="font-size:.95rem">Produk Terlaris Berdasarkan Kategori</h2></div>
        ${katList.map(k => `<div class="cr"><i>${KATICON[k] || I.box}</i><div class="mid"><div style="display:flex;justify-content:space-between"><span>${esc(k)}</span><span class="pc">${pct(kats[k], c.qty)}%</span></div><small>${num(kats[k])} terjual</small><div class="bar" style="margin-top:4px"><i style="width:${pct(kats[k], c.qty)}%"></i></div></div></div>`).join('') || '<p class="empty">Belum ada data</p>'}</div>
    </div>`;
}

const PAGES = {dashboard:pDashboard, laporan:pLaporan, terlaris:pTerlaris};
const TABLES = {terlaris:terDetail};

/* ===================== RENDER & NAVIGASI ===================== */
function render() {
  const y = window.scrollY;
  $('#app').innerHTML = `<div class="app ${collapsed ? 'collapsed' : ''}">${sidebar()}<main class="main">${topbar()}<div class="content">${PAGES[page]()}</div></main></div>`;
  window.scrollTo(0, y);
}
function redrawTable() { const t = $('#tbl'); if (t && TABLES[page]) t.innerHTML = TABLES[page](); }
function nav(k) { page = k; q = ''; userMenu = false; bellOpen = false; render(); window.scrollTo(0, 0); }
function toggleSide() { collapsed = !collapsed; render(); }
function toggleUser(e) { e.stopPropagation(); userMenu = !userMenu; bellOpen = false; render(); }
function toggleBell(e) { e.stopPropagation(); bellOpen = !bellOpen; userMenu = false; render(); }
function logout() {
  if (confirm('Yakin ingin keluar?')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/logout';

    const token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_token';
    token.value = '{{ csrf_token() }}';

    form.appendChild(token);
    document.body.appendChild(form);
    form.submit();
  }
}
function setQ(v) {
  q = v;
  document.querySelectorAll('input[data-q]').forEach(i => { if (i !== document.activeElement) i.value = q; });
  redrawTable();
}
// Pencarian produk ada di halaman Produk Terlaris
function topEnter(e) { if (e.key === 'Enter' && !TABLES[page]) { const keep = q; nav('terlaris'); q = keep; render(); } }
function setPeriod(v) { period = v; render(); }
function setChartN(v) { chartN = parseInt(v, 10); render(); }
function setTopRange(v) { topRange = v; render(); }
function toggleTerAll() { terAll = !terAll; render(); }
function exportPdf() { window.print(); }

document.addEventListener('click', e => {
  if ((userMenu || bellOpen) && !e.target.closest('.wrapdd')) { userMenu = false; bellOpen = false; render(); }
});

let toastTimer;
function toast(msg) {
  const t = $('#toast');
  t.textContent = msg; t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2200);
}

/* ===================== MODAL DETAIL TRANSAKSI ===================== */
function openModal(html) { $('#modal').innerHTML = `<div class="mbg" onclick="if(event.target===this)closeModal()"><div class="modal">${html}</div></div>`; }
function closeModal() { $('#modal').innerHTML = ''; }
const dtl = (a, b) => `<div class="dtl"><span>${a}</span><span>${b}</span></div>`;

function openTrx(id) {
  const t = TRX.find(x => x.trx === id);
  if (!t) return;
  const c = t.c;
  openModal(`<h2>Detail Transaksi</h2>${dtl('No. Transaksi', t.trx)}${dtl('Tanggal & Waktu', fmtTgl(t.ts))}${dtl('Pelanggan', esc(t.nama))}${dtl('Metode Pembayaran', mIcon(t.metode))}${dtl('Status', stBadge(t.status))}${dtl('Kasir', esc(t.kasir))}
    <div style="margin:12px 0 4px;font-weight:700;font-size:.85rem">Daftar Produk</div>
    ${t.items.map(i => { const p = prodBy(i.id); return dtl(`${esc(p.nama)} × ${i.qty}`, rp(i.subtotal || i.harga * i.qty)); }).join('')}
    ${dtl('Subtotal', rp(c.sub))}${dtl('<b>Total</b>', `<b>${rp(c.total)}</b>`)}
    <div class="mfoot"><button class="btn ghost" onclick="closeModal()">Tutup</button><button class="btn" onclick="cetakStruk('${t.trx}')">${I.printer}Cetak Struk</button></div>`);
}

function cetakStruk(id) {
  const t = TRX.find(x => x.trx === id);
  if (!t) return;
  const c = t.c;
  const w = window.open('', '_blank', 'width=380,height=600');
  if (!w) return toast('Izinkan pop-up untuk mencetak struk');
  const baris = t.items.map(i => { const p = prodBy(i.id); return `<div class="r"><span>${esc(p.nama)} x${i.qty}</span><span>${rp(p.harga * i.qty)}</span></div>`; }).join('');
  w.document.write(`<html><head><title>Struk ${t.trx}</title><style>body{font-family:monospace;padding:16px;font-size:13px}h2,p.c{text-align:center}hr{border:0;border-top:1px dashed #000;margin:8px 0}.r{display:flex;justify-content:space-between}</style></head><body>
    <h2>BeanByte</h2><p class="c">Kopi • Rasa • Cerita</p><hr><div>No: ${t.trx}</div><div>Pelanggan: ${esc(t.nama)}</div><div>${fmtTgl(t.ts)}</div><div>Bayar: ${t.metode}</div><hr>
    ${baris}<hr><div class="r"><span>Subtotal</span><span>${rp(c.sub)}</span></div><div class="r"><b>Total</b><b>${rp(c.total)}</b></div><hr><p class="c">Terima kasih!</p></body></html>`);
  w.document.close(); w.focus();
  setTimeout(() => w.print(), 300);
}

/* ===================== MULAI ===================== */
render();
loadDashboardData();
setInterval(() => {
  const active = document.activeElement;
  if (active && ['INPUT','SELECT','TEXTAREA'].includes(active.tagName)) return;
  loadDashboardData();
}, 30000);
</script>
</body>
</html>