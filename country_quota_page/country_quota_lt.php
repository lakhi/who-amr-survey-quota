// ===== QUOTA CONFIG =====
$QUOTA_LT     = 1000;
$QUOTA_URL_LT = 'https://webs.norstatsurveys.com/end/5f178d93b5c2431ba6b41791eac5da93/QuotaFull';

// Completed count for LT (via internal variable)
$finishedLT = statistic('count', 'QC01_01', 2);

if ($finishedLT >= $QUOTA_LT) {
    debug('quota LT reached! redirecting to: ' . $QUOTA_URL_LT);
    redirect($QUOTA_URL_LT);
}
