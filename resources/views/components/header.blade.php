<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="{{route('home.index')}}">Workopia</a>
        </h1>
        <nav class="hidden md:flex items-center space-x-4">
            <x-nav-link route="jobs.index" :active="request()->is('jobs')">All Jobs</x-nav-link>
            <x-nav-link route="home.index" :active="request()->is('jobs/saved')">Saved Jobs</x-nav-link>
            <x-nav-link route="home.index" :active="request()->is('login')">Login</x-nav-link>
            <x-nav-link route="home.index" :active="request()->is('register')">Register</x-nav-link>
            <x-nav-link route="home.index" :active="request()->is('dashboard')" icon="gauge">Dashboard</x-nav-link>
            <x-button-link route='jobs.create' icon='edit'>Create Job</x-button-link>
        </nav>
        <button
            id="hamburger"
            class="text-white md:hidden flex items-center"
        >
            <i class="fa fa-bars text-2xl"></i>
        </button>
    </div>
    <!-- Mobile Menu -->
    <nav
        id="mobile-menu"
        class="hidden md:hidden bg-blue-900 text-white mt-5 pb-4 space-y-2"
    >
        <x-nav-link route="jobs.index" :active="request()->is('jobs')" :mobile="true">All Jobs</x-nav-link>
        <x-nav-link route="home.index" :active="request()->is('bookmarks')" :mobile="true">Saved Jobs</x-nav-link>
        <x-nav-link route="home.index" :active="request()->is('dashboard')" :mobile="true">Dashbaord</x-nav-link>
        <div class="pt-2"></div>
        <x-button-link route='jobs.create' icon='edit' :block="true">Create Job</x-button-link>
        <x-nav-link route="home.index" :active="request()->is('login')" :mobile="true">Login</x-nav-link>
        <x-nav-link route="home.index" :active="request()->is('register')" :mobile="true">Register</x-nav-link>
    </nav>
</header>
