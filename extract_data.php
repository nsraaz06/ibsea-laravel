<?php
$backupFile = 'u957624728_ibsea.sql';
$targetTables = [
    'chapters',
    'councils',
    'membership_plans',
    'member_roles',
    'members',
    'events',
    'event_tickets',
    'event_bookings',
    'payments',
    'posts'
];

$handle = fopen($backupFile, 'r');
if (!$handle) {
    die("Could not open $backupFile\n");
}

$outputHandle = fopen('extracted_inserts.sql', 'w');
fwrite($outputHandle, "SET FOREIGN_KEY_CHECKS = 0;\n");

$isCapture = false;
while (($line = fgets($handle)) !== false) {
    if (preg_match('/^INSERT INTO `([^`]+)`/', $line, $matches)) {
        if (in_array($matches[1], $targetTables)) {
            $isCapture = true;
        }
    }

    if ($isCapture) {
        fwrite($outputHandle, $line);
        if (trim($line) === '' || substr(trim($line), -1) === ';') {
            $isCapture = false;
        }
    }
}

fwrite($outputHandle, "SET FOREIGN_KEY_CHECKS = 1;\n");
fclose($handle);
fclose($outputHandle);
echo "Extracted inserts to extracted_inserts.sql\n";
