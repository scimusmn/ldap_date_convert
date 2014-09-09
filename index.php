<?php

define("DAYS_IN_YEAR", 365.242190);
define("SEC_IN_DAY", 86400);
define("NANOSEC_IN_SEC", 1000000000);

// LDAP - Active Directory time starts in 1601
define("LDAP_YEAR", 1601);

// Unix time starts in 1970
define("UNIX_YEAR", 1970);

$years_btwn_unix_ldap = UNIX_YEAR - LDAP_YEAR;
$days_btwn_unix_ldap = $years_btwn_unix_ldap * DAYS_IN_YEAR;
$seconds_btwn_unix_ldap = $days_btwn_unix_ldap * SEC_IN_DAY;
$nanosec_btwn_unix_ldap = $seconds_btwn_unix_ldap * NANOSEC_IN_SEC;

/**
 * Working backwards from the Apache Directory Studio information
 */
$test_ldap_time = 130277434357040000;
$outputs['Test LDAP time'] = $test_ldap_time;
$test_ldap_time_nanosecs = $test_ldap_time * 100;
$outputs['Test LDAP time - nanosecs'] = $test_ldap_time_nanosecs;
$test_ldap_time_unix = ($test_ldap_time_nanosecs - $nanosec_btwn_unix_ldap) / NANOSEC_IN_SEC;
$outputs['Test LDAP time - Unix'] = $test_ldap_time_unix;

date_default_timezone_set('America/Chicago');
$from_apache_english = date('l jS \of F Y h:i:s A', $test_ldap_time_unix);
$outputs['Test LDAP time - English'] = $from_apache_english;

// Now in LDAP time
// LDAP time is broken down into 100 nanosecond chunks.
// I'm just doing the math this way to make that clear.
$ldap_now = ($nanosec_btwn_unix_ldap + (time() * NANOSEC_IN_SEC))/ 100;
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
  echo '<td align="left"><strong>' . $name . '</strong></td>';
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

//$unix_seconds = $seconds_from_apache_dir_studio - $seconds_btwn_unix_ldap;
//$outputs['Unix seconds'] = $unix_seconds;

//$outputs['From the web'] = '130277027370000000';
