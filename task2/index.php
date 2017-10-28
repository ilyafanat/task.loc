<?php

$arrayNumbers = [
    1,
    2,
    3,
    4,
    4,
    5,
    6
];

foreach (array_count_values($arrayNumbers) as $number => $count) {
    if ($count > 1) {
        echo 'Duplicate number: ' . $number;
    }
}