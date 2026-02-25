// ===== QUOTA CONFIG =====
$QUOTA_SR     = 1000;
$QUOTA_URL_SR = 'https://webs.norstatsurveys.com/end/67babc88a4c14b1192c73b91fa150a25/QuotaFull';

// Completed count for SR (via internal variable)
$finishedSR = statistic('count', 'QC01_01', 3);

if ($finishedSR >= $QUOTA_SR) {
    debug('quota SR reached! redirecting to: ' . $QUOTA_URL_SR);
    redirect($QUOTA_URL_SR);
}
