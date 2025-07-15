@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Informations sur les coupons</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Tableau de bord</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.coupons') }}">
                            <div class="text-tiny">Coupons</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Nouveau Coupon</div>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.store') }}">
                    @csrf
                    <!-- code -->
                    <fieldset class="name">
                        <div class="body-title">Code du coupon <span class="tf-color-1">*</span></div>
                        <input
                            class="flex-grow"
                            type="text"
                            placeholder="Coupon Code"
                            name="code"
                            tabindex="0"
                            value="{{ old('code') }}"
                            aria-required="false"
                        />
                    </fieldset>
                    @error('code') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <!-- Type de coupon -->
                    <fieldset class="category">
                        <div class="body-title">Type de coupon</div>
                        <div class="select flex-grow">
                            <select class="" name="type">
                                <option value="">Select</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percent</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('type') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <!-- valeur -->
                    <fieldset class="name">
                        <div class="body-title">Valeur <span class="tf-color-1">*</span></div>
                        <input
                            class="flex-grow"
                            type="text"
                            placeholder="Coupon Value"
                            name="value"
                            tabindex="0"
                            value="{{ old('value') }}"
                            aria-required="false"
                        />
                    </fieldset>
                    @error('value') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <!-- Valeur du panier -->
                    <fieldset class="name">
                        <div class="body-title">Valeur du panier <span class="tf-color-1">*</span></div>
                        <input
                            class="flex-grow"
                            type="text"
                            placeholder="Cart Value"
                            name="cart_value"
                            tabindex="0"
                            value="{{ old('cart_value') }}"
                            aria-required="false"
                        />
                    </fieldset>
                    @error('cart_value') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <!-- Date d'expiration -->
                    <fieldset class="name">
                        <div class="body-title"> Date d'expiration <span class="tf-color-1">*</span></div>
                        <input
                            class="flex-grow"
                            type="date"
                            placeholder="Expiry Date"
                            name="expiry_date"
                            tabindex="0"
                            value="{{ old('expiry_date') }}"
                            aria-required="false"
                        />
                    </fieldset>
                    @error('expiry_date') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <div class="bot">
                        <div></div>
                        <button type="submit" class="tf-button w208" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
