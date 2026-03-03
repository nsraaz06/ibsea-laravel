<?php
$backupFile = 'u957624728_ibsea.sql';
$handle = fopen($backupFile, 'r');
if (!$handle) {
    die("Could not open $backupFile\n");
}

$outputHandle = fopen('extracted_roles.sql', 'w');
$isCapture = false;

while (($line = fgets($handle)) !== false) {
    if (preg_match('/^INSERT INTO `member_roles`/', $line)) {
        $isCapture = true;
    }

    if ($isCapture) {
        fwrite($outputHandle, $line);
        if (trim($line) === '' || substr(trim($line), -2) === ');' || substr(trim($line), -1) === ';') {
            $isCapture = false;
        }
    }
}

fclose($handle);
fclose($outputHandle);
echo "Extracted roles to extracted_roles.sql\n";
