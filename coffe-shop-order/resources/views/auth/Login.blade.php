<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - BeanByte</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Archivo+Black&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    [hidden]{display:none!important}
    body{font-family:"Open Sans",system-ui,sans-serif;background:#fffdf8;min-height:100vh;display:grid;place-items:center;padding:24px;color:#000}
    .box{display:grid;grid-template-columns:1fr 1fr;width:min(950px,100%);min-height:640px;box-shadow:14px 16px 14px rgba(0,0,0,.25);background:#fff}
    .left{background:#45301f;color:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:40px;gap:6px}
    .left svg{width:100px;height:100px;fill:none;stroke:#ffefd5;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}
    .left h1{font-family:"Archivo Black","Open Sans",sans-serif;font-size:44px;font-weight:400;letter-spacing:1px}
    .left .tag{font-size:17px}
    .left h2{font-size:17px;color:#ffefd5;margin-top:36px}
    .left p{font-size:13px;max-width:240px;line-height:1.4}
    .right{padding:24px 40px;display:flex;flex-direction:column;justify-content:center}
    .right h1{font-family:"Archivo Black","Open Sans",sans-serif;font-size:34px;font-weight:400}
    .sub{margin:6px 0 24px;line-height:1.5}
    label.t{display:block;font-weight:700;font-size:16px;margin-bottom:8px}
    .in{display:flex;align-items:center;gap:16px;border:1.5px solid #000;border-radius:10px;padding:0 16px;height:54px;margin-bottom:22px}
    .in:focus-within{box-shadow:0 0 0 3px rgba(92,64,51,.25)}
    .in svg{width:24px;height:24px;fill:none;stroke:#000;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
    .in input{flex:1;border:0;outline:0;font:inherit;font-size:15px;background:none;min-width:0}
    .in button{border:0;background:none;cursor:pointer;display:grid}
    .row{display:flex;justify-content:space-between;align-items:center;font-size:13px;margin:-8px 0 22px}
    .row label{display:flex;gap:8px;align-items:center;cursor:pointer}.row input{width:20px;height:20px;accent-color:#5b4034}
    .row a{color:#000}
    .go{width:100%;height:54px;border-radius:10px;border:1.5px solid #000;background:#5c4033;color:#fff;font:700 18px "Open Sans";cursor:pointer;display:grid;place-items:center;text-decoration:none}
    .go:hover{background:#4a3226}
    .back{display:inline-flex;gap:8px;align-items:center;margin-top:22px;color:#000;font-size:14px}
    .back svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .err{background:#fbdcdc;color:#a32;border-radius:8px;padding:10px 12px;margin-bottom:16px;font-size:13px}
    .ok{text-align:center;display:flex;flex-direction:column;align-items:center;gap:10px}
    .ok .badge{width:84px;height:84px;border-radius:50%;background:#e0f2e6;display:grid;place-items:center;margin-bottom:6px}
    .ok .badge svg{width:42px;height:42px;fill:none;stroke:#1f7a4d;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}
    .ok p{line-height:1.5;max-width:340px}
    .ok .go{margin-top:14px}
    @media(max-width:720px){.box{grid-template-columns:1fr}.left{padding:28px}.right{padding:28px 24px}}
  </style>
</head>
<body>
  @php $sukses = session('status'); @endphp

  <div class="box">
    {{-- Panel kiri (teks berubah sesuai tampilan) --}}
    <div class="left">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
      <h1>BeanByte</h1>
      <div class="tag">Kopi • Rasa • Cerita</div>
      <h2 id="kiriJudul">Selamat datang di BeanByte</h2>
      <p id="kiriTeks">Nikmati kopi favoritmu, dan kelola pesanan dengan mudah</p>
    </div>

    <div class="right">
      {{-- 1. LOGIN --}}
      <form id="v-login" method="POST" action="{{ url('/login') }}" {{ $sukses ? 'hidden' : '' }}>
        @csrf
        <h1>Login</h1>
        <p class="sub">Masuk untuk mengakses sistem BeanByte.</p>

        @if ($errors->has('username') || $errors->has('password'))
          <div class="err">{{ $errors->first() }}</div>
        @endif

        <label class="t" for="username">Username</label>
        <div class="in">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-3a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v3z"/></svg>
          <input id="username" name="username" value="{{ old('username') }}" placeholder="Masukan username" autocomplete="username" required>
        </div>

        <label class="t" for="password">Password</label>
        <div class="in">
          <svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
          <input id="password" type="password" name="password" placeholder="Masukan password" autocomplete="current-password" required>
          <button type="button" id="toggle" aria-label="Tampilkan password">
            <svg viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
          </button>
        </div>

        <div class="row">
          <label><input type="checkbox" name="remember"> Ingat kamu</label>
          <a href="#lupa" data-view="lupa">Lupa password?</a>
        </div>

        <button class="go" type="submit">Login</button>
      </form>

      {{-- 2. LUPA PASSWORD --}}
      <div id="v-lupa" hidden>
        <form method="POST" action="{{ url('/lupa-password') }}">
          @csrf
          <h1>Lupa Password</h1>
          <p class="sub">Masukkan username atau email yang terdaftar. Kami akan mengirim petunjuk untuk mengatur ulang password kamu.</p>

          @if ($errors->has('akun'))<div class="err">{{ $errors->first('akun') }}</div>@endif

          <label class="t" for="akun">Username atau Email</label>
          <div class="in">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-3a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v3z"/></svg>
            <input id="akun" name="akun" value="{{ old('akun') }}" placeholder="Masukan username atau email" autocomplete="username" required>
          </div>

          <button class="go" type="submit">Kirim Petunjuk Reset</button>
        </form>

        <a class="back" href="#login" data-view="login">
          <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Kembali ke Login
        </a>
      </div>

      {{-- 3. SETELAH PERMINTAAN TERKIRIM --}}
      <div id="v-sukses" class="ok" {{ $sukses ? '' : 'hidden' }}>
        <div class="badge"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
        <h1>Permintaan Terkirim</h1>
        <p>{{ $sukses }}</p>
        <p style="font-size:13px;color:#6b5b50">Belum menerima? Periksa folder spam atau coba lagi beberapa menit lagi.</p>
        <a class="go" href="#login" data-view="login">Kembali ke Login</a>
      </div>
    </div>
  </div>

  <script>
    var teks = {
      login:  ['Selamat datang di BeanByte', 'Nikmati kopi favoritmu, dan kelola pesanan dengan mudah'],
      lupa:   ['Lupa password?', 'Tenang, kami bantu kamu masuk kembali ke akun BeanByte.'],
      sukses: ['Cek kotak masukmu', 'Ikuti petunjuk yang kami kirim untuk mengatur ulang password.']
    };
    var judul = { login: 'Login', lupa: 'Lupa Password', sukses: 'Permintaan Terkirim' };

    function tampil(v) {
      if (!teks[v]) v = 'login';
      ['login', 'lupa', 'sukses'].forEach(function (k) {
        document.getElementById('v-' + k).hidden = (k !== v);
      });
      document.getElementById('kiriJudul').textContent = teks[v][0];
      document.getElementById('kiriTeks').textContent = teks[v][1];
      document.title = judul[v] + ' - BeanByte';
    }

    document.addEventListener('click', function (e) {
      var a = e.target.closest('[data-view]');
      if (a) { e.preventDefault(); history.replaceState(null, '', '#' + a.dataset.view); tampil(a.dataset.view); }
    });

    @if ($sukses)
      tampil('sukses');
    @else
      tampil(location.hash.slice(1) === 'lupa' || {{ $errors->has('akun') ? 'true' : 'false' }} ? 'lupa' : 'login');
    @endif

    var eyeOff = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    var eyeOn  = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    document.getElementById('toggle').addEventListener('click', function () {
      var p = document.getElementById('password');
      var show = p.type === 'password';
      p.type = show ? 'text' : 'password';
      this.querySelector('svg').innerHTML = show ? eyeOn : eyeOff;
    });
  </script>
</body>
</html>