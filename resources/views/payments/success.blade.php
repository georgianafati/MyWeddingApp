@extends('layout.simple')

@section('content')
    <section class="py-12 bg-gray-50 sm:py-16 lg:py-20">
        <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="max-w-md mx-auto text-center">
                <svg class="w-12 h-12 mx-auto text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-6 text-xl font-bold text-gray-900">
                    Plata efectuata cu succes!
                </p>
                <p class="mt-2 text-base font-medium text-gray-500">
                    Va multumim pentru plata efectuata cu succes.
                </p>
            </div>
        </div>
    </section>
@endsection
