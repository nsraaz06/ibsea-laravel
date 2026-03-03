<?php

echo "<h1>IBSEA System Check</h1>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";

if (version_compare(PHP_VERSION, '8.1.0', '<')) {
    echo "<h3 style='color: red;'>CRITICAL ERROR: Your PHP version is too old!</h3>";
    echo "<p>The project is using dependencies (like <code>brick/math</code>) that require at least <strong>PHP 8.2</strong> because they use Enums.</p>";
    echo "<p>Please upgrade your XAMPP to a version that supports PHP 8.2 or 8.3.</p>";
} else {
    echo "<h3 style='color: green;'>PHP Version is OK.</h3>";
}

echo "<h2>Loaded Extensions</h2>";
echo "<pre>";
print_r(get_loaded_extensions());
echo "</pre>";
