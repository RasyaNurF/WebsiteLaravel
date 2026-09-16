@extends('layouts.site')

@section('title', 'Dashboard — Nusakode')
@section('meta-description', 'Ringkasan akun Nusakode Anda.')

@section('content')
<section class="py-16 sm:py-20">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-700">Dashboard</p>
        <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-balance text-navy-950">Halo, {{ auth()->user()->name }}</h1>
        <p class="mt-3 text-[15px] text-neutral-500">Berikut ringkasan akun Anda.</p>

        <dl class="mt-8 divide-y divide-neutral-200 border-y border-neutral-200 text-[15px]">
            <div class="grid grid-cols-[140px_1fr] gap-4 py-5">
                <dt class="font-bold text-navy-950">Nama</dt>
                <dd>{{ auth()->user()->name }}</dd>
            </div>
            <div class="grid grid-cols-[140px_1fr] gap-4 py-5">
                <dt class="font-bold text-navy-950">Email</dt>
                <dd>{{ auth()->user()->email }}</dd>
            </div>
            <div class="grid grid-cols-[140px_1fr] gap-4 py-5">
                <dt class="font-bold text-navy-950">Terdaftar sejak</dt>
                <dd>{{ auth()->user()->created_at->translatedFormat('d F Y') }}</dd>
            </div>
        </dl>

        <form method="post" action="{{ route('logout') }}" class="mt-8">
            @csrf
            <button type="submit" class="border border-navy-800 px-7 py-3 text-sm font-bold text-navy-800 transition hover:bg-navy-800 hover:text-white">
                Keluar
            </button>
        </form>
    </div>
</section>
@endsection
