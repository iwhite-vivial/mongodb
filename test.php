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

$isaacDatastore        = $client->isaac;

$houseRecords          = $isaacDatastore->houses->findOne(['state' => 'IA', 'city' => 'Clear Lake']);
$isaacDatastore->houses->updateOne(['city' => 'Clear Lake'], ['$set' => ['country' => 'USA']]);
$newRecords          = $isaacDatastore->houses->findOne(['state' => 'IA', 'city' => 'Clear Lake']);
var_dump($newRecords);die();

$campaignRecords = $campaignsCollection->find([], ['owner_id' => 1, 'network_data' => ['fbCampaign' => ['account_id']]]);

foreach ($campaignRecords as $record) {
    $settingRecord  = $settingsCollection->findOne(['owner_id' => $record['owner_id']]);

    $campaignAccountId = $record['network_data']['fbCampaign']['account_id'];

    if ('act_'.$campaignAccountId !== $settingRecord['ad_account']) {
        $settingsCollection->updateOne(['owner_id' => $record['owner_id']], ['$set' => ['ad_account' => 'act_'.$campaignAccountId]]);
    }
}


