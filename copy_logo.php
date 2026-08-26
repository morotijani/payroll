<?php
$src = 'C:/Users/user/.gemini/antigravity/brain/17cfaef7-ff51-407f-a263-6315db6af04f/.user_uploaded/media_1787710957106.png';
$dir = __DIR__ . '/public/images';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}
if (copy($src, $dir . '/default_logo.png')) {
    echo 'Default logo copied successfully.';
} else {
    echo 'Failed to copy default logo.';
}
?>
