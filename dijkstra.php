<?php

$json = file_get_contents('graph.json');
$data = json_decode($json, true);

$graph = $data['data'];
$startPoint = $data['startPoint'];

$paths = [];


for ($i = 0; $i < count($graph); $i++) {
    $paths[$i]["weight"]    = $i == $startPoint ? 0 : INF;
    $paths[$i]["fixed"]     = $i == $startPoint;
}

$currentPoint = $startPoint;
$currentWeight = 0;

while(true) {
    for ($i = 0; $i < count($graph[$currentPoint]); $i++) {
        $weight = $graph[$currentPoint][$i];
        if($weight > 0) {
            for($j = 0; $j<count($graph); $j++) {
                if(
                    $j !== $currentPoint &&
                    $graph[$j][$i] != 0 &&
                    !$paths[$j]["fixed"] &&
                    $weight + $currentWeight < $paths[$j]["weight"]
                ) {
                        $paths[$j]["weight"] = $weight + $currentWeight;
                        break;
                }
            }
        }
    }

    $minWeight = INF;

    for ($i = 0; $i < count($paths); $i++) {
        if (!$paths[$i]["fixed"] && ($paths[$i]["weight"] < $minWeight)) {
            $minWeight = $paths[$i]["weight"];
            $minPoint = $i;
        }
    }

    if ($minWeight == INF) {
        break;
    }

    $paths[$minPoint]["fixed"] = true;
    $currentPoint = $minPoint;
    $currentWeight = $paths[$minPoint]["weight"];

}

foreach ($paths as $path) {
    echo $path["weight"]." | ";
}
