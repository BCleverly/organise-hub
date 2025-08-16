<div>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">
            Sign in to your account
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Or
            <a href="{{ route('register') }}" wire:navigate.hover class="font-medium text-indigo-600 hover:text-indigo-500">
                create a new account
            </a>
        </p>
    </div>
    
    <!-- Passkey Authentication -->
    <div class="mb-6">
        {{-- <livewire:passkeys /> --}}
    </div>

    @if(app()->environment('local', 'development', 'testing'))
        <!-- Quick Login for Development -->
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="text-center mb-3">
                <h3 class="text-sm font-medium text-yellow-800">🧪 Development Quick Login</h3>
                <p class="text-xs text-yellow-700 mt-1">Test accounts for development only</p>
            </div>
            <div class="grid grid-cols-1 gap-2">
                <button 
                    wire:click="quickLogin('test@example.com')"
                    wire:loading.attr="disabled"
                    class="w-full px-3 py-2 text-sm bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded border border-yellow-300 transition-colors disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="quickLogin('test@example.com')">
                        👤 Login as Test User (test@example.com)
                    </span>
                    <span wire:loading wire:target="quickLogin('test@example.com')">
                        Logging in...
                    </span>
                </button>
                <button 
                    wire:click="quickLogin('admin@example.com')"
                    wire:loading.attr="disabled"
                    class="w-full px-3 py-2 text-sm bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded border border-yellow-300 transition-colors disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="quickLogin('admin@example.com')">
                        👑 Login as Admin (admin@example.com)
                    </span>
                    <span wire:loading wire:target="quickLogin('admin@example.com')">
                        Logging in...
                    </span>
                </button>
            </div>
        </div>
    @endif

    <!-- Divider -->
    <div class="relative mb-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Or continue with email</span>
        </div>
    </div>
    
    <!-- Email/Password Form -->
    <form wire:submit="login" class="space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required 
                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-300 @enderror" 
                   placeholder="Enter your email">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required 
                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-300 @enderror" 
                   placeholder="Enter your password">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input wire:model="remember" id="remember" name="remember" type="checkbox" 
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-900">
                    Remember me
                </label>
            </div>

            <div class="text-sm">
                <a href="{{ route('password.request') }}" wire:navigate.hover class="font-medium text-indigo-600 hover:text-indigo-500">
                    Forgot your password?
                </a>
            </div>
        </div>

        <div>
            <button type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                Sign in with Email
            </button>
        </div>
    </form>
</div>
