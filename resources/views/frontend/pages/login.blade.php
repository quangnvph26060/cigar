@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">

        <div id="content" class="default normal">

            @php
                $data = [];
                $data['einloggen'] = null;
            @endphp

            @include('frontend.pages.include.breadcrumb', [
                'data' => $data,
            ])


            <div class="checkout-login">

                <div class="ws-g checkout-login__wrapper">
                    <div class="ws-u-1 ws-u-lg-17-24 ws-u-xl-15-24">

                        <div class="ws-g ws-c checkout-login__wrapper-inner">

                            <div class="ws-u-1 ws-u-md-12-24 ws-u-lg-12-24 checkout-login__col">
                                <div class="checkout-login__signin">

                                    <span class="checkout-login__title">Ich bin bereits Kunde</span>
                                    <form action="" method="post" class="ws-form ws-form-stacked">
                                        @csrf

                                        <label for="registeredemail" class="checkout-login__label">E-Mail-Adresse:</label>
                                        <input type="email" name="email" id="registeredemail" value=""
                                            class="checkout-login__input">
                                        @error('email')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                        <br>
                                        <label for="registeredpassword" class="checkout-login__label">Passwort:</label>
                                        <input type="password" name="password" id="registeredpassword" value=""
                                            class="checkout-login__input">
                                        @error('password')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror

                                        <a href="/meinkonto/neuespasswort" class="checkout-login__hint">Haben Sie Ihr
                                            Passwort vergessen?</a>
                                        <br>

                                        <button type="submit"
                                            class="ws-button ws-button-primary checkout-login__button">Anmelden</button>
                                    </form>

                                </div>
                            </div>

                            <div class="ws-u-1 ws-u-md-12-24 ws-u-lg-12-24 checkout-login__col">
                                <div class="checkout-login__guest">

                                    <span class="checkout-login__title">IIch habe es gewusst Rauchr</span>
                                    <p>Melden Sie sich jetzt hier bei Rauchr an und geben Sie Ihre Bestellung auf</p>

                                    {{-- <form action="/bestellung/index" method="post">

                                        <button type="submit" class="ws-button checkout-login__button">Konto
                                            anlegen</button>
                                    </form> --}}

                                    <a href="{{ route('register') }}" class="ws-button checkout-login__button">Konto
                                        anlegen</a>


                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
