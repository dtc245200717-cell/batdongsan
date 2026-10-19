@extends('layout')
@section('title', 'Trang chủ - Bất động sản')
@section('content')
<form method="GET" action="{{ route('properties.index') }}" class="card filter">
  <input type="text" name="q" value="{{ request('q') }}" placeholder="Từ khóa (tên, quận, thành phố)">
  <select name="type">
    <option value="">Bán / Cho thuê</option>
    <option value="ban" @selected(request('type') === 'ban')>Bán</option>
    <option value="thue" @selected(request('type') === 'thue')>Cho thuê</option>
  </select>
  <select name="category">
    <option value="">Loại BĐS</option>
    <option value="nha" @selected(request('category') === 'nha')>Nhà</option>
    <option value="dat" @selected(request('category') === 'dat')>Đất</option>
    <option value="can-ho" @selected(request('category') === 'can-ho')>Căn hộ</option>
  </select>
  <select name="city">
    <option value="">Tỉnh / Thành phố</option>
    @foreach ($cities as $c)
      <option value="{{ $c }}" @selected(request('city') === $c)>{{ $c }}</option>
    @endforeach
  </select>
  <input type="number" step="any" min="0" name="min_price" value="{{ request('min_price') }}" placeholder="Giá từ (triệu)">
  <input type="number" step="any" min="0" name="max_price" value="{{ request('max_price') }}" placeholder="Giá đến (triệu)">
  <button class="btn" type="submit">Tìm kiếm</button>
</form>

<p>Tìm thấy <b>{{ $properties->total() }}</b> tin</p>

<div class="grid">
  @forelse ($properties as $p)
    <div class="card item">
      <span class="tag">{{ $p->type_label }}</span><span class="tag">{{ $p->category_label }}</span>
      <h3><a href="{{ route('properties.show', $p) }}">{{ $p->title }}</a></h3>
      <div class="price">{{ $p->price_text }}</div>
      <div class="meta">{{ $p->area + 0 }} m² @if ($p->bedrooms) · {{ $p->bedrooms }} phòng ngủ @endif</div>
      <div class="meta">📍 {{ $p->district }}, {{ $p->city }}</div>
    </div>
  @empty
    <p>Không có tin nào phù hợp.</p>
  @endforelse
</div>

{{ $properties->links('partials.pagination') }}
@endsection
