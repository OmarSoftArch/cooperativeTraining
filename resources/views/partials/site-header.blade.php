<header class="site-header">
    <div class="page-shell header-inner">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ __('site.home_label') }}">
            <img class="brand-logo" src="{{ asset('images/rshc-logo.png') }}" alt="{{ __('site.organization') }}" width="1658" height="470">
            <span class="brand-divider" aria-hidden="true"></span>
            <span class="brand-copy"><strong>{{ __('site.name') }}</strong><small>{{ __('site.tagline') }}</small></span>
        </a>
        <nav class="desktop-nav" aria-label="{{ __('site.main_navigation') }}">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a @class(['is-active' => request()->routeIs('health-centers.*')]) href="{{ route('health-centers.index') }}">{{ __('health-centers.title') }}</a>
                    <a @class(['is-active' => request()->routeIs('admin.training-applications.*')]) href="{{ route('admin.training-applications.index') }}">{{ __('Training applications') }}</a>
                @else
                    <a @class(['is-active' => request()->routeIs('home')]) href="{{ route('home') }}#home">{{ __('site.home') }}</a>
                    <a href="{{ route('home') }}#about">{{ __('site.about_training') }}</a>
                    <a href="{{ route('home') }}#opportunities">{{ __('site.training_opportunities') }}</a>
                    <a href="{{ route('home') }}#journey">{{ __('site.trainee_journey') }}</a>
                    <a @class(['is-active' => request()->routeIs('health-centers.*')]) href="{{ route('health-centers.index') }}">{{ __('health-centers.title') }}</a>
                    <a href="{{ route('home') }}#faq">{{ __('site.faq') }}</a>
                    <a @class(['is-active' => request()->routeIs('training.application*')]) href="{{ route('training.application') }}">{{ __('Training application') }}</a>
                @endif
            @else
                <a @class(['is-active' => request()->routeIs('home')]) href="{{ route('home') }}#home">{{ __('site.home') }}</a>
                <a href="{{ route('home') }}#about">{{ __('site.about_training') }}</a>
                <a href="{{ route('home') }}#opportunities">{{ __('site.training_opportunities') }}</a>
                <a href="{{ route('home') }}#journey">{{ __('site.trainee_journey') }}</a>
                <a href="{{ route('home') }}#faq">{{ __('site.faq') }}</a>
            @endauth
        </nav>
        <div class="header-actions">
            @auth
                <details class="site-user-menu">
                    <summary><flux:icon.user-circle class="size-5" /><span>{{ auth()->user()->name }}</span><flux:icon.chevron-down class="size-4" /></summary>
                    <nav aria-label="{{ __('User menu') }}">
                        @if (auth()->user()->role !== 'admin')
                            <a href="{{ route('training.profile') }}">{{ __('Personal profile') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">{{ __('Log out') }}</button></form>
                    </nav>
                </details>
            @elseif (Route::has('login'))
                <a class="button button-outline header-login" href="{{ route('login') }}">{{ __('site.login') }} <flux:icon.user-circle class="size-5 shrink-0" /></a>
            @endif
            <x-language-switcher />
            <details class="mobile-menu">
                <summary aria-label="{{ __('site.open_navigation') }}"><span></span><span></span><span></span></summary>
                <nav aria-label="{{ __('site.mobile_navigation') }}">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a @class(['is-active' => request()->routeIs('health-centers.*')]) href="{{ route('health-centers.index') }}">{{ __('health-centers.title') }}</a>
                            <a href="{{ route('admin.training-applications.index') }}">{{ __('Training applications') }}</a>
                        @else
                            <a href="{{ route('home') }}#home">{{ __('site.home') }}</a>
                            <a href="{{ route('home') }}#about">{{ __('site.about_training') }}</a>
                            <a href="{{ route('home') }}#opportunities">{{ __('site.training_opportunities') }}</a>
                            <a href="{{ route('home') }}#journey">{{ __('site.trainee_journey') }}</a>
                            <a @class(['is-active' => request()->routeIs('health-centers.*')]) href="{{ route('health-centers.index') }}">{{ __('health-centers.title') }}</a>
                            <a href="{{ route('home') }}#faq">{{ __('site.faq') }}</a>
                            <a href="{{ route('training.application') }}">{{ __('Training application') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">{{ __('Log out') }}</button></form>
                    @else
                        <a href="{{ route('home') }}#home">{{ __('site.home') }}</a>
                        <a href="{{ route('home') }}#about">{{ __('site.about_training') }}</a>
                        <a href="{{ route('home') }}#opportunities">{{ __('site.training_opportunities') }}</a>
                        <a href="{{ route('home') }}#journey">{{ __('site.trainee_journey') }}</a>
                        <a href="{{ route('home') }}#faq">{{ __('site.faq') }}</a>
                        <a href="{{ route('login') }}">{{ __('site.login') }}</a>
                        <a href="{{ route('register') }}">{{ __('Sign up') }}</a>
                    @endauth
                </nav>
            </details>
        </div>
    </div>
</header>
