<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

echo "Starting Seeder...\n";

if (function_exists('puchong_glass_seed_data')) {
    puchong_glass_seed_data();
    echo "Seeder function executed.\n";
} else {
    echo "Error: Seeder function not found.\n";
    exit(1);
}

echo "Checking Pages:\n";
$pages = ['Home', 'Services', 'Gallery', 'Why Us', 'Contact'];
foreach ($pages as $p) {
    $page = get_page_by_title($p);
    if ($page) {
        echo "[OK] Page '$p' exists (ID: {$page->ID}, Status: {$page->post_status})\n";
        $tmpl = get_post_meta($page->ID, '_wp_page_template', true);
        echo "     Template: $tmpl\n";
    } else {
        echo "[FAIL] Page '$p' NOT found.\n";
    }
}

echo "Checking Permalinks:\n";
echo "Structure: " . get_option('permalink_structure') . "\n";

echo "Done.\n";
