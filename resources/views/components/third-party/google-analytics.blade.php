<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('constants.google_analytics_id') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', '{{ config('constants.google_analytics_id') }}');
</script>
