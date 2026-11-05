<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kasir - BeanByte</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  :root{--dark:#472f24;--nav:#8a5a41;--coffee:#62392a;--cream:#faf4ec;--ink:#111}
  *{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
  body{font-family:"Open Sans",system-ui,sans-serif;color:var(--ink);background:#fff;font-size:14px}
  button{font:inherit;color:inherit;background:none;border:0;cursor:pointer}
  input,textarea{font:inherit;color:inherit}
  h1,h2,h3{font-family:"Outfit",sans-serif}
  svg{display:block}
  .empty{text-align:center;padding:40px 16px;color:#8a6f64}

  /* ===== Layout ===== */
  .app{display:grid;grid-template-columns:230px minmax(0,1fr);min-height:100vh}
  .side{background:var(--dark);color:#fff;position:sticky;top:0;height:100vh;display:flex;flex-direction:column;padding:26px 14px 24px}
  .brand{display:flex;align-items:center;gap:10px;padding:0 6px 28px}
  .brand .logo{width:46px;height:46px;flex:none}
  .brand b{font-family:"Outfit",sans-serif;font-size:1.4rem;font-weight:800;display:block;line-height:1.1}
  .brand small{font-size:.62rem}
  .nv{display:flex;align-items:center;gap:14px;width:100%;padding:11px 14px;border-radius:10px;font-size:1.02rem;color:#fff;margin-bottom:12px;text-align:left}
  .nv svg{width:26px;height:26px;flex:none}
  .nv.on{background:var(--nav)}
  .side-bot{margin-top:auto;border-top:1.5px solid #e6dcd5;padding-top:14px}
.kasir-name {
  color: #fff;
  font-weight: 700;
  font-size: 13px;
  padding: 0 8px;
  white-space: nowrap;
}

.side-bot form {
  display: flex;
  align-items: center;
  gap: 8px;
}

.side-bot form .nv {
  flex: 1;
}
  .main{min-width:0}
  .head{display:flex;align-items:center;gap:20px;padding:16px 26px;border-bottom:1.5px solid #222}
  .sbox{flex:1;max-width:640px;display:flex;align-items:center;gap:14px;height:44px;border:2px solid var(--ink);border-radius:24px;padding:0 18px}
  .sbox svg{width:22px;height:22px;flex:none}
  .sbox input{flex:1;min-width:0;border:0;outline:0;background:transparent;font-size:.85rem}
  .dchip{display:flex;align-items:center;gap:8px;border:2px solid var(--ink);border-radius:16px;padding:10px 16px;font-size:.8rem;white-space:nowrap}
  .dchip svg{width:20px;height:20px}
  .dchip svg + span + svg{margin-left:8px}

  .body{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:20px;padding:20px 22px 30px;align-items:start}
  .col{display:flex;flex-direction:column;gap:18px;min-width:0}
  .welcome{display:flex;justify-content:space-between;align-items:center;gap:16px}
  .welcome h1{font-size:2rem;font-weight:800;line-height:1.15}
  .welcome p{font-size:.85rem;margin-top:2px}

  /* ===== Kartu statistik ===== */
  .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px}
  .stat{display:flex;gap:10px;border:2px solid var(--ink);border-radius:16px;padding:12px;align-items:flex-start}
  .stat i{width:38px;height:38px;border-radius:10px;background:var(--coffee);color:#fff;display:grid;place-items:center;flex:none}
  .stat i svg{width:22px;height:22px}
  .stat > div{min-width:0;flex:1}
  .stat small{display:block;font-size:.72rem}
  .stat b{display:block;font-family:"Outfit",sans-serif;font-weight:800;font-size:clamp(1.2rem,1.7vw,1.5rem);line-height:1.25;white-space:nowrap}
  .stat span{font-size:.78rem}
  .stat .mt{display:flex;justify-content:space-between;gap:16px;font-size:.72rem}

  /* ===== Kartu & tabel ===== */
  .card{border:2px solid var(--ink);border-radius:20px;padding:16px 18px;overflow-x:auto}
  .card.tall{min-height:520px}
  .card h2{font-size:1.15rem;font-weight:700}
  .card-h{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;flex-wrap:wrap;gap:10px}
  .tabs{display:flex;gap:8px}
  .tab{padding:8px 16px;border-radius:8px;background:#ebe7e2;color:var(--coffee);font-size:.85rem}
  .tab.on{background:var(--coffee);color:#fff}
  .tb{width:100%;min-width:640px;border-collapse:collapse;font-size:.8rem}
  .tb th,.tb td{white-space:nowrap}
  .tb td.wrap{white-space:normal;min-width:150px}
  .tb th{background:var(--cream);font-weight:600;text-align:left;padding:12px 8px;font-size:.82rem}
  .tb td{padding:10px 8px;border-bottom:1px solid #f4ead4}
  .tb th:first-child,.tb td:first-child{text-align:center;width:40px}
  .tb tbody tr{cursor:pointer}
  .tb tbody tr:hover{background:#fdf9f2}
  .tb tr.sel{background:#f6ebdc}
  .badge{display:inline-block;min-width:76px;text-align:center;padding:3px 10px;border-radius:6px;font-size:.7rem}
  .badge.menunggu{background:#fbd3ba;color:#c0632b}
  .badge.diproses{background:#f8e8ad;color:#8a7616}
  .badge.selesai{background:#bfeac3;color:#2f7a34}

  /* ===== Menu cepat ===== */
  .quick{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-top:12px}
  .qc{border:2px solid var(--ink);border-radius:18px;padding:8px;text-align:left}
  .qc .thumb{width:100%;height:92px;border-radius:12px;font-size:2rem}
  .qc b{display:block;font-size:.82rem;margin-top:8px}
  .qc small{display:block;font-size:.72rem;margin-bottom:6px}
  .linkbtn{font-weight:700;font-size:.85rem;color:var(--coffee);padding:6px 4px}
  .linkbtn:hover{text-decoration:underline}
  .qadd{width:100%;background:var(--coffee);color:#fff;border-radius:8px;padding:7px;font-size:.82rem}

  .thumb{position:relative;width:46px;height:46px;border-radius:6px;overflow:hidden;flex:none;
    background:linear-gradient(135deg,#ead9c8,#c9a58a);display:grid;place-items:center;font-size:1.3rem}
  .thumb img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}

  /* ===== Panel kanan ===== */
  .rp{border:2px solid var(--ink);border-radius:22px;padding:16px 18px;position:sticky;top:16px;overflow-wrap:anywhere}
  .rp-h{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
  .rp-h h2{font-size:1.35rem;font-weight:800}
  .info2{display:grid;grid-template-columns:1fr 1fr;border-top:1px solid #8a6f64;border-bottom:1px solid #8a6f64}
  .info2 > div{padding:10px 4px 12px;font-size:.85rem}
  .info2 > div:nth-child(even){border-left:1px solid #8a6f64;padding-left:14px}
  .info2 > div:nth-child(n+3){border-top:1px solid #8a6f64}
  .info2 small,.kv small{display:block;font-size:.74rem}
  .info2 b,.kv b{display:block;font-size:1rem;font-weight:800}
  .rp h3{font-size:.95rem;font-weight:700;margin:16px 0 6px}
  .li{display:flex;gap:10px;align-items:flex-start;padding:10px 0;border-bottom:1px solid #b9a196}
  .li .thumb{width:46px;height:46px}
  .li-i{flex:1}
  .li-i b{display:block;font-size:.85rem}
  .li-i small{display:block;font-size:.72rem}
  .li-t{font-size:.85rem;align-self:flex-end}
  .step{display:flex;align-items:center;gap:10px;margin-top:4px}
  .step button{font-size:1.1rem;line-height:1;width:18px}
  .step span{font-size:.75rem}
  .sum2{padding:10px 0 4px}
  .sum2 > div{display:flex;justify-content:space-between;font-size:.85rem;padding:3px 0}
  .sum2 .tot{font-family:"Outfit",sans-serif;font-weight:800;font-size:1.15rem;margin-top:4px}
  .b1,.b2,.b3{width:100%;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;gap:10px;margin-top:12px;font-size:.9rem}
  .b1{background:var(--coffee);color:#fff}
  .b2{border:1.5px solid var(--ink);background:#fff}
  .b3{background:var(--cream)}
  .b1 svg,.b2 svg,.b3 svg{width:20px;height:20px}
  .cat{border:1.5px solid var(--ink);border-radius:14px;padding:10px 12px;margin-top:14px}
  .cat label{font-weight:700;font-size:.85rem;display:block;padding-left:10px}
  .cat textarea{width:100%;height:90px;border:0;outline:0;resize:none;padding:6px 10px;font-size:.85rem}
  .kv{padding:8px 0;font-size:.85rem}
  .totbox{display:flex;justify-content:space-between;align-items:center;border:1.5px solid #8a6f64;background:var(--cream);border-radius:10px;padding:14px 16px;margin-top:10px;font-family:"Outfit",sans-serif;font-size:1.15rem}
  .totbox b{font-weight:800}

  /* ===== Pembayaran tunai (uang diterima & kembalian) ===== */
  .cash{border:1.5px solid var(--ink);border-radius:14px;padding:12px 14px;margin-top:12px;background:var(--cream)}
  .cash label{display:block;font-weight:700;font-size:.85rem;margin-bottom:6px}
  .cash input{width:100%;height:42px;border:1.5px solid #8a6f64;border-radius:10px;padding:0 12px;outline:0;font-size:.95rem;background:#fff}
  .cash input:disabled{background:#f1ebe4}
  .cash .pecah{display:flex;gap:8px;flex-wrap:wrap;margin-top:8px}
  .cash .pecah button{padding:6px 12px;border-radius:8px;background:#fff;border:1px solid #8a6f64;font-size:.78rem}
  .cash .pecah button:disabled{opacity:.5;cursor:default}
  .cash .kmb{display:flex;justify-content:space-between;margin-top:12px;font-family:"Outfit",sans-serif;font-weight:800;font-size:1.05rem}
  .cash .kmb.kurang{color:#c0392b}

  .toast{position:fixed;left:50%;bottom:30px;transform:translateX(-50%);background:#2b1d16;color:#fff;padding:10px 18px;
    border-radius:20px;font-size:.85rem;opacity:0;pointer-events:none;transition:opacity .25s;z-index:10}
  .toast.show{opacity:1}

  @media (max-width:1100px){
    .body{grid-template-columns:1fr}
    .stats{grid-template-columns:repeat(2,1fr)}
    .rp{position:static}
  }
  @media (max-width:800px){
    .app{grid-template-columns:1fr}
    .side{position:static;height:auto}
    .quick{grid-template-columns:repeat(2,1fr)}
    .card{overflow-x:auto}
  }
</style>
</head>
<body>

<div id="app"></div>
<div class="toast" id="toast"></div>

<script>
/* ===================== DATA ===================== */
// Foto menu diambil dari public/images (nama file sama seperti di halaman pelanggan)
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
const KEY = 'beanbyte_kasir';
const BLN = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sept','Okt','Nov','Des'];

const MENU = [
  ['americano','Americano','americano.jpg','🧊'],
  ['latte','Latte','latte.jpg','🥛'],
  ['cappuccino','Cappuccino','cappucino.jpg','☕'],
  ['caramel-macchiato','Caramel Macchiato','caramel.jpg','🍮'],
  ['affogato','Affogato','affogato.jpg','🍨'],
  ['butterscots','Butterscots','butterscots.jpg','☕'],
  ['espresso','Espresso','esspreso.jpg','☕'],
  ['cocolate','Cocolate','cocolate.jpg','🍫'],
  ['matcha','Matcha','matcha.jpg','🍵'],
  ['fresh-orange','Fresh Orange','jus jeruk.jpg','🍊'],
  ['milk-tea','Milk Tea','milk tea.jpg','🧋'],
  ['jus-strawberry','Jus Strawberry','jud strawberry.jpg','🍓'],
  ['croissant','Croissant','croissant.jpg','🥐'],
  ['spaghetti','Spaghetti','spageti.jpg','🍝'],
  ['donat','Donat','donat.jpg','🍩'],
  ['french-fries','French Fries','kentang.jpg','🍟'],
  ['nasi-goreng-spesial','Nasi Goreng Spesial','nasi-goreng-spesial.jpg','🍳']
].map(([id,nama,foto,emoji]) => ({id,nama,foto,emoji,harga:HARGA}));

const QUICK = ['americano','latte','cappuccino','espresso'];

function seedOrders() {
  // [no pesanan, meja, pelanggan, menu, status, waktu, metode bayar]
  const R = [
    ['B016','A013','Sri',['croissant','americano'],'Menunggu','10.00','QRIS'],
    ['B007','A010','Kisa',['americano','matcha'],'Diproses','10.10','Tunai'],
    ['B008','A008','Juliana',['matcha'],'Diproses','10.08','QRIS'],
    ['B005','A015','Alen',['americano'],'Selesai','10.20','QRIS'],
    ['B013','A007','Alip',['caramel-macchiato'],'Menunggu','9.45','Tunai'],
    ['B004','A004','Leon',['latte'],'Selesai','10.40','QRIS'],
    ['B006','A005','Sarah',['jus-strawberry'],'Diproses','10.15','QRIS'],
    ['B012','A003','Nesya',['donat'],'Diproses','9.20','Tunai'],
    ['B009','A006','Alia',['spaghetti'],'Diproses','10.05','QRIS'],
    ['B001','A009','Tera',['milk-tea','donat'],'Selesai','11.05','QRIS'],
    ['B015','A016','Oila',['espresso'],'Menunggu','9.43','Tunai'],
    ['B010','A017','Tola',['french-fries'],'Diproses','10.04','QRIS'],
    ['B003','A002','Sera',['cocolate','donat'],'Selesai','10.55','Tunai'],
    ['B011','A014','Liondra',['matcha','spaghetti'],'Diproses','10.02','QRIS'],
    ['B002','A001','Yura',['nasi-goreng-spesial'],'Selesai','11.00','QRIS'],
    ['B014','A020','Hira',['fresh-orange'],'Menunggu','9.40','QRIS']
  ];
  return R.map(([pes,meja,nama,ids,status,waktu,metode]) =>
    ({pes,meja,nama,items:ids.map(id => ({id,qty:1})),status,waktu,metode,catatan:''}));
}

function seedTrx() {
  const R = [
    ['Sri','QRIS',['croissant','americano']],['Kisa','QRIS',['americano']],['Juliana','QRIS',['matcha']],
    ['Alen','Tunai',['americano']],['Alip','QRIS',['caramel-macchiato']],['Leon','QRIS',['latte']],
    ['Sarah','Tunai',['jus-strawberry']],['Alex','QRIS',['donat']]
  ];
  return R.map(([nama,metode,ids],i) => ({
    trx:'TRX-20260924-' + String(i + 1).padStart(3,'0'),
    waktu:'24 Sept 2026 10:12', nama, metode, items:ids.map(id => ({id,qty:1}))
  }));
}

/* ===================== STATE ===================== */
let db = null;
try { db = JSON.parse(localStorage.getItem(KEY)); } catch (e) {}
if (!db || !Array.isArray(db.orders) || !Array.isArray(db.trx)) db = {orders:seedOrders(), trx:seedTrx()};
const save = () => { try { localStorage.setItem(KEY, JSON.stringify(db)); } catch (e) {} };

/* ===== Pesanan masuk dari halaman pelanggan =====
   Pesanan dibaca dari antrian bersama (localStorage) dan muncul otomatis sebagai status "Menunggu".
   Perubahan status di kasir ditulis balik supaya terlihat di Riwayat Pesanan pelanggan.
   Berjalan selama halaman pelanggan dan kasir dibuka di browser yang sama. */
const ANTRIAN = 'beanbyte_antrian';
if (!Array.isArray(db.diambil)) db.diambil = [];
const bacaAntrian = () => { try { const a = JSON.parse(localStorage.getItem(ANTRIAN)); return Array.isArray(a) ? a : []; } catch (e) { return []; } };
const tulisAntrian = a => { try { localStorage.setItem(ANTRIAN, JSON.stringify(a)); } catch (e) {} };
function setStatusAntrian(pes, status) {
  const a = bacaAntrian(), x = a.find(y => y.no === pes);
  if (x) { x.status = status; tulisAntrian(a); }
}

function ambilPesananBaru() {
  let baru = 0, terakhir = '';

  bacaAntrian().forEach(x => {
    if (db.diambil.includes(x.no) || db.orders.some(o => o.pes === x.no)) return;

    const d = new Date(x.ts);

    db.diambil.push(x.no);
    db.orders.unshift({
      pes: x.no,
      meja: x.nomor_meja
        ? 'Meja ' + x.nomor_meja
        : (x.id_meja ? 'Meja M' + String(x.id_meja).padStart(2, '0') : 'Online'),
      nama: x.nama,
      items: x.items.map(i => ({id: i.id, qty: i.qty})),
      status: ['Selesai', 'Diproses', 'Dibatalkan'].includes(x.status)
        ? x.status
        : 'Menunggu',
      waktu: d.getHours() + '.' + String(d.getMinutes()).padStart(2, '0'),
      metode: x.metode === 'qris' ? 'QRIS' : 'Tunai',
      catatan: x.catatan || '',
      sumber: 'pelanggan'
    });

    baru++;
    terakhir = x.nama;
  });

  if (baru) save();
  return {baru, terakhir};
}

function bunyi() {
  try {
    const c = new (window.AudioContext || window.webkitAudioContext)(), o = c.createOscillator(), g = c.createGain();
    o.connect(g); g.connect(c.destination); o.frequency.value = 880; g.gain.value = 0.08;
    o.start(); o.stop(c.currentTime + 0.15);
  } catch (e) {}
}
let perluRender = false;
function sinkron() {
  const r = ambilPesananBaru();
  if (r.baru) {
    perluRender = true;
    toast(r.baru === 1 ? 'Pesanan baru dari ' + r.terakhir : r.baru + ' pesanan baru masuk');
    bunyi();
  }
  const el = document.activeElement;
  if (perluRender && !(el && /^(INPUT|TEXTAREA|SELECT)$/.test(el.tagName))) { perluRender = false; render(); }
}

/* ===== SINKRONISASI PESANAN DATABASE BEANBYTE ===== */
const API_PESANAN = '/api/pesanan';
const API_MENU = '/api/menu';
let apiSedangDimuat = false;
let apiGagalPernah = false;

function normalisasiNamaMenu(v) {
  return String(v || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');
}

function statusDariDatabase(v) {
  const s = String(v || 'menunggu').toLowerCase();

  if (s.includes('selesai') || s.includes('lunas')) return 'Selesai';
  if (s.includes('proses')) return 'Diproses';
  if (s.includes('batal')) return 'Dibatalkan';

  return 'Menunggu';
}

function waktuDariDatabase(v) {
  if (!v) return '--:--';

  const teks = String(v).trim().replace(' ', 'T');

  // Jika database tidak menyertakan zona waktu,
  // anggap waktu yang tersimpan adalah UTC.
  const adaZonaWaktu = /(?:Z|[+-]\d{2}:?\d{2})$/i.test(teks);

  const d = new Date(adaZonaWaktu ? teks : teks + 'Z');

  if (Number.isNaN(d.getTime())) {
    return String(v).slice(-5);
  }

  return pad(d.getHours()) + '.' + pad(d.getMinutes());
}

function cariMenuFrontend(nama) {
  const n = normalisasiNamaMenu(nama);

  const alias = {
    'nasi-goreng': 'nasi-goreng-spesial',
    'jus-strawberi': 'jus-strawberry',
    'spageti': 'spaghetti',
    'cokelat': 'cocolate',
    'coklat': 'cocolate'
  };

  const key = alias[n] || n;

  let hasil = MENU.find(m =>
    normalisasiNamaMenu(m.id) === key ||
    normalisasiNamaMenu(m.nama) === key
  );

  if (hasil) return hasil;

  return MENU.find(m => {
    const id = normalisasiNamaMenu(m.id);
    const nm = normalisasiNamaMenu(m.nama);

    return key.length > 3 &&
      (key.includes(id) || id.includes(key) ||
       key.includes(nm) || nm.includes(key));
  }) || null;
}

async function sinkronPesananDatabase() {
  if (apiSedangDimuat) return;

  apiSedangDimuat = true;

  try {
    // Mengambil data pesanan dan menu dari API
    const [resPesanan, resMenu] = await Promise.all([
      fetch(API_PESANAN, {
        headers: { Accept: 'application/json' },
        cache: 'no-store'
      }),

      fetch(API_MENU, {
        headers: { Accept: 'application/json' },
        cache: 'no-store'
      })
    ]);

    if (!resPesanan.ok) {
      throw new Error('API pesanan HTTP ' + resPesanan.status);
    }

    if (!resMenu.ok) {
      throw new Error('API menu HTTP ' + resMenu.status);
    }

    const jsonPesanan = await resPesanan.json();
    const jsonMenu = await resMenu.json();

    console.log('DATA PESANAN API:', jsonPesanan);
    console.log('DATA MENU API:', jsonMenu);

    // Memastikan data berbentuk array
    const daftarPesanan = Array.isArray(jsonPesanan)
      ? jsonPesanan
      : (Array.isArray(jsonPesanan.data) ? jsonPesanan.data : []);

    const daftarMenu = Array.isArray(jsonMenu)
      ? jsonMenu
      : (Array.isArray(jsonMenu.data) ? jsonMenu.data : []);

    // Mencocokkan ID menu dari database dengan data menu
    const menuById = new Map(
      daftarMenu.map(m => [
        String(m.id_menu ?? m.id),
        m
      ])
    );

    // Menyimpan data pesanan lama
    const pesananLama = new Map(
      db.orders
        .filter(o => o.idDatabase != null)
        .map(o => [String(o.idDatabase), o])
    );

    // Mengubah data pesanan database agar bisa dibaca halaman kasir
    const pesananDatabase = daftarPesanan.map(p => {
      const id = p.id_pesanan ?? p.id;

      if (id == null) return null;

      const lama = pesananLama.get(String(id));
      const pelanggan = p.pelanggan || {};
      const meja = p.meja || {};

      // Mengambil detail menu pesanan
      const detail =
        p.detail_pesanans ||
        p.detailPesanans ||
        p.detail_pesanan ||
        p.details ||
        [];

      // Mengubah detail database menjadi daftar menu kasir
      const items = (Array.isArray(detail) ? detail : [])
        .map(d => {
          const menu =
            d.menu ||
            d.menus ||
            menuById.get(String(d.id_menu ?? d.menu_id ?? ''));

          const namaMenu =
            menu?.nama_menu ||
            menu?.nama ||
            menu?.name ||
            d.nama_menu ||
            d.menu_name ||
            d.nama ||
            '';

          const menuFrontend = cariMenuFrontend(namaMenu);

          if (!menuFrontend) {
            console.warn('Menu tidak ditemukan:', namaMenu, d);
            return null;
          }

          const jumlah = Number(
            d.jumlah ?? d.qty ?? d.quantity ?? 1
          );

         return {
  id: menuFrontend.id,
  qty: Number.isFinite(jumlah) && jumlah > 0
    ? jumlah
    : 1
};
}).filter(item => item !== null);

      // Mengambil nomor meja
      const nomorMeja =
        meja.nomor_meja ||
        meja.kode_meja ||
        meja.nama_meja ||
        meja.no_meja ||
        p.nomor_meja ||
        p.id_meja ||
        '-';

      const mejaTeks = String(nomorMeja);

      // Mengambil data transaksi
      const transaksi = Array.isArray(p.transaksi)
        ? (p.transaksi[0] || {})
        : (p.transaksi || {});

      // Mengambil metode pembayaran
      const metodePembayaran =
        transaksi.metode_pembayaran ||
        p.metode_pembayaran ||
        'Tunai';

      const namaMetode =
        typeof metodePembayaran === 'object'
          ? (
              metodePembayaran.nama_metode ||
              metodePembayaran.nama ||
              'Tunai'
            )
          : metodePembayaran;

      // Mengambil nama pelanggan
      const namaPelanggan =
        pelanggan.nama_pelanggan ||
        pelanggan.nama ||
        p.nama_pelanggan ||
        p.nama ||
        ('Pelanggan ' + (p.id_pelanggan ?? ''));

      return {
        pes: 'DB-' + String(id).padStart(4, '0'),

        idDatabase: id,

        meja: mejaTeks.toLowerCase().startsWith('meja')
          ? mejaTeks
          : 'Meja ' + mejaTeks,

        nama: namaPelanggan,

        items: items,

        status: lama?.status || statusDariDatabase(p.status),

        waktu: waktuDariDatabase(
          p.tanggal_pesanan || p.created_at
        ),

        metode: String(namaMetode).toLowerCase().includes('qris')
          ? 'QRIS'
          : 'Tunai',

        catatan: lama?.catatan || p.catatan || '',

        sumber: 'database',

        totalDatabase: Number(p.total_harga || p.total || 0),

        bayar: lama?.bayar
      };
   }).filter(p =>
  p !== null &&
  Array.isArray(p.items) &&
  p.items.length > 0
);

console.log('PESANAN HASIL SINKRON:', pesananDatabase);
    // Menampilkan pesanan dari database
    const dataSebelum = JSON.stringify(db.orders);

    db.orders = pesananDatabase;

    // Memilih pesanan pertama jika pesanan sebelumnya tidak tersedia
    if (!db.orders.some(o => o.pes === selOrder)) {
      selOrder = db.orders.length
        ? db.orders[0].pes
        : null;
    }

    // Menyimpan dan memperbarui tampilan
    save();

    if (JSON.stringify(db.orders) !== dataSebelum) {
      render();
    }

    apiGagalPernah = false;

  } catch (e) {
    if (!apiGagalPernah) {
      console.warn(
        'Sinkronisasi pesanan BeanByte gagal:',
        e.message
      );
    }

    apiGagalPernah = true;

  } finally {
    apiSedangDimuat = false;
  }
}

let page = 'dashboard';
let filter = 'Semua';
let q = '';
let quickAll = false;   // false = 4 menu cepat, true = semua menu
let selOrder = db.orders.length ? db.orders[0].pes : null;
let selTrx = db.trx.length ? db.trx[0].trx : null;

/* ===================== HELPER ===================== */
const $ = s => document.querySelector(s);
const pad = n => String(n).padStart(2, '0');
const rp = n => 'Rp ' + n.toLocaleString('id-ID');
const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const byId = id => MENU.find(m => m.id === id);
const menuText = o => o.items.map(i => byId(i.id).nama).join(', ');
const tglPendek = () => { const d = new Date(); return d.getDate() + ' ' + BLN[d.getMonth()]; };
const badge = s => `<span class="badge ${s.toLowerCase()}">${s}</span>`;
const angka = s => parseInt(String(s).replace(/\D/g, ''), 10) || 0;

function calc(items) {
  let qty = 0, sub = 0;
  items.forEach(i => { qty += i.qty; sub += byId(i.id).harga * i.qty; });
  const diskon = qty > 2 ? Math.round(sub * 0.15) : 0;   // diskon 15% bila lebih dari 2 menu
  return {qty, sub, diskon, total: sub - diskon};
}

let toastTimer;
function toast(msg) {
  const t = $('#toast');
  t.textContent = msg; t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 1800);
}

function tick() {
  const d = new Date();
  document.querySelectorAll('.dt-date').forEach(e => e.textContent = `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()}`);
  document.querySelectorAll('.dt-time').forEach(e => e.textContent = `${pad(d.getHours())}:${pad(d.getMinutes())}`);
}
setInterval(tick, 30000);

/* ===================== IKON ===================== */
const svg = (p, extra = '') => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ${extra}>${p}</svg>`;
const I = {
  home:   `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 11l9-8 9 8v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg>`,
  note:   svg('<path d="M14 3H6a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8zM14 3v5h5M8.5 12h7M8.5 16h4"/>'),
  wallet: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 7a2 2 0 0 1 2-2h12v3H5v.5h15a1 1 0 0 1 1 1V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zM16 13.5a1.3 1.3 0 1 0 0 2.6 1.3 1.3 0 0 0 0-2.6z"/></svg>`,
  logout: svg('<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>'),
  search: svg('<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>','stroke-width="2"'),
  cal:    svg('<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>'),
  clock:  svg('<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>'),
  clip:   svg('<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 3h6v3H9zM9 13l2 2 4-4"/>'),
  check:  svg('<path d="M5 12.5l4.5 4.5L19 7.5"/>','stroke-width="2.6"'),
  dollar: svg('<circle cx="12" cy="12" r="9"/><path d="M14.5 9.2c-.6-.9-1.5-1.2-2.5-1.2-1.4 0-2.4.8-2.4 1.9 0 2.6 5 1.3 5 3.9 0 1.1-1.1 2-2.6 2-1.1 0-2.1-.5-2.6-1.4M12 6v2M12 16v2"/>'),
  okc:    `<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#fff"/><path d="M7 12.5l3.5 3.5L17 9" fill="none" stroke="#62392a" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
  print:  svg('<path d="M6 9V3h12v6M6 18H4a1 1 0 0 1-1-1v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1h-2"/><rect x="6" y="14" width="12" height="7"/>'),
  trash:  svg('<path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13M10 11v6M14 11v6"/>'),
  plus:   svg('<path d="M12 5v14M5 12h14"/>','stroke-width="2.4"')
};

const logo = (c, bg) => `<svg class="logo" viewBox="0 0 100 100" fill="${c}">
  <g fill="none" stroke="${c}" stroke-width="2.6" stroke-linecap="round">
    <path d="M36 6c-4 4 4 7 0 12s-4 6 0 8"/><path d="M50 2c-4 5 4 8 0 14s-4 8 0 10"/><path d="M64 6c-4 4 4 7 0 12s-4 6 0 8"/>
  </g>
  <path d="M12 38h62v8c0 16-9 27-22 27H36C22 73 12 62 12 46z"/>
  <path d="M74 44h6c8 0 11 4 11 8 0 7-8 14-17 14v-5c6 0 11-4 11-8 0-2-2-3-5-3h-6z"/>
  <path d="M24 44c1 12 8 20 16 22-9-3-13-12-12-22z" fill="${bg}"/>
  <ellipse cx="46" cy="83" rx="44" ry="6"/></svg>`;

const thumb = m => `<div class="thumb"><span>${m.emoji}</span>${imgTag(m.id, m.foto, esc(m.nama))}</div>`;
const dateChip = () => `<div class="dchip">${I.cal}<span class="dt-date"></span>${I.clock}<span class="dt-time"></span></div>`;
const statCard = (icon, label, val, sub) => `<div class="stat"><i>${icon}</i><div><small>${label}</small><b>${val}</b>${sub ? `<span>${sub}</span>` : ''}</div></div>`;

/* ===================== KERANGKA (SIDEBAR + HEADER) ===================== */
function shell(content, placeholder, showDate) {
  const link = (k, l, i) => `<button class="nv ${page === k ? 'on' : ''}" onclick="nav('${k}')">${i}<span>${l}</span></button>`;
  return `<div class="app">
    <aside class="side">
      <div class="brand">${logo('#ffefd5','#472f24')}<div><b>BeanByte</b><small>Kopi • Rasa • Overthinking</small></div></div>
      <nav>${link('dashboard','Dashboard',I.home)}${link('pesanan','Daftar Pesanan',I.note)}${link('transaksi','Transaksi',I.wallet)}</nav>
      <div class="side-bot">
  <form method="POST" action="/logout" style="margin:0">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <span class="kasir-name">
      {{ session('name', session('username', 'Kasir')) }}
    </span>

    <button class="nv" type="submit" style="margin:0">
      ${I.logout}<span>Logout</span>
    </button>
  </form>
</div>
</aside>
    <main class="main">
      <header class="head"><div class="sbox">${I.search}<input id="q" value="${esc(q)}" placeholder="${placeholder}" oninput="setQ(this.value)"></div>${showDate ? dateChip() : ''}</header>
      ${content}
    </main></div>`;
}
/* ===================== DAFTAR PESANAN ===================== */
function visibleOrders() {
  const kw = q.trim().toLowerCase();

  let l = db.orders.filter(
    o => filter === 'Semua' || o.status === filter
  );

  if (kw) {
    l = l.filter(o =>
      [o.nama, o.meja, o.pes, menuText(o)]
        .join(' ')
        .toLowerCase()
        .includes(kw)
    );
  }

  // Pesanan terbaru ditampilkan paling atas
  l.sort((a, b) =>
    Number(b.idDatabase || 0) - Number(a.idDatabase || 0)
  );

  // Dashboard menampilkan maksimal 8 pesanan
  return page === 'dashboard' ? l.slice(0, 8) : l;
}

function tabs() {
  return `<div class="tabs">${['Semua','Diproses','Selesai','Menunggu'].map(f => `<button class="tab ${filter === f ? 'on' : ''}" onclick="setFilter('${f}')">${f}</button>`).join('')}</div>`;
}

function ordersHtml() {
  const l = visibleOrders();
  const full = page === 'pesanan';
  if (!l.length) return '<p class="empty">Pesanan tidak ditemukan</p>';
  return `<table class="tb"><thead><tr><th>No</th><th>${full ? 'No Meja' : 'Nomor Meja'}</th><th>Nama Pelanggan</th><th>Menu</th><th>Status</th><th>Waktu Pesan</th>${full ? '<th>No Pesanan</th>' : ''}</tr></thead><tbody>
    ${l.map((o, i) => `<tr class="${o.pes === selOrder ? 'sel' : ''}" onclick="pilih('${o.pes}')"><td>${i + 1}</td><td>${o.meja}</td><td>${esc(o.nama)}</td><td class="wrap">${menuText(o)}</td><td>${badge(o.status)}</td><td>${o.waktu}</td>${full ? `<td>${o.pes}</td>` : ''}</tr>`).join('')}
  </tbody></table>`;
}

/* ----- Pembayaran tunai: uang diterima & kembalian ----- */
const kmbText = (selisih, bayar) => !bayar
  ? '<span>Kembalian</span><span>Rp 0</span>'
  : selisih < 0
    ? `<span>Uang kurang</span><span>${rp(-selisih)}</span>`
    : `<span>Kembalian</span><span>${rp(selisih)}</span>`;

function panelTunai(o, total) {
  const kunci = o.status === 'Selesai';
  const bayar = o.bayar || 0;
  return `<div class="cash">
    <label for="uang">Uang diterima (Tunai)</label>
    <input id="uang" inputmode="numeric" placeholder="Rp 0" ${kunci ? 'disabled' : ''}
      value="${bayar ? bayar.toLocaleString('id-ID') : ''}" oninput="setBayar(this.value)">
    ${kunci ? '' : `<div class="pecah">
      <button onclick="setBayar(${total}, true)">Uang pas</button>
      ${[20000, 50000, 100000].map(n => `<button onclick="setBayar(${n}, true)">${rp(n)}</button>`).join('')}
    </div>`}
    <div class="kmb ${bayar && bayar < total ? 'kurang' : ''}" id="kmb">${kmbText(bayar - total, bayar)}</div>
  </div>`;
}

function detailOrder() {
  const o = db.orders.find(x => x.pes === selOrder);
  if (!o) return `<aside class="rp"><div class="rp-h"><h2>Detail Pesanan</h2></div><p class="empty">Pilih pesanan dari daftar</p></aside>`;
  const t = calc(o.items);
  const items = o.items.map(i => { const m = byId(i.id); return `<div class="li">${thumb(m)}
      <div class="li-i"><b>${m.nama}</b><small>${rp(m.harga)}</small>
        <div class="step"><button onclick="ubahItem('${i.id}',-1)">−</button><span>${i.qty}</span><button onclick="ubahItem('${i.id}',1)">+</button></div></div>
      <span class="li-t">${rp(m.harga * i.qty)}</span></div>`; }).join('');
  return `<aside class="rp">
    <div class="rp-h"><h2>Detail Pesanan</h2>${badge(o.status)}</div>
    <div class="info2">
      <div><small>No. Pesanan</small><b>${o.pes}</b></div>
      <div><small>Waktu Pesan</small><span>${tglPendek()} • ${o.waktu}</span></div>
      <div><small>Meja</small><b>${o.meja}</b></div>
      <div><small>Pelanggan</small><span>${esc(o.nama)}</span></div>
      <div><small>Pembayaran</small><b>${o.metode}</b></div>
      <div><small>Asal</small><span>${o.sumber === 'pelanggan' ? 'Pesan online' : 'Kasir'}</span></div>
    </div>
    <h3>Daftar Menu</h3>
    ${items || '<p class="empty">Belum ada menu</p>'}
    <div class="sum2">
      <div><span>Subtotal</span><span>${rp(t.sub)}</span></div>
      ${t.diskon ? `<div><span>Diskon (15%)</span><span>- ${rp(t.diskon)}</span></div>` : ''}
      <div class="tot"><span>Total</span><span>${rp(t.total)}</span></div>
    </div>
    ${o.metode === 'Tunai' ? panelTunai(o, t.total) : ''}
    <button class="b1" onclick="ubahStatus()">${I.okc}Ubah Status Pesanan</button>
    <button class="b2" onclick="cetakOrder()">${I.print}Cetak Struk</button>
    <button class="b3" onclick="batalkan()">${I.trash}Batalkan Pesanan</button>
    <div class="cat"><label>Catatan</label><textarea oninput="catatan(this.value)">${esc(o.catatan || '')}</textarea></div>
  </aside>`;
}

function quickMenu() {
  const ids = quickAll ? MENU.map(m => m.id) : QUICK;
  return `<section class="card">
    <div class="card-h" style="margin-bottom:0"><h2>Menu Cepat</h2>
      <button class="linkbtn" onclick="toggleQuick()">${quickAll ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua'}</button></div>
    <div class="quick">${ids.map(id => { const m = byId(id); return `<div class="qc">${thumb(m)}<b>${m.nama}</b><small>${rp(m.harga)}</small><button class="qadd" onclick="tambahCepat('${id}')">+ Tambah</button></div>`; }).join('')}</div></section>`;
}

/* ===================== TRANSAKSI ===================== */
function visibleTrx() {
  const kw = q.trim().toLowerCase();
  return db.trx.filter(t => !kw || [t.nama, t.trx, t.waktu, t.metode].join(' ').toLowerCase().includes(kw));
}

function trxHtml() {
  const l = visibleTrx();
  if (!l.length) return '<p class="empty">Transaksi tidak ditemukan</p>';
  return `<table class="tb"><thead><tr><th>No</th><th>Tanggal &amp; Waktu</th><th>Nama Pelanggan</th><th>No. Transaksi</th><th>Total</th><th>Metode Pembayaran</th><th>Status</th></tr></thead><tbody>
    ${l.map((t, i) => `<tr class="${t.trx === selTrx ? 'sel' : ''}" onclick="pilihTrx('${t.trx}')"><td>${i + 1}</td><td>${t.waktu}</td><td>${esc(t.nama)}</td><td>${t.trx}</td><td>${rp(calc(t.items).total)}</td><td>${t.metode}</td><td>${badge('Selesai')}</td></tr>`).join('')}
  </tbody></table>`;
}

function detailTrx() {
  const t = db.trx.find(x => x.trx === selTrx);
  if (!t) return `<aside class="rp"><div class="rp-h"><h2>Detail Transaksi</h2></div><p class="empty">Pilih transaksi dari daftar</p></aside>`;
  const c = calc(t.items);
  return `<aside class="rp">
    <div class="rp-h"><h2>Detail Transaksi</h2>${badge('Selesai')}</div>
    <div class="kv"><small>No. Pesanan</small><b>${t.trx}</b></div>
    <div class="kv"><small>Tanggal &amp; Waktu</small><span>${t.waktu}</span></div>
    <div class="kv"><small>Pelanggan</small><span>${esc(t.nama)}</span></div>
    <div class="kv"><small>Metode Pembayaran</small><span>${t.metode}</span></div>
    <h3 style="border-top:1px solid #8a6f64;padding-top:14px">Item Pesanan</h3>
    ${t.items.map(i => { const m = byId(i.id); return `<div class="li">${thumb(m)}<div class="li-i"><b>${m.nama}</b><small>×${i.qty}</small></div><span class="li-t">${rp(m.harga * i.qty)}</span></div>`; }).join('')}
    <div class="sum2">
      <div><span>Subtotal</span><span>${rp(c.sub)}</span></div>
      ${c.diskon ? `<div><span>Diskon (15%)</span><span>- ${rp(c.diskon)}</span></div>` : ''}
    </div>
    <div class="totbox"><b>Total</b><b>${rp(c.total)}</b></div>
    ${t.metode === 'Tunai' && t.bayar ? `<div class="sum2" style="margin-top:8px">
      <div><span>Uang diterima</span><span>${rp(t.bayar)}</span></div>
      <div class="tot"><span>Kembalian</span><span>${rp(t.bayar - c.total)}</span></div></div>` : ''}
    <button class="b1" style="margin-top:18px" onclick="cetakTrx()">${I.print}Cetak Struk</button>
  </aside>`;
}

/* ===================== LAYAR ===================== */
const SCREENS = {

  dashboard: () => {
    const O = db.orders;
    const pendapatan = O.filter(o => o.status === 'Selesai').reduce((s, o) => s + calc(o.items).total, 0);
    return shell(`<div class="body"><div class="col">
      <div class="welcome"><div><h1>Selamat Datang Kasir!</h1><p>Semangat bekerja, setiap pesanan adalah kebahagiaan pelanggan</p></div>${dateChip()}</div>
      <div class="stats">
        ${statCard(I.clip, 'Total Pesanan Hari ini', O.length, 'Pesanan')}
        ${statCard(I.clock, 'Pesanan Diproses', O.filter(o => o.status === 'Diproses').length, 'Pesanan')}
        ${statCard(I.check, 'Pesanan Selesai', O.filter(o => o.status === 'Selesai').length, 'Pesanan')}
        ${statCard(I.dollar, 'Total Pendapatan Hari ini', rp(pendapatan), '')}
      </div>
      <section class="card"><div class="card-h"><h2>Daftar Pesanan</h2>${tabs()}</div><div id="tbl">${ordersHtml()}</div></section>
      ${quickMenu()}
    </div>${detailOrder()}</div>`, 'Cari pesanan, nama pelanggan, atau nomor meja....', false);
  },

  pesanan: () => shell(`<div class="body"><div class="col">
      <section class="card tall"><div class="card-h"><h2>Daftar Pesanan</h2>${tabs()}</div><div id="tbl">${ordersHtml()}</div></section>
    </div>${detailOrder()}</div>`, 'Cari nama pelanggan, No pesanan, No meja....', false),

  transaksi: () => {
    const T = db.trx;
    const total = T.reduce((s, t) => s + calc(t.items).total, 0);
    const rata = T.length ? Math.round(total / T.length) : 0;
    const tunai = T.length ? Math.round(T.filter(t => t.metode === 'Tunai').length * 100 / T.length) : 0;
    const metodeCard = `<div class="stat"><i>${I.check}</i><div style="flex:1"><small>Metode Pembayaran</small>
        <div class="mt" style="margin-top:6px"><span>Tunai</span><b style="font-size:.8rem;font-family:inherit">${tunai}%</b></div>
        <div class="mt"><span>Non Tunai</span><b style="font-size:.8rem;font-family:inherit">${T.length ? 100 - tunai : 0}%</b></div></div></div>`;
    return shell(`<div class="body"><div class="col">
      <div class="stats">
        ${statCard(I.clip, 'Total Transaksi', T.length, 'Transaksi')}
        ${statCard(I.dollar, 'Total Pendapatan', rp(total), '')}
        ${statCard(I.clock, 'Rata-Rata Transaksi', rp(rata), '')}
        ${metodeCard}
      </div>
      <section class="card tall"><div class="card-h"><h2>Daftar Pesanan</h2></div><div id="tbl">${trxHtml()}</div></section>
    </div>${detailTrx()}</div>`, 'Cari no transaksi, nama pelanggan, tanggal&amp;waktu', true);
  }
};

function render() {
  $('#app').innerHTML = SCREENS[page]();
  tick();
}

/* ===================== AKSI ===================== */
function nav(k) { page = k; q = ''; filter = 'Semua'; render(); window.scrollTo(0, 0); }
function setFilter(f) { filter = f; render(); }
function toggleQuick() { quickAll = !quickAll; const y = window.scrollY; render(); window.scrollTo(0, y); }
function setQ(v) { q = v; $('#tbl').innerHTML = page === 'transaksi' ? trxHtml() : ordersHtml(); }
function pilih(pes) { selOrder = pes; const y = window.scrollY; render(); window.scrollTo(0, y); }
function pilihTrx(t) { selTrx = t; const y = window.scrollY; render(); window.scrollTo(0, y); }
const curOrder = () => db.orders.find(x => x.pes === selOrder);

function ubahItem(id, d) {
  const o = curOrder(); if (!o) return;
  if (o.status === 'Selesai') return toast('Pesanan sudah selesai, tidak bisa diubah');
  const it = o.items.find(i => i.id === id); if (!it) return;
  it.qty += d;
  o.items = o.items.filter(i => i.qty > 0);
  save(); render();
}

function tambahCepat(id) {
  const o = curOrder();
  if (!o) return toast('Pilih pesanan dulu');
  if (o.status === 'Selesai') return toast('Pesanan sudah selesai, tidak bisa diubah');
  const it = o.items.find(i => i.id === id);
  if (it) it.qty++; else o.items.push({id, qty:1});
  save(); render();
  toast(byId(id).nama + ' ditambahkan ke ' + o.pes);
}

function catatan(v) { const o = curOrder(); if (o) { o.catatan = v; save(); } }

// Isi uang diterima. Tidak memanggil render() supaya kolom input tidak kehilangan fokus saat mengetik.
function setBayar(v, isi) {
  const o = curOrder(); if (!o || o.status === 'Selesai') return;
  o.bayar = angka(v);
  save();
  const total = calc(o.items).total;
  const k = $('#kmb');
  if (k) { k.className = 'kmb' + (o.bayar && o.bayar < total ? ' kurang' : ''); k.innerHTML = kmbText(o.bayar - total, o.bayar); }
  if (isi) { const u = $('#uang'); if (u) u.value = o.bayar.toLocaleString('id-ID'); }
}

function ubahStatus() {
  const o = curOrder(); if (!o) return;
  if (o.status === 'Selesai') return toast('Pesanan sudah selesai');
  if (!o.items.length) return toast('Pesanan belum ada menu');
  if (o.status === 'Menunggu') {
    o.status = 'Diproses';
  } else {
    // Tunai: uang diterima harus cukup sebelum pesanan diselesaikan
    const total = calc(o.items).total;
    if (o.metode === 'Tunai' && (!o.bayar || o.bayar < total)) {
      toast(o.bayar ? 'Uang diterima kurang ' + rp(total - o.bayar) : 'Isi uang diterima dulu');
      const u = $('#uang'); if (u) u.focus();
      return;
    }
    o.status = 'Selesai';
    const d = new Date();
    const ymd = `${d.getFullYear()}${pad(d.getMonth() + 1)}${pad(d.getDate())}`;
    const n = db.trx.filter(t => t.trx.startsWith('TRX-' + ymd)).length + 1;
    const trx = {
      trx: `TRX-${ymd}-${String(n).padStart(3, '0')}`,
      waktu: `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`,
      nama: o.nama, metode: o.metode, items: o.items.map(i => Object.assign({}, i))
    };
    if (o.metode === 'Tunai') trx.bayar = o.bayar;
    db.trx.unshift(trx);
    if (o.metode === 'Tunai') toast('Kembalian ' + rp(o.bayar - total));
  }
  setStatusAntrian(o.pes, o.status);
  save(); render();
  if (o.status !== 'Selesai' || o.metode !== 'Tunai') toast('Status pesanan ' + o.pes + ': ' + o.status);
}

function batalkan() {
  const o = curOrder(); if (!o) return;
  if (!confirm('Batalkan pesanan ' + o.pes + ' atas nama ' + o.nama + '?')) return;
  setStatusAntrian(o.pes, 'Dibatalkan');
  db.orders = db.orders.filter(x => x.pes !== o.pes);
  selOrder = db.orders.length ? db.orders[0].pes : null;
  save(); render();
  toast('Pesanan ' + o.pes + ' dibatalkan');
}
/* ===== Struk (kertas thermal) =====
   LEBAR_STRUK: 80 = kertas 80 mm (paling umum), 58 = kertas 58 mm. Ganti TOKO sesuai data coffee shop. */
const TOKO = {nama:'BeanByte', tagline:'Kopi • Rasa • Overthinking', alamat:'Jl. Melati No. 12, Jakarta Selatan', telp:'0812 3456 7890'};
const LEBAR_STRUK = 80;

function cetakStruk(nama, no, waktu, items, metode, bayar, meja) {
  const c = calc(items);
  const w = window.open('', '_blank', 'width=420,height=720');
  if (!w) return toast('Izinkan pop-up untuk mencetak struk');
  const W = LEBAR_STRUK === 58 ? 58 : 80, kecil = W === 58;
  const fmt = n => n.toLocaleString('id-ID');
  const d = new Date();
  const dicetak = `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
  const baris = items.map(i => { const m = byId(i.id); return `<div class="it">${esc(m.nama)}</div><div class="r"><span>${i.qty} x ${fmt(m.harga)}</span><span>${fmt(m.harga * i.qty)}</span></div>`; }).join('');
  const tunai = metode === 'Tunai' && bayar
    ? `<div class="r"><span>Tunai</span><span>${rp(bayar)}</span></div><div class="r b"><span>Kembalian</span><span>${rp(Math.max(0, bayar - c.total))}</span></div>` : '';
  w.document.write(`<!DOCTYPE html><html><head><meta charset="utf-8"><title>Struk ${esc(no)}</title><style>
    @page{size:${W}mm auto;margin:0}
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;background:#fff}
    body{width:${W}mm;margin:0 auto;padding:4mm ${kecil ? 3 : 4}mm 8mm;font-family:"Courier New",Courier,monospace;font-size:${kecil ? 11 : 12}px;line-height:1.4;color:#000}
    .c{text-align:center}
    .logo{display:block;width:${kecil ? 16 : 22}mm;height:${kecil ? 16 : 22}mm;margin:0 auto 2mm}
    h1{margin:0;font-size:${kecil ? 15 : 18}px;letter-spacing:1px}
    .sm{font-size:${kecil ? 10 : 11}px}
    hr{border:0;border-top:1px dashed #000;margin:2.5mm 0}
    .r{display:flex;justify-content:space-between;gap:6px}
    .r span:last-child{text-align:right;white-space:nowrap}
    .it{margin-top:1.5mm;font-weight:bold;word-break:break-word}
    .b{font-weight:bold}
    .tot{font-size:${kecil ? 13 : 15}px;font-weight:bold;margin-top:1mm}
    @media screen{body{margin:8px auto;box-shadow:0 0 8px rgba(0,0,0,.25)}}
    </style></head><body>
    <div class="c">
    <img class="logo" src="${window.location.origin}/foto/logo.jpeg" alt="Logo BeanByte">
</div>
    <div class="c"><h1>${esc(TOKO.nama)}</h1><div class="sm">${esc(TOKO.tagline)}</div>
      <div class="sm" style="margin-top:1.5mm">${esc(TOKO.alamat)}</div><div class="sm">Telp. ${esc(TOKO.telp)}</div></div>
    <hr>
    <div class="r"><span>No</span><span>${esc(no)}</span></div>
    <div class="r"><span>Tanggal</span><span>${esc(waktu)}</span></div>
    <div class="r"><span>Pelanggan</span><span>${esc(nama)}</span></div>
    ${meja && meja !== 'Online' ? `<div class="r"><span>Meja</span><span>${esc(meja)}</span></div>` : ''}
    <div class="r"><span>Bayar</span><span>${esc(metode)}</span></div>
    <hr>${baris}<hr>
    <div class="r"><span>Subtotal</span><span>${rp(c.sub)}</span></div>
    ${c.diskon ? `<div class="r"><span>Diskon (15%)</span><span>- ${rp(c.diskon)}</span></div>` : ''}
    <div class="r tot"><span>TOTAL</span><span>${rp(c.total)}</span></div>
    ${tunai}
    <hr>
    <div class="c sm">Terima kasih sudah berkunjung!<br>Selamat menikmati<br>Dicetak ${dicetak}</div>
    </body></html>`);
  w.document.close(); w.focus();
  w.onafterprint = () => w.close();
  setTimeout(() => w.print(), 300);
}
function cetakOrder() { const o = curOrder(); if (o) cetakStruk(o.nama, o.pes, tglPendek() + ' ' + o.waktu, o.items, o.metode, o.bayar, o.meja); }
function cetakTrx() { const t = db.trx.find(x => x.trx === selTrx); if (t) cetakStruk(t.nama, t.trx, t.waktu, t.items, t.metode, t.bayar); }

render();

sinkronPesananDatabase();

setInterval(sinkronPesananDatabase, 5000);

</script>
</body>
</html>