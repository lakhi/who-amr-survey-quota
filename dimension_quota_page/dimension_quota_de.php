// ===== GERMANY QUOTA CONFIG =====
$QUOTA_URL_DE    = 'https://webs.norstatsurveys.com/end/17ae08cfd6ed4e3ab008e33856732e1a/QuotaFull';
$QUOTA_DE_GENDER = [1 => 1, 2 => 1];   // test values: [1 => 1, 2 => 1]; production: [1 => 493, 2 => 507]
$QUOTA_DE_AGE    = [1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 1];  // test values; production: [1 => 91, 2 => 150, 3 => 146, 4 => 199, 5 => 162, 6 => 251]
$QUOTA_DE_EDU    = [1 => 1, 2 => 1];   // test values: [1 => 1, 2 => 1]; production: [1 => 218, 2 => 782]

// ===== DEBUG RAW VALUES =====
debug('RAW: SD05=' . value('SD05') . ', SD03_01=' . value('SD03_01') . ', SD08=' . value('SD08'));


// current respondent groups
$g   = (int) value('SD05');
$age = (int) value('SD03_01');
$edu = (int) value('SD08');

// age group
if ($age >= 18 && $age <= 24) {
    $ageGroup = 1;
} elseif ($age <= 34) {
    $ageGroup = 2;
} elseif ($age <= 44) {
    $ageGroup = 3;
} elseif ($age <= 54) {
    $ageGroup = 4;
} elseif ($age <= 64) {
    $ageGroup = 5;
} else {
    $ageGroup = 6;
}

// education group
if ($edu == 1 || $edu == 2) {
    $eduGroup = 1;
} elseif ($edu >= 3 && $edu <= 7) {
    $eduGroup = 2;
} else {
    $eduGroup = 0;
}

// counts
$countAge = statistic('count', 'QC01_03', $ageGroup);

if ($eduGroup == 1 || $eduGroup == 2) {
    $countEdu = statistic('count', 'QC01_04', $eduGroup);
} else {
    $countEdu = 0;
}

$genderQuotaFull = false;
$countGender     = 0;
if ($g == 1 || $g == 2) {
    $countGender     = statistic('count', 'QC01_02', $g);
    $genderQuotaFull = ($countGender >= $QUOTA_DE_GENDER[$g]);
}

$ageQuotaFull = ($countAge >= $QUOTA_DE_AGE[$ageGroup]);

if ($eduGroup == 1 || $eduGroup == 2) {
    $eduQuotaFull = ($countEdu >= $QUOTA_DE_EDU[$eduGroup]);
} else {
    $eduQuotaFull = false;
}

// debug counts and hits
if ($genderQuotaFull) {
    $genderHitStr = 'YES';
} else {
    $genderHitStr = 'NO';
}

if ($ageQuotaFull) {
    $ageHitStr = 'YES';
} else {
    $ageHitStr = 'NO';
}

if ($eduQuotaFull) {
    $eduHitStr = 'YES';
} else {
    $eduHitStr = 'NO';
}

debug('GROUPS: g=' . $g . ', ageGroup=' . $ageGroup . ', eduGroup=' . $eduGroup);
debug('COUNTS: gender=' . $countGender . ', age=' . $countAge . ', edu=' . $countEdu);
debug('HITS: gender=' . $genderHitStr . ', age=' . $ageHitStr . ', edu=' . $eduHitStr);

if ($genderQuotaFull || $ageQuotaFull || $eduQuotaFull) {
    debug('TRIGGER: DE dimension quota hit - redirecting');
    redirect($QUOTA_URL_DE);
}
