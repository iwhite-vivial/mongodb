<?php
require 'login.php';

$adsDatastore       = $client->ads;

$settingsCollection  = $adsDatastore->settings;
$adsCollection       = $adsDatastore->ads;
$campaignsCollection = $adsDatastore->campaigns;

$adRecord = $adsCollection->find([]);

$corrections = [];
$unique = [];
foreach ($adRecord as $record) {
    $campaignRecord = $campaignsCollection->findOne(['owner_id' => $record['owner_id']]);
    $settingRecord  = $settingsCollection->findOne(['owner_id' => $record['owner_id']]);

    if ('act_'.$record['account_id'] !==
        $settingRecord['ad_account']) {

        if ($campaignRecord['name']) {
            $unique[$record['owner_id']] =
                [
                    'name' => $campaignRecord['name'],
                    'settings_ad_account' => $settingRecord['ad_account'],
                    'ads_ad_account' => $record['account_id']
                ];
            $corrections[] = [$record['owner_id'] =>
                [
                    'name' => $campaignRecord['name'],
                    'settings_ad_account' => $settingRecord['ad_account'],
                    'ads_ad_account' => $record['account_id']
                ]];
        }
    }
}

echo 'All values: ' . count($corrections) . PHP_EOL;
var_dump($corrections);
echo PHP_EOL.PHP_EOL;
echo 'Unique by owner_id: ' . count($unique) . PHP_EOL;
var_dump($unique);







