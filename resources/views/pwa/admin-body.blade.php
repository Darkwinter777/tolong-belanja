<!-- PWA scripts (admin) -->
<script>
    "use strict";
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("{{ asset('sw.js') }}", { scope: "/admin" }).then(
            () => {},
            () => {}
        );
    }
</script>
<!-- PWA scripts -->
