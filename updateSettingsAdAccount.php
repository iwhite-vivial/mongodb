<?php
require 'login.php';
/**
 * Created by PhpStorm.
 * User: isaacwhite
 * Date: 3/28/18
 * Time: 1:38 PM
 *
 * This script will update the mismatched Settings Ad Account Ids to match the Campaign Ad Account Ids
 * NOTE: The Settings Account Ids all have a prepended 'act_' by convention.
 */

/**
 * @var MongoDB\Database   $adsDatastore
 * @var MongoDB\Collection $settingCollection
 * @var MongoDB\Collection $campaignsCollection
 * @var MongoDB\Driver\Cursor $campaignRecords
 */
$adsDatastore        = $client->ads;

$settingsCollection  = $adsDatastore->settings;

$campaignsCollection = $adsDatastore->campaigns;

$campaignRecords = $campaignsCollection->find([], ['owner_id' => 1, 'network_data' => ['fbCampaign' => ['account_id']]]);

foreach ($campaignRecords as $record) {
    $settingsRecords = $settingsCollection->find(['owner_id' => $record['owner_id']]);

    $campaignAccountId = $record['network_data']['fbCampaign']['account_id'];

    if ($campaignAccountId)  {
        foreach($settingsRecords as $settingsRecord) {
            if ('act_' . $campaignAccountId !== $settingsRecord['ad_account']) {
                $settingsCollection->updateMany(['owner_id' => $record['owner_id']], ['$set' => ['ad_account' => 'act_' . $campaignAccountId]]);
            }
        }
    }
}
