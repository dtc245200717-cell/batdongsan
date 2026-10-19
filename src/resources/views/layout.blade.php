<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Bất động sản')</title>
<style>
*{box-sizing:border-box}
body{margin:0;font-family:Arial,sans-serif;background:#f4f6f8;color:#222}
a{color:#0b5ed7;text-decoration:none}
.wrap{max-width:1100px;margin:0 auto;padding:0 16px}
header{background:#0b3d91;color:#fff;padding:14px 0}
header .wrap{display:flex;justify-content:space-between;align-items:center}
header a{color:#fff;font-weight:bold}
footer{text-align:center;color:#777;padding:24px 0;font-size:14px}
.btn{display:inline-block;background:#e8590c;color:#fff;border:0;padding:9px 16px;border-radius:6px;cursor:pointer;font-size:15px}
.card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,.1);padding:16px;margin:16px 0}
.filter{display:flex;flex-wrap:wrap;gap:8px}
.filter input,.filter select{padding:8px;border:1px solid #ccd;border-radius:6px;flex:1 1 150px}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(310px,1fr));gap:16px}
.item h3{margin:0 0 8px;font-size:17px}
.price{color:#d6336c;font-weight:bold;font-size:18px}
.meta{color:#555;font-size:14px;margin:4px 0}
.tag{display:inline-block;background:#e7f1ff;color:#0b3d91;padding:2px 8px;border-radius:10px;font-size:12px;margin-right:4px}
label{display:block;margin:10px 0 4px;font-weight:bold;font-size:14px}
input[type=text],input[type=email],input[type=number],select,textarea{width:100%;padding:9px;border:1px solid #ccd;border-radius:6px;font-size:15px}
textarea{min-height:110px}
.row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.ok{background:#d3f9d8;border:1px solid #8ce99a;padding:10px;border-radius:6px;margin:12px 0}
.err{background:#ffe3e3;border:1px solid #ffa8a8;padding:10px;border-radius:6px;margin:12px 0}
.pagination{display:flex;gap:6px;list-style:none;padding:0;justify-content:center;flex-wrap:wrap}
.pagination li a,.pagination li span{display:block;padding:6px 12px;border:1px solid #ccd;border-radius:4px;background:#fff}
.pagination .active span{background:#0b3d91;color:#fff}
.pagination .disabled span{color:#aaa}
@media(max-width:600px){.row{grid-template-columns:1fr}}
</style>
</head>
<body>
<header>
  <div class="wrap">
    <a href="{{ route('properties.index') }}">🏠 Bất Động Sản</a>
    <a class="btn" href="{{ route('properties.create') }}">+ Đăng tin</a>
  </div>
</header>
<main class="wrap">
  @if (session('ok'))<div class="ok">{{ session('ok') }}</div>@endif
  @if ($errors->any())
    <div class="err"><ul style="margin:0;padding-left:18px">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif
  @yield('content')
</main>
<footer>Đề 25 - Website đăng tin bất động sản</footer>
</body>
</html>
