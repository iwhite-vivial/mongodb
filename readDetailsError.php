<?php
require 'login.php';
/**
 * Created by PhpStorm.
 * User: isaacwhite
 * Date: 3/28/18
 * Time: 9:47 AM
 */

$start_time = time();

/**
 * @var MongoDB\Database   $adsDatastore
 * @var MongoDB\Collection $settingCollection
 * @var MongoDB\Collection $campaignsCollection
 * @var MongoDB\Driver\Cursor $campaignRecords
 */
$adsDatastore       = $client->ads;

$auditsCollection   = $adsDatastore->audit;

/**
 * details.error.error_subcode => 1885499 // Viewer has no permissions
 * details.subCode => 1815107 // Error accessing adreport job.
 */
$auditRecords       = $auditsCollection->find(['details.subCode' => 1815107], ['date' => 1]);
$campaignsCollection = $adsDatastore->campaigns;

$unique = [];
$complete = [];
$i = 0;
foreach ($auditRecords as $record) {
    $campaignsRecord = $campaignsCollection->findOne(['owner_id' => $record->owner_id], ['name' => 1]);

    $unique[$record->owner_id] = date('Y-m-d\Th:m:s', $record->date->toDateTime()->getTimestamp()) . ' :: ' . $campaignsRecord->name;
    $i++;
}

$end_time = time();
$difference = $end_time - $start_time;
echo 'Unique by owner_id: ' . count($unique) . PHP_EOL;
echo 'Total Records: ' . $i . PHP_EOL;
echo "Start Time: " . date('h:i:s', $start_time) . PHP_EOL;
echo "End Time: " . date('h:i:s', $end_time) . PHP_EOL;
echo "Difference: " . $difference . ' seconds' . PHP_EOL.PHP_EOL;
foreach ($unique as $id => $name) {
    echo $name.PHP_EOL;
}


