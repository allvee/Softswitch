<?php
/**
 * Created by PhpStorm.
 * User: Mazhar
 * Date: 1/7/2015
 * Time: 3:12 PM
 */

date_default_timezone_set('Asia/Dhaka');
$arrayTimeZones = timezone_list();

$arrayTimeZoneKeys = array_keys($arrayTimeZones);
$innerHTML = '';
foreach ($arrayTimeZoneKeys as $timeZoneKey) {

    $innerHTML = $innerHTML . ' <option value="' . $arrayTimeZones[$timeZoneKey] . '" >' . $arrayTimeZones[$timeZoneKey] . '</option> ';
}

echo ($innerHTML);

function timezone_list()
{
    static $timezones = null;

    if ($timezones === null) {
        $timezones = array();
        $offsets = array();
        $now = new DateTime();

        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = format_timezone_name($timezone) . ' (' . format_GMT_offset($offset) . ') ';
        }

        array_multisort($offsets, $timezones);
    }
    return $timezones;
}

function format_GMT_offset($offset)
{
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
}

function get_formatted_GMT_offset($offset)
{
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return $offset ? sprintf('%+03d:%02d', $hours, $minutes) : '00:00';
}

function format_timezone_name($name)
{
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    return $name;
}


function get_List_unused()
{
    $timezones = DateTimeZone::listAbbreviations();

    $cities = array();
    foreach ($timezones as $key => $zones) {
        foreach ($zones as $id => $zone) {
            /**
             * Only get timezones explicitely not part of "Others".
             * @see http://www.php.net/manual/en/timezones.others.php
             */
            if (preg_match('/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $zone['timezone_id'])
                && $zone['timezone_id']
            ) {
                $cities[$zone['timezone_id']][] = $key;
            }
        }
    }

// For each city, have a comma separated list of all possible timezones for that city.
    foreach ($cities as $key => $value)
        $cities[$key] = join(', ', $value);

// Only keep one city (the first and also most important) for each set of possibilities.
    $cities = array_unique($cities);

// Sort by area/city name.
    ksort($cities);
}

function get_List_another_unused()
{
    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

//print_r($tzlist);
}