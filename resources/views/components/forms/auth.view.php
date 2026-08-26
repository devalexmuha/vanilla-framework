<form action="/log-in" method="post" class="flex flex-col gap-5">
	  @csrf

	<div class="flex flex-col gap-1.5">
		<label for="email" class="font-mono text-xs uppercase tracking-wider text-ink-soft">Email</label>
		<input type="email" name="email" id="email" required value="{{ $pageData['email'] ?? '' }}"
		       class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
	</div>

	<div class="flex flex-col gap-1.5">
		<label for="pass" class="font-mono text-xs uppercase tracking-wider text-ink-soft">Password</label>
		<input type="password" name="pass" id="pass" required
		       class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
	</div>

	@if ( ! empty( $error ) )
	<p class="font-mono text-sm text-accent-deep">{{ $error }}</p>
	@endif

	<button type="submit"
	        class="mt-2 border border-accent bg-accent px-4 py-2 font-mono text-sm uppercase tracking-wider text-on-accent transition-colors duration-300 ease-out hover:cursor-pointer hover:bg-transparent hover:text-accent">
		Log in
	</button>
</form>
