<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

// Switch Theme
switch_theme('pungcong-glass');
echo "Theme switched to Puchong Glass.<br>";

// Run Seeder
if (function_exists('puchong_glass_seed_data')) {
    puchong_glass_seed_data();
    echo "Data seeded successfully.<br>";
} else {
    echo "Seeder function not found. Make sure the theme is active.<br>";
}

echo "Setup complete. <a href='" . home_url() . "'>Go to Home</a>";
