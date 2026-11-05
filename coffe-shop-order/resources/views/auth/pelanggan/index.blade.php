<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#5d4037">
<title>BeanByte</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>
<style>
  :root{--dark:#4a2e24;--coffee:#5d4037;--coffee2:#6f4232;--soft:#f7eeee;--ink:#111}
  *{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
  body{background:#ece4dc;font-family:"Open Sans",system-ui,sans-serif;color:var(--ink)}
  button{font:inherit;color:inherit;background:none;border:0;cursor:pointer}
  input{font:inherit;color:inherit}
  h1,h2,.hd{font-family:"Outfit",sans-serif}
  svg{display:block}

  .phone{max-width:430px;min-height:100vh;margin:0 auto;background:#fff;box-shadow:0 0 30px rgba(0,0,0,.18)}
  .screen{display:flex;flex-direction:column;min-height:100vh}
  .content{flex:1}
  .empty{text-align:center;padding:60px 24px;color:#8a6f64}

  /* Top bar */
  .topbar{display:flex;align-items:center;gap:18px;padding:24px 20px 14px}
  .topbar h1{font-size:1.15rem;font-weight:700}
  .iconbtn{width:32px;height:32px;display:grid;place-items:center}
  .iconbtn svg{width:24px;height:24px}
  .spacer{flex:1}
  .msearch{margin:0 20px 8px;border:1px solid var(--coffee);border-radius:24px;padding:10px 16px}
  .msearch input{width:100%;border:0;outline:0;background:transparent}

  /* Thumbnail */
  .thumb{position:relative;width:96px;height:66px;border-radius:6px;overflow:hidden;flex:none;
    background:linear-gradient(135deg,#ead9c8,#c9a58a);display:grid;place-items:center;font-size:1.8rem}
  .thumb img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
  .thumb.sm{width:82px;height:82px}
  .thumb.xs{width:52px;height:52px;font-size:1.3rem}
  .thumb.card{width:100%;height:130px;border-radius:0;font-size:2.6rem}

  /* Daftar menu */
  .row{display:flex;align-items:center;gap:18px;padding:16px 20px}
  .info{flex:1}
  .info b{display:block;font-weight:700;font-size:.95rem}
  .info span{font-size:.9rem}
  .step{display:flex;align-items:center;gap:8px}
  .step button{width:22px;height:22px;font-size:1.1rem;line-height:1}
  .step .q,.step span{min-width:22px;height:22px;border:1px solid #999;border-radius:3px;font-size:.7rem;display:grid;place-items:center}
  .step.big{gap:14px;margin-top:8px}
  .step.big button{color:var(--coffee);font-weight:800;font-size:1.3rem;width:auto;height:auto}
  .step.big span{border:0;font-size:.9rem;min-width:auto;height:auto}

  .cartbar{position:sticky;bottom:16px;align-self:center;width:calc(100% - 32px);margin:12px 0 16px;display:flex;
    align-items:center;gap:16px;background:var(--coffee);color:#fff;border-radius:16px;padding:14px 26px;font-size:.78rem}
  .cartbar svg{width:34px;height:34px}
  .cartbar span{flex:1;text-align:center;padding-right:34px;line-height:1.35}

  /* Keranjang */
  .crow{display:flex;align-items:center;gap:12px;padding:14px 22px}
  .cinfo{flex:1}
  .cinfo b{display:block}
  .cinfo div{font-size:.9rem}
  .trash{color:var(--coffee);padding:6px}
  .trash svg{width:24px;height:24px}
  .sum{padding:10px 26px}
  .sum div{display:flex;justify-content:space-between;padding:10px 0;font-size:.95rem}
  .sum .tot{font-family:"Outfit",sans-serif;font-weight:700;font-size:1.15rem;margin-top:4px}
  .namebox{display:block;width:calc(100% - 48px);height:52px;margin:14px 24px 0;border:1.5px solid var(--coffee);
    border-radius:14px;text-align:center;outline:0;background:#fff;display:flex;align-items:center;justify-content:center}
  input.namebox{display:block}
  .btn{display:block;width:calc(100% - 48px);height:52px;margin:18px 24px 24px;background:var(--coffee);color:#fff;
    border-radius:16px;font-weight:600}

  /* Catatan */
  .notebox{display:block;width:calc(100% - 48px);min-height:84px;margin:14px 24px 0;padding:12px 16px;border:1.5px solid var(--coffee);
    border-radius:14px;outline:0;resize:none;font:inherit;font-size:.9rem;background:#fff}
  .notetxt{margin:14px 24px 0;padding:12px 16px;border:1px dashed var(--coffee);border-radius:14px;font-size:.85rem;color:#6f4232}

  /* Scan QRIS */
  .qris-note{text-align:center;font-size:.85rem;padding:14px 32px 14px;color:#6f4232;line-height:1.4}
  .camwrap{position:relative;margin:6px 24px 0;aspect-ratio:1;border-radius:20px;overflow:hidden;background:#000}
  .camwrap video{width:100%;height:100%;object-fit:cover}
  .camwrap .frame{position:absolute;inset:18%;border:3px solid #fff;border-radius:16px;box-shadow:0 0 0 999px rgba(0,0,0,.35)}
  .qtotal{text-align:center;margin-top:8px;font-size:.85rem}
  .qtotal b{display:block;font-family:"Outfit",sans-serif;font-size:1.5rem;color:var(--coffee)}
  .qres{margin:8px 24px 0;padding:18px 20px;border:1.5px solid var(--coffee);border-radius:16px}
  .qres small{display:block;font-size:.8rem;margin-top:12px;color:#7a4a3a}
  .qres small:first-child{margin-top:0}
  .qres b{display:block;font-size:1rem}
  .ghost{background:#fff;color:var(--coffee);border:1.5px solid var(--coffee);display:grid;place-items:center;cursor:pointer;margin:10px 24px 0}
  .linkbtn{display:block;margin:14px auto 0;color:var(--coffee);font-weight:700;font-size:.85rem}
  .okcircle.sm{width:64px;height:64px;background:var(--coffee);color:#fff;margin:18px auto 0}
  .okcircle.sm svg{width:34px;height:34px}

  /* Detail pesanan */
  .drow{display:grid;grid-template-columns:52px 1fr 24px 92px;gap:10px;align-items:center;padding:12px 24px}
  .drow b{display:block;font-size:.85rem}
  .drow small{font-size:.8rem}
  .drow .t{text-align:right;font-size:.9rem}
  .sect{font-weight:700;font-size:.95rem;padding:22px 24px 12px}
  .pay{display:flex;align-items:center;gap:14px;width:calc(100% - 48px);height:52px;margin:0 24px 14px;padding:0 20px;
    border:1px solid #ddd;border-radius:24px;text-align:left}
  .pay.on{border-color:var(--coffee)}
  .pay svg{width:26px;height:26px}
  .radio{width:16px;height:16px;border-radius:50%;border:2px solid #111;flex:none}
  .pay.on .radio{background:#111;box-shadow:inset 0 0 0 2px #fff}
  .pay em{margin-left:auto;font-style:normal;color:var(--coffee)}

  /* Pesanan berhasil */
  .dark{background:var(--dark);color:#fff;padding:90px 40px 40px}
  .okcircle{width:88px;height:88px;border-radius:50%;background:#fff;color:var(--dark);display:grid;place-items:center;margin:0 auto}
  .okcircle svg{width:48px;height:48px}
  .dark h1{text-align:center;font-size:1.6rem;margin-top:34px}
  .dark p.sub{text-align:center;font-size:.85rem;font-weight:600;margin-top:8px;line-height:1.4;font-family:"Outfit",sans-serif}
  .rcard{background:#fff;color:var(--dark);border-radius:20px;padding:20px;margin-top:40px}
  .rcard .nm{font-family:"Outfit",sans-serif;font-weight:800;text-transform:uppercase;font-size:.9rem;margin-bottom:14px}
  .rcard small{display:block;font-size:.9rem;margin-top:16px}
  .rcard b{display:block;font-size:1rem;font-weight:800}
  .btn2{display:block;width:100%;height:46px;margin-top:44px;background:#744536;color:#fff;border-radius:16px;font-size:.95rem}

  /* Riwayat */
  .chips{display:flex;gap:10px;padding:10px 24px 18px}
  .chip{padding:9px 22px;border-radius:20px;background:var(--soft);color:var(--coffee2);font-size:.85rem}
  .chip.on{background:var(--coffee2);color:#fff}
  .ocard{margin:0 24px 14px;border:1px solid #999;border-radius:16px;padding:16px;display:grid;grid-template-columns:1fr auto;row-gap:4px;align-items:center}
  .ocard .no{font-family:"Outfit",sans-serif;font-weight:800;font-size:.95rem}
  .ocard .tgl{font-size:.7rem;color:#7a4a3a}
  .ocard .tot{font-weight:700;font-size:1.05rem;margin-top:10px}
  .ocard .who{font-family:"Outfit",sans-serif;font-weight:800;text-transform:uppercase;font-size:.85rem;color:var(--dark);text-align:right;margin-top:10px}
  .badge{justify-self:end;padding:4px 14px;border-radius:12px;font-size:.7rem;font-weight:700}
  .badge.proses{background:#fff3cf;color:#ee7a0a}
  .badge.selesai{background:#d5f7d0;color:#2a8a19}
  .badge.batal{background:#fde0e0;color:#c0392b}

  /* Bottom nav */
  .nav{position:sticky;bottom:0;margin-top:auto;display:flex;justify-content:space-around;background:#fff;border-top:1px solid #f1e7e3;padding:10px 0 14px}
  .nav button{display:flex;flex-direction:column;align-items:center;gap:4px;color:var(--coffee);font-size:.7rem;opacity:.75}
  .nav button.on{opacity:1;font-weight:700}
  .nav svg{width:26px;height:26px}

  /* Beranda */
  .home-head{display:flex;align-items:center;gap:8px;padding:26px 24px 0}
  .home-head .logo{width:62px;height:62px}
  .brandname{font-weight:800;font-size:1.9rem;color:var(--coffee);line-height:1}
  .brandtag{font-size:.9rem;color:var(--coffee);font-weight:600}
  .logout{margin-left:auto;width:40px;height:40px;display:grid;place-items:center;color:var(--coffee);border:1px solid var(--coffee);border-radius:50%;flex:none}
  .logout svg{width:20px;height:20px}
  .search{display:flex;align-items:center;gap:12px;margin:22px 20px 0;border:1px solid var(--coffee);border-radius:26px;padding:0 18px;height:40px}
  .search svg{width:20px;height:20px;color:var(--coffee)}
  .search input{flex:1;min-width:0;border:0;outline:0;font-size:.82rem;background:transparent}
  .banner{margin:16px 14px 0;height:185px;border-radius:20px;padding:26px 18px;color:#fff}
  .banner h2{font-size:1.3rem;font-weight:700;max-width:150px;line-height:1.3}
  .banner p{font-size:.68rem;max-width:150px;margin-top:14px;line-height:1.4}
  .sec-title{text-align:center;font-family:"Outfit",sans-serif;font-weight:700;font-size:1.1rem;margin-top:26px}
  .cats{display:flex;justify-content:space-around;padding:14px 20px 0}
  .cat{display:flex;flex-direction:column;align-items:center;gap:8px;font-size:.85rem}
  .cat i{width:74px;height:74px;background:var(--soft);border-radius:20px;display:grid;place-items:center;color:var(--coffee)}
  .cat i svg{width:40px;height:40px}
  .favhead{display:flex;justify-content:space-between;align-items:center;padding:28px 20px 12px}
  .favhead h2{font-size:1.05rem;font-weight:700;margin-left:20px}
  .favhead button{display:flex;align-items:center;gap:8px;font-weight:700;font-size:.78rem}
  .favhead svg{width:16px;height:16px}
  .grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding:0 14px 20px}
  .fav{border:1px solid #fbe3e3;border-radius:14px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.06)}
  .fav .body{padding:12px 14px 14px}
  .fav b{display:block;font-weight:700}
  .fav .add{width:100%;margin-top:10px;background:var(--coffee);color:#fff;border-radius:8px;padding:10px;font-weight:600;font-size:.85rem}

  /* Layar awal */
  .splash{color:#fff;text-align:center;justify-content:space-between;padding:90px 24px 40px}
  .splash .logo{width:56px;height:56px;margin:0 auto}
  .sp-title{font-family:"Open Sans",sans-serif;font-weight:800;font-size:2.6rem;line-height:1.1;margin-top:4px}
  .sp-tag{font-size:.95rem;margin-top:2px}
  .sp-desc{font-size:.9rem;margin-top:14px;line-height:1.45}
  .pill{width:78%;align-self:center;height:50px;border-radius:26px;background:rgba(48,50,58,.94);color:#fff;font-size:1.05rem}

  .toast{position:fixed;left:50%;bottom:96px;transform:translateX(-50%);background:#2b1d16;color:#fff;padding:10px 18px;
    border-radius:20px;font-size:.85rem;opacity:0;pointer-events:none;transition:opacity .25s;z-index:10;white-space:nowrap}
  .toast.show{opacity:1}
</style>
</head>
<body>

<div class="phone" id="app"></div>
<div class="toast" id="toast"></div>

<script>
/* ===================== DATA ===================== */
// Folder foto: public/foto  (nama file ada di daftar MENU di bawah)
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
const HARGA = 22000;
const KEY = 'beanbyte_riwayat';
const BLN = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sept','Okt','Nov','Des'];


const MENU_DATABASE = {
  'americano': 6,
  'latte': 7,
  'cappuccino': 8,
  'caramel-macchiato': 9,
  'affogato': 10,
  'butterscots': 11,
  'espresso': 12,
  'cocolate': 13,
  'matcha': 3,
  'fresh-orange': 14,
  'milk-tea': 15,
  'jus-strawberry': 4,
  'croissant': 16,
  'spaghetti': 2,
  'donat': 17,
  'french-fries': 18,
  'nasi-goreng-spesial': 1
};

// [id, nama, kategori, file foto, emoji cadangan]
const MENU = [
  ['americano','Americano','kopi','americano.jpg','🧊'],
  ['latte','Latte','kopi','latte.jpg','🥛'],
  ['cappuccino','Cappuccino','kopi','cappucino.jpg','☕'],
  ['caramel-macchiato','Caramel Macchiato','kopi','caramel.jpg','🍮'],
  ['affogato','Affogato','kopi','affogato.jpg','🍨'],
  ['butterscots','Butterscots','kopi','butterscots.jpg','☕'],
  ['espresso','Espresso','kopi','esspreso.jpg','☕'],
  ['cocolate','Cocolate','nonkopi','cocolate.jpg','🍫'],
  ['matcha','Matcha','nonkopi','matcha.jpg','🍵'],
  ['fresh-orange','Fresh Orange','nonkopi','jus jeruk.jpg','🍊'],
  ['milk-tea','Milk Tea','nonkopi','milk tea.jpg','🧋'],
  ['jus-strawberry','Jus Strawberry','nonkopi','jud strawberry.jpg','🍓'],
  ['croissant','Croissant','makanan','croissant.jpg','🥐'],
  ['spaghetti','Spaghetti','makanan','spageti.jpg','🍝'],
  ['donat','Donat','makanan','donat.jpg','🍩'],
  ['french-fries','French Fries','makanan','kentang.jpg','🍟'],
  ['nasi-goreng-spesial','Nasi Goreng Spesial','makanan','nasi-goreng-spesial.jpg','🍳']
].map(([id,nama,kat,foto,emoji]) => ({
  id,
  id_menu: MENU_DATABASE[id],
  nama,
  kat,
  foto,
  emoji,
  harga: HARGA,
  stok: 0
}));

/* ===================== STATE ===================== */


let cart = {};
let nama = '';
let catatan = '';

const parameterURL = new URLSearchParams(window.location.search);
const mejaDariURL = parameterURL.get('meja');

let idMeja = null;
let nomorMeja = null;

if (mejaDariURL && /^[1-9]\d*$/.test(mejaDariURL)) {
  idMeja = Number(mejaDariURL);
  nomorMeja = 'Meja ' + idMeja;
}

let qrisInfo = null;
let camStream = null, scanRaf = 0;

// Opsional: nama merchant QRIS toko
const QRIS_TOKO = '';

let metode = 'qris';
let filter = 'Semua';
let stack = [];
let cur = { name: idMeja ? 'dashboard' : 'splash' };

const seed = [
  {no:'#B0022',nama:'Neng Sri',total:56100,waktu:'18 Sept 2026 · 11:05',status:'Selesai'},
  {no:'#B0021',nama:'Neng Sri',total:56100,waktu:'18 Sept 2026 · 10:12',status:'Selesai'}
];

let riwayat = null;

try {
  riwayat = JSON.parse(localStorage.getItem(KEY));
} catch (e) {}

if (!Array.isArray(riwayat)) riwayat = seed.slice();

const simpan = () => {
  try {
    localStorage.setItem(KEY, JSON.stringify(riwayat));
  } catch (e) {}
};

/* ===== Jembatan ke halaman kasir =====
   Pesanan ditulis ke antrian bersama (localStorage), lalu dibaca oleh halaman kasir.
   Status dari kasir (Menunggu, Diproses, Selesai, Dibatalkan) dibaca balik ke Riwayat Pesanan.
   Berjalan selama halaman pelanggan dan kasir dibuka di browser yang sama. */
const ANTRIAN = 'beanbyte_antrian';
const bacaAntrian = () => { try { const a = JSON.parse(localStorage.getItem(ANTRIAN)); return Array.isArray(a) ? a : []; } catch (e) { return []; } };
const tulisAntrian = a => { try { localStorage.setItem(ANTRIAN, JSON.stringify(a)); } catch (e) {} };
const STATUS_KASIR = {'Menunggu':'Menunggu', 'Diproses':'Sedang Diproses', 'Selesai':'Selesai', 'Dibatalkan':'Dibatalkan'};
function sinkronStatus() {
  const a = bacaAntrian();
  let berubah = false;
  riwayat.forEach(o => {
    const x = a.find(y => '#' + y.no === o.no);
    const s = x && STATUS_KASIR[x.status];
    if (s && s !== o.status) { o.status = s; berubah = true; }
  });
  if (berubah) { simpan(); if (cur.name === 'riwayat') refresh(); }
}

/* ===================== HELPER ===================== */
const $ = s => document.querySelector(s);
const rp = n => 'Rp ' + n.toLocaleString('id-ID');
const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const qtyOf = id => cart[id] || 0;
const byId = id => MENU.find(m => m.id === id);

function hitung() {
  let qty = 0, sub = 0;
  for (const id in cart) { qty += cart[id]; sub += byId(id).harga * cart[id]; }
  const diskon = qty > 2 ? Math.round(sub * 0.15) : 0;   // diskon 15% bila lebih dari 2 menu
  return {qty, sub, diskon, total: sub - diskon};
}

let toastTimer;
function toast(msg) {
  const t = $('#toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 1800);
}

/* ===================== IKON ===================== */
const svg = (p, extra = '') => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ${extra}>${p}</svg>`;
const I = {
  back:  svg('<path d="M20 12H5M11 5l-7 7 7 7"/>','stroke-width="2.6"'),
  logout:svg('<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>'),
  arrow: svg('<path d="M4 12h16M14 6l6 6-6 6"/>'),
  search:svg('<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>'),
  cart:  svg('<path d="M2 3h3l2.6 12.2a2 2 0 0 0 2 1.6h8.3a2 2 0 0 0 2-1.5L21.5 8H6"/><circle cx="10" cy="20.5" r="1.3"/><circle cx="18" cy="20.5" r="1.3"/>'),
  trash: svg('<path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13M10 11v6M14 11v6"/>'),
  check: svg('<path d="M5 12.5l4.5 4.5L19 7.5"/>','stroke-width="3.2"'),
  home:  `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 11l9-8 9 8v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg>`,
  note:  svg('<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 3h6v3H9zM8.5 11h7M8.5 15h4"/>','stroke-width="2"'),
  hist:  svg('<path d="M3 12a9 9 0 1 0 3-6.7L3 8M3 3v5h5M12 7v5l3 2"/>','stroke-width="2.2"'),
  qr:    svg('<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM19 14h2M14 19h2M18 18h3v3h-3z"/>','stroke-width="1.6"'),
  wallet:svg('<path d="M3 7a2 2 0 0 1 2-2h13v3M3 7v11a2 2 0 0 0 2 2h15V8H5a2 2 0 0 1-2-1zM16 14h2"/>','stroke-width="2"'),
  cup:   svg('<path d="M5 11h12v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6zM17 12h1.5a2.5 2.5 0 0 1 0 5H16M3 21h18M9 3c-1 1.5 1 2.5 0 4M13 3c-1 1.5 1 2.5 0 4"/>'),
  drink: svg('<path d="M6 8h12l-1.5 12h-9zM6 12h12M13 8l2-5h3"/>'),
  food:  svg('<circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="2.6"/><path d="M3.5 4v6a1.5 1.5 0 0 0 3 0V4M5 4v16M20.5 4c-1.5 1-2.5 3-2.5 6h2.5V20"/>')
};

const logo = (c, bg) => `<svg class="logo" viewBox="0 0 100 100" fill="${c}">
  <g fill="none" stroke="${c}" stroke-width="2.6" stroke-linecap="round">
    <path d="M36 6c-4 4 4 7 0 12s-4 6 0 8"/><path d="M50 2c-4 5 4 8 0 14s-4 8 0 10"/><path d="M64 6c-4 4 4 7 0 12s-4 6 0 8"/>
  </g>
  <path d="M12 38h62v8c0 16-9 27-22 27H36C22 73 12 62 12 46z"/>
  <path d="M74 44h6c8 0 11 4 11 8 0 7-8 14-17 14v-5c6 0 11-4 11-8 0-2-2-3-5-3h-6z"/>
  <path d="M24 44c1 12 8 20 16 22-9-3-13-12-12-22z" fill="${bg}"/>
  <ellipse cx="46" cy="83" rx="44" ry="6"/></svg>`;

const thumb = (m, c = '') => `<div class="thumb ${c}"><span>${m.emoji}</span>${imgTag(m.id, m.foto, esc(m.nama))}</div>`;

const stepper = id => `<div class="step"><button onclick="ubah('${id}',-1)">−</button><span class="q">${qtyOf(id)}</span><button onclick="ubah('${id}',1)">+</button></div>`;

const nav = a => `<nav class="nav">${[['beranda','Beranda',I.home],['keranjang','Pesanan',I.note],['riwayat','Riwayat',I.hist]]
  .map(([k,l,i]) => `<button class="${a===k?'on':''}" onclick="navTo('${k}')">${i}<span>${l}</span></button>`).join('')}</nav>`;

function cartBar() {
  const t = hitung();
  if (!t.qty) return '';
  return `<button class="cartbar" onclick="go('keranjang')">${I.cart}<span>Lihat keranjang (${t.qty})<br>${rp(t.sub)}</span></button>`;
}

/* ===================== NAVIGASI ===================== */
function render() { $('#app').innerHTML = SCREENS[cur.name](); }
function refresh() { const y = window.scrollY; render(); window.scrollTo(0, y); }
function go(name, p = {}) { hentikanKamera(); stack.push(cur); cur = Object.assign({name}, p); render(); window.scrollTo(0, 0); }
function back() { hentikanKamera(); cur = stack.pop() || {name:'beranda'}; render(); window.scrollTo(0, 0); }
function navTo(k) {
  hentikanKamera();
  if (k === 'keranjang') return go('keranjang');
  stack = []; cur = {name:k}; render(); window.scrollTo(0, 0);
}

/* ===================== AKSI ===================== */
function ubah(id, d) {
  const q = Math.max(0, qtyOf(id) + d);
  if (q) cart[id] = q; else delete cart[id];
  refresh();
}
function hapus(id) { delete cart[id]; refresh(); }
function tambah(id) { cart[id] = qtyOf(id) + 1; toast(byId(id).nama + ' ditambahkan'); }
function cari() { go('menu', {kat:'cari', q: $('#q').value}); }
function logout() { if (confirm('Yakin ingin keluar?')) location.href = '/login'; }
function toggleCari() { cur.cari = !cur.cari; refresh(); }
function setMetode(m) { metode = m; if (m === 'qris') bukaScan(); else refresh(); }
function setFilter(f) { filter = f; refresh(); }

function lanjut() {
  if (!Object.keys(cart).length) return toast('Keranjang masih kosong');
  if (!nama.trim()) { toast('Masukan nama anda dulu'); $('#nama').focus(); return; }
  go('detail');
}

// Tombol "Selesai" di Detail Pesanan:
// QRIS  -> kamera scan QRIS dulu (kalau belum), lalu pesanan dikirim setelah konfirmasi
// Tunai -> pesanan langsung dikirim ke kasir
function selesai() {
  if (metode === 'qris' && !qrisInfo) return bukaScan();
  kirimPesanan();
}

/* ===== Scan QRIS lewat kamera ===== */
function bukaScan() { go('scan'); if (!qrisInfo) mulaiKamera(); }
function scanUlang() { qrisInfo = null; render(); mulaiKamera(); }

function hentikanKamera() {
  cancelAnimationFrame(scanRaf);
  if (camStream) { camStream.getTracks().forEach(t => t.stop()); camStream = null; }
}

// QRIS memakai format EMV: tag(2 digit) + panjang(2 digit) + isi
function tlv(str) {
  const o = {}; let i = 0;
  while (i + 4 <= str.length) {
    const tag = str.substr(i, 2), len = parseInt(str.substr(i + 2, 2), 10);
    if (isNaN(len)) break;
    o[tag] = str.substr(i + 4, len); i += 4 + len;
  }
  return o;
}
function bacaQris(raw) {
  if (!/^000201/.test(raw)) return null;
  const d = tlv(raw);
  if (d['58'] !== 'ID' || !d['59']) return null;
  return {merchant: d['59'], kota: d['60'] || '', raw};
}

// true bila QR valid dan diterima
function hasilScan(raw) {
  const msg = $('#scanmsg'), q = bacaQris(raw);
  if (!q) { if (msg) msg.textContent = 'Itu bukan kode QRIS. Arahkan ke QRIS BeanByte.'; return false; }
  if (QRIS_TOKO && q.merchant.toLowerCase() !== QRIS_TOKO.toLowerCase()) {
    if (msg) msg.textContent = 'QRIS ini bukan milik BeanByte.'; return false;
  }
  hentikanKamera(); qrisInfo = q; render(); return true;
}

async function mulaiKamera() {
  const v = $('#cam'), msg = $('#scanmsg');
  if (!v) return;
  if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    msg.textContent = 'Kamera tidak tersedia (butuh HTTPS). Pilih foto QR di bawah.'; return;
  }
  try {
    camStream = await navigator.mediaDevices.getUserMedia({video: {facingMode: {ideal: 'environment'}}, audio: false});
  } catch (e) {
    msg.textContent = 'Izin kamera ditolak. Izinkan kamera, atau pilih foto QR di bawah.'; return;
  }
  if (cur.name !== 'scan' || !$('#cam')) { hentikanKamera(); return; }
  v.srcObject = camStream;
  try { await v.play(); } catch (e) {}
  const detector = ('BarcodeDetector' in window) ? new BarcodeDetector({formats: ['qr_code']}) : null;
  const c = document.createElement('canvas'), x = c.getContext('2d', {willReadFrequently: true});
  const loop = async () => {
    if (!camStream) return;
    if (v.readyState >= 2 && v.videoWidth) {
      let raw = '';
      try {
        if (detector) { const r = await detector.detect(v); raw = r[0] ? r[0].rawValue : ''; }
        else if (window.jsQR) {
          c.width = v.videoWidth; c.height = v.videoHeight; x.drawImage(v, 0, 0);
          const im = x.getImageData(0, 0, c.width, c.height), r = jsQR(im.data, c.width, c.height);
          raw = r ? r.data : '';
        }
      } catch (e) {}
      if (raw && hasilScan(raw)) return;
    }
    scanRaf = requestAnimationFrame(loop);
  };
  loop();
}

// Cadangan: pilih foto/screenshot QR dari galeri
function scanFile(inp) {
  const f = inp.files[0]; if (!f) return;
  const img = new Image();
  img.onload = () => {
    const c = document.createElement('canvas'); c.width = img.width; c.height = img.height;
    const x = c.getContext('2d'); x.drawImage(img, 0, 0);
    const im = x.getImageData(0, 0, c.width, c.height);
    const r = window.jsQR && jsQR(im.data, c.width, c.height);
    if (!r) $('#scanmsg').textContent = 'QR tidak terbaca pada foto. Coba foto yang lebih jelas.';
    else hasilScan(r.data);
    URL.revokeObjectURL(img.src);
  };
  img.src = URL.createObjectURL(f);
}

 
/* ===================== DATABASE MENU ===================== */

// Hubungkan ID menu halaman dengan ID menu di database MySQL
const idMenuDatabase = {
  'nasi-goreng-spesial': 1,
  'spaghetti': 2,
  'croissant': 16,
  'donat': 17,
  'french-fries': 18,

  'matcha': 3,
  'jus-strawberry': 4,
  'cocolate': 13,
  'fresh-orange': 14,
  'milk-tea': 15,

  'americano': 6,
  'latte': 7,
  'cappuccino': 8,
  'caramel-macchiato': 9,
  'affogato': 10,
  'butterscots': 11,
  'espresso': 12
};


/* ===================== SINKRON STOK MENU ===================== */

async function perbaruiStokMenu() {
  try {
    const response = await fetch('/api/menu', {
      headers: {
        'Accept': 'application/json'
      },
      cache: 'no-store'
    });

    if (!response.ok) {
      throw new Error('Gagal mengambil stok dari database.');
    }

    const hasil = await response.json();

    if (!Array.isArray(hasil)) {
      throw new Error('Format data menu dari database tidak sesuai.');
    }

    MENU.forEach(menu => {
      const idDatabase = idMenuDatabase[menu.id];

      const menuDB = hasil.find(
        item => Number(item.id_menu) === Number(idDatabase)
      );

      if (menuDB) {
        menu.stok = Number(menuDB.stok ?? 0);
        menu.harga = Number(menuDB.harga ?? menu.harga);
      }
    });

    render();
  } catch (error) {
    console.error('Gagal memperbarui stok:', error);
  }
}



/* ===================== KIRIM PESANAN ===================== */

async function kirimPesanan() {
  if (!nama.trim()) {
    alert('Nama pelanggan harus diisi.');
    return;
  }

  if (Object.keys(cart).length === 0) {
    alert('Pilih menu terlebih dahulu.');
    return;
  }

  try {
    // Siapkan detail pesanan untuk dikirim ke Laravel
    const items = Object.keys(cart).map(id => {
      const idMenu = idMenuDatabase[id];

      if (!idMenu) {
        throw new Error(
          `Menu "${id}" belum terhubung dengan database.`
        );
      }

      return {
        id_menu: idMenu,
        jumlah: cart[id],
        catatan: catatan.trim()
      };
    });

    const response = await fetch('/api/pesanan-pelanggan', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        nama_pelanggan: nama.trim(),
        id_meja: idMeja,
        items: items
      })
    });

    const hasil = await response.json();

    if (!response.ok) {
      const pesanError = hasil.message
        || Object.values(hasil.errors || {}).flat().join('\n')
        || 'Pesanan gagal disimpan.';

      throw new Error(pesanError);
    }

    // Pastikan API mengembalikan data pesanan
    const pesananDB = hasil.data;

    if (!pesananDB || pesananDB.total_harga == null) {
      throw new Error(
        'Respons API tidak memiliki data total_harga.'
      );
    }

    const totalAkhir = Number(pesananDB.total_harga);

    // Buat nomor pesanan untuk tampilan pelanggan
    const terakhir = Math.max(
      0,
      ...riwayat.map(o => {
        const nomor = String(o.no || '');
        return parseInt(nomor.slice(2), 10) || 0;
      })
    );

    const d = new Date();
    const pad = n => String(n).padStart(2, '0');

    const order = {
      no: '#B' + String(terakhir + 1).padStart(4, '0'),
      nama: nama.trim(),
      total: totalAkhir,
      waktu: `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()} · ${pad(d.getHours())}:${pad(d.getMinutes())}`,
      status: 'Menunggu',
      metode: metode,
      catatan: catatan.trim(),
      id_meja: idMeja || null,
      nomor_meja: nomorMeja || null
    };

    // Simpan pesanan untuk dibaca halaman kasir
    const antrian = bacaAntrian();

    antrian.push({
      no: order.no.replace('#', ''),
      nama: order.nama,
      id_meja: order.id_meja,
      nomor_meja: order.nomor_meja,
      items: Object.keys(cart).map(id => ({
        id: id,
        qty: cart[id]
      })),
      total: totalAkhir,
      metode: metode,
      catatan: order.catatan,
      ts: d.getTime(),
      status: 'Menunggu'
    });

    tulisAntrian(antrian);

    // Simpan riwayat pesanan pelanggan
    riwayat.unshift(order);
    simpan();

    // Kosongkan keranjang setelah pesanan berhasil
    cart = {};
    catatan = '';
    qrisInfo = null;

    // Tampilkan halaman pesanan berhasil
    go('sukses', { order: order });

  } catch (error) {
    console.error('Gagal mengirim pesanan:', error);
    alert(error.message || 'Pesanan gagal dikirim. Silakan coba lagi.');
  }
}

/* ===================== DAFTAR MENU ===================== */

function menuRows() {
  let l = MENU.filter(
    m => ['semua', 'cari'].includes(cur.kat) || m.kat === cur.kat
  );

  const q = (cur.q || '').trim().toLowerCase();

  if (q) {
    l = l.filter(m => m.nama.toLowerCase().includes(q));
  }

  if (!l.length) {
    return '<p class="empty">Menu tidak ditemukan</p>';
  }

  return l.map(m => {
    const stok = Number(m.stok ?? 0);
    const habis = stok <= 0;

    return `
      <div class="row">
        ${thumb(m)}
        <div class="info">
          <b>${m.nama}</b>
          <span>${rp(m.harga)}</span>
          <span style="color:${habis ? '#dc2626' : '#15803d'}; font-size:12px;">
            ${habis ? 'Stok habis' : `Stok tersedia: ${stok}`}
          </span>
        </div>
        ${stepper(m.id)}
      </div>
    `;
  }).join('');
}


/* ===================== LAYAR ===================== */

const SCREENS = {
    // Dashboard Pelanggan yang dibuka dari QR meja
  dashboard: () => `<div class="screen splash"
    style="background:linear-gradient(rgba(0,0,0,.25),rgba(0,0,0,.6)),${bgUrls('hero')},#1e1410">
    <div>
      ${logo('#fff','#1e1410')}
      <h1 class="sp-title">BeanByte</h1>
      <p class="sp-tag">Dashboard Pelanggan</p>
      <p class="sp-desc">
        Selamat datang! Kamu memesan dari ${esc(nomorMeja || 'BeanByte')}.
      </p>
    </div>
    <button class="pill" onclick="navTo('beranda')">
      Lihat Menu
    </button>
  </div>`,

  // 1. Layar awal 
  splash: () => `<div class="screen splash" style="background:linear-gradient(rgba(0,0,0,.25),rgba(0,0,0,.6)),${bgUrls('hero')},#1e1410">
    <div>${logo('#fff','#1e1410')}
      <h1 class="sp-title">BeanByte</h1>
      <p class="sp-tag">Kopi • Rasa • Cerita</p>
      <p class="sp-desc">Nikmati kopi favoritmu<br>dengan cara yang lebih mudah!</p>
    </div>
    <button class="pill" onclick="navTo('beranda')">Lihat Menu</button>
  </div>`,

  // 2. Beranda
  beranda: () => {
    const favs = ['americano','latte'].map(byId);

    return `<div class="screen"><div class="content">
      <div class="home-head">${logo('#5d4037','#fff')}<div><div class="brandname">BeanByte</div><div class="brandtag">Kopi • Rasa • Cerita</div></div><button class="logout" onclick="logout()" aria-label="Logout">${I.logout}</button></div>
      <div class="search">${I.search}<input id="q" placeholder="Cari menu, kategori, atau produk..." onkeydown="if(event.key==='Enter')cari()"><button onclick="cari()" aria-label="Cari" style="width:20px">${I.arrow}</button></div>
      <div class="banner" style="background:linear-gradient(90deg,rgba(40,25,18,.88) 0%,rgba(40,25,18,.55) 48%,rgba(0,0,0,.05) 100%),${bgUrls('banner')},#6b3f2e">
        <h2>Nikmati Kopi Terbaik di BeanByte</h2>
        <p>Bila membeli lebih dari 2 menu akan mendapatkan diskon 15%</p>
      </div>
      <div class="sec-title">Kategori</div>
      <div class="cats">
        <button class="cat" onclick="go('menu',{kat:'kopi'})"><i>${I.cup}</i>Kopi</button>
        <button class="cat" onclick="go('menu',{kat:'nonkopi'})"><i>${I.drink}</i>Non-Kopi</button>
        <button class="cat" onclick="go('menu',{kat:'makanan'})"><i>${I.food}</i>Makanan</button>
      </div>
      <div class="favhead"><h2>Menu Favorit</h2><button onclick="go('menu',{kat:'semua'})">Lihat Semua ${I.arrow}</button></div>
      <div class="grid2">${favs.map(m => `<div class="fav">${thumb(m,'card')}<div class="body"><b>${m.nama}</b><span>${rp(m.harga)}</span><button class="add" onclick="tambah('${m.id}')">+ Tambah</button></div></div>`).join('')}</div>
    </div>${nav('beranda')}</div>`;
  },

  // 3-5. Menu Kopi / Non-Kopi / Makanan (+ semua & hasil pencarian)
  menu: () => {
    const judul = {
      kopi: 'Menu kopi',
      nonkopi: 'Menu Non-Kopi',
      makanan: 'Menu Makanan',
      semua: 'Semua Menu',
      cari: 'Hasil Pencarian'
    }[cur.kat];

    const tampilCari = cur.kat === 'cari' || cur.cari;

    return `<div class="screen">
      <div class="topbar"><button class="iconbtn" onclick="back()" aria-label="Kembali">${I.back}</button><h1>${judul}</h1><span class="spacer"></span>
        ${cur.kat === 'cari' ? '' : `<button class="iconbtn" onclick="toggleCari()" aria-label="Cari">${I.search}</button>`}</div>
      ${tampilCari ? `<div class="msearch"><input value="${esc(cur.q || '')}" placeholder="Cari menu..." oninput="cur.q=this.value;$('#list').innerHTML=menuRows()"></div>` : ''}
      <div class="content" id="list">${menuRows()}</div>
      ${cartBar()}
    </div>`;
  },

  // 6. Keranjang
  keranjang: () => {
    const ids = Object.keys(cart);
    const t = hitung();

    const head = `<div class="topbar"><button class="iconbtn" onclick="back()" aria-label="Kembali">${I.back}</button><h1>Keranjang</h1></div>`;

    if (!ids.length) {
      return `<div class="screen">${head}<div class="content"><p class="empty">Keranjang masih kosong</p></div><button class="btn" onclick="navTo('beranda')">Pilih Menu</button></div>`;
    }

    const rows = ids.map(id => {
      const m = byId(id);

      return `<div class="crow">${thumb(m,'sm')}
      <div class="cinfo"><b>${m.nama}</b><div>${rp(m.harga)}</div>
        <div class="step big"><button onclick="ubah('${id}',-1)">−</button><span>${cart[id]}</span><button onclick="ubah('${id}',1)">+</button></div></div>
      <button class="trash" onclick="hapus('${id}')" aria-label="Hapus">${I.trash}</button></div>`;
    }).join('');

    return `<div class="screen">${head}
      <div class="content">${rows}
        <div class="sum" style="margin-top:8px">
          <div><span>Subtotal</span><span>${rp(t.sub)}</span></div>
          <div><span>Diskon (15%)</span><span>${rp(t.diskon)}</span></div>
          <div class="tot"><span>Total</span><span>${rp(t.total)}</span></div>
        </div>
        <input id="nama" class="namebox" placeholder="Masukan nama anda" value="${esc(nama)}" oninput="nama=this.value">
        <textarea id="catatan" class="notebox" placeholder="Catatan (mis. less sugar, tanpa es, pedas)" oninput="catatan=this.value">${esc(catatan)}</textarea>
      </div>
      <button class="btn" onclick="lanjut()">Lanjut Ke Pesanan</button>
    </div>`;
  },

  // 7. Detail pesanan
  detail: () => {
    const t = hitung();

    const rows = Object.keys(cart).map(id => {
      const m = byId(id);

      return `<div class="drow">${thumb(m,'xs')}
      <div><b>${m.nama}</b><small>${rp(m.harga)}</small></div><span>${cart[id]}</span><span class="t">${rp(m.harga * cart[id])}</span></div>`;
    }).join('');

    return `<div class="screen">
      <div class="topbar"><button class="iconbtn" onclick="back()" aria-label="Kembali">${I.back}</button><h1>Detail Pesanan</h1></div>
      <div class="content">${rows}
        <div class="sum">
          <div><span>Subtotal</span><span>${rp(t.sub)}</span></div>
          <div><span>Diskon (15%)</span><span>${rp(t.diskon)}</span></div>
          <div class="tot"><span>Total</span><span>${rp(t.total)}</span></div>
        </div>
        <div class="sect">Metode Pembayaran</div>
        <button class="pay ${metode==='qris'?'on':''}" onclick="setMetode('qris')"><span class="radio"></span>${I.qr}<span>Qris</span><em>›</em></button>
        <button class="pay ${metode==='tunai'?'on':''}" onclick="setMetode('tunai')"><span class="radio"></span>${I.wallet}<span>Tunai</span></button>
        ${metode === 'qris' && qrisInfo ? `<div class="notetxt" style="margin-top:0">QRIS terbaca: <b>${esc(qrisInfo.merchant)}</b></div>` : ''}
        <div class="namebox" style="margin-top:22px">${esc(nama)}</div>
        ${catatan.trim() ? `<div class="notetxt"><b>Catatan:</b> ${esc(catatan)}</div>` : ''}
      </div>
      <button class="btn" onclick="selesai()">Selesai</button>
    </div>`;
  },

  // 7b. Scan QRIS (kamera)
  scan: () => {
    const t = hitung();

    const head = `<div class="topbar"><button class="iconbtn" onclick="back()" aria-label="Kembali">${I.back}</button><h1>Pembayaran Qris</h1></div>`;

    if (qrisInfo) {
      return `<div class="screen">${head}
      <div class="content">
        <div class="okcircle sm">${I.check}</div>
        <p class="qris-note">QRIS berhasil dibaca</p>
        <div class="qres">
          <small>Merchant</small><b>${esc(qrisInfo.merchant)}</b>
          ${qrisInfo.kota ? `<small>Kota</small><b>${esc(qrisInfo.kota)}</b>` : ''}
          <small>Total Pembayaran</small><b>${rp(t.total)}</b>
        </div>
        <button class="linkbtn" onclick="scanUlang()">Scan ulang</button>
      </div>
      <button class="btn" onclick="kirimPesanan()">Konfirmasi Pembayaran</button>
    </div>`;
    }

    return `<div class="screen">${head}
      <div class="content">
        <div class="camwrap"><video id="cam" muted playsinline></video><div class="frame"></div></div>
        <p class="qris-note" id="scanmsg">Arahkan kamera ke kode QRIS BeanByte</p>
        <div class="qtotal">Total Pembayaran<b>${rp(t.total)}</b></div>
        <label class="btn ghost">Pilih foto QR<input type="file" accept="image/*" hidden onchange="scanFile(this)"></label>
      </div>
    </div>`;
  },

  // 8. Pesanan berhasil
  sukses: () => {
    const o = cur.order;

    return `<div class="screen dark">
      <div class="okcircle">${I.check}</div>
      <h1>Pesanan Berhasil!</h1>
      <p class="sub">Terimakasih sudah memesan<br>di BeanByte.</p>
      <p class="sub" style="margin-top:6px;opacity:.85">Pesananmu sudah diteruskan ke kasir.</p>
      <div class="rcard">
        <div class="nm">${esc(o.nama)}</div>
        <small>No. Pesanan</small><b>${o.no}</b>
        <small>Total Pembayaran</small><b>${rp(o.total)}</b>
        ${o.catatan ? `<small>Catatan</small><b>${esc(o.catatan)}</b>` : ''}
      </div>
      <button class="btn2" onclick="navTo('beranda')">Kembali ke Beranda</button>
    </div>`;
  },

  // 9. Riwayat pesanan
  riwayat: () => {
    const list = riwayat.filter(
      o => filter === 'Semua'
        || (filter === 'Selesai'
          ? o.status === 'Selesai'
          : ['Menunggu', 'Sedang Diproses'].includes(o.status))
    );

    const cards = list.length
      ? list.map(o => `<div class="ocard">
        <span class="no">${o.no}</span><span class="badge ${o.status === 'Selesai' ? 'selesai' : (o.status === 'Dibatalkan' ? 'batal' : 'proses')}">${o.status}</span>
        <span class="tgl">${o.waktu}</span><span></span>
        <span class="tot">${rp(o.total)}</span><span class="who">${esc(o.nama)}</span></div>`).join('')
      : '<p class="empty">Belum ada pesanan</p>';

    return `<div class="screen">
      <div class="topbar" style="padding-top:34px"><button class="iconbtn" onclick="navTo('beranda')" aria-label="Kembali">${I.back}</button><h1>Riwayat Pesanan</h1></div>
      <div class="chips">${['Semua','Selesai','Diproses'].map(f => `<button class="chip ${filter===f?'on':''}" onclick="setFilter('${f}')">${f}</button>`).join('')}</div>
      <div class="content">${cards}</div>
      ${nav('riwayat')}
    </div>`;
  }
};


/* ===================== JALANKAN APLIKASI ===================== */

render();
perbaruiStokMenu();
sinkronStatus();

setInterval(sinkronStatus, 2000);

if (window.addEventListener) {
  window.addEventListener('storage', e => {
    if (e.key === ANTRIAN) {
      sinkronStatus();
    }
  });
}
</script>
</body>
</html>
