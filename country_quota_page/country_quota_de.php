// ===== QUOTA CONFIG =====
$QUOTA_DE     = 5;
$QUOTA_URL_DE = 'https://webs.norstatsurveys.com/end/17ae08cfd6ed4e3ab008e33856732e1a/QuotaFull';

// Completed count for DE (via internal variable)
$finishedDE = statistic('count', 'QC01_01', 1);

debug($finishedDE);
debug($QUOTA_DE);
debug(value('QUESTNNR'));

if ($finishedDE >= $QUOTA_DE) {
    debug('quota DE reached! redirecting to: ' . $QUOTA_URL_DE);
    redirect($QUOTA_URL_DE);
}
