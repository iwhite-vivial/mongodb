<?php
require 'login.php';
/**
 * Created by PhpStorm.
 * User: isaacwhite
 * Date: 3/28/18
 * Time: 9:47 AM
 */

$start_time = time();

$adsDatastore       = $client->ads;

$settingsCollection  = $adsDatastore->settings;
$campaignsCollection = $adsDatastore->campaigns;
var_dump([get_class($adsDatastore), get_class($settingsCollection)]);
$campaignRecords = $campaignsCollection->find([], ['owner_id' => 1, 'network_data' => ['fbCampaign' => ['account_id']]]);
var_dump(get_class($campaignRecords));die();

$unique = [];
foreach ($campaignRecords as $record) {
    $settingRecord  = $settingsCollection->findOne(['owner_id' => $record['owner_id']]);

    $campaignAccountId = $record['network_data']['fbCampaign']['account_id'];

    if ('act_'.$campaignAccountId !== $settingRecord['ad_account']) {
        $unique[$record['owner_id']] =
            [
                'name' => $record['name'],
                'settings_ad_account' => $settingRecord['ad_account'],
                'campaign_account_id' => $campaignAccountId,
            ];
    }
}

$end_time = time();
$difference = $end_time - $start_time;
echo 'Unique by owner_id: ' . count($unique) . PHP_EOL;
echo "Start Time: " . date('h:i:s', $start_time) . PHP_EOL;
echo "End Time: " . date('h:i:s', $end_time) . PHP_EOL;
echo "Difference: " . $difference . ' seconds' .PHP_EOL;
var_dump($unique);


