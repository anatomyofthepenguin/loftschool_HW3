<?php

function task1()
{
    $file= file_get_contents(__DIR__ . "\data.xml");
    $xml = new SimpleXMLElement($file);

    ob_start();

    foreach ($xml->Address as $address) {
        echo $address->attributes()->Type . PHP_EOL;
        echo "Name: {$address->Name->__toString()}" . PHP_EOL;
        echo "Street: {$address->Street->__toString()}" . PHP_EOL;
        echo "City: {$address->City->__toString()}" . PHP_EOL;
        echo "State: {$address->State->__toString()}" . PHP_EOL;
        echo "Zip: {$address->Zip->__toString()}" . PHP_EOL;
        echo "Country: {$address->Country->__toString()}" . PHP_EOL;
    }

    echo "Notes: {$xml->DeliveryNotes->__toString()}" . PHP_EOL;

    foreach ($xml->Items->Item as $item) {
        echo "Part number: {$item->attributes()->PartNumber}" . PHP_EOL;
        echo "Name: {$item->ProductName->__toString()}" . PHP_EOL;
        echo "Quantity: {$item->Quantity->__toString()}" . PHP_EOL;
        echo "Price: {$item->USPrice->__toString()}$" . PHP_EOL;
        if ($item->ShipDate) {
            echo "ShipDate: {$item->ShipDate->__toString()}" . PHP_EOL;
        }
        if ($item->Comment) {
            echo "Comment: {$item->Comment->__toString()}" . PHP_EOL;
        }
    }
    $output = "<pre>" . ob_get_contents() . "</pre>";
    ob_end_clean();

    echo $output;
}

function task2()
{
    $array = [12, 13, 14, ["qwerty", "abcd", "array" => [12313, 234234]]];
    $json = json_encode($array);
    file_put_contents(__DIR__ . "/output.json", $json);

    $data = file_get_contents(__DIR__ . "/output.json");
    $dataDecode = json_decode($data, true);

    if (rand(-15, 14) < 0) {
        $dataDecode[] = ['changed', 'array'];
        $dataDecode[3]['array'] = ['changed', 'inner', 'array'];
    }
    file_put_contents(__DIR__ . "/output2.json", $json);

    $data2 = file_get_contents(__DIR__ . "/output.json");
    $dataDecode2 = json_decode($data2, true);

    if ($dataDecode2 !== $dataDecode) {
        $diffValues = [];
        foreach ($dataDecode as $key => $value) {
            if ($dataDecode[$key] !== $dataDecode2[$key]) {
                $diffValues[$key] = $value;
            }
        }

        echo "Элементы Отличные от первого массива";
        print_r($diffValues);
    } else {
        echo "Массивы равны";
    }
}

function task3()
{
    $array = [];
    for ($i = 0; $i <= 50; $i++) {
        $array[] = rand(1, 100);
    }

    $fp = fopen('data.csv', 'a+');
    fputcsv($fp, $array);
    rewind($fp);

    $dataArray = [];

    while ($str = fgetcsv($fp)) {
        $dataArray = array_merge($dataArray, $str);
    }

    fclose($fp);

    $arraySum = 0;
    foreach ($dataArray as $value) {
        $arraySum += $value % 2 ? 0 : $value;
    }
    echo "Сумма : $arraySum";
}

function task4()
{
    $url = "https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json";
    $data = file_get_contents($url);
    $data_decode = json_decode($data, true);

    echo "Page id:" . $data_decode["query"]["pages"]["15580374"]["pageid"] . PHP_EOL;
    echo "Title:" . $data_decode["query"]["pages"]["15580374"]["title"] . PHP_EOL;
}
