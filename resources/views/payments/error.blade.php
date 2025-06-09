@extends('layout.simple')

@section('content')
    <section class="py-12 bg-gray-50 sm:py-16 lg:py-20">
        <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="max-w-md mx-auto text-center">
                <svg class="w-12 h-12 mx-auto text-gray-900" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17q.425 0 .713-.288T13 16t-.288-.712T12 15t-.712.288T11 16t.288.713T12 17m0-4q.425 0 .713-.288T13 12V8q0-.425-.288-.712T12 7t-.712.288T11 8v4q0 .425.288.713T12 13m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>

                <p class="mt-6 text-xl font-bold text-gray-900">
                    Ceva nu a mers bine!
                </p>
                <p class="mt-2 text-base font-medium text-gray-500">
                    Plata nu a putut fi efectuata. Va rugam sa contactati echipa noastra pentru mai multe informatii.
                </p>

                <p>
{{--                    if session has error--}}
                    @if(session()->has('errors'))
                        {{ session('errors') }}
                    @endif
                </p>
            </div>
        </div>
    </section>
@endsection
