<header class="w-full border-b border-line">
	<div class="container flex items-center justify-between py-4">

		<!-- logo -->
		<a href="/" class="font-display text-2xl md:text-4xl font-semibold leading-none tracking-tight">
			V<span class="text-accent">C</span>
		</a>

		<!-- right: log in / log out (both built — wire the session flag as you like) -->
		@if ( ! empty( $_SESSION['loggedIn'] ) )
		<div class="flex items-center gap-6 font-mono text-sm md:text-m">
			<span class="text-ink-soft">{{ $_SESSION['user_email'] ?? '' }}</span>

			<a href="/page/create/"
			   class="border border-accent bg-accent px-4 py-1.5 uppercase tracking-wider text-on-accent transition-colors hover:bg-transparent hover:text-accent">
				Create
			</a>

			<form action="/log-out/" method="post">
				<button type="submit"
				        class="uppercase tracking-wider text-accent underline-offset-4 transition-colors hover:cursor-pointer hover:underline">
					Log out
				</button>
			</form>
		</div>
		@else
		<a href="/log-in"
		   class="font-mono text-sm md:uppercase tracking-wider text-accent underline-offset-4 transition-colors hover:underline">
			Log in
		</a>
		@endif

	</div>
</header>