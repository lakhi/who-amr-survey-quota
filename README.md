# WHO AMR Survey – SoSci Quota Logic

PHP quota control code for the WHO Textual Messages AMR survey hosted on SoSci Survey.

## Structure

| File | Description |
|------|-------------|
| `country_quota.php` | Country-level quota check and redirect |
| `dimension_quota_de.php` | Germany gender/age/education quota check and redirect |
| `dimension_quota_lt.php` | Lithuania gender/age/education quota check and redirect |
| `dimension_quota_sr.php` | Serbia gender/age/education quota check and redirect |
| `dimension_quota_uz.php` | Uzbekistan gender/age/education quota check and redirect |
| `penultimate_write_de_lt_sr.php` | Writes completed interview data to internal QC variables (DE, LT, SR) |
| `penultimate_write_uz.php` | Writes completed interview data to internal QC variables (UZ; different age bands) |

## Countries
| Code | Country | Quota |
|------|---------|-------|
| 1 | Germany (DE) | 1000 |
| 2 | Lithuania (LT) | 1000 |
| 3 | Serbia (SR) | 1000 |
| 4 | Uzbekistan (UZ) | 1000 |

## Country Dimension Quotas
Gender (man/woman only), age group (6 bands), and education group (2 bands) are checked independently. Non-binary/other gender responses bypass gender quota but are still subject to age and education quotas. Participants who select "prefer not to answer" for education group also bypass the education quota check.

## Notes
- Variables must be declared on each page directly — PHP Functions tab does not pass variables to page scope in SoSci.
- Age group bands for Uzbekistan differ from those used for Germany, Lithuania, and Serbia.
- Use low limits during testing; restore production values before go-live.