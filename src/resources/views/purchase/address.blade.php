@extends('layouts.app')

@section('content')
<div class="address-page">
    <h1 class="page-title">住所の変更</h1>

    <form action="{{ route('address.update', $item) }}" method="POST" class="address-form">
        @csrf

        <div class="form-group">
            <label class="form-label" for="postal_code">郵便番号</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="{{ old('postal_code', $address['postal_code'] ?? '') }}"
                placeholder="123-4567"
                class="form-input @error('postal_code') form-input--error @enderror"
            >
            @error('postal_code')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="address">住所</label>
            <input
                type="text"
                id="address"
                name="address"
                value="{{ old('address', $address['address'] ?? '') }}"
                class="form-input @error('address') form-input--error @enderror"
            >
            @error('address')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="building">建物名</label>
            <input
                type="text"
                id="building"
                name="building"
                value="{{ old('building', $address['building'] ?? '') }}"
                class="form-input"
            >
        </div>

        <button type="submit" class="btn btn--primary btn--full">更新する</button>
    </form>
</div>
@endsection
