@extends('layout')
@section('title', 'Đăng tin mới')
@section('content')
<div class="card">
  <h2>Đăng tin bất động sản</h2>
  <form method="POST" action="{{ route('properties.store') }}">
    @csrf
    <label>Tiêu đề</label><input type="text" name="title" value="{{ old('title') }}" required>
    <div class="row">
      <div><label>Hình thức</label>
        <select name="type" required>
          <option value="ban" @selected(old('type') === 'ban')>Bán</option>
          <option value="thue" @selected(old('type') === 'thue')>Cho thuê</option>
        </select></div>
      <div><label>Loại BĐS</label>
        <select name="category" required>
          <option value="nha" @selected(old('category') === 'nha')>Nhà</option>
          <option value="dat" @selected(old('category') === 'dat')>Đất</option>
          <option value="can-ho" @selected(old('category') === 'can-ho')>Căn hộ</option>
        </select></div>
    </div>
    <div class="row">
      <div><label>Giá (triệu đồng)</label><input type="number" step="any" min="0" name="price_million" value="{{ old('price_million') }}" required></div>
      <div><label>Diện tích (m²)</label><input type="number" step="any" min="1" name="area" value="{{ old('area') }}" required></div>
    </div>
    <div class="row">
      <div><label>Số phòng ngủ</label><input type="number" min="0" name="bedrooms" value="{{ old('bedrooms') }}"></div>
      <div><label>Địa chỉ (không bắt buộc)</label><input type="text" name="address" value="{{ old('address') }}"></div>
    </div>
    <div class="row">
      <div><label>Tỉnh / Thành phố</label><input type="text" name="city" value="{{ old('city') }}" required></div>
      <div><label>Quận / Huyện</label><input type="text" name="district" value="{{ old('district') }}" required></div>
    </div>
    <label>Mô tả</label><textarea name="description" required>{{ old('description') }}</textarea>
    <div class="row">
      <div><label>Tên người liên hệ</label><input type="text" name="contact_name" value="{{ old('contact_name') }}" required></div>
      <div><label>Số điện thoại</label><input type="text" name="contact_phone" value="{{ old('contact_phone') }}" required></div>
    </div>
    <p><button class="btn" type="submit">Đăng tin</button></p>
  </form>
</div>
@endsection
