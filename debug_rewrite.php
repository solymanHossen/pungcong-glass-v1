<?php
require_once('wp-load.php');

$url = isset($_GET['url']) ? $_GET['url'] : '/services';
echo "Testing URL: " . $url . "\n";

global $wp_rewrite;
$rewrite_rules = $wp_rewrite->wp_rewrite_rules();

echo "<h2>Rewrite Rules Matching '$url'</h2>";
$found = false;
foreach ($rewrite_rules as $pattern => $query) {
    if (preg_match("#^$pattern#", ltrim($url, '/'))) {
        echo "Matched Rule: $pattern => $query<br>";
        $found = true;
    }
}

if (!$found) {
    echo "No matching rewrite rules found.<br>";
}

echo "<h2>Page Check</h2>";
$page = get_page_by_path('services');
if ($page) {
    echo "Page 'services' found. ID: " . $page->ID . "<br>";
    echo "Template: " . get_post_meta($page->ID, '_wp_page_template', true) . "<br>";
} else {
    echo "Page 'services' NOT found.<br>";
}

echo "<h2>Request Analysis</h2>";
$wp = new WP();
$wp->parse_request();
echo "Query Vars:<br>";
print_r($wp->query_vars);

echo "<h2>Template Hierarchy</h2>";
// Simulate template loading
if ($page) {
    $template = get_page_template_slug($page->ID);
    echo "Assigned Template Slug: " . $template . "<br>";
}
