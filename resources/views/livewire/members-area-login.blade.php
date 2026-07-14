<div class="min-h-screen flex flex-col items-center justify-center px-4 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                Members Only Area
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                Sign in with your name or email address, or request a member account. If you can please use the same email address as your Bowls-hub account.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-2 rounded-lg bg-gray-100 p-1 dark:bg-gray-900">
            <button type="button" wire:click="showLogin" class="rounded-md px-3 py-2 text-sm font-medium transition {{ $formMode === 'login' ? 'bg-white text-blue-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                Sign in
            </button>
            <button type="button" wire:click="showRegister" class="rounded-md px-3 py-2 text-sm font-medium transition {{ $formMode === 'register' ? 'bg-white text-blue-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                Register
            </button>
        </div>

        @if($formMode === 'login')
            @if(session('passwordResetStatus'))
                <div class="rounded-md border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">
                    {{ session('passwordResetStatus') }}
                </div>
            @endif

            @if($registrationSubmitted)
                <div class="rounded-md border {{ $registrationApproved ? 'border-green-200 bg-green-50 text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300' : 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-800 dark:bg-amber-900/20 dark:text-amber-300' }} p-4 text-sm">
                    @if($registrationApproved)
                        Your registration has been approved automatically. You can now log in.
                    @else
                        Your registration has been sent for approval. We will email you once your account has been approved.
                    @endif
                </div>
            @endif

            <form class="mt-8 space-y-6" wire:submit.prevent="login">
                <div class="space-y-4">
                    <div>
                        <label for="loginIdentifier" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name or email address</label>
                        <input wire:model="loginIdentifier" id="loginIdentifier" name="loginIdentifier" type="text" autocomplete="username" required class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        @error('loginIdentifier')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="loginPassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input wire:model="loginPassword" id="loginPassword" name="loginPassword" type="password" autocomplete="current-password" required class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        @error('loginPassword')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" wire:loading.attr="disabled" wire:target="login" class="group relative flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70">
                        <span wire:loading.remove wire:target="login">Login</span>
                        <span wire:loading wire:target="login">Checking details...</span>
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('members.password.request') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">
                        Forgotten password?
                    </a>
                </div>
            </form>
        @else
            <form class="mt-8 space-y-6" wire:submit.prevent="register">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input wire:model="name" id="name" name="name" type="text" autocomplete="name" required class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email address</label>
                        <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input wire:model="password" id="password" name="password" type="password" autocomplete="new-password" required class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm password</label>
                        <input wire:model="passwordConfirmation" id="passwordConfirmation" name="passwordConfirmation" type="password" autocomplete="new-password" required class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                        @error('passwordConfirmation')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Request Account
                    </button>
                </div>
            </form>
        @endif

        <div class="mt-4 text-center">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                Return Home
            </a>
        </div>
    </div>
</div>
