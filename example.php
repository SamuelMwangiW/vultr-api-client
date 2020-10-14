<?php
include 'Vultr.class.php';

$token = 'YOUR_VULTR_TOKEN_HERE';
$snapshot_id = 'A_SNAPSHOT_TO_CREATE_FROM';
$region_id = 1;
$vps_plan = 202;

$vultr = new Vultr($token);
$snapshots = $vultr->snapshot_list();

if($snapshots[$snapshot_id]){
    $config = [
        'DCID' => $region_id,
        'OSID' => $snapshots[$snapshot_id]['OSID'],
        'VPSPLANID' => $vps_plan,
        'SNAPSHOTID' => $snapshots[$snapshot_id]['SNAPSHOTID']
    ];

    $SUBID = $vultr->create($config);

    do{
        sleep(30);
        $ip = $vultr->list_ipv4($SUBID);
    }
    while($ip[0]['ip'] == '0.0.0.0');

    print_r($ip);
}
else{
    echo 'The snapshot id or token is invalid';
}
