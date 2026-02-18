// ===== QUOTA CONFIG =====
$QUOTA_DE = 5;
$QUOTA_LT = 1000;
$QUOTA_SR = 1000;
$QUOTA_UZ = 1000;

$QUOTA_URL_DE = 'https://webs.norstatsurveys.com/end/17ae08cfd6ed4e3ab008e33856732e1a/QuotaFull';
$QUOTA_URL_LT = 'https://webs.norstatsurveys.com/end/5f178d93b5c2431ba6b41791eac5da93/QuotaFull';
$QUOTA_URL_UZ = 'https://webs.norstatsurveys.com/end/44e47d14a5ac4ef5bc1b64f853590ad4/QuotaFull';
$QUOTA_URL_SR = 'https://webs.norstatsurveys.com/end/67babc88a4c14b1192c73b91fa150a25/QuotaFull';

// Completed counts per country (via internal variable)
$finishedDE = statistic('count', 'QC01_01', 1);
$finishedLT = statistic('count', 'QC01_01', 2);
$finishedSR = statistic('count', 'QC01_01', 3);
$finishedUZ = statistic('count', 'QC01_01', 4);

debug($finishedDE);
debug($QUOTA_DE);
debug(value('QUESTNNR'));

// test values; production: 'germany'
if (value('QUESTNNR') == 'germany' && $finishedDE >= $QUOTA_DE) {
    debug('quota DE reached! redirecting to: ' . $QUOTA_URL_DE);
    redirect($QUOTA_URL_DE);
}