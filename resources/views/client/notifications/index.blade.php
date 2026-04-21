@extends('layouts.app')

@section('title', 'Thông báo - Tour Manager')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Thông báo của bạn</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($notifications->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Bạn chưa có thông báo nào.
            </div>
        @else
            <ul class="divide-y divide-gray-100">
                @foreach($notifications as $notify)
                    <li class="{{ $notify->is_read ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 transition">
                        <form action="{{ route('notifications.read', $notify->id) }}" method="POST" class="block w-full text-left">
                            @csrf
                            <button type="submit" class="w-full text-left p-5 flex items-start gap-4">
                                <span class="text-2xl bg-white p-2 rounded-full shadow-sm">{{ $notify->icon() }}</span>
                                <div class="flex-1">
                                    <h3 class="font-bold {{ $notify->is_read ? 'text-gray-700' : 'text-gray-900' }}">{{ $notify->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $notify->message }}</p>
                                    <span class="text-xs text-gray-400 mt-2 block">{{ $notify->created_at->diffForHumans() }}</span>
                                </div>
                                @if(!$notify->is_read)
                                    <span class="w-2.5 h-2.5 bg-blue-600 rounded-full mt-2"></span>
                                @endif
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
