@extends('layouts.app')

@section('content')
<div class="purchase-page">
    <div class="purchase-item">
        <div class="purchase-item__image-wrap">
            @if (str_starts_with($item->image, 'http'))
                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="purchase-item__image">
            @else
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="purchase-item__image">
            @endif
        </div>
        <div class="purchase-item__info">
            <p class="purchase-item__name">{{ $item->name }}</p>
            <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
        </div>
    </div>

    <form action="{{ route('purchase.store', $item) }}" method="POST" class="purchase-form">
        @csrf

        {{-- 支払い方法 --}}
        <div class="purchase-section">
            <h2 class="purchase-section__title">支払い方法</h2>
            <select name="payment_method" id="payment_method"
                    class="form-select @error('payment_method') form-input--error @enderror"
                    onchange="updatePaymentDisplay(this.value)">
                <option value="">選択してください</option>
                <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>
                    コンビニ支払い
                </option>
                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>
                    カード支払い
                </option>
            </select>
            @error('payment_method')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- 配送先 --}}
        <div class="purchase-section">
            <div class="purchase-section__header">
                <h2 class="purchase-section__title">配送先</h2>
                <a href="{{ route('address.edit', $item) }}" class="purchase-section__edit-link">変更する</a>
            </div>
            <div class="address-display">
                <p>〒{{ $address['postal_code'] ?? '' }}</p>
                <p>{{ $address['address'] ?? '' }}</p>
                @if (!empty($address['building']))
                    <p>{{ $address['building'] }}</p>
                @endif
            </div>
        </div>

        {{-- 小計 --}}
        <div class="purchase-summary">
            <table class="purchase-summary__table">
                <tr>
                    <th>商品代金</th>
                    <td>¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td id="payment-method-display">-</td>
                </tr>
            </table>
        </div>

        <button type="submit" class="btn btn--primary btn--full">購入する</button>
    </form>
</div>

<script>
const paymentLabels = {
    convenience: 'コンビニ支払い',
    card: 'カード支払い',
};

function updatePaymentDisplay(value) {
    document.getElementById('payment-method-display').textContent = paymentLabels[value] || '-';
}

// 初期表示
const sel = document.getElementById('payment_method');
if (sel.value) updatePaymentDisplay(sel.value);
</script>
@endsection
