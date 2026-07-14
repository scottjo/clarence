<div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 px-4 dark:bg-gray-900">
    <div class="w-full max-w-md space-y-8 rounded-xl bg-white p-8 shadow-lg dark:bg-gray-800">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                Forgotten Password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                Enter your member email address and we will send you a link to choose a new password.
            </p>
        </div>

        @if($resetLinkSent)
            <div class="rounded-md border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">
                If we found a member account for that email address, we have sent a password reset link.
            </div>
        @endif

        <form class="mt-8 space-y-6" wire:submit.prevent="sendResetLink">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email address</label>
                <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" wire:loading.attr="disabled" wire:target="sendResetLink" class="group relative flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70">
                    <span wire:loading.remove wire:target="sendResetLink">Send reset link</span>
                    <span wire:loading wire:target="sendResetLink">Sending link...</span>
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('members') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                Return to sign in
            </a>
        </div>
    </div>
</div>
