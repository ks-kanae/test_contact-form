@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('nav')
@if (Auth::check())
<form class="header-nav__link" action="/logout" method="post">
@csrf
    <button class="header-nav__button">logout</button>
</form>
@endif
@endsection

@section('content')
<div class="admin__content">
    <div class="admin__heading">
        <p>Admin</p>
    </div>
    <div class="admin__condition">
        <div class="condition__content">
            <form class="form" action="/search" method="get">
                <div class="form__input keyword">
                    <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="" />
                </div>
                <!--バリデーション**********-->
                <div class="form__input gender">
                    <select class="select__gender" name="gender">
                        <option value="" disabled selected>性別</option> <option value="1">男性</option> <option value="2">女性</option> <option value="3">その他</option>
                    </select>
                </div>
                <div class="form__input category">
                    <select class="select__category" name="category_id">
                        <option value="" disabled selected>お問い合わせの種類</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['content'] }}</option>
                        @endforeach
                    </select>
                </div>
                <!------バリデーション-------->
                <div class="form__input date">
                    <input type="date" name="date"/>
                    <!-------バリデーション------->
                </div>
                <div class="form__button search">
                    <button class="button-search" type="submit">検索
                    </button>
                </div>
                <div class="form__button reset">
                <a class="button-reset" href="/reset">リセット
                </a>
            </div>
            </form>
        </div>
    </div>
    <div class="admin__action">
        <div class="actinon__button export">
            <form action="/export" method="GET">
                <button class="button-export" type="submit">エクスポート
                </button>
            </form>
        </div>
        <div class="action__pagination">
        {{ $contacts->links() }}
        </div>
    </div>
    <div class="table">
        <table class="admin-table">
            <tr class="admin-table__row">
                <th class="admin-table__header">
                    <span class="table__row">お名前
                    </span>
                </th>
                <th class="admin-table__header">
                    <span class="table__row">性別
                    </span>
                </th>
                <th class="admin-table__header">
                    <span class="table__row">メールアドレス
                    </span>
                </th>
                <th class="admin-table__header">
                    <span class="table__row">お問い合わせの種類
                    </span>
                </th>
                <th class="admin-table__header">
                    <span class="table__row"><!--詳細ボタン-->
                    </span>
                </th>
            </tr>
            @foreach($contacts as $contact)
            <tr class="admin-table__row">
                <td class="admin-table__item">
                    <span class="table__item">
                        <p class="table__item--name">{{ $contact->first_name }}　{{ $contact->last_name }}
                        </p>
                    </span>
                </td>
                <td class="admin-table__item">
                    <span class="table__item">
                        <p class="table__item--gender">{{ [1=>'男性',2=>'女性',3=>'その他'][$contact->gender] }}
                        </p>
                    </span>
                </td>
                <td class="admin-table__item">
                    <span class="table__item">
                        <p class="table__item--email">{{ $contact->email }}
                        </p>
                    </span>
                </td>
                <td class="admin-table__item">
                    <span class="table__item">
                        <p class="table__item--contact-type">{{ $contact->category->content }}
                        </p>
                    </span>
                </td>
                <td class="admin-table__item">
                    <div class="table__button">
                        <label class="button-details" for="modal-toggle-{{ $contact->id }}">詳細</label>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        @foreach($contacts as $contact)
        <input class="modal-toggle" id="modal-toggle-{{ $contact->id }}" type="checkbox" hidden>
        <div class="modal">
            <label class="modal-overlay" for="modal-toggle-{{ $contact->id }}"></label>
            <div class="modal-content">
                <div class="close-button">
                    <label class="modal-close" for="modal-toggle-{{ $contact->id }}">×</label>
                </div>
                <div class="modal-group__box">
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">お名前</span>
                        </div>
                        <div class="group-content">
                            <span class="group-content__item">{{ $contact->first_name }}　{{ $contact->last_name }}</span>
                        </div>
                    </div>
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">性別</span>
                        </div>
                        <div class="group-content">
                            <span class="group-content__item">{{ [1=>'男性',2=>'女性',3=>'その他'][$contact->gender] }}</span>
                        </div>
                    </div>
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">メールアドレス</span>
                        </div>
                        <div class="group-content">
                            <span class="group-content__item">{{ $contact->email }}</span>
                        </div>
                    </div>
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">電話番号</span>
                        </div>
                        <div class="group-content">
                            <span class="group-content__item">{{ $contact->tel }}</span>
                        </div>
                    </div>
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">住所</span>
                        </div>
                        <div class="group-content">
                            <span class="group-content__item">{{ $contact->address }}</span>
                        </div>
                    </div>
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">建物名</span>
                        </div>
                        <div class="group-content">
                            <span class="group-content__item">{{ $contact->building }}</span>
                        </div>
                    </div>
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">お問い合わせの種類</span>
                        </div>
                        <div class="group-content">
                            <span class="group-content__item">{{ $contact->category->content }}</span>
                        </div>
                    </div>
                    <div class="modal-group">
                        <div class="group-title">
                            <span class="group-title__item">お問い合わせ内容</span>
                        </div>
                        <div class="group-content message">
                            <span class="group-content__item">
                                {{ $contact->detail }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-button">
                    <form action="/delete" method="post">
                    @csrf
                    @method('DELETE')
                        <input type="hidden" name="id" value="{{ $contact->id }}">
                        <button class="delete" type="submit">削除</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
