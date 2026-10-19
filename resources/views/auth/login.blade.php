@extends('layouts.app')

@section('title', 'Giriş Yap - kle')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Giriş Yap</h1>
            <p>Hesabınıza erişmek için bilgilerinizi girin</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">E-posta Adresi</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="ad@ornek.com"
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Şifre</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="••••••••"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1rem;">
                Giriş Yap
            </button>
        </form>

        <div class="auth-footer">
            Hesabınız yok mu? <a href="/register">Kayıt Ol</a>
        </div>
    </div>
</div>
@endsection
