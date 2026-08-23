<?php /** @var array $pageData */ ?>

<vc-layouts.main>
    <div class="mx-auto max-w-3xl">

        <header class="mb-10 text-center">
            <span class="text-eyebrow font-display italic text-ink-soft">Everything we've written</span>
            <h1 class="mt-2 font-display font-semibold tracking-tight text-ink text-3xl md:text-4xl">
                All Pages
            </h1>
        </header>

        @if ( empty( $pageData ) )
            <p class="py-12 text-center font-mono text-sm uppercase tracking-wider text-ink-soft">
                Nothing here yet — go write something nice.
            </p>
        @else
            <div class="flex flex-col">
                @foreach ( $pageData as $page )
                    <a href="/page/{{ $page['slug'] }}"
                       class="group flex flex-col gap-2 border-b border-line py-6 transition-colors duration-300 ease-out hover:border-accent">

                        <h2 class="font-display text-xl font-semibold text-ink transition-colors duration-300 ease-out group-hover:text-accent">
                            {{ $page['name'] }}
                        </h2>

                        <p class="text-content-text text-ink-soft">
                            {{ mb_strimwidth( trim( $page['description'] ), 0, 140, '…' ) }}
                        </p>

                        <span class="mt-1 font-mono text-xs uppercase tracking-wider text-ink-soft transition-colors duration-300 ease-out group-hover:text-accent">
                        Read &rarr;
                    </span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-10 text-center">
            <a href="/"
               class="font-mono text-sm md:text-m uppercase tracking-wider text-accent underline-offset-4 hover:underline">
                &larr; Home
            </a>
        </div>
    </div>
</vc-layouts.main>