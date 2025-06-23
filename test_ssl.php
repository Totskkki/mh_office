<?php
$url = "https://www.google.com";
$result = file_get_contents($url);
if ($result !== false) {
    echo "SSL configuration works!";
} else {
    echo "SSL configuration failed.";
}
