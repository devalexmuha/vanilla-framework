<?php /** @var array $errors */ ?>

<form action="/page/" method="post" class="mx-auto max-w-2xl">
    <input type="hidden" name="csrf_token">

    <a href="/pages"
       class="font-mono text-xs uppercase tracking-wider text-ink-soft transition-colors hover:text-accent">
        &larr; All pages
    </a>

    <!-- name → text input, styled to echo the h1 -->
    <input type="text" name="name" required autofocus
           placeholder="Give it a name…"
           class="mt-6 w-full border-b border-line bg-transparent pb-2 font-display font-semibold leading-tight tracking-tight text-ink text-2xl outline-none transition-colors placeholder:text-ink/30 focus:border-accent md:text-3xl">

    <!-- vanilla-core stamp -->
    <div class="mt-4 flex items-center gap-4">
        <span class="h-px w-10 bg-line"></span>
        <span class="font-mono text-sm text-accent-deep">New page</span>
    </div>

    <!-- description → textarea -->
    <textarea name="description" rows="10" required
              placeholder="Write something nice…"
              class="mt-8 w-full resize-y border border-line bg-surface px-4 py-3 leading-relaxed text-ink/85 text-content-text outline-none transition-colors placeholder:text-ink/30 focus:border-accent"><?= e( $old['description'] ?? '' ) ?></textarea>

    <?php if ( ! empty( $errors ) ): ?>
        <p class="mt-4 font-mono text-sm text-accent-deep">
            Name and description can't be empty.
        </p>
    <?php endif; ?>

    <!-- single publish button -->
    <button type="submit"
            class="mt-8 border border-accent bg-accent px-6 py-2 font-mono text-sm uppercase tracking-wider text-on-accent transition-colors hover:cursor-pointer hover:bg-transparent hover:text-accent">
        Publish
    </button>
</form>