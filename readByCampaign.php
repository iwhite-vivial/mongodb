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

$settingsCollection  = $adsDatastore->settings;

$campaignsCollection = $adsDatastore->campaigns;

$campaignRecords = $campaignsCollection->find([], ['owner_id' => 1, 'network_data' => ['fbCampaign' => ['account_id']]]);

$unique = [];
$complete = [];
foreach ($campaignRecords as $record) {
    $settingsRecords  = $settingsCollection->find(['owner_id' => $record['owner_id']]);

    $campaignAccountId = $record['network_data']['fbCampaign']['account_id'];

    if ($campaignAccountId) {
        foreach($settingsRecords as $settingsRecord) {
            if ('act_' . $campaignAccountId !== $settingsRecord['ad_account']) {
                $unique[$record['owner_id']] =
                    [
                        'name' => $record['name'],
                        'settings_ad_account' => $settingsRecord['ad_account'],
                        'campaign_account_id' => $campaignAccountId,
                    ];
                $complete[] = [
                    'owner_id' => $record['owner_id'],
                    'name' => $record['name'],
                    'settings_ad_account' => $settingsRecord['ad_account'],
                    'campaign_account_id' => $campaignAccountId,
                ];
            }
        }
    }
}

$end_time = time();
$difference = $end_time - $start_time;
echo 'Unique by owner_id: ' . count($unique) . PHP_EOL;
echo 'Complete by owner_id: ' . count($complete) . PHP_EOL;
echo "Start Time: " . date('h:i:s', $start_time) . PHP_EOL;
echo "End Time: " . date('h:i:s', $end_time) . PHP_EOL;
echo "Difference: " . $difference . ' seconds' . PHP_EOL;
var_dump($unique);
echo PHP_EOL.PHP_EOL.'Complete By Owner ID:'.PHP_EOL;
var_dump($complete);



