@script
<script>
    (function () {
        if (window.hljs) {
            return;
        }

        // Determine if user prefers dark mode
        const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // Create link element for CSS
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = isDark
            ? '/css/github-dark.min.css'
            : '/css/github.min.css';
        document.head.appendChild(link);

        // Load Highlight.js library
        const script = document.createElement('script');
        script.src = '/js/highlight.min.js';
        script.onload = () => {
            document.querySelectorAll('pre code').forEach(block => hljs.highlightElement(block));
        };
        document.body.appendChild(script);
    })();
</script>
@endscript

<div class="prose max-w-none">
    <pre class="text-xs overflow-x-auto rounded-lg">
        <code class="language-diff">
{{ $diff }}
        </code>
    </pre>
</div>

@script
<!-- Run highlighting immediately -->
<script>
    const observer = new MutationObserver(() => {
        document.querySelectorAll('pre code:not([data-highlighted])').forEach(block => {
            if (window.hljs) {
                hljs.highlightElement(block)
            }
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });
</script>
@endscript


