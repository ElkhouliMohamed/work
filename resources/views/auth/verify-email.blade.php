@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 flex justify-center items-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <div class="flex justify-center mb-6">
            <!-- Replace with your logo -->
            <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Vérification de l'email requise</h1>
        
        <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        {{ __('Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer.') }}
                    </p>
                    <p class="mt-2 text-sm text-blue-700">
                        {{ __("Si vous ne voyez pas l'e-mail, vérifiez également votre dossier de spam ou de courriers indésirables.") }}
                    </p>
                </div>
            </div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </span>
                    {{ __('Renvoyer l\'email de vérification') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-center text-sm font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline">
                    {{ __('Se déconnecter') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection