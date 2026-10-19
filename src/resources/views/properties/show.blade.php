@extends('layout')
@section('title', $property->title)
@section('content')
<div class="card">
  <span class="tag">{{ $property->type_label }}</span><span class="tag">{{ $property->category_label }}</span>
  <h2>{{ $property->title }}</h2>
  <div class="price">{{ $property->price_text }}</div>
  <p class="meta">{{ $property->area + 0 }} m² @if ($property->bedrooms) · {{ $property->bedrooms }} phòng ngủ @endif</p>
  <p class="meta">📍 {{ $property->address ? $property->address . ', ' : '' }}{{ $property->district }}, {{ $property->city }}</p>
  <hr>
  <p>{!! nl2br(e($property->description)) !!}</p>
  <p><b>Người đăng:</b> {{ $property->contact_name }} · 📞 {{ $property->contact_phone }}</p>
</div>

<div class="card">
  <h3>Liên hệ người đăng tin</h3>
  <form method="POST" action="{{ route('contacts.store', $property) }}">
    @csrf
    <div class="row">
      <div><label>Họ tên</label><input type="text" name="name" value="{{ old('name') }}" required></div>
      <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
    </div>
    <label>Số điện thoại</label><input type="text" name="phone" value="{{ old('phone') }}">
    <label>Nội dung</label><textarea name="message" required>{{ old('message') }}</textarea>
    <p><button class="btn" type="submit">Gửi liên hệ</button></p>
  </form>
</div>
<p><a href="{{ route('properties.index') }}">← Quay lại danh sách</a></p>
@endsection
