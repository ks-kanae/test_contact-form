@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
@php
    $oldGender = old('gender', session('contact_input.gender'));
    $oldCategory = old('category_id', session('contact_input.category_id'));
@endphp
<div class="contact-form__content">
    <div class="contact-form__heading">
        <p>Contact</p>
    </div>
    <form class="form" action="/confirm" method="POST">
    @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
                <div class="form__error">
                    <ul>
                        @error('first_name')
                        <li>{{ $message }}</li>
                        @enderror
                        @error('last_name')
                        <li>{{ $message }}</li>
                        @enderror
                    </ul>
                </div>
            </div>
            <div class="form__group-content">
                <div class="form__input--name">
                    <input type="text" name="first_name" placeholder="例: 山田" value="{{ old('first_name', session('contact_input.first_name') ?? '') }}" />
                    <span class="form__label--name-space"></span>
                    <input type="text" name="last_name" placeholder="例: 太郎" value="{{ old('last_name', session('contact_input.last_name') ?? '') }}" />
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
                <div class="form__error">
                    <ul>
                        @error('gender')
                        <li>{{ $message }}</li>
                        @enderror
                    </ul>
                </div>
            </div>
            <div class="form__group-content">
                <div class="form__input--gender">
                    <label>
                        <input type="radio" name="gender" value="1" @php if($oldGender == 1) echo 'checked'; @endphp>
                        <span class="radio__dot"></span>
                        男性
                    </label>
                    <span class="form__label--gender-space"></span>
                    <label>
                        <input type="radio" name="gender" value="2" @php if($oldGender == 2) echo 'checked'; @endphp>
                        <span class="radio__dot"></span>
                        女性
                    </label>
                    <span class="form__label--gender-space"></span>
                    <label>
                        <input type="radio" name="gender" value="3" @php if($oldGender == 3) echo 'checked'; @endphp>
                        <span class="radio__dot"></span>
                        その他
                    </label>
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
                <div class="form__error">
                    <ul>
                        @error('email')
                        <li>{{ $message }}</li>
                        @enderror
                    </ul>
                </div>
            </div>
            <div class="form__group-content">
                <div class="form__input email">
                    <input type="email" name="email" placeholder="例: test@example.com" value="{{ old('email', session('contact_input.email') ?? '') }}" />
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
                <div class="form__error">
                    <ul>
                        @php
                        $telErrors = array_merge($errors->get('tel1'), $errors->get('tel2'), $errors->get('tel3'));
                        $telErrors = array_unique($telErrors); // 重複を取り除く
                        @endphp
                        @foreach($telErrors as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="form__group-content">
                <div class="form__input--tel">
                    <input type="tel" name="tel1" placeholder="080" value="{{ old('tel1', substr(session('contact_input.tel') ?? '', 0, 3)) }}" />
                    <span class="form__label--hyphen">-</span>
                    <input type="tel" name="tel2" placeholder="1234" value="{{ old('tel2', substr(session('contact_input.tel') ?? '', 3, 4)) }}"/>
                    <span class="form__label--hyphen">-</span>
                    <input type="tel" name="tel3" placeholder="5678" value="{{ old('tel3', substr(session('contact_input.tel') ?? '', 7, 4)) }}" />
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
                <div class="form__error">
                    <ul>
                        @error('address')
                        <li>{{ $message }}</li>
                        @enderror
                    </ul>
                </div>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address', session('contact_input.address') ?? '') }}" />
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building', session('contact_input.building') ?? '') }}" />
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
                <div class="form__error">
                    <ul>
                        @error('category_id')
                        <li>{{ $message }}</li>
                        @enderror
                    </ul>
                </div>
            </div>
            <div class="form__group-content">
                <div class="form__input--item">
                    <select class="form__input-select" name="category_id">
                        <option value="" disabled selected>選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}" @php if($oldCategory == $category->id) echo 'selected'; @endphp >{{ $category['content'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
                <div class="form__error">
                    <ul>
                        @error('detail')
                        <li>{{ $message }}</li>
                        @enderror
                    </ul>
                </div>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail', session('contact_input.detail') ?? '') }}</textarea>
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection
