<?php

// Test basic intl functionality
$formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
$number = 1234.56;
echo "Testing NumberFormatter:\n";
echo $formatter->format($number) . "\n";

echo "\nTesting IntlDateFormatter:\n";
$fmt = new IntlDateFormatter('en_US', IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM);
echo $fmt->format(time()) . "\n";

echo "\nICU Version: " . INTL_ICU_VERSION . "\n";
echo "PHP intl extension version: " . INTL_ICU_DATA_VERSION . "\n";

