<a href="/page/{{ $page['slug'] }}"
   class="group flex flex-col gap-2 border-b border-line py-6 transition-colors duration-300 ease-out hover:border-accent">

	<h2 class="font-display text-xl font-semibold text-ink transition-colors duration-300 ease-out group-hover:text-accent">
		{{ $page['name'] }}
	</h2>

    <vc-partials.card-description/>

	<span class="mt-1 font-mono text-xs uppercase tracking-wider text-ink-soft transition-colors duration-300 ease-out group-hover:text-accent">
                        Read &rarr;
                    </span>
</a>