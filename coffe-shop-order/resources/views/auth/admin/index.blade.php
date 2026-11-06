 <!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin - BeanByte</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  :root{--brown:#5a3425;--brown2:#6b3f2d;--nav:#7a4d37;--bg:#f7f1e9;--card:#fffdfa;--line:#eadfd2;--head:#f3e9de;--ink:#2b1a12;--muted:#8b7467}
  *{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
  body{font-family:"Open Sans",system-ui,sans-serif;background:var(--bg);color:var(--ink);font-size:14px}
  button{font:inherit;color:inherit;background:none;border:0;cursor:pointer}
  input,select,textarea{font:inherit;color:inherit}
  button:disabled{opacity:.4;cursor:default}
  h1,h2,h3{font-family:"Outfit",sans-serif}
  svg{display:block}
  .grow{flex:1}
  .empty{text-align:center;padding:50px 16px;color:var(--muted)}

  /* ===== Kerangka ===== */
  .app{display:grid;grid-template-columns:255px minmax(0,1fr);min-height:100vh}
  .app.collapsed{grid-template-columns:76px minmax(0,1fr)}
  .side{position:sticky;top:0;height:100vh;overflow:hidden;display:flex;flex-direction:column;color:#f3e6da;
    background:linear-gradient(180deg,#3b2217 0%,#2a170e 100%)}
  .brand{display:flex;align-items:center;gap:10px;padding:22px 20px 18px;position:relative;z-index:1}
  .brand svg{width:46px;height:46px;flex:none}
  .bt b{display:block;font-family:"Outfit",sans-serif;font-size:1.45rem;font-weight:700;line-height:1.1}
  .bt small{font-size:.74rem;opacity:.8}
  .side nav{padding:8px 10px;position:relative;z-index:1;overflow-y:auto}
  .nv{display:flex;align-items:center;gap:14px;width:100%;padding:11px 16px;border-radius:10px;text-align:left;color:#f3e6da;font-size:.92rem;margin-bottom:5px}
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
  .top{display:flex;align-items:center;gap:16px;padding:12px 24px;background:#fbf7f1;border-bottom:1px solid var(--line);position:sticky;top:0;z-index:5}
  .ibtn{width:38px;height:38px;border-radius:10px;display:grid;place-items:center;position:relative}
  .ibtn svg{width:24px;height:24px}
  .ibtn:hover{background:#f1e7dc}
  .bell b{position:absolute;top:2px;right:2px;background:#d9531e;color:#fff;border-radius:50%;width:16px;height:16px;font-size:.62rem;display:grid;place-items:center}
  .usr{display:flex;align-items:center;gap:10px;position:relative;cursor:pointer;font-size:.85rem;font-weight:600}
  .usr svg{width:14px;height:14px}
  .dd{position:absolute;right:0;top:44px;background:#fff;border:1px solid var(--line);border-radius:10px;box-shadow:0 6px 18px rgba(60,30,15,.15);padding:6px;min-width:130px}
  .dd button{width:100%;text-align:left;padding:9px 12px;border-radius:8px}
  .dd button:hover{background:#f6ece1}
  .content{padding:22px 26px 40px}

  /* ===== Komponen ===== */
  .ph{display:flex;align-items:center;gap:14px;margin-bottom:18px}
  .ph .pi{width:42px;height:42px;color:var(--brown2);flex:none}
  .ph h1{font-size:2rem;font-weight:700;color:var(--brown);line-height:1.1}
  .ph p{color:var(--muted);margin-top:4px;font-size:.88rem}
  .card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px;box-shadow:0 1px 3px rgba(80,50,30,.05)}
  .card h2{font-size:1.05rem;font-weight:700}
  .ch{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;gap:10px;flex-wrap:wrap}
  .lnk{display:flex;align-items:center;gap:6px;font-size:.74rem;font-weight:600;color:var(--ink)}
  .lnk svg{width:14px;height:14px}
  .btn{display:inline-flex;align-items:center;gap:8px;background:var(--brown);color:#fff;border-radius:10px;padding:10px 18px;font-weight:600;font-size:.88rem}
  .btn svg{width:18px;height:18px}
  .btn:hover{background:#47281c}
  .btn.ghost{background:#fff;color:var(--ink);border:1px solid var(--line)}
  .btn.ghost:hover{background:#f7efe6}
  .btn.sm{padding:7px 14px;font-size:.76rem;border-radius:8px}
  .btn.sm svg{width:14px;height:14px}
  .btn.del{background:#fdeaea;color:#c0392b}
  .btn.del:hover{background:#fbdcdc}
  .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:14px;margin-bottom:16px}
  .st{display:flex;gap:12px;align-items:flex-start;background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px}
  .st i{width:46px;height:46px;border-radius:12px;background:var(--brown2);color:#fff;display:grid;place-items:center;flex:none}
  .st i.light{background:#f1e0cf;color:var(--brown2)}
  .st i svg{width:24px;height:24px}
  .st > div{min-width:0;flex:1}
  .st small{display:block;font-size:.76rem;color:#4a3328}
  .st b{display:block;font-family:"Outfit",sans-serif;font-size:1.7rem;font-weight:700;line-height:1.25;white-space:nowrap}
  .st .sub{font-size:.74rem;color:var(--muted)}
  .up{color:#2c9a4d;font-size:.74rem;font-weight:600}
  .up svg{display:inline;width:11px;height:11px;vertical-align:-1px}
  .tools{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
  .sb{display:flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--line);border-radius:10px;padding:0 14px;height:42px;min-width:0}
  .sb svg{width:20px;height:20px;color:#6b564a;flex:none}
  .sb input{flex:1;min-width:0;border:0;outline:0;background:transparent;font-size:.84rem}
  .sb.wide{flex:1;max-width:620px;background:#fff9f1}
  .sel{height:42px;border:1px solid var(--line);border-radius:10px;padding:0 12px;background:#fff;font-size:.82rem}
  .fbtn{width:42px;height:42px;border:1px solid var(--line);border-radius:10px;background:#fff;display:grid;place-items:center}
  .fbtn svg{width:20px;height:20px}
  .fbtn.on{background:var(--brown);color:#fff}
  .tabs{display:flex;gap:10px;flex-wrap:wrap}
  .tabb{display:flex;align-items:center;gap:8px;padding:10px 16px;border-radius:10px;background:#f1e7dc;color:#5a3d2e;font-size:.82rem}
  .tabb svg{width:18px;height:18px}
  .tabb.on{background:var(--brown);color:#fff}
  .tabb.c-baru{background:#e0eafb;color:#2b5db5}
  .tabb.c-diproses{background:#fdecc8;color:#b36b00}
  .tabb.c-selesai{background:#d6f0da;color:#2c7a3d}
  .tabb.c-dibatalkan{background:#fbdcdc;color:#c0392b}
  .tabb.c-berhasil{background:#d6f0da;color:#2c7a3d}
  .tabb.c-pending{background:#fdecc8;color:#b36b00}
  .tabb[class*="c-"].on{box-shadow:inset 0 0 0 2px currentColor}
    /* Tabel */
  .tbw {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin-top: 14px;
    border: 1px solid var(--line);
    border-radius: 12px;
}

.tb {
    min-width: 700px;
    width: 100%;
    border-collapse: collapse;
}
  .tb{width:100%;border-collapse:collapse;min-width:620px}
  .tb th{background:var(--head);text-align:left;font-weight:600;padding:13px 10px;font-size:.8rem;white-space:nowrap}
  .tb td{padding:10px;border-bottom:1px solid #f0e6da;font-size:.82rem;vertical-align:middle}
  .tb tr:last-child td{border-bottom:0}
  .tb tbody tr.clk{cursor:pointer}
  .tb tbody tr.clk:hover{background:#fbf4ea}
  .tb tr.sel{background:#f6ebdc}
  .tb .sub{font-size:.72rem;color:var(--muted);margin-top:2px}
  .act{white-space:nowrap}
  .act .btn{margin-right:6px}
  .th{position:relative;width:54px;height:54px;border-radius:9px;overflow:hidden;background:linear-gradient(135deg,#ead9c8,#c9a58a);display:grid;place-items:center;font-size:1.5rem;flex:none}
  .th img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
  .th.s{width:42px;height:42px;font-size:1.2rem;border-radius:8px}
  .th.xs{width:46px;height:46px;font-size:1.2rem}
  .tile{width:86px;height:80px;border-radius:12px;display:grid;place-items:center;background:var(--brown2);color:#fff}
  .tile.light{background:#f1dcc7;color:var(--brown2)}
  .tile svg{width:44px;height:44px}
  .foot{display:flex;justify-content:space-between;align-items:center;padding-top:14px;color:var(--muted);font-size:.8rem;flex-wrap:wrap;gap:10px}
  .pg{display:flex;gap:6px;align-items:center}
  .pg button{min-width:32px;height:32px;border:1px solid var(--line);border-radius:8px;background:#fff;display:grid;place-items:center;padding:0 6px}
  .pg button svg{width:14px;height:14px}
  .pg button.on{background:var(--brown);color:#fff;border-color:var(--brown)}
  .dots{color:var(--muted)}

  /* Badge */
  .bd{display:inline-block;padding:3px 12px;border-radius:7px;font-size:.72rem;font-weight:600;white-space:nowrap}
  .bd.dot::before{content:"";display:inline-block;width:6px;height:6px;border-radius:50%;background:currentColor;margin-right:6px;vertical-align:1px}
  .k-kopi{background:#f0d9bf;color:#8a5a2b}
  .k-nonkopi{background:#dbe7fb;color:#2b5db5}
  .k-makanan{background:#fddcbf;color:#b86017}
  .k-other{background:#e9dfd5;color:#6b564a}
  .s-tersedia,.s-berhasil,.s-selesai,.s-aman,.s-aktif{background:#d6f0da;color:#2c7a3d}
  .s-habis,.s-dibatalkan,.s-nonaktif{background:#fbdcdc;color:#c0392b}
  .s-menunggu{background:#fbd5d0;color:#c0463a}
  .s-diproses,.s-pending,.s-menipis{background:#fbebc0;color:#a67712}
  .m-qris{background:#dbe7fb;color:#2b5db5}
  .m-tunai{background:#ecd9c4;color:#7b5230}
  .m-lainnya{background:#e5e0da;color:#6b564a}
  .bd.lg{background:#efe3f7;color:#7a3fa0;margin-left:6px;padding:2px 8px;font-size:.66rem}

  /* Dashboard */
  .dash{display:grid;grid-template-columns:minmax(0,1fr) 330px;gap:18px;align-items:start}
  .colf{display:flex;flex-direction:column;gap:16px;min-width:0}
  .hero{border-radius:16px;padding:26px 28px;color:#fff;min-height:160px;display:flex;flex-direction:column;justify-content:center;gap:8px}
  .hero h2{font-size:1.9rem;font-weight:700}
  .hero p{font-size:.95rem;opacity:.95}
  .dchip{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.14);border-radius:10px;padding:10px 16px;width:fit-content;margin-top:6px;font-size:.82rem}
  .dchip svg{width:18px;height:18px}
  .two{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(0,1fr);gap:16px}
  .leg{display:flex;gap:14px;font-size:.7rem;color:var(--muted)}
  .leg i{display:inline-block;width:9px;height:9px;margin-right:5px;background:#5a3425}
  .leg i.b{background:#c9a285}
  .top5 .it{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #f0e6da}
  .top5 .it:last-child{border-bottom:0}
  .top5 .no{width:24px;height:24px;border-radius:7px;background:#f3e9de;display:grid;place-items:center;font-size:.75rem}
  .top5 b{display:block;font-size:.82rem}
  .top5 small{color:var(--muted);font-size:.72rem}
  .qa{display:flex;align-items:center;gap:12px;width:100%;padding:10px 12px;border-radius:10px;background:#f7efe6;margin-bottom:10px;text-align:left;font-weight:600;font-size:.85rem}
  .qa i{width:34px;height:34px;border-radius:9px;background:var(--brown2);color:#fff;display:grid;place-items:center;flex:none}
  .qa i svg{width:19px;height:19px}
  .qa .chev{margin-left:auto;width:16px;height:16px}
  .qa:hover{background:#f1e5d8}
  .rc{display:flex;align-items:center;gap:10px;padding:10px;border:1px solid var(--line);border-radius:10px;margin-bottom:8px;cursor:pointer;background:#fff}
  .rc i{width:34px;height:34px;border-radius:9px;background:#f3e9de;color:var(--brown2);display:grid;place-items:center;flex:none}
  .rc i svg{width:18px;height:18px}
  .rc .mid{flex:1;min-width:0}
  .rc b{font-size:.78rem}
  .rc small{display:block;font-size:.7rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .rc .rt{text-align:right}
  .rc .rt small{margin-top:6px}
  .mini{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:12px;padding-top:12px;border-top:1px solid var(--line)}
  .mini div{display:flex;gap:8px;align-items:center;font-size:.72rem;color:var(--muted)}
  .mini svg{width:22px;height:22px;color:var(--brown2);flex:none}
  .mini b{display:block;font-size:.86rem;color:var(--ink)}

  /* Panel detail */
  .split{display:grid;gap:16px;grid-template-columns:minmax(0,1fr);align-items:start}
  .split.open{grid-template-columns:minmax(0,1fr) 310px}
  .dp{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px;position:sticky;top:80px;font-size:.82rem}
  .dp .dh{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
  .dp .dh h3{font-size:.95rem}
  .dp .x{width:26px;height:26px;display:grid;place-items:center}
  .dp .x svg{width:16px;height:16px}
  .dp .idr{display:flex;justify-content:space-between;align-items:flex-start}
  .dp .idr b{font-family:"Outfit",sans-serif;font-size:1.25rem}
  .dp .meta{color:var(--muted);font-size:.76rem;margin:3px 0}
  .dp h4{font-size:.85rem;margin:14px 0 8px;padding-top:12px;border-top:1px solid var(--line)}
  .dp .li{display:flex;gap:10px;align-items:center;margin-bottom:8px}
  .dp .li .nm{flex:1;min-width:0}
  .dp .li b{display:block;font-size:.78rem;font-weight:600}
  .dp .li small{color:var(--muted);font-size:.7rem}
  .dp .li span{font-size:.78rem}
  .dp .row{display:flex;justify-content:space-between;padding:4px 0;color:#5a4438}
  .dp .row.g span:last-child{color:#2c9a4d}
  .dp .row.t{font-family:"Outfit",sans-serif;font-weight:700;font-size:1rem;color:var(--ink);margin-top:2px}
  .dp .inf{display:flex;align-items:center;gap:8px;padding:3px 0;color:#5a4438}
  .dp .inf svg{width:15px;height:15px;flex:none}
  .dp select{width:100%;height:40px;border:1px solid var(--line);border-radius:9px;padding:0 10px;background:#fff;margin-bottom:10px}
  .dp .btn{width:100%;justify-content:center}

  /* Laporan */
  .lap{display:grid;grid-template-columns:minmax(0,1.9fr) minmax(0,1fr);gap:16px;margin-bottom:16px}
  .donut{display:flex;align-items:center;gap:18px}
  .donut .lg{flex:1}
  .donut .lr{display:flex;align-items:center;gap:8px;font-size:.82rem;margin-bottom:10px}
  .donut .lr i{width:12px;height:12px;border-radius:50%;flex:none}
  .donut .lr em{font-style:normal;margin-left:auto;font-weight:600}
  .donut .lr small{display:block;color:var(--muted);text-align:right}
  .kin{display:flex;align-items:center;gap:12px;padding:10px;border:1px solid var(--line);border-radius:10px;margin-bottom:8px;background:#fff}
  .kin i{width:40px;height:40px;border-radius:10px;background:#f3e9de;color:var(--brown2);display:grid;place-items:center;flex:none}
  .kin i svg{width:22px;height:22px}
  .kin .mid{flex:1;font-size:.78rem}
  .kin .mid small{display:block;color:var(--muted);font-size:.7rem}
  .kin .mid b{font-size:.9rem}
  .rank{width:26px;height:26px;border-radius:50%;background:var(--brown2);color:#fff;display:grid;place-items:center;font-size:.75rem}
  .rank.l{background:#f1e5d8;color:var(--brown2)}

  .fl.inl{margin:0}
  .role-tag{display:inline-flex;align-items:center;border-radius:999px;padding:5px 10px;font-size:.72rem;font-weight:700;background:#f3e9de;color:var(--brown2);white-space:nowrap}
  .role-admin{background:#ead5c7;color:#5a3425}
  .role-kasir{background:#fff0ce;color:#805d13}
  .role-pemilik{background:#dcefe2;color:#276749}
  .role-pelanggan{background:#e7e8f8;color:#4b4f91}
  code{font-family:Consolas,Monaco,monospace;background:#f5eee7;padding:3px 6px;border-radius:5px;font-size:.8rem}

  /* Modal */
  .mbg{position:fixed;inset:0;background:rgba(30,15,8,.5);display:grid;place-items:center;z-index:20;padding:16px}
  .modal{background:#fffdfa;border-radius:16px;width:min(480px,100%);padding:22px;max-height:92vh;overflow:auto}
  .modal h2{font-size:1.3rem;color:var(--brown);margin-bottom:14px}
  .fl{display:block;margin-bottom:12px}
  .fl span{display:block;font-size:.78rem;font-weight:600;margin-bottom:5px}
  .fl input,.fl select{width:100%;height:42px;border:1px solid var(--line);border-radius:9px;padding:0 12px;background:#fff}
  .g2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
  .mfoot{display:flex;justify-content:flex-end;gap:10px;margin-top:8px}

  .toast{position:fixed;left:50%;bottom:30px;transform:translateX(-50%);background:#2b1d16;color:#fff;padding:10px 18px;border-radius:20px;font-size:.85rem;opacity:0;pointer-events:none;transition:opacity .25s;z-index:30}
  .toast.show{opacity:1}


  /* Kelola QR Pelanggan */
  .qr-setting{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:10px;align-items:end}
  .qr-setting .fl{margin:0}.qr-setting input{width:100%;height:44px;border:1px solid var(--line);border-radius:10px;padding:0 12px;background:#fff}
  .qr-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px;margin-top:16px}
  .qr-card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:16px;text-align:center}
  .qr-card h3{color:var(--brown);font-size:1.05rem;margin-bottom:4px}
  .qr-card p{color:var(--muted);font-size:.76rem;margin-bottom:10px}
  .qr-card img{width:170px;height:170px;max-width:100%;object-fit:contain;margin:0 auto 10px;display:block;background:#fff}
  .qr-card .qr-url{font-size:.68rem;overflow-wrap:anywhere;color:var(--muted);margin:6px 0 12px}
  .qr-note{padding:12px 14px;border-radius:10px;background:#f7efe6;color:#654633;font-size:.82rem;line-height:1.6;margin-top:12px}
  @media print{body *{visibility:hidden!important}#qrPrint,#qrPrint *{visibility:visible!important}#qrPrint{position:absolute;left:0;top:0;width:100%;padding:10mm}.qr-grid{grid-template-columns:repeat(3,1fr)}.qr-card{break-inside:avoid;border:1px solid #aaa}.qr-card .btn{display:none!important}}

  @media (max-width:1180px){
    .dash{grid-template-columns:1fr}
    .stats{grid-template-columns:repeat(2,minmax(0,1fr))}
    .lap,.two{grid-template-columns:1fr}
    .split.open{grid-template-columns:1fr}
    .dp{position:static}
  }
  @media (max-width:760px){
    .content{padding:16px}
    .top{padding:10px 14px}
    .usr span.nm{display:none}
  }
</style>
</head>
<body>

<div id="app"></div>
<div id="modal"></div>
<div class="toast" id="toast"></div>

<script>
/* ===================== KONFIGURASI ===================== */
// Foto diambil dari public/images. Jika foto belum ada, otomatis tampil emoji.
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
const KEY = 'beanbyte_admin';
const API_PENGGUNA = '/admin/pengguna';
let daftarPengguna = [];
let penggunaLoading = false;
let penggunaError = '';
const BLN = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sept','Okt','Nov','Des'];
const BLNP = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
// Pengali riwayat 6 hari sebelumnya (data contoh untuk grafik, belum dari database)
const HIST = [0.62, 0.88, 0.74, 0.55, 0.83, 0.71, 1];
const NAMA = ['Rizky','Siti Nurhaliza','Andi','Dewi','Budi','Sari','Rina','Fajar','Dimas','Tika','Yuda','Lina','Bayu','Nia','Gilang','Maya','Eko','Wulan','Hendra','Putri'];

/* ===================== DATA AWAL ===================== */
// 3 kategori saja: Kopi, Non-Kopi, Makanan
const KAT0 = [
  {id:'kopi',nama:'Kopi',desc:'Berbagai macam minuman berbahan dasar kopi.',status:'Aktif',ikon:'cup',tone:'dark'},
  {id:'nonkopi',nama:'Non-Kopi',desc:'Minuman selain kopi, seperti matcha, cokelat, dan lainnya.',status:'Aktif',ikon:'drink',tone:'light'},
  {id:'makanan',nama:'Makanan',desc:'Berbagai jenis makanan berat dan ringan.',status:'Aktif',ikon:'food',tone:'dark'}
];

// Daftar menu SAMA dengan halaman pelanggan dan kasir (id harus sama agar pesanan bisa mengurangi stok menu).
// [id, nama, deskripsi, kategori, harga, stok, status, emoji]
const MENU0 = [
  ['americano','Americano','Kopi hitam tanpa gula','kopi',22000,30,'Tersedia','🧊'],
  ['latte','Latte','Espresso dengan susu segar','kopi',22000,30,'Tersedia','🥛'],
  ['cappucino','Cappucino','Espresso dengan susu dan foam','kopi',22000,30,'Tersedia','☕'],
  ['caramel-macchiato','Caramel','Espresso, susu, dan saus karamel','kopi',22000,25,'Tersedia','🍮'],
  ['affogato','Affogato','Es krim vanila dengan espresso','kopi',22000,20,'Tersedia','🍨'],
  ['butterscots','Butterscots','Kopi susu dengan butterscotch','kopi',22000,25,'Tersedia','☕'],
  ['espresso','Espresso','Kopi espresso murni','kopi',22000,30,'Tersedia','☕'],
  ['cocolate','Cocolate','Minuman cokelat creamy','nonkopi',22000,25,'Tersedia','🍫'],
  ['matcha','Matcha','Matcha dengan susu','nonkopi',22000,20,'Tersedia','🍵'],
  ['fresh-orange','Fresh Orange','Jus jeruk segar','nonkopi',22000,20,'Tersedia','🍊'],
  ['milk tea','Milk Tea','Teh dengan susu','nonkopi',22000,25,'Tersedia','🧋'],
  ['jus-strawberry','Jus Strawberry','Jus stroberi segar','nonkopi',22000,20,'Tersedia','🍓'],
  ['croissant','Croissant','Roti croissant dengan mentega','makanan',22000,20,'Tersedia','🥐'],
  ['spaghetti','Spaghetti','Spaghetti saus bolognese','makanan',22000,15,'Tersedia','🍝'],
  ['donat','Donat','Donat dengan berbagai topping','makanan',22000,25,'Tersedia','🍩'],
  ['french-fries','French Fries','Kentang goreng crispy','makanan',22000,30,'Tersedia','🍟'],
  ['nasi-goreng-spesial','Nasi Goreng Spesial','Nasi goreng spesial BeanByte','makanan',22000,15,'Tersedia','🍳']
].map(([id,nama,desc,kat,harga,stok,status,emoji]) => ({id,nama,desc,kat,harga,stok,status,emoji,foto:id + '.jpg'}));

// [no, pelanggan, menu, status, waktu, catatan]
const ORD0 = [
  ['A012','Rizky',['latte','cappuccino','croissant'],'Diproses','10:12','Tanpa gula'],
  ['A011','Siti Nurhaliza',['americano','donat'],'Menunggu','10:15','-'],
  ['A010','Andi',['cappuccino','nasi-goreng-spesial','americano','french-fries'],'Selesai','10:17','-'],
  ['A009','Dewi',['latte','croissant','donat'],'Selesai','10:20','-'],
  ['A008','Budi',['matcha','french-fries'],'Diproses','10:21','Es sedikit'],
  ['A007','-',['cocolate','spaghetti','croissant'],'Menunggu','10:22','-'],
  ['A006','Sari',['americano','croissant'],'Selesai','10:24','-'],
  ['A005','Rina',['spaghetti'],'Dibatalkan','10:26','Pelanggan membatalkan'],
  ['A004','Fajar',['latte','cappuccino','nasi-goreng-spesial'],'Diproses','10:28','-'],
  ['A003','Dimas',['americano','cocolate'],'Selesai','10:30','-'],
  ['A002','Tika',['matcha','donat'],'Selesai','10:32','-'],
  ['A001','Yuda',['latte','nasi-goreng-spesial','americano'],'Selesai','10:35','Pedas'],
  ['A013','Lina',['cappuccino'],'Selesai','10:38','-'],
  ['A014','Bayu',['spaghetti','cocolate'],'Selesai','10:40','-'],
  ['A015','Nia',['americano','french-fries'],'Selesai','10:42','-'],
  ['A016','Gilang',['latte','croissant','donat'],'Selesai','10:45','-'],
  ['A017','Maya',['cocolate'],'Diproses','10:47','-'],
  ['A018','Eko',['nasi-goreng-spesial','americano'],'Dibatalkan','10:50','Stok habis']
].map(([no,nama,ids,status,waktu,catatan],i) => ({
  no, nama, items:ids.map(id => ({id,qty:1})), status, waktu, catatan, meja:String(i % 10 + 1),
  telp:'+62 8' + (12 + (i % 8)) + ' 3456 ' + (7890 + i * 11)
}));

function seedTrx() {
  const d = new Date();
  const ymd = '' + d.getFullYear() + pad(d.getMonth() + 1) + pad(d.getDate());
  const first = [[10,32],[10,17],[9,58],[9,42],[9,21],[8,55],[8,37],[8,12],[7,56],[7,34]];
  const ids = MENU0.map(m => m.id);
  const out = [];
  for (let i = 0; i < 86; i++) {
    let h, m;
    if (i < 10) { h = first[i][0]; m = first[i][1]; }
    else { const t = 7 * 60 + 34 - (i - 9) * 4; h = Math.floor(t / 60); m = t % 60; }
    let metode;
    if (i < 10) metode = i % 2 === 0 ? 'QRIS' : 'Tunai';
    else { const r = i % 13; metode = r < 6 ? 'Tunai' : (r < 12 ? 'QRIS' : 'Lainnya'); }
    let status = 'Berhasil';
    if (i === 4) status = 'Pending';
    else if (i === 7) status = 'Dibatalkan';
    else if (i >= 10 && i % 17 === 3) status = 'Pending';
    else if (i >= 10 && i % 23 === 5) status = 'Dibatalkan';
    const items = [{id:ids[i % ids.length], qty:1}];
    if (i % 3 === 0) items.push({id:ids[(i + 3) % ids.length], qty:1});
    if (i % 5 === 0) items.push({id:ids[(i + 6) % ids.length], qty:1});
    out.push({
      trx:'TRX-' + ymd + '-' + String(i + 1).padStart(3, '0'),
      ts:new Date(d.getFullYear(), d.getMonth(), d.getDate(), h, m).getTime(),
      nama:NAMA[i % NAMA.length], metode, status, items, kasir:'Kasir 1',
      telp:'+62 8' + (12 + (i % 8)) + ' 3456 ' + (7890 + i * 7)
    });
  }
  return out;
}

// Pelanggan langganan (contoh awal, bisa diubah di menu Pelanggan Langganan)
function seedMember() {
  const day = 86400000, now = Date.now();
  return [
    ['Siti Nurhaliza','+62 812 3456 7891',120,'Aktif'], ['Rizky','+62 813 3456 7890',95,'Aktif'],
    ['Dewi','+62 815 3456 7899',60,'Aktif'], ['Andi','+62 814 3456 7901',45,'Aktif'],
    ['Sari','+62 817 3456 7910',30,'Aktif'], ['Budi','+62 816 3456 7920',200,'Nonaktif']
  ].map(([nama,telp,hari,status]) => ({id:nama.toLowerCase().replace(/[^a-z0-9]+/g, '-'), nama, telp, bergabung:now - hari * day, status}));
}

function seedDb() {
  return JSON.parse(JSON.stringify({v:3, kat:KAT0, menu:MENU0, orders:ORD0, trx:seedTrx(), member:seedMember(), diambil:[], stokLog:{}}));
}

/* ===================== STATE ===================== */
function pad(n) { return String(n).padStart(2, '0'); }
let db = null;
try { db = JSON.parse(localStorage.getItem(KEY)); } catch (e) {}
if (!db || ![2, 3].includes(db.v) || !db.kat || !db.menu || !db.orders || !db.trx) db = seedDb();
// Migrasi v2 -> v3: kategori Snack dihapus, menu snack pindah ke Makanan (sama seperti halaman pelanggan)
if (db.v === 2) {
  db.kat = db.kat.filter(k => k.id !== 'snack');
  db.menu.forEach(m => { if (m.kat === 'snack') m.kat = 'makanan'; });
  db.v = 3;
}
if (!Array.isArray(db.member)) db.member = seedMember();
if (!db.stokLog) db.stokLog = {};
if (!Array.isArray(db.diambil)) db.diambil = [];
const save = () => { try { localStorage.setItem(KEY, JSON.stringify(db)); } catch (e) {} };
save();
if (db.trx.some(t => t.items.some(i => !i.id))) { db.trx = seedTrx(); save(); }   // perbaiki data transaksi lama yang rusak


/* ===== Pesanan dari halaman pelanggan -> stok menu berkurang =====
   Pesanan dibaca dari antrian bersama (localStorage). Tiap pesanan baru:
   1) mengurangi stok menu di Kelola Menu (stok 0 otomatis berstatus Habis),
   2) muncul di Kelola Pesanan dengan status Menunggu, lengkap dengan nomor meja dari QR.
   Jika pesanan dibatalkan, stok dikembalikan. Status dari kasir ikut tersinkron.
   Berjalan selama halaman pelanggan, kasir, dan admin dibuka di browser yang sama. */
const ANTRIAN = 'beanbyte_antrian';
const bacaAntrian = () => { try { const a = JSON.parse(localStorage.getItem(ANTRIAN)); return Array.isArray(a) ? a : []; } catch (e) { return []; } };
const tulisAntrian = a => { try { localStorage.setItem(ANTRIAN, JSON.stringify(a)); } catch (e) {} };
function setStatusAntrian(no, status) {
  const a = bacaAntrian(), x = a.find(y => y.no === no);
  if (x && x.status !== status) { x.status = status; tulisAntrian(a); }
}
function ubahStokMenu(items, arah) {   // arah: -1 = kurangi, +1 = kembalikan
  const habis = [];
  items.forEach(i => {
    const m = db.menu.find(x => x.id === i.id);
    if (!m) return;
    m.stok = Math.max(0, m.stok + arah * i.qty);
    if (m.stok === 0) { if (m.status !== 'Habis') habis.push(m.nama); m.status = 'Habis'; }
    else if (arah > 0 && m.status === 'Habis') m.status = 'Tersedia';
  });
  return habis;
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
  let ubah = false;
  let baru = 0;
  let terakhir = '';

  bacaAntrian().forEach(x => {
    // Antrean hanya memperbarui daftar dan status pesanan lokal.
    // Stok tidak dikurangi di sini; stok utama berasal dari database MySQL.
    const o = db.orders.find(y => y.no === x.no);

    if (!o) {
      if (db.diambil.includes(x.no)) return;
      const d = new Date(x.ts);
      db.diambil.push(x.no);
      db.orders.unshift({
        no: x.no,
        nama: x.nama,
        items: x.items.map(i => ({id: i.id, qty: i.qty})),
        status: x.status || 'Menunggu',
        waktu: pad(d.getHours()) + ':' + pad(d.getMinutes()),
        telp: '-',
        catatan: x.catatan || '-',
        metode: x.metode === 'qris' ? 'QRIS' : 'Tunai',
        meja: x.meja ? String(x.meja) : '-',
        sumber: 'pelanggan'
      });
      baru++;
      terakhir = x.nama + (x.meja ? ' (Meja ' + x.meja + ')' : '');
      ubah = true;
    } else if (o.sumber === 'pelanggan' && x.status && o.status !== x.status) {
      const was = o.status;
      o.status = x.status;
      if (x.status === 'Selesai' && was !== 'Selesai') buatTrx(o);
      ubah = true;
    }
  });

  if (ubah) {
    save();
    perluRender = true;
    if (baru) {
      toast(baru === 1 ? 'Pesanan baru dari ' + terakhir : baru + ' pesanan baru');
      bunyi();
    }
  }

  const el = document.activeElement;
  if (perluRender && !(el && /^(INPUT|TEXTAREA|SELECT)$/.test(el.tagName)) && !modal) {
    perluRender = false;
    render();
  }
}
let page = 'dashboard';
let q = '';
let menuKategoriTab = 'menu'; // Satu fitur dengan dua tab: Menu dan Kategori Menu
let pg = {menu:1, pesanan:1, transaksi:1, pelanggan:1, pengguna:1};
let F = {menuKat:'semua', menuStatus:'', katStatus:'', memStatus:'',
         ordTab:'Semua', ordAsc:false, trxTab:'Semua', trxMetode:'', trxFrom:'', trxTo:'', trxSort:'terbaru'};
let applied = {kat:'', metode:''};
let selOrder = null, selTrx = null;
let collapsed = window.innerWidth < 900;
let userMenu = false;
let modal = null;

/* ===================== HELPER ===================== */
const $ = s => document.querySelector(s);
const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
const num = n => n.toLocaleString('id-ID');
const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const slug = s => s.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') || 'item';

/* Sinkronisasi stok dan harga dari MySQL */
async function sinkronStokDatabase() {
  try {
    const response = await fetch('/api/menu', {
      headers: {
        Accept: 'application/json'
      },
      credentials: 'same-origin',
      cache: 'no-store'
    });

    const teks = await response.text();

    if (!response.ok) {
      throw new Error('API menu gagal: HTTP ' + response.status);
    }

    // Membersihkan pembungkus Markdown jika ada
 const jsonBersih = teks
  .replace('```php', '')
  .replace('```json', '')
  .replaceAll('```', '')
  .trim();

    const data = JSON.parse(jsonBersih);

    const daftar = Array.isArray(data)
      ? data
      : (data.data || []);

    if (!Array.isArray(daftar)) {
      throw new Error('Format data menu tidak sesuai.');
    }

    // ID database disesuaikan dengan ID menu Admin
    const idMenuAdmin = {
      1: 'nasi-goreng-spesial',
      2: 'spaghetti',
      3: 'matcha',
      4: 'jus-strawberry',
      6: 'americano',
      7: 'latte',
      8: 'cappucino',
      9: 'caramel-macchiato',
      10: 'affogato',
      11: 'butterscots',
      12: 'espresso',
      13: 'cocolate',
      14: 'fresh-orange',
      15: 'milk tea',
      16: 'croissant',
      17: 'donat',
      18: 'french-fries'
    };

    let berubah = false;

    daftar.forEach(item => {
      const idLokal = idMenuAdmin[Number(item.id_menu)];

      if (!idLokal) return;

      const m = db.menu.find(x => x.id === idLokal);

      if (!m) {
        console.warn('ID menu Admin tidak cocok:', idLokal);
        return;
      }

      const stok = Number(item.stok);
      const harga = Number(item.harga);

      if (m.stok !== stok || Number(m.harga) !== harga) {
        berubah = true;
      }

      m.stok = stok;
      m.harga = harga;
      m.idDb = Number(item.id_menu);
      m.status = stok > 0 ? 'Tersedia' : 'Habis';
    });

    if (berubah) {
      save();

      if (page === 'menu' && !modal) {
        render();
      }
    }

    console.log('Stok MySQL berhasil disinkronkan:', daftar);

  } catch (error) {
    console.error('Gagal sinkron stok MySQL:', error);
  }
}


const menuBy = id => db.menu.find(m => m.id === id) || {id, nama:'(menu dihapus)', harga:0, emoji:'❔', kat:'', foto:'x.jpg'};
const katNama = id => (db.kat.find(k => k.id === id) || {nama:id}).nama;
const fmtTgl = ts => { const d = new Date(ts); return `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`; };
const tglSaja = ts => { const d = new Date(ts); return `${d.getDate()} ${BLN[d.getMonth()]} ${d.getFullYear()}`; };
const tglPanjang = () => { const d = new Date(); return `${d.getDate()} ${BLNP[d.getMonth()]} ${d.getFullYear()}`; };
const nice = v => { const p = Math.pow(10, Math.floor(Math.log10(v))); const f = v / p; return (f <= 1 ? 1 : f <= 2 ? 2 : f <= 4 ? 4 : f <= 8 ? 8 : 10) * p; };
const isMember = nama => db.member.some(m => m.status === 'Aktif' && m.nama.toLowerCase() === String(nama).toLowerCase());

function calc(items) {
  let qty = 0, sub = 0;
  items.forEach(i => { qty += i.qty; sub += menuBy(i.id).harga * i.qty; });
  const diskon = qty > 2 ? Math.round(sub * 0.15) : 0;
  return {qty, sub, diskon, total: sub - diskon};
}

function last7() {
  return [0,1,2,3,4,5,6].map(i => { const d = new Date(); d.setDate(d.getDate() - (6 - i)); return `${d.getDate()} ${BLN[d.getMonth()]}`; });
}

function aggregate(trxs, kat) {
  const map = {};
  trxs.forEach(t => {
    const c = calc(t.items), f = c.sub ? c.total / c.sub : 1;
    t.items.forEach(i => {
      if (!db.menu.some(x => x.id === i.id)) return;
      const m = menuBy(i.id);
      if (kat && m.kat !== kat) return;
      const e = map[i.id] || (map[i.id] = {m, qty:0, rev:0});
      e.qty += i.qty; e.rev += m.harga * i.qty * f;
    });
  });
  return Object.values(map).sort((a, b) => b.qty - a.qty || b.rev - a.rev);
}

let toastTimer;
function toast(msg) {
  const t = $('#toast');
  t.textContent = msg; t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2000);
}

function tick() {
  const d = new Date();
  document.querySelectorAll('.dt-date').forEach(e => e.textContent = `${d.getDate()} ${BLNP[d.getMonth()]} ${d.getFullYear()}`);
  document.querySelectorAll('.dt-time').forEach(e => e.textContent = `${pad(d.getHours())}:${pad(d.getMinutes())}`);
}
setInterval(tick, 30000);

/* ===================== IKON ===================== */
const ic = (p, x = '') => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ${x}>${p}</svg>`;
const I = {
  home:ic('<path d="M3 11l9-8 9 8M5 10v10h5v-6h4v6h5V10"/>'),
  fork:ic('<path d="M5 3v6a2 2 0 0 0 4 0V3M7 3v18M17 21V3c-2 1.5-3 4-3 7h3"/>'),
  grid:ic('<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>'),
  box:ic('<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9zM4 7.5l8 4.5 8-4.5M12 12v9"/>'),
  clip:ic('<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 3h6v3H9zM9 11h6M9 15h4"/>'),
  receipt:ic('<rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/>'),
  bars:ic('<rect x="4" y="12" width="4" height="9" rx="1"/><rect x="10" y="5" width="4" height="16" rx="1"/><rect x="16" y="9" width="4" height="12" rx="1"/>'),
  logout:ic('<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>'),
  search:ic('<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>','stroke-width="2"'),
  bell:ic('<path d="M6 16v-5a6 6 0 0 1 12 0v5l2 2H4zM10 21a2 2 0 0 0 4 0"/>'),
  menu:ic('<path d="M4 6h16M4 12h16M4 18h16"/>','stroke-width="2.2"'),
  cup:ic('<path d="M5 11h12v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6zM17 12h1.5a2.5 2.5 0 0 1 0 5H16M3 21h18M9 3c-1 1.5 1 2.5 0 4M13 3c-1 1.5 1 2.5 0 4"/>'),
  drink:ic('<path d="M6 8h12l-1.5 12h-9zM6 12h12M13 8l2-5h3"/>'),
  food:ic('<circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="2.6"/><path d="M3.5 4v6a1.5 1.5 0 0 0 3 0V4M5 4v16M20.5 4c-1.5 1-2.5 3-2.5 6h2.5V20"/>'),
  plus:ic('<path d="M12 5v14M5 12h14"/>','stroke-width="2.4"'),
  edit:ic('<path d="M4 20h4L19 9l-4-4L4 16zM13.5 6.5l4 4"/>'),
  trash:ic('<path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13M10 11v6M14 11v6"/>'),
  filter:ic('<path d="M3 5h18l-7 8v6l-4 2v-8z"/>'),
  chevR:ic('<path d="M9 5l7 7-7 7"/>','stroke-width="2.2"'),
  chevL:ic('<path d="M15 5l-7 7 7 7"/>','stroke-width="2.2"'),
  chevD:ic('<path d="M5 9l7 7 7-7"/>','stroke-width="2.2"'),
  cal:ic('<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>'),
  clock:ic('<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>'),
  users:ic('<circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-4 3-6 7-6s7 2 7 6M16 4.5a3.5 3.5 0 0 1 0 7M18 14c2.5.6 4 2.5 4 6"/>'),
  dollar:ic('<circle cx="12" cy="12" r="9"/><path d="M14.5 9.2c-.6-.9-1.5-1.2-2.5-1.2-1.4 0-2.4.8-2.4 1.9 0 2.6 5 1.3 5 3.9 0 1.1-1.1 2-2.6 2-1.1 0-2.1-.5-2.6-1.4M12 6v2M12 16v2"/>'),
  up:ic('<path d="M12 19V5M5 12l7-7 7 7"/>','stroke-width="2.4"'),
  x:ic('<path d="M6 6l12 12M18 6L6 18"/>','stroke-width="2"'),
  eye:ic('<path d="M2 12s3.6-6.5 10-6.5S22 12 22 12s-3.6 6.5-10 6.5S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>'),
  download:ic('<path d="M12 4v11M7 11l5 5 5-5M4 20h16"/>'),
  hourglass:ic('<path d="M6 3h12M6 21h12M7 3c0 5 5 6 5 9s-5 4-5 9M17 3c0 5-5 6-5 9s5 4 5 9"/>'),
  checkc:ic('<circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6"/>'),
  xc:ic('<circle cx="12" cy="12" r="9"/><path d="M9 9l6 6M15 9l-6 6"/>'),
  trophy:ic('<path d="M8 4h8v5a4 4 0 0 1-8 0zM8 6H4v2a3 3 0 0 0 4 3M16 6h4v2a3 3 0 0 1-4 3M12 13v4M8 21h8M10 17h4"/>'),
  printer:ic('<path d="M6 9V3h12v6M6 18H4a1 1 0 0 1-1-1v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1h-2"/><rect x="6" y="14" width="12" height="7"/>'),
  phone:ic('<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>'),
  user:ic('<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-6 8-6s8 2 8 6"/>'),
  note:ic('<path d="M14 3H6a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8zM14 3v5h5M8.5 12h7M8.5 16h4"/>'),
  trend:ic('<path d="M3 17l6-6 4 4 8-8M15 7h6v6"/>'),
  wallet:ic('<path d="M3 7a2 2 0 0 1 2-2h13v3M3 7v11a2 2 0 0 0 2 2h15V8H5a2 2 0 0 1-2-1zM16 14h2"/>'),
  list:ic('<path d="M8 6h13M8 12h13M8 18h13M3 6h.5M3 12h.5M3 18h.5"/>','stroke-width="2.2"'),
  tag:ic('<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.3"/>')
};
const KATICON = {cup:I.cup, drink:I.drink, food:I.food};

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
const katBadge = id => `<span class="bd k-${['kopi','nonkopi','makanan'].includes(id) ? id : 'other'}">${esc(katNama(id))}</span>`;
const stBadge = (s, dot) => `<span class="bd s-${s.toLowerCase()} ${dot ? 'dot' : ''}">${s}</span>`;
const mBadge = m => `<span class="bd m-${m.toLowerCase()}">${m}</span>`;
const up = t => `<span class="up">${I.up} ${t}</span>`;
const stat = (icon, label, val, sub, light) => `<div class="st"><i class="${light ? 'light' : ''}">${icon}</i><div><small>${label}</small><b>${val}</b>${sub || ''}</div></div>`;
const pageHead = (icon, title, sub, action) => `<div class="ph"><span class="pi">${icon}</span><div class="grow"><h1>${title}</h1><p>${sub}</p></div>${action || ''}</div>`;
const searchBox = ph => `<div class="sb grow">${I.search}<input data-q value="${esc(q)}" placeholder="${ph}" oninput="setQ(this.value)"></div>`;

function pager(pages, p) {
  const show = [];
  for (let i = 1; i <= pages; i++) {
    if (i === 1 || i === pages || Math.abs(i - p) <= 1 || (p <= 3 && i <= 5) || (p >= pages - 2 && i >= pages - 4)) show.push(i);
  }
  let h = `<button ${p <= 1 ? 'disabled' : ''} onclick="goPg(${p - 1})">${I.chevL}</button>`;
  let last = 0;
  show.forEach(i => {
    if (i - last > 1) h += '<span class="dots">…</span>';
    h += `<button class="${i === p ? 'on' : ''}" onclick="goPg(${i})">${i}</button>`;
    last = i;
  });
  h += `<button ${p >= pages ? 'disabled' : ''} onclick="goPg(${p + 1})">${I.chevR}</button>`;
  return `<div class="pg">${h}</div>`;
}
function foot(total, per, p, label) {
  const pages = Math.max(1, Math.ceil(total / per));
  const a = total ? (p - 1) * per + 1 : 0, b = Math.min(total, p * per);
  return `<div class="foot"><span>Menampilkan ${a} - ${b} dari ${total} ${label}</span>${pager(pages, p)}</div>`;
}
function clampPg(total, per) {
  const pages = Math.max(1, Math.ceil(total / per));
  if (pg[page] > pages) pg[page] = pages;
  if (pg[page] < 1) pg[page] = 1;
  return pg[page];
}

/* ===================== KERANGKA ===================== */
const NAV = [['dashboard','Dashboard',I.home],['menu','Menu & Kategori',I.fork],
             ['pesanan','Kelola Pesanan',I.clip],['transaksi','Kelola Transaksi',I.receipt],
             ['pelanggan','Pelanggan Langganan',I.users],['qrpelanggan','Kelola QR Pelanggan',I.qr || I.grid],['pengguna','Kelola Pengguna',I.users],
             ['laporan','Laporan Penjualan',I.bars]];

function sidebar() {
  return `<aside class="side">
    <div class="brand">${LOGO}<div class="bt"><b>BeanByte</b><small>Kopi • Rasa • Cerita</small></div></div>
    <nav>${NAV.map(([k, l, i]) => `<button class="nv ${page === k ? 'on' : ''}" onclick="nav('${k}')" title="${l}">${i}<span>${l}</span></button>`).join('')}</nav>
    ${LEAF}
    <div class="sfoot">
      <div class="me"><span class="av big">${I.user}</span><div class="bt"><b>Admin</b><small>Administrator</small></div></div>
      <button class="nv" style="margin:0" onclick="logout()" title="Logout">${I.logout}<span>Logout</span></button>
    </div></aside>`;
}
function topbar() {
  const n = db.orders.filter(o => o.status === 'Menunggu').length;
  return `<header class="top">
    <button class="ibtn" onclick="toggleSide()" aria-label="Menu">${I.menu}</button>
    <div class="sb wide">${I.search}<input data-q value="${esc(q)}" placeholder="Cari menu, pesanan, atau fitur..." oninput="setQ(this.value)" onkeydown="topEnter(event)"></div>
    <span class="grow"></span>
    <button class="ibtn bell" onclick="notif()" aria-label="Notifikasi">${I.bell}${n ? `<b>${n}</b>` : ''}</button>
    <div class="usr" onclick="toggleUser()"><span class="av">${I.user}</span><span class="nm">Admin</span>${I.chevD}
      ${userMenu ? `<div class="dd"><button onclick="logout()">Logout</button></div>` : ''}</div>
  </header>`;
}

/* ===================== HALAMAN: DASHBOARD ===================== */
function chartBars(days, revs, cnts) {
  const W = 560, H = 240, L = 62, R = 12, T = 14, B = 30, w = W - L - R, h = H - T - B;
  const max = nice(Math.max(...revs, 1) * 1.05), cmax = Math.max(...cnts, 1) * 1.25;
  const step = w / days.length, bw = step * 0.5;
  let g = '';
  for (let i = 0; i <= 4; i++) {
    const y = T + h - h * i / 4;
    g += `<line x1="${L}" x2="${W - R}" y1="${y}" y2="${y}" stroke="#eadfd2"/><text x="${L - 8}" y="${y + 4}" text-anchor="end" font-size="10" fill="#8b7467">${num(max * i / 4)}</text>`;
  }
  const bars = revs.map((v, i) => { const bh = h * v / max; return `<rect x="${L + step * i + (step - bw) / 2}" y="${T + h - bh}" width="${bw}" height="${bh}" rx="3" fill="#c9a285"/>`; }).join('');
  const pts = cnts.map((v, i) => [L + step * i + step / 2, T + h - h * v / cmax]);
  const line = `<polyline points="${pts.map(p => p.join(',')).join(' ')}" fill="none" stroke="#5a3425" stroke-width="2"/>` + pts.map(p => `<circle cx="${p[0]}" cy="${p[1]}" r="3.5" fill="#5a3425"/>`).join('');
  const lab = days.map((d, i) => `<text x="${L + step * i + step / 2}" y="${H - 8}" text-anchor="middle" font-size="10" fill="#6b564a">${d}</text>`).join('');
  return `<svg viewBox="0 0 ${W} ${H}" width="100%">${g}${bars}${line}${lab}</svg>`;
}

function chartArea(days, vals) {
  const W = 640, H = 250, L = 76, R = 14, T = 14, B = 30, w = W - L - R, h = H - T - B;
  const max = nice(Math.max(...vals, 1) * 1.05);
  const step = w / (days.length - 1);
  let g = '';
  for (let i = 0; i <= 4; i++) {
    const y = T + h - h * i / 4;
    g += `<line x1="${L}" x2="${W - R}" y1="${y}" y2="${y}" stroke="#eadfd2"/><text x="${L - 8}" y="${y + 4}" text-anchor="end" font-size="10" fill="#8b7467">Rp ${num(max * i / 4)}</text>`;
  }
  const pts = vals.map((v, i) => [L + step * i, T + h - h * v / max]);
  const area = `<polygon points="${L},${T + h} ${pts.map(p => p.join(',')).join(' ')} ${L + w},${T + h}" fill="#5a3425" fill-opacity=".08"/>`;
  const line = `<polyline points="${pts.map(p => p.join(',')).join(' ')}" fill="none" stroke="#5a3425" stroke-width="2"/>` + pts.map(p => `<circle cx="${p[0]}" cy="${p[1]}" r="4" fill="#5a3425"/>`).join('');
  const lab = days.map((d, i) => `<text x="${L + step * i}" y="${H - 8}" text-anchor="middle" font-size="10" fill="#6b564a">${d}</text>`).join('');
  return `<svg viewBox="0 0 ${W} ${H}" width="100%">${g}${area}${line}${lab}</svg>`;
}

function pDashboard() {
  const O = db.orders, S = O.filter(o => o.status === 'Selesai');
  const rev = S.reduce((s, o) => s + calc(o.items).total, 0);
  const sold = S.reduce((s, o) => s + calc(o.items).qty, 0);
  const pel = new Set(O.map(o => o.nama).filter(n => n && n !== '-')).size;
  const aktif = db.menu.filter(m => m.status === 'Tersedia').length;
  const revs = HIST.map(h => Math.round(h * rev / 1000) * 1000), cnts = HIST.map(h => Math.round(h * O.length));
  const top = aggregate(db.trx.filter(t => t.status === 'Berhasil')).slice(0, 5);
  const names = o => o.items.map(i => menuBy(i.id).nama);
  const qa = [['Tambah Menu', I.plus, "openForm('menu')"], ['Menu & Kategori', I.grid, "nav('menu')"], ['Lihat Pesanan', I.clip, "nav('pesanan')"],
              ['Pelanggan Langganan', I.users, "nav('pelanggan')"], ['Kelola Pengguna', I.users, "nav('pengguna')"], ['Laporan Penjualan', I.bars, "nav('laporan')"]];
  return `<div class="dash"><div class="colf">
    <div class="hero" style="background:linear-gradient(90deg,rgba(35,18,10,.92) 0%,rgba(35,18,10,.65) 50%,rgba(35,18,10,.15) 100%),${bgUrls('banner')},#4a2b1c">
      <h2>Selamat Datang, Admin!</h2><p>Kelola data dan pantau operasional BeanByte dengan mudah.</p>
      <div class="dchip">${I.cal}<span class="dt-date"></span>${I.clock}<span class="dt-time"></span></div>
    </div>
    <div class="stats" style="margin:0">
      ${stat(I.cup, 'Total Pesanan Hari Ini', O.length, up('12% dari kemarin'))}
      ${stat(I.users, 'Total Pelanggan', pel, `<span class="sub">Langganan aktif: ${db.member.filter(m => m.status === 'Aktif').length}</span>`)}
      ${stat(I.dollar, 'Total Pendapatan Hari Ini', rp(rev), up('15% dari kemarin'))}
      ${stat(I.box, 'Total Menu', db.menu.length, `<span class="sub">Aktif: ${aktif} &nbsp;|&nbsp; Nonaktif: ${db.menu.length - aktif}</span>`)}
    </div>
    <div class="two">
      <div class="card"><div class="ch"><h2>Grafik Penjualan 7 Hari Terakhir</h2><div class="leg"><span><i class="b"></i>Pendapatan</span><span><i></i>Jumlah Pesanan</span></div></div>${chartBars(last7(), revs, cnts)}</div>
      <div class="card top5"><div class="ch"><h2>Produk Terlaris</h2><button class="lnk" onclick="nav('laporan')">Lihat Semua ${I.chevR}</button></div>
        ${top.map((e, i) => `<div class="it"><span class="no">${i + 1}</span>${thumb(e.m, 's')}<div><b>${esc(e.m.nama)}</b><small>${e.qty} terjual</small></div></div>`).join('')}</div>
    </div>
    <div class="card"><div class="ch"><h2>Pesanan Terbaru</h2><button class="lnk" onclick="nav('pesanan')">Lihat Semua ${I.chevR}</button></div>
      <div class="tbw" style="margin-top:0"><table class="tb"><thead><tr><th>No. Pesanan</th><th>Nama Pelanggan</th><th>Meja</th><th>Menu</th><th>Total</th><th>Status</th><th>Waktu</th><th></th></tr></thead><tbody>
        ${O.slice(0, 7).map((o, i) => `<tr class="clk" onclick="openOrder('${o.no}')"><td>${i + 1}. &nbsp;${o.no}</td><td>${esc(o.nama)}</td><td>${esc(o.meja || '-')}</td><td>${esc(names(o).join(', '))}</td><td>${rp(calc(o.items).total)}</td><td>${stBadge(o.status)}</td><td>${o.waktu}</td><td>${I.chevR.replace('<svg', '<svg width="14" height="14"')}</td></tr>`).join('')}
      </tbody></table></div></div>
  </div>
  <div class="colf">
    <div class="card"><h2 style="margin-bottom:12px">Aksi Cepat</h2>${qa.map(([t, i, f]) => `<button class="qa" onclick="${f}"><i>${i}</i>${t}<span class="chev">${I.chevR}</span></button>`).join('')}</div>
    <div class="card"><div class="ch"><h2>Pesanan Terbaru</h2><button class="lnk" onclick="nav('pesanan')">Lihat Semua ${I.chevR}</button></div>
      ${O.slice(0, 5).map(o => `<div class="rc" onclick="openOrder('${o.no}')"><i>${I.note}</i><div class="mid"><b>#${o.no}</b><small>${esc(names(o).slice(0, 2).join(' + '))}</small></div><div class="rt">${stBadge(o.status)}<small>${o.waktu}</small></div></div>`).join('')}</div>
    <div class="card"><div class="ch" style="margin-bottom:6px"><h2>Laporan Penjualan</h2><button class="lnk" onclick="nav('laporan')">Lihat Detail ${I.chevR}</button></div>
      <small style="color:var(--muted)">Total Penjualan (Hari Ini)</small>
      <div style="display:flex;justify-content:space-between;align-items:center"><b style="font-family:Outfit;font-size:1.5rem">${rp(rev)}</b>${up('15% dari kemarin')}</div>
      <div class="mini">
        <div>${I.receipt}<span>Jumlah Transaksi<b>${S.length}</b></span></div>
        <div>${I.wallet}<span>Rata-rata per Transaksi<b>${rp(S.length ? rev / S.length : 0)}</b></span></div>
        <div>${I.box}<span>Produk Terjual<b>${sold}</b></span></div>
      </div></div>
  </div></div>`;
}

/* ===================== HALAMAN: KELOLA MENU ===================== */
function menuFiltered() {
  const kw = q.trim().toLowerCase();
  return db.menu.filter(m => (F.menuKat === 'semua' || m.kat === F.menuKat) && (!F.menuStatus || m.status === F.menuStatus)
    && (!kw || [m.nama, m.desc, katNama(m.kat)].join(' ').toLowerCase().includes(kw)));
}
function menuTable() {
  const l = menuFiltered(), per = 10, p = clampPg(l.length, per);
  if (!l.length) return '<p class="empty">Menu tidak ditemukan</p>';
  return `<div class="tbw"><table class="tb"><thead><tr><th>No.</th><th>Gambar</th><th>Nama Menu</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
    ${l.slice((p - 1) * per, p * per).map((m, i) => `<tr><td>${(p - 1) * per + i + 1}</td><td>${thumb(m)}</td><td><b style="font-weight:600">${esc(m.nama)}</b><div class="sub">${esc(m.desc)}</div></td><td>${katBadge(m.kat)}</td><td>${rp(m.harga)}</td><td style="${m.stok <= 5 ? 'color:#c0392b;font-weight:700' : ''}">${m.stok}</td><td>${stBadge(m.status)}</td>
      <td class="act"><button class="btn sm" onclick="openForm('menu','${m.id}')">${I.edit}Edit</button><button class="btn sm del" onclick="hapusItem('menu','${m.id}')">${I.trash}Hapus</button></td></tr>`).join('')}
  </tbody></table></div>${foot(l.length, per, p, 'menu')}`;
}
function kategoriTable() {
  const kw = q.trim().toLowerCase();

  const rows = db.kat.filter(k =>
    (!F.katStatus || k.status === F.katStatus) &&
    (!kw || (k.nama + ' ' + (k.desc || '')).toLowerCase().includes(kw))
  );

  if (rows.length === 0) {
    return '<p class="empty">Kategori tidak ditemukan</p>';
  }

  return `
    <div class="tbw">
      <table class="tb">
        <thead>
          <tr>
            <th>No.</th>
            <th>Ikon</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Jumlah Menu</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          ${rows.map((k, i) => `
            <tr>
              <td>${i + 1}</td>
              <td>
                <span class="tile light"
                  style="width:44px;height:44px">
                  ${KATICON[k.ikon] || I.grid}
                </span>
              </td>
              <td><b>${esc(k.nama)}</b></td>
              <td>${esc(k.desc || '-')}</td>
              <td>${db.menu.filter(m => m.kat === k.id).length}</td>
              <td>${stBadge(k.status || 'Aktif')}</td>
              <td class="act">
                <button class="btn sm"
                  onclick="openForm('kategori','${k.id}')">
                  ${I.edit}Edit
                </button>
                <button class="btn sm del"
                  onclick="hapusItem('kategori','${k.id}')">
                  ${I.trash}Hapus
                </button>
              </td>
            </tr>
          `).join('')}
        </tbody>
      </table>
    </div>
  `;
}
function setMenuKategoriTab(tab) {
  if (tab !== 'menu' && tab !== 'kategori') return;
  menuKategoriTab = tab;
  q = '';
  pg.menu = 1;
  if (tab === 'menu') {
    F.menuKat = 'semua';
    F.menuStatus = '';
  } else {
    F.katStatus = '';
  }
  render();
}
function menuKategoriTabs() {
  return `<div class="tabs" style="margin-bottom:14px">
    <button class="tabb ${menuKategoriTab === 'menu' ? 'on' : ''}" onclick="setMenuKategoriTab('menu')">${I.fork}Menu</button>
    <button class="tabb ${menuKategoriTab === 'kategori' ? 'on' : ''}" onclick="setMenuKategoriTab('kategori')">${I.grid}Kategori Menu</button>
  </div>`;
}
function pMenu() {
  const isKategori = menuKategoriTab === 'kategori';
  const action = isKategori
    ? `<button class="btn" onclick="openForm('kategori')">${I.plus}Tambah Kategori</button>`
    : `<button class="btn" onclick="openForm('menu')">${I.plus}Tambah Menu</button>`;
  const heading = pageHead(I.fork, 'Menu & Kategori', 'Kelola daftar menu, kategori, harga, dan stok BeanByte dalam satu fitur.', action);

  if (isKategori) {
    return `${heading}<div class="card">${menuKategoriTabs()}
      <div class="tools">${searchBox('Cari kategori...')}
        <select class="sel" onchange="setF('katStatus',this.value)">
          <option value="">Semua Status</option>
          <option ${F.katStatus === 'Aktif' ? 'selected' : ''}>Aktif</option>
          <option ${F.katStatus === 'Nonaktif' ? 'selected' : ''}>Nonaktif</option>
        </select>
      </div>
      <div id="tbl">${kategoriTable()}</div>
    </div>`;
  }

  const categoryFilters = [['semua', 'Semua Menu', I.grid]]
    .concat(db.kat.map(k => [k.id, k.nama, KATICON[k.ikon] || I.cup]));

  return `${heading}<div class="card">${menuKategoriTabs()}
    <div class="tools"><div class="tabs grow">${categoryFilters.map(([k, t, i]) => `<button class="tabb ${F.menuKat === k ? 'on' : ''}" onclick="setF('menuKat','${k}')">${i}${esc(t)}</button>`).join('')}</div>
      <div class="sb" style="width:260px">${I.search}<input data-q value="${esc(q)}" placeholder="Cari menu..." oninput="setQ(this.value)"></div>
      <button class="fbtn ${F.menuStatus ? 'on' : ''}" onclick="cycleMenuStatus()" title="Filter status: ${F.menuStatus || 'Semua'}">${I.filter}</button>
    </div>
    <div id="tbl">${menuTable()}</div>
  </div>`;
}
/* ===================== HALAMAN: KELOLA PESANAN ===================== */
function ordFiltered() {
  const kw = q.trim().toLowerCase(), map = {Baru:'Menunggu'};
  const l = db.orders.filter(o => (F.ordTab === 'Semua' || o.status === (map[F.ordTab] || F.ordTab)) && (!kw || ['#' + o.no, o.no, o.nama].join(' ').toLowerCase().includes(kw)));
  return F.ordAsc ? l.slice().reverse() : l;
}
function pesananTable() {
  const l = ordFiltered(), per = 10, p = clampPg(l.length, per);
  if (!l.length) return '<p class="empty">Pesanan tidak ditemukan</p>';
  return `<div class="tbw"><table class="tb"><thead><tr><th>No.</th><th>Nomor Pesanan</th><th>Nama Pelanggan</th><th>Meja</th><th>Total</th><th>Status</th><th>Waktu</th><th>Aksi</th></tr></thead><tbody>
    ${l.slice((p - 1) * per, p * per).map((o, i) => `<tr class="clk ${o.no === selOrder ? 'sel' : ''}" onclick="pilihOrder('${o.no}')"><td>${(p - 1) * per + i + 1}</td><td>#${o.no}</td><td>${esc(o.nama)}${isMember(o.nama) ? '<span class="bd lg">Langganan</span>' : ''}<div class="sub">${calc(o.items).qty} item</div></td><td>${esc(o.meja || '-')}</td><td>${rp(calc(o.items).total)}</td><td>${stBadge(o.status)}</td><td>${o.waktu}</td><td class="act"><button class="btn sm">Detail ${I.chevR}</button></td></tr>`).join('')}
  </tbody></table></div>${foot(l.length, per, p, 'pesanan')}`;
}
function detailOrder() {
  const o = db.orders.find(x => x.no === selOrder);
  if (!o) return '';
  const c = calc(o.items);
  return `<aside class="dp"><div class="dh"><h3>Detail Pesanan</h3><button class="x" onclick="tutupDetail()" aria-label="Tutup">${I.x}</button></div>
    <div class="idr"><div><b>#${o.no}</b><div class="meta">${esc(o.nama)} • ${c.qty} item</div><div class="meta" style="display:flex;gap:6px;align-items:center">${I.clock.replace('<svg', '<svg width="14" height="14"')}${o.waktu} • ${tglPanjang()}</div></div>${stBadge(o.status)}</div>
    <h4>Daftar Menu</h4>
    ${o.items.map(i => { const m = menuBy(i.id); return `<div class="li">${thumb(m, 'xs')}<div class="nm"><b>${esc(m.nama)}</b><small>${i.qty} x ${rp(m.harga)}</small></div><span>${rp(m.harga * i.qty)}</span></div>`; }).join('')}
    <div class="row" style="margin-top:10px"><span>Subtotal</span><span>${rp(c.sub)}</span></div>
    ${c.diskon ? `<div class="row g"><span>Diskon</span><span>- ${rp(c.diskon)}</span></div>` : ''}
    <div class="row t"><span>Total</span><span>${rp(c.total)}</span></div>
    <h4>Informasi Pelanggan</h4>
    <div class="inf">${I.user}${esc(o.nama)}${isMember(o.nama) ? '<span class="bd lg">Langganan</span>' : ''}</div><div class="inf">${I.phone}${esc(o.telp)}</div>
    <div class="inf">${I.tag}Meja: ${esc(o.meja || '-')}</div><div class="inf">${I.wallet}Bayar: ${esc(o.metode || '-')}</div><div class="inf">${I.note}Catatan: ${esc(o.catatan || '-')}</div>
    <h4 style="border:0;padding-top:0;margin-bottom:6px">Ubah Status</h4>
    <select id="st_sel">${['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'].map(s => `<option ${o.status === s ? 'selected' : ''}>${s}</option>`).join('')}</select>
    <button class="btn" onclick="simpanStatus('${o.no}')">${I.checkc}Simpan</button></aside>`;
}
function pPesanan() {
  const O = db.orders;
  const tabs = [['Semua', I.list, ''], ['Baru', I.note, 'c-baru'], ['Diproses', I.hourglass, 'c-diproses'], ['Selesai', I.checkc, 'c-selesai'], ['Dibatalkan', I.xc, 'c-dibatalkan']];
  return `${pageHead(I.clip, 'Kelola Pesanan', 'Pantau dan kelola semua pesanan pelanggan di BeanByte.')}
    <div class="stats">
      ${stat(I.clip, 'Total Pesanan Hari Ini', O.length, up('12% dari kemarin'), true)}
      ${stat(I.hourglass, 'Pesanan Diproses', O.filter(o => o.status === 'Diproses' || o.status === 'Menunggu').length, `<span class="sub">dari ${O.length} pesanan</span>`, true)}
      ${stat(I.checkc, 'Pesanan Selesai', O.filter(o => o.status === 'Selesai').length, `<span class="sub">dari ${O.length} pesanan</span>`, true)}
      ${stat(I.xc, 'Pesanan Dibatalkan', O.filter(o => o.status === 'Dibatalkan').length, `<span class="sub">dari ${O.length} pesanan</span>`, true)}
    </div>
    <div class="split ${selOrder ? 'open' : ''}"><div class="card"><div class="tools"><div class="tabs grow">${tabs.map(([t, i, c]) => `<button class="tabb ${c} ${F.ordTab === t ? 'on' : ''}" onclick="setF('ordTab','${t}')">${i}${t}</button>`).join('')}</div>
      <div class="sb" style="width:250px">${I.search}<input data-q value="${esc(q)}" placeholder="Cari nomor pesanan, nama pelanggan..." oninput="setQ(this.value)"></div>
      <button class="fbtn ${F.ordAsc ? 'on' : ''}" onclick="toggleOrdSort()" title="Urutkan">${I.filter}</button></div>
      <div id="tbl">${pesananTable()}</div></div>${detailOrder()}</div>`;
}

/* ===================== HALAMAN: KELOLA TRANSAKSI ===================== */
function trxFiltered() {
  const kw = q.trim().toLowerCase();
  const l = db.trx.filter(t => {
    if (F.trxTab !== 'Semua' && t.status !== F.trxTab) return false;
    if (F.trxMetode && t.metode !== F.trxMetode) return false;
    if (F.trxFrom && t.ts < new Date(F.trxFrom + 'T00:00:00').getTime()) return false;
    if (F.trxTo && t.ts > new Date(F.trxTo + 'T23:59:59').getTime()) return false;
    if (kw) {
      const names = t.items.map(i => menuBy(i.id).nama).join(' ');
      if (![t.trx, t.nama, names].join(' ').toLowerCase().includes(kw)) return false;
    }
    return true;
  });
  const tot = t => calc(t.items).total;
  const sorter = {terbaru:(a, b) => b.ts - a.ts, terlama:(a, b) => a.ts - b.ts, tertinggi:(a, b) => tot(b) - tot(a), terendah:(a, b) => tot(a) - tot(b)};
  return l.sort(sorter[F.trxSort]);
}
function transaksiTable() {
  const l = trxFiltered(), per = 10, p = clampPg(l.length, per);
  if (!l.length) return '<p class="empty">Transaksi tidak ditemukan</p>';
  return `<div class="tbw"><table class="tb"><thead><tr><th>No.</th><th>No. Transaksi</th><th>Tanggal &amp; Waktu</th><th>Nama Pelanggan</th><th>Total</th><th>Metode</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
    ${l.slice((p - 1) * per, p * per).map((t, i) => `<tr class="clk ${t.trx === selTrx ? 'sel' : ''}" onclick="pilihTrx('${t.trx}')"><td>${(p - 1) * per + i + 1}</td><td>#${t.trx}</td><td>${fmtTgl(t.ts)}</td><td>${esc(t.nama)}</td><td>${rp(calc(t.items).total)}</td><td>${mBadge(t.metode)}</td><td>${stBadge(t.status)}</td><td class="act"><button class="btn sm ghost">${I.eye}Detail</button></td></tr>`).join('')}
  </tbody></table></div>${foot(l.length, per, p, 'transaksi')}`;
}
function detailTrx() {
  const t = db.trx.find(x => x.trx === selTrx);
  if (!t) return '';
  const c = calc(t.items);
  return `<aside class="dp"><div class="dh"><h3>Detail Transaksi</h3><button class="x" onclick="tutupDetail()" aria-label="Tutup">${I.x}</button></div>
    <div class="idr"><div><b style="font-size:.95rem">#${t.trx}</b><div class="meta">${fmtTgl(t.ts)}</div></div>${stBadge(t.status)}</div>
    <div class="inf" style="margin-top:6px">${I.user}${esc(t.nama)}</div><div class="inf">${I.phone}${esc(t.telp)}</div>
    <h4>Daftar Menu</h4>
    ${t.items.map(i => { const m = menuBy(i.id); return `<div class="li">${thumb(m, 'xs')}<div class="nm"><b>${esc(m.nama)}</b><small>${i.qty} x ${rp(m.harga)}</small></div><span>${rp(m.harga * i.qty)}</span></div>`; }).join('')}
    <div class="row" style="margin-top:10px"><span>Subtotal</span><span>${rp(c.sub)}</span></div>
    ${c.diskon ? `<div class="row g"><span>Diskon</span><span>- ${rp(c.diskon)}</span></div>` : ''}
    <div class="row t"><span>Total</span><span>${rp(c.total)}</span></div>
    <h4>Metode Pembayaran</h4><div class="inf">${I.wallet}${t.metode}</div>
    <h4>Informasi Kasir</h4><div class="inf">${I.user}${esc(t.kasir)}</div><div class="inf" style="padding-left:23px;font-size:.74rem">${fmtTgl(t.ts)}</div>
    <button class="btn" style="margin-top:14px" onclick="cetakTrx()">${I.printer}Cetak Struk</button></aside>`;
}
function pTransaksi() {
  const T = db.trx, ok = T.filter(t => t.status === 'Berhasil');
  const rev = ok.reduce((s, t) => s + calc(t.items).total, 0);
  const cnt = m => T.filter(t => t.metode === m).length;
  const tabs = [['Semua', I.list, ''], ['Berhasil', I.checkc, 'c-berhasil'], ['Pending', I.hourglass, 'c-pending'], ['Dibatalkan', I.xc, 'c-dibatalkan']];
  return `${pageHead(I.receipt, 'Kelola Transaksi', 'Pantau dan kelola semua transaksi yang terjadi di BeanByte.')}
    <div class="stats">
      ${stat(I.clip, 'Total Transaksi', T.length, up('12% dari kemarin'), true)}
      ${stat(I.dollar, 'Total Pendapatan', rp(rev), up('15% dari kemarin'), true)}
      ${stat(I.wallet, 'Metode Pembayaran', '', `<span class="sub" style="color:#4a3328">Tunai: ${cnt('Tunai')} &nbsp;|&nbsp; QRIS: ${cnt('QRIS')} &nbsp;|&nbsp; Lainnya: ${cnt('Lainnya')}</span>`, true)}
      ${stat(I.receipt, 'Rata-rata Transaksi', rp(ok.length ? rev / ok.length : 0), up('8% dari kemarin'), true)}
    </div>
    <div class="split ${selTrx ? 'open' : ''}"><div class="card">
      <div class="tools">${searchBox('Cari nomor transaksi, nama pelanggan, atau nama menu...')}
        <input class="sel" type="date" value="${F.trxFrom}" onchange="setF('trxFrom',this.value)" title="Dari tanggal"><span>s/d</span>
        <input class="sel" type="date" value="${F.trxTo}" onchange="setF('trxTo',this.value)" title="Sampai tanggal">
        <select class="sel" onchange="setF('trxMetode',this.value)"><option value="">Semua Metode</option>${['QRIS', 'Tunai', 'Lainnya'].map(m => `<option ${F.trxMetode === m ? 'selected' : ''}>${m}</option>`).join('')}</select></div>
      <div class="tools" style="margin-top:12px"><div class="tabs grow">${tabs.map(([t, i, c]) => `<button class="tabb ${c} ${F.trxTab === t ? 'on' : ''}" onclick="setF('trxTab','${t}')">${i}${t}</button>`).join('')}</div>
        <select class="sel" onchange="setF('trxSort',this.value)">${[['terbaru', 'Urutkan: Terbaru'], ['terlama', 'Urutkan: Terlama'], ['tertinggi', 'Total Tertinggi'], ['terendah', 'Total Terendah']].map(([v, t]) => `<option value="${v}" ${F.trxSort === v ? 'selected' : ''}>${t}</option>`).join('')}</select></div>
      <div id="tbl">${transaksiTable()}</div></div>${detailTrx()}</div>`;
}

/* ===================== HALAMAN: PELANGGAN LANGGANAN ===================== */
function memberStat(m) {
  const T = db.trx.filter(t => t.status === 'Berhasil' && t.nama.toLowerCase() === m.nama.toLowerCase());
  return {n:T.length, belanja:T.reduce((s, t) => s + calc(t.items).total, 0)};
}
function memberFiltered() {
  const kw = q.trim().toLowerCase();
  return db.member.filter(m => (!F.memStatus || m.status === F.memStatus) && (!kw || (m.nama + ' ' + m.telp).toLowerCase().includes(kw)));
}
function memberTable() {
  const l = memberFiltered(), per = 10, p = clampPg(l.length, per);
  if (!l.length) return '<p class="empty">Belum ada pelanggan langganan</p>';
  return `<div class="tbw"><table class="tb"><thead><tr><th>No.</th><th>Nama Pelanggan</th><th>No. Telepon</th><th>Bergabung</th><th>Total Pesanan</th><th>Total Belanja</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
    ${l.slice((p - 1) * per, p * per).map((m, i) => { const s = memberStat(m); return `<tr><td>${(p - 1) * per + i + 1}</td><td><b style="font-weight:600">${esc(m.nama)}</b></td><td>${esc(m.telp)}</td><td>${tglSaja(m.bergabung)}</td><td>${s.n}</td><td>${rp(s.belanja)}</td><td>${stBadge(m.status, true)}</td>
      <td class="act"><button class="btn sm" onclick="openForm('member','${m.id}')">${I.edit}Edit</button><button class="btn sm del" onclick="hapusItem('member','${m.id}')">${I.trash}Hapus</button></td></tr>`; }).join('')}
  </tbody></table></div>${foot(l.length, per, p, 'pelanggan')}`;
}
function pPelanggan() {
  const M = db.member, st = M.map(memberStat);
  const aktif = M.filter(m => m.status === 'Aktif').length;
  const belanja = st.reduce((s, x) => s + x.belanja, 0), pes = st.reduce((s, x) => s + x.n, 0);
  return `${pageHead(I.users, 'Pelanggan Langganan', 'Kelola pelanggan setia BeanByte. Pesanan mereka diberi tanda Langganan di Kelola Pesanan.', `<button class="btn" onclick="openForm('member')">${I.plus}Tambah Langganan</button>`)}
    <div class="stats">
      ${stat(I.users, 'Total Langganan', M.length, `<span class="sub">Aktif: ${aktif} &nbsp;|&nbsp; Nonaktif: ${M.length - aktif}</span>`, true)}
      ${stat(I.receipt, 'Total Pesanan Langganan', pes, `<span class="sub">transaksi berhasil</span>`, true)}
      ${stat(I.dollar, 'Total Belanja Langganan', rp(belanja), '', true)}
      ${stat(I.wallet, 'Rata-rata per Langganan', rp(M.length ? belanja / M.length : 0), '', true)}
    </div>
    <div class="card"><div class="tools">${searchBox('Cari nama atau nomor telepon...')}
      <select class="sel" onchange="setF('memStatus',this.value)"><option value="">Semua Status</option><option ${F.memStatus === 'Aktif' ? 'selected' : ''}>Aktif</option><option ${F.memStatus === 'Nonaktif' ? 'selected' : ''}>Nonaktif</option></select></div>
      <div id="tbl">${memberTable()}</div></div>`;
}
/* ===================== HALAMAN: KELOLA PENGGUNA ===================== */
function roleNama(role) {
  return ({admin:'Admin', kasir:'Kasir', pemilik:'Pemilik', pelanggan:'Pelanggan'})[String(role || '').toLowerCase()] || role || '-';
}
function penggunaTable() {
  if (penggunaLoading && !daftarPengguna.length) return '<p class="empty">Memuat data pengguna dari database...</p>';
  if (penggunaError && !daftarPengguna.length) return `<p class="empty">${esc(penggunaError)}<br><button class="btn sm" style="margin-top:12px" onclick="loadPengguna()">Coba Lagi</button></p>`;

  const term = String(q || '').toLowerCase();
  const rows = daftarPengguna.filter(u => [u.name, u.username, u.email, roleNama(u.role)].some(v => String(v || '').toLowerCase().includes(term)));
  if (!rows.length) return '<p class="empty">Belum ada pengguna yang cocok. Klik Tambah Pengguna untuk membuat akun.</p>';

  return `<div class="tbw"><table class="tb"><thead><tr><th>No.</th><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr></thead><tbody>
    ${rows.map((u, i) => `<tr>
      <td>${i + 1}</td><td><b>${esc(u.name)}</b></td><td><code>${esc(u.username || '-')}</code></td><td>${esc(u.email || '-')}</td>
      <td><span class="role-tag role-${esc(String(u.role || '').toLowerCase())}">${esc(roleNama(u.role))}</span></td>
      <td>${stBadge(String(u.status || 'aktif').toLowerCase() === 'nonaktif' ? 'Nonaktif' : 'Aktif', true)}</td>
      <td>${u.created_at ? esc(String(u.created_at).slice(0, 10)) : '-'}</td>
      <td><div style="display:flex;gap:6px"><button class="btn sm" onclick="openForm('pengguna', ${Number(u.id)})">${I.edit}Edit</button><button class="btn sm del" onclick="hapusItem('pengguna', ${Number(u.id)})">${I.trash}Hapus</button></div></td>
    </tr>`).join('')}
  </tbody></table></div><div class="foot"><span>${rows.length} pengguna ditampilkan</span><button class="btn ghost sm" onclick="loadPengguna()">Muat Ulang</button></div>`;
}
function pPengguna() {
  const total = daftarPengguna.length;
  const jumlahRole = role => daftarPengguna.filter(u => String(u.role).toLowerCase() === role).length;
  return `${pageHead(I.users, 'Kelola Pengguna', 'Atur akun login BeanByte, username, password, dan hak akses setiap pengguna.', `<button class="btn" onclick="openForm('pengguna')">${I.plus}Tambah Pengguna</button>`)}
    <div class="stats">
      ${stat(I.users, 'Total Akun', total, '<span class="sub">Akun yang tersimpan di database</span>', true)}
      ${stat(I.user, 'Admin', jumlahRole('admin'), '<span class="sub">Pengelola sistem</span>', true)}
      ${stat(I.clip, 'Kasir', jumlahRole('kasir'), '<span class="sub">Mengelola pesanan dan transaksi</span>', true)}
      ${stat(I.box, 'Pemilik', jumlahRole('pemilik'), '<span class="sub">Memantau operasional</span>', true)}
    </div>
    <div class="card"><div class="ch"><div><h2>Daftar Akun</h2><small style="color:var(--muted)">Password tidak ditampilkan. Untuk mengganti password, gunakan tombol Edit.</small></div></div>
      <div class="tools">${searchBox('Cari nama, username, email, atau role...')}<button class="btn ghost sm" onclick="loadPengguna()">Muat Ulang</button></div>
      <div id="tbl">${penggunaTable()}</div>
    </div>`;
}

function csrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}
async function requestPengguna(url, options = {}) {
  const headers = Object.assign({Accept:'application/json', 'X-CSRF-TOKEN':csrfToken()}, options.headers || {});
  if (options.body) headers['Content-Type'] = 'application/json';
  const response = await fetch(url, Object.assign({credentials:'same-origin', cache:'no-store'}, options, {headers}));
  const result = await response.json().catch(() => ({}));
  if (!response.ok) {
    const firstError = result.errors ? Object.values(result.errors).flat()[0] : null;
    throw new Error(firstError || result.message || `Permintaan gagal (HTTP ${response.status}). Pastikan login admin aktif.`);
  }
  return result;
}
async function loadPengguna() {
  if (penggunaLoading) return;
  penggunaLoading = true;
  penggunaError = '';
  if (page === 'pengguna') redrawTable();
  try {
    const result = await requestPengguna(API_PENGGUNA, {method:'GET'});
    daftarPengguna = Array.isArray(result) ? result : (result.data || []);
    if (!Array.isArray(daftarPengguna)) daftarPengguna = [];
  } catch (error) {
    penggunaError = error.message;
    console.error('Gagal mengambil data pengguna:', error);
  } finally {
    penggunaLoading = false;
    if (page === 'pengguna') render();
  }
}

/* ===================== HALAMAN: LAPORAN PENJUALAN ===================== */
function lapData() {
  let T = db.trx.filter(t => t.status === 'Berhasil');
  if (applied.metode) T = T.filter(t => t.metode === applied.metode);
  const kat = applied.kat;
  let rev = 0, qty = 0, count = 0;
  const byMetode = {QRIS:0, Tunai:0, Lainnya:0}, byHour = {};
  T.forEach(t => {
    const c = calc(t.items), f = c.sub ? c.total / c.sub : 1;
    let tr = 0, tq = 0;
    t.items.forEach(i => { const m = menuBy(i.id); if (kat && m.kat !== kat) return; tr += m.harga * i.qty * f; tq += i.qty; });
    if (tq) {
      rev += tr; qty += tq; count++;
      byMetode[t.metode] = (byMetode[t.metode] || 0) + tr;
      const h = new Date(t.ts).getHours();
      byHour[h] = (byHour[h] || 0) + tr;
    }
  });
  return {rev, qty, count, avg: count ? rev / count : 0, byMetode, byHour, top: aggregate(T, kat)};
}
function donut(parts, total) {
  const R = 62, C = 2 * Math.PI * R;
  let off = 0, segs = '';
  parts.forEach(p => {
    const len = total ? C * p.v / total : 0;
    segs += `<circle cx="80" cy="80" r="${R}" fill="none" stroke="${p.c}" stroke-width="26" stroke-dasharray="${len} ${C - len}" stroke-dashoffset="${-off}" transform="rotate(-90 80 80)"/>`;
    off += len;
  });
  return `<svg viewBox="0 0 160 160" width="170" height="170"><circle cx="80" cy="80" r="${R}" fill="none" stroke="#f1e7dc" stroke-width="26"/>${segs}
    <text x="80" y="74" text-anchor="middle" font-size="9" fill="#8b7467">Total</text><text x="80" y="90" text-anchor="middle" font-size="11" font-weight="600" fill="#2b1a12">${rp(total)}</text></svg>`;
}
function pLaporan() {
  const d = lapData(), ts = db.trx.map(t => t.ts), rev = d.rev;
  const rentang = ts.length ? `${fmtTgl(Math.min(...ts)).slice(0, -6)} - ${fmtTgl(Math.max(...ts)).slice(0, -6)}` : '-';
  const parts = [{n:'QRIS', c:'#6b3f2d'}, {n:'Tunai', c:'#d9b896'}, {n:'Lainnya', c:'#6cbf8f'}].map(p => ({...p, v:d.byMetode[p.n] || 0}));
  const hours = Object.keys(d.byHour).sort((a, b) => d.byHour[b] - d.byHour[a]);
  const peak = hours.length ? +hours[0] : null;
  const top1 = d.top[0];
  const trend = HIST.map(h => Math.round(h * rev / 1000) * 1000);
  const kopt = ['<option value="">Semua Kategori</option>'].concat(db.kat.map(k => `<option value="${k.id}" ${applied.kat === k.id ? 'selected' : ''}>${esc(k.nama)}</option>`)).join('');
  const mopt = ['<option value="">Semua Metode</option>'].concat(['QRIS', 'Tunai', 'Lainnya'].map(m => `<option ${applied.metode === m ? 'selected' : ''}>${m}</option>`)).join('');
  const kin = (icon, t, main, sub, right) => `<div class="kin"><i>${icon}</i><div class="mid"><small>${t}</small><b>${main}</b><small>${sub}</small></div>${right || ''}</div>`;
  return `${pageHead(I.bars, 'Laporan Penjualan', 'Analisis penjualan dan performa bisnis BeanByte.')}
    <div class="card" style="margin-bottom:16px"><div class="tools">
      <div class="sb" style="min-width:230px">${I.cal}<span style="font-size:.82rem">${rentang}</span></div>
      <select class="sel" id="lap_kat" style="min-width:170px">${kopt}</select>
      <select class="sel" id="lap_met" style="min-width:170px">${mopt}</select>
      <span class="grow"></span>
      <button class="btn" onclick="terapkanLap()">${I.filter}Terapkan</button>
      <button class="btn ghost" onclick="eksporLaporan()">${I.download}Ekspor Laporan</button></div></div>
    <div class="stats">
      ${stat(I.wallet, 'Total Penjualan', rp(d.rev), up('15% dari periode sebelumnya'))}
      ${stat(I.receipt, 'Total Transaksi', d.count, up('12% dari periode sebelumnya'))}
      ${stat(I.dollar, 'Rata-rata Transaksi', rp(d.avg), up('8% dari periode sebelumnya'))}
      ${stat(I.box, 'Produk Terjual', d.qty, up('10% dari periode sebelumnya'))}
    </div>
    <div class="lap">
      <div class="card"><div class="ch"><h2>${I.trend.replace('<svg', '<svg width="20" height="20" style="display:inline;vertical-align:-4px;margin-right:8px"')}Tren Penjualan</h2><span class="leg"><span><i></i>Penjualan</span></span></div>${chartArea(last7(), trend)}</div>
      <div class="card"><div class="ch"><h2>Metode Pembayaran</h2></div><div class="donut">${donut(parts, d.rev)}
        <div class="lg">${parts.map(p => `<div class="lr"><i style="background:${p.c}"></i>${p.n}<em>${d.rev ? Math.round(100 * p.v / d.rev) : 0}%<small>${rp(p.v)}</small></em></div>`).join('')}</div></div></div>
    </div>
    <div class="lap" style="grid-template-columns:minmax(0,1.5fr) minmax(0,1fr)">
      <div class="card"><div class="ch"><h2>${I.trophy.replace('<svg', '<svg width="20" height="20" style="display:inline;vertical-align:-4px;margin-right:8px"')}Produk Terlaris</h2></div>
        ${d.top.length ? `<div class="tbw" style="margin-top:0"><table class="tb"><thead><tr><th>Peringkat</th><th>Produk</th><th>Kategori</th><th>Terjual</th><th>Pendapatan</th></tr></thead><tbody>
          ${d.top.slice(0, 5).map((e, i) => `<tr><td><span class="rank ${i > 2 ? 'l' : ''}">${i + 1}</span></td><td><div style="display:flex;align-items:center;gap:10px">${thumb(e.m, 's')}${esc(e.m.nama)}</div></td><td>${katBadge(e.m.kat)}</td><td>${e.qty}</td><td>${rp(e.rev)}</td></tr>`).join('')}
        </tbody></table></div>` : '<p class="empty">Belum ada data penjualan</p>'}</div>
      <div class="card"><div class="ch"><h2>${I.trend.replace('<svg', '<svg width="20" height="20" style="display:inline;vertical-align:-4px;margin-right:8px"')}Ringkasan Kinerja</h2></div>
        ${kin(I.bars, 'Pertumbuhan Penjualan', '', 'dibandingkan periode sebelumnya', up('15%'))}
        ${kin(I.user, 'Rata-rata Nilai Transaksi', rp(d.avg), 'per transaksi', up('8%'))}
        ${kin(I.box, 'Produk Paling Laris', top1 ? esc(top1.m.nama) : '-', top1 ? `${top1.qty} terjual (${d.qty ? Math.round(100 * top1.qty / d.qty) : 0}% dari total)` : '-', I.chevR.replace('<svg', '<svg width="16" height="16"'))}
        ${kin(I.clock, 'Jam Puncak Penjualan', peak !== null ? `${pad(peak)}:00 - ${pad(peak + 1)}:00` : '-', peak !== null && d.rev ? `${Math.round(100 * d.byHour[peak] / d.rev)}% dari total penjualan` : '-', I.chevR.replace('<svg', '<svg width="16" height="16"'))}
      </div>
    </div>`;
}


/* ===================== HALAMAN: KELOLA QR PELANGGAN ===================== */
const QR_TUNNEL_KEY = 'beanbyte_tunnel_url';
let daftarMejaQR = [];
let qrLoading = false;
let qrError = '';
function urlTunnelTersimpan(){ return localStorage.getItem(QR_TUNNEL_KEY) || ''; }
function normalisasiTunnel(v){ return String(v || '').trim().replace(/\/+$/, ''); }
function urlQrMeja(id){ return normalisasiTunnel(urlTunnelTersimpan()) + '/pelanggan?meja=' + encodeURIComponent(id); }
function pQrPelanggan(){
  const tunnel = urlTunnelTersimpan();
  const status = qrLoading ? 'Mengambil daftar meja dari database...' : qrError ? qrError : `${daftarMejaQR.length} meja ditemukan dari database`;
  return `${pageHead(I.grid, 'Kelola QR Pelanggan', 'Atur URL akses pelanggan dan buat QR Code untuk meja M01 sampai M10.')}
    <div class="card">
      <div class="ch"><h2>Pengaturan URL Tunnel</h2><span class="bd ${tunnel ? 's-aktif' : 's-menipis'}">${tunnel ? 'URL tersimpan' : 'Belum diatur'}</span></div>
      <div class="qr-setting"><label class="fl"><span>URL Cloudflare Tunnel</span><input id="qrTunnelInput" type="url" placeholder="https://nama-tunnel.trycloudflare.com" value="${esc(tunnel)}"></label>
      <button class="btn" onclick="simpanTunnelQR()">${I.checkc}Simpan URL</button></div>
      <div class="qr-note">Masukkan URL tunnel yang sedang aktif, tanpa tambahan <code>/pelanggan</code>. Sistem akan mengambil data meja dari database melalui <code>/api/meja</code> dan membuat QR yang membuka halaman pelanggan sesuai nomor meja.</div>
    </div>
    <div class="card" style="margin-top:16px">
      <div class="ch"><div><h2>QR Code Meja Pelanggan</h2><small style="color:var(--muted)">${esc(status)}</small></div>
        <div class="tools"><button class="btn ghost sm" onclick="muatMejaQR()">${I.refresh || I.grid}Muat Ulang</button><button class="btn sm" onclick="cetakSemuaQR()" ${!tunnel || !daftarMejaQR.length ? 'disabled' : ''}>${I.receipt}Cetak Semua QR</button></div>
      </div>
      ${!tunnel ? '<p class="empty">Simpan URL Tunnel terlebih dahulu untuk menampilkan QR Code.</p>' : qrLoading ? '<p class="empty">Sedang mengambil data meja...</p>' : qrError ? `<p class="empty">${esc(qrError)}</p>` : !daftarMejaQR.length ? '<p class="empty">Data meja belum ditemukan di database.</p>' : `<div id="qrPrint"><div class="qr-grid">${daftarMejaQR.map(m => { const id = Number(m.id_meja ?? m.id); const nama = m.nomor_meja || m.nama_meja || m.kode_meja || ('M' + String(id).padStart(2,'0')); const link = urlQrMeja(id); const img = 'https://api.qrserver.com/v1/create-qr-code/?size=240x240&margin=10&data=' + encodeURIComponent(link); return `<article class="qr-card"><h3>${esc(nama)}</h3><p>Scan untuk memesan di meja ini</p><img loading="lazy" src="${img}" alt="QR Code ${esc(nama)}"><div class="qr-url">${esc(link)}</div><button class="btn ghost sm" onclick="bukaLinkQR('${esc(link)}')">Buka Link</button></article>`; }).join('')}</div></div>`}
    </div>`;
}
function simpanTunnelQR(){
  const el = document.getElementById('qrTunnelInput');
  const value = normalisasiTunnel(el ? el.value : '');
  if (!value) return toast('URL Tunnel wajib diisi');
  try { const u = new URL(value); if (u.protocol !== 'https:' && u.hostname !== 'localhost' && u.hostname !== '127.0.0.1') return toast('Gunakan URL HTTPS yang valid'); }
  catch(e){ return toast('Format URL Tunnel tidak valid'); }
  localStorage.setItem(QR_TUNNEL_KEY, value);
  toast('URL Tunnel berhasil disimpan');
  muatMejaQR();
}

async function muatMejaQR() {
  qrLoading = true;
  qrError = '';
  render();

  try {
    const response = await fetch('/api/meja', {
      headers: {
        Accept: 'application/json'
      },
      cache: 'no-store',
      credentials: 'same-origin'
    });

    if (!response.ok) {
      throw new Error(
        'Gagal mengambil data meja dari database (HTTP ' +
        response.status + ').'
      );
    }

    const hasil = await response.json();

    const rows = Array.isArray(hasil)
      ? hasil
      : (hasil.data || hasil.meja || []);

    if (!Array.isArray(rows)) {
      throw new Error('Format data meja dari API tidak sesuai.');
    }

    daftarMejaQR = rows
  .map(m => ({
    ...m,
    status: String(m.status ?? '').trim().toLowerCase()
  }))
  .filter(m => {
    const id = Number(m.id_meja ?? m.id);
    return Number.isInteger(id) && id >= 1 && id <= 10;
  })
      .sort((a, b) =>
        Number(a.id_meja ?? a.id) -
        Number(b.id_meja ?? b.id)
      );

    if (daftarMejaQR.length === 0) {
      throw new Error(
        'Data meja M01 sampai M10 tidak ditemukan.'
      );
    }

  } catch (e) {
    qrError = e.message || 'Tidak dapat menghubungi API meja.';
    daftarMejaQR = [];
    console.error('Error QR Meja:', e);

  } finally {
    qrLoading = false;
    render();
  }
}

function bukaLinkQR(link){ window.open(link,'_blank','noopener'); }
function cetakSemuaQR(){ if (!daftarMejaQR.length || !urlTunnelTersimpan()) return toast('QR belum tersedia'); window.print(); }

const PAGES = {dashboard:pDashboard, menu:pMenu, pesanan:pPesanan, transaksi:pTransaksi, pelanggan:pPelanggan, pengguna:pPengguna, laporan:pLaporan, qrpelanggan:pQrPelanggan};
const TABLES = {menu:() => menuKategoriTab === 'kategori' ? kategoriTable() : menuTable(), pesanan:pesananTable, transaksi:transaksiTable, pelanggan:memberTable, pengguna:penggunaTable};

/* ===================== RENDER ===================== */
function render() {
  const y = window.scrollY;
  $('#app').innerHTML = `<div class="app ${collapsed ? 'collapsed' : ''}">${sidebar()}<main class="main">${topbar()}<div class="content">${PAGES[page]()}</div></main></div>`;
  tick();
  window.scrollTo(0, y);
}
function redrawTable() { const t = $('#tbl'); if (t && TABLES[page]) t.innerHTML = TABLES[page](); }

/* ===================== AKSI UMUM ===================== */
function nav(k) {
  page = k; q = ''; userMenu = false; selOrder = null; selTrx = null;
  Object.keys(pg).forEach(x => pg[x] = 1);
  render(); window.scrollTo(0, 0);
  if (page === 'pengguna') loadPengguna();
  if (page === 'qrpelanggan') muatMejaQR();
}
function toggleSide() { collapsed = !collapsed; render(); }
function toggleUser() { userMenu = !userMenu; render(); }
function notif() {
  const n = db.orders.filter(o => o.status === 'Menunggu').length;
  toast(n ? `Ada ${n} pesanan yang menunggu diproses` : 'Tidak ada notifikasi baru');
}
async function logout() {
  if (!confirm('Yakin ingin keluar?')) return;
  try {
    await fetch('/logout', {method:'POST', credentials:'same-origin', headers:{'X-CSRF-TOKEN':csrfToken(), 'Accept':'application/json'}});
  } catch (e) { console.warn('Permintaan logout tidak berhasil dikonfirmasi:', e); }
  window.location.href = '/login';
}
function setQ(v) {
  q = v; pg[page] = 1;
  document.querySelectorAll('input[data-q]').forEach(i => { if (i !== document.activeElement) i.value = q; });
  redrawTable();
}
function topEnter(e) {
  if (e.key === 'Enter' && !TABLES[page]) { const keep = q; nav('menu'); q = keep; render(); }
}
function setF(k, v) { F[k] = v; pg[page] = 1; render(); }
function goPg(n) { pg[page] = n; redrawTable(); }

function cycleMenuStatus() {
  F.menuStatus = F.menuStatus === '' ? 'Tersedia' : (F.menuStatus === 'Tersedia' ? 'Habis' : '');
  pg.menu = 1; render(); toast('Filter status: ' + (F.menuStatus || 'Semua'));
}
function toggleOrdSort() { F.ordAsc = !F.ordAsc; pg.pesanan = 1; render(); toast(F.ordAsc ? 'Urutan: terlama dulu' : 'Urutan: terbaru dulu'); }

function pilihOrder(no) { selOrder = no; render(); }
function pilihTrx(t) { selTrx = t; render(); }
function tutupDetail() { selOrder = null; selTrx = null; render(); }
function openOrder(no) {
  page = 'pesanan'; q = ''; F.ordTab = 'Semua'; selOrder = no;
  const idx = ordFiltered().findIndex(o => o.no === no);
  pg.pesanan = Math.floor(Math.max(idx, 0) / 10) + 1;
  render(); window.scrollTo(0, 0);
}

function buatTrx(o) {
  if (db.trx.some(t => t.pes === o.no)) return;
  const d = new Date(), ymd = '' + d.getFullYear() + pad(d.getMonth() + 1) + pad(d.getDate());
  const n = db.trx.filter(t => t.trx.startsWith('TRX-' + ymd)).length + 1;
  db.trx.unshift({trx:`TRX-${ymd}-${String(n).padStart(3, '0')}`, ts:Date.now(), nama:o.nama, metode:o.metode || 'Tunai', status:'Berhasil',
    items:o.items.map(i => Object.assign({}, i)), kasir:'Kasir 1', telp:o.telp, pes:o.no});
}
function simpanStatus(no) {
  const o = db.orders.find(x => x.no === no), v = $('#st_sel').value;
  if (!o) return;
  const was = o.status;
  o.status = v;
  if (v === 'Selesai' && was !== 'Selesai') buatTrx(o);
  setStatusAntrian(no, v);
  save(); render(); toast(`Status #${no}: ${v}`);
  sinkron();
}

/* ===================== FORM (MODAL) ===================== */
const fld = (label, id, val, attrs = '') => `<label class="fl"><span>${label}</span><input id="f_${id}" value="${esc(val)}" ${attrs}></label>`;
const slc = (label, id, opts, val) => `<label class="fl"><span>${label}</span><select id="f_${id}">${opts.map(o => { const v = Array.isArray(o) ? o[0] : o, t = Array.isArray(o) ? o[1] : o; return `<option value="${esc(v)}" ${String(v) === String(val) ? 'selected' : ''}>${esc(t)}</option>`; }).join('')}</select></label>`;

function openForm(type, id) { modal = {type, id:id || null}; renderModal(); }
function closeModal() { modal = null; $('#modal').innerHTML = ''; }
function renderModal() {
  if (!modal) return;
  const {type, id} = modal;
  let title = '', body = '';
  if (type === 'menu') {
    const m = id ? db.menu.find(x => x.id === id) : {nama:'', desc:'', kat:db.kat[0] ? db.kat[0].id : '', harga:'', stok:'', status:'Tersedia'};
    title = id ? 'Edit Menu' : 'Tambah Menu';
    body = fld('Nama Menu', 'nama', m.nama) + fld('Deskripsi', 'desc', m.desc) + slc('Kategori', 'kat', db.kat.map(k => [k.id, k.nama]), m.kat)
      + `<div class="g2">${fld('Harga (Rp)', 'harga', m.harga, 'type="number" min="0"')}${fld('Stok', 'stok', m.stok, 'type="number" min="0"')}</div>` + slc('Status', 'status', ['Tersedia', 'Habis'], m.status);
  } else if (type === 'kategori') {
    const k = id ? db.kat.find(x => x.id === id) : {nama:'', desc:'', status:'Aktif', ikon:'cup'};
    title = id ? 'Edit Kategori' : 'Tambah Kategori';
    body = fld('Nama Kategori', 'nama', k.nama) + fld('Deskripsi', 'desc', k.desc)
      + `<div class="g2">${slc('Status', 'status', ['Aktif', 'Nonaktif'], k.status)}${slc('Ikon', 'ikon', [['cup', 'Kopi'], ['drink', 'Minuman'], ['food', 'Makanan']], k.ikon)}</div>`;
  } else if (type === 'pengguna') {
    const u = id ? daftarPengguna.find(x => Number(x.id) === Number(id)) : {name:'', username:'', email:'', role:'kasir'};
    if (!u) { modal = null; toast('Data pengguna tidak ditemukan'); return; }
    title = id ? 'Edit Pengguna' : 'Tambah Pengguna';
    body = fld('Nama Lengkap', 'nama', u.name || '')
      + fld('Username', 'username', u.username || '', 'autocomplete="off"')
      + fld('Email', 'email', u.email || '', 'type="email" autocomplete="off"')
      + slc('Role / Hak Akses', 'role', [['admin','Admin'], ['kasir','Kasir'], ['pemilik','Pemilik'], ['pelanggan','Pelanggan']], u.role || 'kasir')
      + slc('Status Akun', 'status', [['aktif','Aktif'], ['nonaktif','Nonaktif']], String(u.status || 'aktif').toLowerCase())
      + `<label class="fl"><span>Password ${id ? '(kosongkan jika tidak diubah)' : ''}</span><input id="f_password" type="password" autocomplete="new-password" minlength="8" ${id ? '' : 'required'} placeholder="Minimal 8 karakter"></label>`
      + `<label class="fl"><span>Konfirmasi Password ${id ? '(isi jika mengganti password)' : ''}</span><input id="f_password_confirm" type="password" autocomplete="new-password" minlength="8" placeholder="Ulangi password"></label>`;
  } else if (type === 'member') {
    const m = id ? db.member.find(x => x.id === id) : {nama:'', telp:'', status:'Aktif'};
    title = id ? 'Edit Pelanggan Langganan' : 'Tambah Pelanggan Langganan';
    body = fld('Nama Pelanggan', 'nama', m.nama) + fld('No. Telepon', 'telp', m.telp === '-' ? '' : m.telp, 'type="tel"') + slc('Status', 'status', ['Aktif', 'Nonaktif'], m.status);
  }
  $('#modal').innerHTML = `<div class="mbg" onclick="if(event.target===this)closeModal()"><div class="modal"><h2>${title}</h2>${body}
    <div class="mfoot"><button class="btn ghost" onclick="closeModal()">Batal</button><button class="btn" onclick="simpanForm()">Simpan</button></div></div></div>`;
  const first = $('#f_nama'); if (first) first.focus();
}
const val = id => ($('#f_' + id) || {value:''}).value.trim();
function uniqueId(list, nama) { let id = slug(nama), n = 2; while (list.some(x => x.id === id)) id = slug(nama) + '-' + n++; return id; }

async function simpanForm() {
  const {type, id} = modal;
  if (type === 'pengguna') {
    const name = val('nama');
    const username = val('username');
    const email = val('email');
    const role = val('role');
    const password = ($('#f_password') || {value:''}).value;
    const passwordConfirmation = ($('#f_password_confirm') || {value:''}).value;
    if (!name || !username || !email) return toast('Nama, username, dan email wajib diisi');
    if (!id && password.length < 8) return toast('Password minimal 8 karakter');
    if (password && password.length < 8) return toast('Password minimal 8 karakter');
    if (password && password !== passwordConfirmation) return toast('Konfirmasi password tidak sama');
    if (!id && !password) return toast('Password wajib diisi untuk akun baru');
    const payload = {name, username, email, role, status:val('status') || 'aktif'};
    if (password) {
      payload.password = password;
      payload.password_confirmation = passwordConfirmation;
    }
    try {
      await requestPengguna(id ? `${API_PENGGUNA}/${id}` : API_PENGGUNA, {
        method: id ? 'PUT' : 'POST', body: JSON.stringify(payload)
      });
      closeModal();
      await loadPengguna();
      toast(id ? 'Pengguna berhasil diperbarui' : 'Pengguna berhasil ditambahkan');
    } catch (error) {
      toast(error.message);
      console.error(error);
    }
    return;
  }
  if (!val('nama')) return toast('Nama wajib diisi');
  if (type === 'menu') {
    const harga = parseInt(val('harga'), 10), stok = parseInt(val('stok'), 10);
    if (isNaN(harga) || harga < 0) return toast('Harga belum valid');
    const data = {nama:val('nama'), desc:val('desc'), kat:val('kat'), harga, stok:isNaN(stok) ? 0 : stok, status:val('status')};
    if (id) Object.assign(db.menu.find(x => x.id === id), data);
    else {
      const nid = uniqueId(db.menu, data.nama), emo = {kopi:'☕', nonkopi:'🧋', makanan:'🍽️'}[data.kat] || '🍽️';
      db.menu.push(Object.assign({id:nid, emoji:emo, foto:nid + '.jpg'}, data));
    }
  } else if (type === 'kategori') {
    const data = {nama:val('nama'), desc:val('desc'), status:val('status'), ikon:val('ikon')};
    if (id) Object.assign(db.kat.find(x => x.id === id), data);
    else db.kat.push(Object.assign({id:uniqueId(db.kat, data.nama), tone:'dark'}, data));
  } else if (type === 'member') {
    const data = {nama:val('nama'), telp:val('telp') || '-', status:val('status')};
    if (id) Object.assign(db.member.find(x => x.id === id), data);
    else db.member.push(Object.assign({id:uniqueId(db.member, data.nama), bergabung:Date.now()}, data));
  }
  save(); closeModal(); render(); toast('Data berhasil disimpan');
}

async function hapusItem(type, id) {
  if (type === 'pengguna') {
    const u = daftarPengguna.find(x => Number(x.id) === Number(id));
    if (!u || !confirm(`Hapus akun "${u.username}"? Pengguna tersebut tidak bisa login lagi.`)) return;
    try {
      await requestPengguna(`${API_PENGGUNA}/${id}`, {method:'DELETE'});
      await loadPengguna();
      toast('Akun pengguna berhasil dihapus');
    } catch (error) {
      toast(error.message);
      console.error(error);
    }
    return;
  }
  if (type === 'kategori') {
    const dipakai = db.menu.filter(m => m.kat === id).length;
    if (dipakai) return toast(`Kategori masih dipakai ${dipakai} menu`);
  }
  const list = {menu:db.menu, kategori:db.kat, member:db.member}[type];
  const item = list.find(x => x.id === id);
  if (!item || !confirm(`Hapus "${item.nama}"?`)) return;
  list.splice(list.indexOf(item), 1);
  if (type === 'kategori' && F.menuKat === id) F.menuKat = 'semua';
  save(); render(); toast('Data dihapus');
}

/* ===================== LAPORAN & STRUK ===================== */
function terapkanLap() { applied.kat = $('#lap_kat').value; applied.metode = $('#lap_met').value; render(); toast('Filter diterapkan'); }
function eksporLaporan() {
  const d = lapData();
  const rows = [['Peringkat', 'Produk', 'Kategori', 'Terjual', 'Pendapatan']].concat(d.top.map((e, i) => [i + 1, e.m.nama, katNama(e.m.kat), e.qty, Math.round(e.rev)]));
  rows.push([], ['Total Penjualan', Math.round(d.rev)], ['Total Transaksi', d.count], ['Produk Terjual', d.qty]);
  const csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g, '""') + '"').join(',')).join('\r\n');
  const a = document.createElement('a');
  a.href = URL.createObjectURL(new Blob(['\ufeff' + csv], {type:'text/csv;charset=utf-8'}));
  a.download = 'laporan-penjualan.csv';
  a.click();
  toast('Laporan diekspor');
}
function cetakTrx() {
  const t = db.trx.find(x => x.trx === selTrx);
  if (!t) return;
  const c = calc(t.items);
  const w = window.open('', '_blank', 'width=380,height=600');
  if (!w) return toast('Izinkan pop-up untuk mencetak struk');
  const baris = t.items.map(i => { const m = menuBy(i.id); return `<div class="r"><span>${esc(m.nama)} x${i.qty}</span><span>${rp(m.harga * i.qty)}</span></div>`; }).join('');
  w.document.write(`<html><head><title>Struk ${t.trx}</title><style>body{font-family:monospace;padding:16px;font-size:13px}h2,p.c{text-align:center}hr{border:0;border-top:1px dashed #000;margin:8px 0}.r{display:flex;justify-content:space-between}</style></head><body>
    <h2>BeanByte</h2><p class="c">Kopi • Rasa • Cerita</p><hr><div>No: ${t.trx}</div><div>Pelanggan: ${esc(t.nama)}</div><div>${fmtTgl(t.ts)}</div><div>Bayar: ${t.metode}</div><hr>
    ${baris}<hr><div class="r"><span>Subtotal</span><span>${rp(c.sub)}</span></div>${c.diskon ? `<div class="r"><span>Diskon (15%)</span><span>- ${rp(c.diskon)}</span></div>` : ''}
    <div class="r"><b>Total</b><b>${rp(c.total)}</b></div><hr><p class="c">Terima kasih!</p></body></html>`);
  w.document.close(); w.focus();
  setTimeout(() => w.print(), 300);
}

sinkron();
render();

// Stok dan harga selalu dibaca dari MySQL, bukan dikurangi di localStorage Admin.
sinkronStokDatabase();
setInterval(sinkronStokDatabase, 5000);

setInterval(sinkron, 2000);
if (window.addEventListener) window.addEventListener('storage', e => { if (e.key === ANTRIAN) sinkron(); });
</script>
</body>
</html>