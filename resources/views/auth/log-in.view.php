<div class="mx-auto max-w-sm py-8">

    <header class="mb-8 text-center">
        <span class="text-eyebrow font-display italic text-ink-soft">Welcome back</span>
        <h1 class="mt-1 font-display font-semibold text-accent text-fluid-lg">Log in</h1>
    </header>

    <form action="/log-in" method="post" class="flex flex-col gap-5">
        <input type="hidden" name="csrf_token">

        <div class="flex flex-col gap-1.5">
            <label for="user-email" class="font-mono text-xs uppercase tracking-wider text-ink-soft">Email</label>
            <input type="email" name="user-email" id="user-email" required value="<?= e( $email ?? '' ) ?>"
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="user-pass" class="font-mono text-xs uppercase tracking-wider text-ink-soft">Password</label>
            <input type="password" name="user-pass" id="user-pass" required
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
        </div>

        <?php if ( ! empty( $error ) ): ?>
            <p class="font-mono text-sm text-accent-deep">Invalid email or password.</p>
        <?php endif; ?>

        <button type="submit"
                class="mt-2 border border-accent bg-accent px-4 py-2 font-mono text-sm uppercase tracking-wider text-on-accent transition-colors duration-300 ease-out hover:cursor-pointer hover:bg-transparent hover:text-accent">
            Log in
        </button>
    </form>
</div>