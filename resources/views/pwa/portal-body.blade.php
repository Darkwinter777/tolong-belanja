<!-- PWA scripts (portal) -->
<script>
    "use strict";
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("{{ asset('sw.js') }}", { scope: "/portal" }).then(
            () => {},
            () => {}
        );
    }
</script>
<!-- PWA scripts -->
