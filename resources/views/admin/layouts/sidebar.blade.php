@php
    $navItems = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'home', 'active' => request()->routeIs('admin.dashboard')],
        ['label' => 'Posts', 'route' => 'admin.posts.index', 'icon' => 'document-text', 'active' => request()->routeIs('admin.posts.*')],
        ['label' => 'Pages', 'route' => 'admin.pages.index', 'icon' => 'document', 'active' => request()->routeIs('admin.pages.*')],
        ['label' => 'Categories', 'route' => 'admin.categories.index', 'icon' => 'tag', 'active' => request()->routeIs('admin.categories.*')],
        ['label' => 'Media', 'route' => 'admin.media.index', 'icon' => 'photo', 'active' => request()->routeIs('admin.media.*')],
    ];
@endphp

<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-slate-800 px-6 pb-4">
        {{-- Logo --}}
        <div class="flex h-16 shrink-0 items-center border-b border-slate-700">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-white">LaraWP</span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        @foreach ($navItems as $item)
                            <li>
                                <a href="{{ route($item['route']) }}"
                                   class="{{ $item['active']
                                        ? 'bg-slate-700 text-white'
                                        : 'text-slate-300 hover:text-white hover:bg-slate-700'
                                    }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-medium transition-colors">
                                    @include('admin.layouts.icons.' . $item['icon'])
                                    {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Bottom section --}}
                <li class="mt-auto">
                    <div class="border-t border-slate-700 pt-4">
                        <div class="flex items-center gap-x-4 px-2 py-2">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-600 text-white text-sm font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST" class="mt-1">
                            @csrf
                            <button type="submit"
                                class="group -mx-2 flex w-full gap-x-3 rounded-md p-2 text-sm font-medium leading-6 text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
