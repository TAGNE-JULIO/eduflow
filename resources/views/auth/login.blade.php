@extends('layouts.guest')

@section('title', 'Login')

@section('body')
    <x-partials.authentication-card>
        <div class="w-full text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Welcome Back</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Please sign in to your account</p>
        </div>
        <form action="{{ route('login') }}" method="POST" class="w-full pb-6 border-b border-slate-200 dark:border-slate-700">
            <div class="space-y-4">
                <x-input name="email" id="email" type="email" label="Email Address" />
                <x-input name="password" id="password" type="password" label="Password" />
                
                <div class="flex items-center justify-between pt-2">
                    <label for="remember" class="flex items-center text-sm cursor-pointer">
                        <input type="checkbox" id="remember" name="remember" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-slate-600 dark:text-slate-300">Remember me</span>
                    </label>
                </div>
            </div>
            
            @csrf
            <div class="mt-6">
                <button type="submit" class="w-full btn-primary py-2.5 text-sm">
                    Sign in
                </button>
            </div>
        </form>
        <div class="pt-6 w-full text-center text-sm">
            <p class="text-slate-600 dark:text-slate-400">Don't have an account? <a href="{{route('register')}}" class="text-indigo-600 hover:text-indigo-500 font-semibold transition-colors" aria-label="Register">Create Account</a></p>
        </div>
        <x-slot:footer>
            <a href="{{route('password.request')}}" class="text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" aria-label="Forgot Password">Forgot your Password?</a>

        </x-slot:footer>
    </x-partials.authentication-card>
@endsection