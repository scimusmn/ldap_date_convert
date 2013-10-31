<?php

define("DAYS_IN_YEAR", 365.242190);
define("SEC_IN_DAY", 86400);
define("NANOSEC_IN_SEC", 1000000000);

// LDAP - Active Directory time starts in 1601
define("LDAP_YEAR", 1601);

// Unix time starts in 1970
define("UNIX_YEAR", 1970);

$years_between_unix_ldap = UNIX_YEAR - LDAP_YEAR;
$outputs['Years between Unix and LDAP start date'] = $years_between_unix_ldap;

$days_between_unix_ldap = $years_between_unix_ldap * DAYS_IN_YEAR;
$outputs['Days between Unix and LDAP start date'] = $days_between_unix_ldap;

$seconds_between_unix_ldap = $days_between_unix_ldap * SEC_IN_DAY;
$outputs['Seconds between Unix and LDAP start date'] = $seconds_between_unix_ldap;

$nanoseconds_between_unix_ldap = $seconds_between_unix_ldap * NANOSEC_IN_SEC;
$outputs['Nanoseconds between Unix and LDAP start date'] = $nanoseconds_between_unix_ldap;

$ldap_units_between_unix_ldap = $nanoseconds_between_unix_ldap / 100;
$outputs['LDAP units between Unix and LDAP start date'] = $ldap_units_between_unix_ldap;

$outputs['1'] = '------------------------';

$seconds_since_unix = time();
$outputs['Seconds from unix start date til now'] = $seconds_since_unix;

$nanoseconds_since_unix = $seconds_since_unix * NANOSEC_IN_SEC;
$outputs['Nanoseconds from Unix start date til now'] = $nanoseconds_since_unix;

$nanoseconds_since_ad = $nanoseconds_since_unix + $nanoseconds_between_unix_ldap;
$outputs['Nanoseconds since LDAP'] = $nanoseconds_since_ad;

/**
 * Working backwards from the Apache Directory Studio information
 */
$outputs['2'] = '------------------------';
$from_apache_dir_studio = 130277434357040000;
$outputs['From Apache Directory Studio - LDAP units'] = $from_apache_dir_studio;
$from_apache_nanosec = $from_apache_dir_studio * 100;
$outputs['From Apache - nanosecs'] = $from_apache_nanosec;
$from_apache_unix_sec = ($from_apache_nanosec - $nanoseconds_between_unix_ldap) / NANOSEC_IN_SEC;
$outputs['From Apache - Unix secs'] = $from_apache_unix_sec;

date_default_timezone_set('America/Chicago');
$from_apache_english = date('l jS \of F Y h:i:s A', $from_apache_unix_sec);
$outputs['From Apache - English'] = $from_apache_english;

// Now in LDAP time
$ldap_now = ($nanoseconds_between_unix_ldap + (time() * NANOSEC_IN_SEC))/ 100;
$outputs['LDAP Now'] = $ldap_now;
$ldap_in_180_days = $ldap_now + (((SEC_IN_DAY * 180) * NANOSEC_IN_SEC) / 100);
$outputs['LDAP in 180 days'] = $ldap_in_180_days;


// Expiration date in Unix time
// We want to expire accounts automatically after 180 days (approx 6 months)
$expire_unix = time() + (SEC_IN_DAY * 180);

/**
 * Print stuff
 */
echo '<table>';
foreach ($outputs as $name => $value) {
  echo '<tr>';
  echo '<td align="right"><strong>' . $name . '</strong></td>';
  echo '<td>';
  if (is_numeric($value)) {
    echo number_format($value, 0, '', '');
  } else {
    echo $value;
  }
  echo '</td>';
  echo '</tr>';
}
echo '</table>';

//$seconds_from_apache_dir_studio = $from_apache_dir_studio / NANOSEC_IN_SEC;
//$outputs['Seconds from Apache Dir Studio'] = $seconds_from_apache_dir_studio;

//$unix_seconds = $seconds_from_apache_dir_studio - $seconds_between_unix_ldap;
//$outputs['Unix seconds'] = $unix_seconds;

//$outputs['From the web'] = '130277027370000000';
