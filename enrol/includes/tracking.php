<?php
declare(strict_types=1);

function enrol_tracking_values(array $config): array
{
    $tracking = $config['tracking'] ?? [];
    return [
        'gtm' => preg_match('/^GTM-[A-Z0-9]+$/', (string) ($tracking['gtm_container_id'] ?? '')) ? (string) $tracking['gtm_container_id'] : '',
        'ga4' => preg_match('/^G-[A-Z0-9]+$/', (string) ($tracking['ga4_measurement_id'] ?? '')) ? (string) $tracking['ga4_measurement_id'] : '',
        'ads_id' => preg_match('/^AW-\d+$/', (string) ($tracking['google_ads_conversion_id'] ?? '')) ? (string) $tracking['google_ads_conversion_id'] : '',
        'ads_label' => preg_match('/^[A-Za-z0-9_-]+$/', (string) ($tracking['google_ads_conversion_label'] ?? '')) ? (string) $tracking['google_ads_conversion_label'] : '',
        'meta' => preg_match('/^\d{5,30}$/', (string) ($tracking['meta_pixel_id'] ?? '')) ? (string) $tracking['meta_pixel_id'] : '',
    ];
}

function enrol_tracking_head(array $config): void
{
    $ids = enrol_tracking_values($config);

    if ($ids['gtm'] !== ''): ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer',<?= json_encode($ids['gtm']) ?>);</script>
<!-- End Google Tag Manager -->
<?php endif;

    if ($ids['ga4'] !== '' || $ids['ads_id'] !== ''):
        $loaderId = $ids['ga4'] !== '' ? $ids['ga4'] : $ids['ads_id']; ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($loaderId) ?>"></script>
<script>
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());
<?php if ($ids['ga4'] !== ''): ?>gtag('config',<?= json_encode($ids['ga4']) ?>);<?php endif; ?>
<?php if ($ids['ads_id'] !== ''): ?>gtag('config',<?= json_encode($ids['ads_id']) ?>);<?php endif; ?>
</script>
<?php endif;

    if ($ids['meta'] !== ''): ?>
<!-- Meta Pixel -->
<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init',<?= json_encode($ids['meta']) ?>);fbq('track','PageView');</script>
<!-- End Meta Pixel -->
<?php endif;
}

function enrol_tracking_body(array $config): void
{
    $ids = enrol_tracking_values($config);
    if ($ids['gtm'] !== ''): ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e($ids['gtm']) ?>" height="0" width="0" class="tracking-frame" title="Google Tag Manager"></iframe></noscript>
<?php endif;
    if ($ids['meta'] !== ''): ?>
<noscript><img height="1" width="1" class="tracking-pixel" src="https://www.facebook.com/tr?id=<?= e($ids['meta']) ?>&ev=PageView&noscript=1" alt=""></noscript>
<?php endif;
}

function enrol_success_tracking(array $config): void
{
    $ids = enrol_tracking_values($config); ?>
<script>
window.dataLayer=window.dataLayer||[];
window.dataLayer.push({event:'generate_lead',lead_type:'initial_assessment'});
if(typeof window.gtag==='function'){
  gtag('event','generate_lead',{lead_type:'initial_assessment'});
<?php if ($ids['ads_id'] !== '' && $ids['ads_label'] !== ''): ?>
  gtag('event','conversion',{send_to:<?= json_encode($ids['ads_id'] . '/' . $ids['ads_label']) ?>});
<?php endif; ?>
}
if(typeof window.fbq==='function'){fbq('track','Lead');}
</script>
<?php
}
