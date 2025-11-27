<?php

// Include Admin Panel
require_once get_template_directory() . '/inc/admin-panel.php';

function puchong_glass_scripts() {
    // Tailwind CSS (Development CDN)
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), '3.4.0', false);
    
    // Lucide Icons
    wp_enqueue_script('lucide', 'https://unpkg.com/lucide@latest', array(), '1.0.0', true);
    
    // Main Styles
    wp_enqueue_style('puchong-glass-style', get_stylesheet_uri());

    // Initialize Lucide
    wp_add_inline_script('lucide', 'lucide.createIcons();');
    
    // Add custom config for Tailwind to match the React theme colors if needed, 
    // but standard Tailwind colors (slate, amber) are standard.
}
add_action('wp_enqueue_scripts', 'puchong_glass_scripts');

function puchong_glass_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'puchong_glass_setup');

// Register Custom Post Types
function puchong_glass_register_cpt() {
    // Services
    register_post_type('service', array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-hammer',
    ));

    // Projects
    register_post_type('project', array(
        'labels' => array(
            'name' => 'Projects',
            'singular_name' => 'Project',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-portfolio',
    ));

    // Project Categories Taxonomy
    register_taxonomy('project_category', 'project', array(
        'labels' => array(
            'name' => 'Project Categories',
            'singular_name' => 'Project Category',
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
    ));
}
add_action('init', 'puchong_glass_register_cpt');

// Seeder Function
function puchong_glass_seed_data() {
    // Check if data already exists to prevent duplicates
    // $existing_services = get_posts(array('post_type' => 'service', 'numberposts' => 1));
    // if (!empty($existing_services)) {
    //    return; // Data likely already seeded
    // }

    // --- Seed Services ---
    $existing_services = get_posts(array('post_type' => 'service', 'numberposts' => 1));
    
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    if (empty($existing_services)) {
        $services_data = [
        [
            'title' => "Aluminium Works",
            'shortDesc' => "Premium grade aluminium profiles.",
            'fullDesc' => "Our aluminium solutions provide the perfect balance of durability and aesthetics. We use high-grade, powder-coated aluminium that resists rust and fading, perfect for the Malaysian climate.",
            'features' => ["Folding & Sliding Doors", "Casement Windows", "Shopfront Facades", "Louvers & Vents", "Sustainable Materials", "Weather Resistant"],
            'image' => "https://images.unsplash.com/photo-1600607686527-6fb886090705?auto=format&fit=crop&q=80",
            'icon' => 'layers'
        ],
        [
            'title' => "Security Grills",
            'shortDesc' => "High-tensile modern security grills.",
            'fullDesc' => "Safety doesn't have to look like a cage. Our modern security grills are designed to blend seamlessly with your home's architecture while providing maximum protection against intruders.",
            'features' => ["Window & Door Grills", "Wrought Iron Gates", "Balcony Railings", "Staircase Handrails", "Custom Geometric Patterns", "Anti-Climb Design"],
            'image' => "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80",
            'icon' => 'shield-check'
        ],
        [
            'title' => "Glass Solutions",
            'shortDesc' => "Elegance with tempered glass.",
            'fullDesc' => "Transform your space with light. We specialize in frameless glass structures, shower screens, and partitions that create an open, airy feel while maintaining safety standards.",
            'features' => ["Shower Screens", "Glass Partitions", "Tempered Glass Doors", "Mirrors & Skylights", "Laminated Safety Glass", "Sound Proofing Options"],
            'image' => "https://images.unsplash.com/photo-1502005229762-cf1b2da7c5d6?auto=format&fit=crop&q=80",
            'icon' => 'image'
        ],
        [
            'title' => "Renovation",
            'shortDesc' => "Complete home upgrades.",
            'fullDesc' => "Beyond glass and metal, we assist in holistic home renovation. From plaster ceilings to kitchen extensions, our team ensures your entire renovation project runs smoothly.",
            'features' => ["Plaster Ceilings", "Kitchen Cabinetry", "Polycarbonate Awnings", "Custom Fabrication", "Wet Works", "Tiling Services"],
            'image' => "https://images.unsplash.com/photo-1484154218962-a1c002085d2f?auto=format&fit=crop&q=80",
            'icon' => 'home'
        ]
    ];

    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    foreach ($services_data as $service) {
        $post_id = wp_insert_post(array(
            'post_title' => $service['title'],
            'post_content' => $service['fullDesc'],
            'post_excerpt' => $service['shortDesc'],
            'post_type' => 'service',
            'post_status' => 'publish',
        ));

        if ($post_id) {
            update_post_meta($post_id, 'features', $service['features']); // Store as array, will be serialized
            update_post_meta($post_id, 'icon_name', $service['icon']);
            
            // Sideload Image
            $image_url = $service['image'];
            $image_desc = $service['title'];
            $file_array = array();
            $tmp = download_url($image_url);
            if (!is_wp_error($tmp)) {
                $file_array['name'] = basename($image_url) . '.jpg'; // Append extension if needed or parse it
                $file_array['tmp_name'] = $tmp;
                $id = media_handle_sideload($file_array, $post_id, $image_desc);
                if (!is_wp_error($id)) {
                    set_post_thumbnail($post_id, $id);
                }
                @unlink($file_array['tmp_name']);
            }
        }
    }
    } // End if empty existing services

    // --- Seed Projects ---
    $projects_data = [
        [ 
            'cat' => 'Aluminium', 
            'title' => 'Modern Folding Doors', 
            'location' => 'Bandar Puteri, Puchong',
            'date' => 'Oct 2023',
            'client' => 'Mr. Tan Residence',
            'desc' => 'Installation of a 12-foot heavy-duty aluminium bi-fold door system connecting the living room to the garden patio. Features powder-coated matte black finish and 10mm tempered glass.',
            'specs' => ['Material: Aluminium Grade 6063', 'Glass: 10mm Tempered Green', 'Finish: Matte Black Powder Coat'],
            'image' => 'https://images.unsplash.com/photo-1600607686527-6fb886090705?auto=format&fit=crop&q=80'
        ],
        [ 
            'cat' => 'Glass', 
            'title' => 'Office Partition System', 
            'location' => 'IOI Boulevard',
            'date' => 'Sept 2023',
            'client' => 'TechStart Office',
            'desc' => 'Frameless glass partition system for a modern open-plan office. Includes frosted privacy bands and heavy-duty floor springs for the main entrance door.',
            'specs' => ['Glass: 12mm Tempered Clear', 'Hardware: Stainless Steel 304', 'Height: 10ft Floor to Ceiling'],
            'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80'
        ],
        [ 
            'cat' => 'Grill', 
            'title' => 'Safety Security Grills', 
            'location' => 'Kinrara Residence',
            'date' => 'Aug 2023',
            'client' => 'Mrs. Sarah',
            'desc' => 'Full house security grill installation for a 2-storey terrace. Design focuses on horizontal bars for a modern, minimalist look that is easy to clean and highly secure.',
            'specs' => ['Material: Mild Steel', 'Finish: Gloss White Paint', 'Locking: Deadbolt System'],
            'image' => 'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?auto=format&fit=crop&q=80'
        ],
        [ 
            'cat' => 'Glass', 
            'title' => 'Luxury Shower Screen', 
            'location' => 'Puchong Utama',
            'date' => 'Nov 2023',
            'client' => 'Residential Unit',
            'desc' => 'Wall-to-wall sliding shower screen with black frame detailing. Creating a dry/wet separation in a master bathroom renovation.',
            'specs' => ['Glass: 10mm Tempered', 'Frame: Black Aluminium', 'Mechanism: Soft Close Rollers'],
            'image' => 'https://images.unsplash.com/photo-1584622050111-993a426fbf0a?auto=format&fit=crop&q=80'
        ],
        [ 
            'cat' => 'Aluminium', 
            'title' => 'Shopfront Facade', 
            'location' => 'SetiaWalk',
            'date' => 'July 2023',
            'client' => 'Retail Boutique',
            'desc' => 'Complete shopfront revamp including composite panel cladding and a large frameless glass display window.',
            'specs' => ['Cladding: 4mm Aluminium Composite', 'Glass: Laminated Safety Glass', 'Signage: Integrated Backlight'],
            'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&q=80'
        ],
        [ 
            'cat' => 'Renovation', 
            'title' => 'Polycarbonate Awning', 
            'location' => 'Bukit Puchong',
            'date' => 'June 2023',
            'client' => 'Semi-D House',
            'desc' => 'Extended car porch coverage using solid polycarbonate sheets with a timber-grain aluminium frame structure.',
            'specs' => ['Roof: 3mm Solid Polycarbonate', 'Frame: Aluminium 4x4 Hollow', 'UV Protection: 99%'],
            'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&q=80'
        ]
    ];

    foreach ($projects_data as $project) {
        $post_id = wp_insert_post(array(
            'post_title' => $project['title'],
            'post_content' => $project['desc'],
            'post_type' => 'project',
            'post_status' => 'publish',
        ));

        if ($post_id) {
            update_post_meta($post_id, 'location', $project['location']);
            update_post_meta($post_id, 'project_date', $project['date']);
            update_post_meta($post_id, 'client', $project['client']);
            update_post_meta($post_id, 'specs', $project['specs']);
            
            // Set Category
            wp_set_object_terms($post_id, $project['cat'], 'project_category');

            // Sideload Image
            $image_url = $project['image'];
            $image_desc = $project['title'];
            $file_array = array();
            $tmp = download_url($image_url);
            if (!is_wp_error($tmp)) {
                $file_array['name'] = basename($image_url) . '.jpg';
                $file_array['tmp_name'] = $tmp;
                $id = media_handle_sideload($file_array, $post_id, $image_desc);
                if (!is_wp_error($id)) {
                    set_post_thumbnail($post_id, $id);
                }
                @unlink($file_array['tmp_name']);
            }
        }
    }

    // --- Seed Pages ---
    $pages_data = [
        'Services' => 'page-services.php',
        'Gallery' => 'page-gallery.php',
        'Why Us' => 'page-why-us.php',
        'Contact' => 'page-contact.php'
    ];

    foreach ($pages_data as $title => $template) {
        $page_check = get_page_by_title($title);
        $page_id = null;
        
        if (!isset($page_check->ID)) {
            $page_id = wp_insert_post(array(
                'post_title' => $title,
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_content' => ''
            ));
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $template);
            }
        } else {
            $page_id = $page_check->ID;
            // Ensure template is set even if page exists
            update_post_meta($page_id, '_wp_page_template', $template);
            // Ensure it's published
            if ($page_check->post_status != 'publish') {
                wp_update_post(array('ID' => $page_id, 'post_status' => 'publish'));
            }
        }
    }

    // Set Home Page
    $home_page = get_page_by_title('Home');
    if (!$home_page) {
        $home_page_id = wp_insert_post(array(
            'post_title' => 'Home',
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_content' => ''
        ));
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    } else {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page->ID);
    }
    
    // Set Permalinks to Post Name
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'puchong_glass_seed_data');
// Also run on init if we want to force it for development, but switch_theme is safer for production.
// For this user request, I'll add a temporary check to run it if no posts exist.
add_action('init', function() {
    if (isset($_GET['seed_data']) && $_GET['seed_data'] == '1') {
        puchong_glass_seed_data();
    }
});
