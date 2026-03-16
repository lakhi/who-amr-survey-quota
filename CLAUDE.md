# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

PHP quota-control logic for the WHO Textual Messages AMR survey, hosted on **SoSci Survey**. There is no build system, test suite, or local runtime — all PHP runs inside SoSci's page-level PHP execution environment. The code is copy-pasted into SoSci page editors.

## Architecture

The survey flow for each respondent hits these pages in order:

1. **country_quota_page** — checks overall country quota via `QC01_01`; redirects to panel QuotaFull URL if full.
2. **dimension_quota_page** — checks gender / age / education quotas independently; redirects if *any* dimension is full.
3. *(survey questions run here)*
4. **penultimate_write_page** — on completion, writes the respondent's group codes to QC internal variables so they are counted for future quota checks.
5. **final_page** — static HTML with a country-specific panel completion redirect link.
6. **reporting_page** — read-only debug output showing filled/remaining counts per dimension (not in the respondent flow).

Each folder has one file per country (DE, LT, SR, UZ).

## QC Variable Mapping

Each country uses isolated internal-variable items so quota counts don't interfere:

| Country | Country completion | Gender | Age | Education |
|---------|-------------------|--------|-----|-----------|
| DE (1)  | QC01_01 = 1       | QC02_01 | QC02_02 | QC02_03 |
| LT (2)  | QC01_01 = 2       | QC03_01 | QC03_02 | QC03_03 |
| SR (3)  | QC01_01 = 3       | QC04_01 | QC04_02 | QC04_03 |
| UZ (4)  | QC01_01 = 4       | QC05_01 | QC05_02 | QC05_03 |

All countries share QC01 for the country-level count (distinguished by value), but dimensions use separate QC02–QC05 items per country.

## Key SoSci API Functions

- `value('VAR')` — read a survey variable
- `put('VAR', val)` — write to an internal variable
- `statistic('count', 'VAR', val)` — count how many completed cases have a given value
- `redirect(url)` — end survey and redirect respondent
- `debug(msg)` — emit debug output (visible only in SoSci debug/pretest mode)

## Survey Variables (respondent data)

- `SD02` — country code (1=DE, 2=LT, 3=SR, 4=UZ)
- `SD05` — gender (1=male, 2=female, 3+=other/non-binary)
- `SD03_01` — age (integer)
- `SD08` — education level (1-2=low, 3-7=high)

## Important Constraints

- **No shared scope**: SoSci does not pass variables from the PHP Functions tab to page scope. Every variable must be declared directly on each page.
- **Age bands differ for Uzbekistan**: DE/LT/SR use 18-24, 25-34, 35-44, 45-54, 55-64, 65+. UZ uses 18-29, 30-39, 40-49, 50-59, 60-64, 65+.
- **Gender bypass**: Non-binary respondents (SD05 >= 3) bypass gender quota but are still subject to age and education quotas.
- **Education bypass**: Respondents with SD08 outside 1-7 (e.g. "prefer not to answer") bypass the education quota check.
- **Quota values come from CSV**: The `quota_csv/` folder has the authoritative per-country quota splits. When updating quotas, update both the CSV and all PHP files that reference the values.
- **Panel redirect URLs**: Each country has a unique Norstat QuotaFull URL. These appear in both country_quota and dimension_quota files.

## When Adding a New Country

1. Add a row to `quota_csv/` with the quota splits.
2. Create files in all five page folders following the existing country pattern.
3. Assign the next QC item range (e.g. QC06_01–03) for dimension variables.
4. Use the correct age-band mapping for that country.
5. Update `Quota_control_internal-variable.xml` if new QC items are needed.
