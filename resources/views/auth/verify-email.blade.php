@extends('layouts.app')

@section('body')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full bg-white p-6 rounded-lg shadow">

            <h2 class="text-xl font-semibold text-center mb-4">
                Confirme seu e-mail
            </h2>

            <x-alert />

            <p class="text-sm text-gray-600 mb-4">
                Seu cadastro foi realizado com sucesso, mas seu e-mail ainda não foi confirmado.
                <br>
                Verifique sua caixa de entrada e clique no link de confirmação.
            </p>

            @if (session('status') === 'verification-link-sent')
                <div class="alert-success mb-4">
                    Um novo link de verificação foi enviado para seu e-mail.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full">
                    Reenviar e-mail de confirmação
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="btn-danger">
                    Sair
                </button>
            </form>

        </div>
    </div>
@endsection
