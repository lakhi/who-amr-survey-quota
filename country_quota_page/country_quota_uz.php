// ===== QUOTA CONFIG =====
$QUOTA_UZ     = 5;
$QUOTA_URL_UZ = 'https://webs.norstatsurveys.com/end/44e47d14a5ac4ef5bc1b64f853590ad4/QuotaFull';

// Completed count for UZ (via internal variable)
$finishedUZ = statistic('count', 'QC01_01', 4);

if ($finishedUZ >= $QUOTA_UZ) {
    debug('quota UZ reached! redirecting to: ' . $QUOTA_URL_UZ);
    redirect($QUOTA_URL_UZ);
}
