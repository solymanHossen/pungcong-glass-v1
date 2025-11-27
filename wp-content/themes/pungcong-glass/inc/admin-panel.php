<?php
/**
 * Puchong Glass - Modern Admin Panel
 * Comprehensive admin management system
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Puchong_Glass_Admin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_ajax_puchong_submit_contact', array($this, 'save_contact_submission'));
        add_action('wp_ajax_nopriv_puchong_submit_contact', array($this, 'save_contact_submission'));
        add_action('wp_ajax_puchong_delete_contact', array($this, 'delete_contact'));
        add_action('wp_ajax_puchong_mark_contact_read', array($this, 'mark_contact_read'));
        add_action('wp_ajax_puchong_save_why_us', array($this, 'save_why_us_settings'));
        add_action('wp_ajax_puchong_upload_gallery', array($this, 'upload_gallery_image'));
        add_action('wp_ajax_puchong_delete_gallery', array($this, 'delete_gallery_image'));
        
        // Create database tables on theme activation
        add_action('after_switch_theme', array($this, 'create_tables'));
        
        // Initialize tables if not exist
        $this->maybe_create_tables();
    }
    
    /**
     * Create custom database tables
     */
    public function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        // Contact submissions table
        $contacts_table = $wpdb->prefix . 'puchong_contacts';
        $sql_contacts = "CREATE TABLE IF NOT EXISTS $contacts_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            phone varchar(50) NOT NULL,
            email varchar(255) DEFAULT '',
            service varchar(255) NOT NULL,
            message text NOT NULL,
            is_read tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Gallery table
        $gallery_table = $wpdb->prefix . 'puchong_gallery';
        $sql_gallery = "CREATE TABLE IF NOT EXISTS $gallery_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            image_id bigint(20) NOT NULL,
            title varchar(255) DEFAULT '',
            category varchar(100) DEFAULT 'general',
            display_order int(11) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_contacts);
        dbDelta($sql_gallery);
    }
    
    public function maybe_create_tables() {
        global $wpdb;
        $contacts_table = $wpdb->prefix . 'puchong_contacts';
        if ($wpdb->get_var("SHOW TABLES LIKE '$contacts_table'") != $contacts_table) {
            $this->create_tables();
        }
    }
    
    /**
     * Add admin menu pages
     */
    public function add_admin_menu() {
        // Main menu
        add_menu_page(
            'Puchong Glass',
            'Puchong Glass',
            'manage_options',
            'puchong-glass',
            array($this, 'render_dashboard'),
            'dashicons-building',
            30
        );
        
        // Dashboard
        add_submenu_page(
            'puchong-glass',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'puchong-glass',
            array($this, 'render_dashboard')
        );
        
        // Services
        add_submenu_page(
            'puchong-glass',
            'Manage Services',
            'Services',
            'manage_options',
            'puchong-services',
            array($this, 'render_services_page')
        );
        
        // Projects
        add_submenu_page(
            'puchong-glass',
            'Manage Projects',
            'Projects',
            'manage_options',
            'puchong-projects',
            array($this, 'render_projects_page')
        );
        
        // Gallery
        add_submenu_page(
            'puchong-glass',
            'Photo Gallery',
            'Gallery',
            'manage_options',
            'puchong-gallery',
            array($this, 'render_gallery_page')
        );
        
        // Why Choose Us
        add_submenu_page(
            'puchong-glass',
            'Why Choose Us',
            'Why Choose Us',
            'manage_options',
            'puchong-why-us',
            array($this, 'render_why_us_page')
        );
        
        // Contact Submissions
        add_submenu_page(
            'puchong-glass',
            'Contact Messages',
            'Contact Messages',
            'manage_options',
            'puchong-contacts',
            array($this, 'render_contacts_page')
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our admin pages
        if (strpos($hook, 'puchong') === false) {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_style('puchong-admin-style', get_template_directory_uri() . '/inc/admin-style.css', array(), '1.0.0');
        wp_enqueue_script('puchong-admin-script', get_template_directory_uri() . '/inc/admin-script.js', array('jquery'), '1.0.0', true);
        
        wp_localize_script('puchong-admin-script', 'puchongAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('puchong_admin_nonce')
        ));
    }
    
    /**
     * Get unread contacts count
     */
    private function get_unread_count() {
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_contacts';
        return (int) $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE is_read = 0");
    }
    
    /**
     * Render Dashboard
     */
    public function render_dashboard() {
        $services_count = wp_count_posts('service')->publish;
        $projects_count = wp_count_posts('project')->publish;
        $unread_contacts = $this->get_unread_count();
        
        global $wpdb;
        $gallery_table = $wpdb->prefix . 'puchong_gallery';
        $gallery_count = (int) $wpdb->get_var("SELECT COUNT(*) FROM $gallery_table");
        
        // Recent contacts
        $contacts_table = $wpdb->prefix . 'puchong_contacts';
        $recent_contacts = $wpdb->get_results("SELECT * FROM $contacts_table ORDER BY created_at DESC LIMIT 5");
        ?>
        <div class="puchong-admin-wrap">
            <div class="puchong-admin-header">
                <div class="puchong-header-content">
                    <h1><span class="dashicons dashicons-building"></span> Puchong Glass Dashboard</h1>
                    <p>Welcome to your business management panel</p>
                </div>
                <div class="puchong-header-actions">
                    <span class="puchong-date"><?php echo date('l, F j, Y'); ?></span>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="puchong-stats-grid">
                <div class="puchong-stat-card stat-services">
                    <div class="stat-icon"><span class="dashicons dashicons-hammer"></span></div>
                    <div class="stat-content">
                        <h3><?php echo $services_count; ?></h3>
                        <p>Services</p>
                    </div>
                    <a href="<?php echo admin_url('admin.php?page=puchong-services'); ?>" class="stat-link">Manage →</a>
                </div>
                
                <div class="puchong-stat-card stat-projects">
                    <div class="stat-icon"><span class="dashicons dashicons-portfolio"></span></div>
                    <div class="stat-content">
                        <h3><?php echo $projects_count; ?></h3>
                        <p>Projects</p>
                    </div>
                    <a href="<?php echo admin_url('admin.php?page=puchong-projects'); ?>" class="stat-link">Manage →</a>
                </div>
                
                <div class="puchong-stat-card stat-gallery">
                    <div class="stat-icon"><span class="dashicons dashicons-format-gallery"></span></div>
                    <div class="stat-content">
                        <h3><?php echo $gallery_count; ?></h3>
                        <p>Gallery Photos</p>
                    </div>
                    <a href="<?php echo admin_url('admin.php?page=puchong-gallery'); ?>" class="stat-link">Manage →</a>
                </div>
                
                <div class="puchong-stat-card stat-contacts <?php echo $unread_contacts > 0 ? 'has-unread' : ''; ?>">
                    <div class="stat-icon"><span class="dashicons dashicons-email"></span></div>
                    <div class="stat-content">
                        <h3><?php echo $unread_contacts; ?></h3>
                        <p>New Messages</p>
                    </div>
                    <a href="<?php echo admin_url('admin.php?page=puchong-contacts'); ?>" class="stat-link">View All →</a>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="puchong-section">
                <h2><span class="dashicons dashicons-plus-alt"></span> Quick Actions</h2>
                <div class="puchong-quick-actions">
                    <a href="<?php echo admin_url('post-new.php?post_type=service'); ?>" class="quick-action-btn">
                        <span class="dashicons dashicons-hammer"></span>
                        Add New Service
                    </a>
                    <a href="<?php echo admin_url('post-new.php?post_type=project'); ?>" class="quick-action-btn">
                        <span class="dashicons dashicons-portfolio"></span>
                        Add New Project
                    </a>
                    <a href="<?php echo admin_url('admin.php?page=puchong-gallery'); ?>" class="quick-action-btn">
                        <span class="dashicons dashicons-format-gallery"></span>
                        Upload Photos
                    </a>
                    <a href="<?php echo home_url(); ?>" class="quick-action-btn" target="_blank">
                        <span class="dashicons dashicons-external"></span>
                        View Website
                    </a>
                </div>
            </div>
            
            <!-- Recent Messages -->
            <div class="puchong-section">
                <div class="section-header">
                    <h2><span class="dashicons dashicons-email-alt"></span> Recent Contact Messages</h2>
                    <a href="<?php echo admin_url('admin.php?page=puchong-contacts'); ?>" class="view-all-link">View All Messages</a>
                </div>
                
                <?php if ($recent_contacts) : ?>
                <div class="puchong-messages-list">
                    <?php foreach ($recent_contacts as $contact) : ?>
                    <div class="message-item <?php echo !$contact->is_read ? 'unread' : ''; ?>">
                        <div class="message-avatar">
                            <?php echo strtoupper(substr($contact->name, 0, 1)); ?>
                        </div>
                        <div class="message-content">
                            <div class="message-header">
                                <strong><?php echo esc_html($contact->name); ?></strong>
                                <span class="message-service"><?php echo esc_html($contact->service); ?></span>
                            </div>
                            <p class="message-preview"><?php echo esc_html(wp_trim_words($contact->message, 15)); ?></p>
                            <span class="message-time"><?php echo human_time_diff(strtotime($contact->created_at), current_time('timestamp')) . ' ago'; ?></span>
                        </div>
                        <?php if (!$contact->is_read) : ?>
                        <span class="unread-badge">New</span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <div class="puchong-empty-state">
                    <span class="dashicons dashicons-email"></span>
                    <p>No contact messages yet</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Services Page
     */
    public function render_services_page() {
        $services = get_posts(array(
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'ASC'
        ));
        ?>
        <div class="puchong-admin-wrap">
            <div class="puchong-admin-header">
                <div class="puchong-header-content">
                    <h1><span class="dashicons dashicons-hammer"></span> Manage Services</h1>
                    <p>Add, edit, and manage your service offerings</p>
                </div>
                <div class="puchong-header-actions">
                    <a href="<?php echo admin_url('post-new.php?post_type=service'); ?>" class="puchong-btn puchong-btn-primary">
                        <span class="dashicons dashicons-plus"></span> Add New Service
                    </a>
                </div>
            </div>
            
            <div class="puchong-section">
                <?php if ($services) : ?>
                <div class="puchong-services-grid">
                    <?php foreach ($services as $service) : 
                        $image = get_the_post_thumbnail_url($service->ID, 'medium');
                        $icon = get_post_meta($service->ID, 'icon_name', true);
                        $features = get_post_meta($service->ID, 'features', true);
                    ?>
                    <div class="puchong-service-card">
                        <div class="service-image" style="background-image: url('<?php echo $image ? $image : 'https://via.placeholder.com/400x200'; ?>')">
                            <div class="service-overlay">
                                <a href="<?php echo get_edit_post_link($service->ID); ?>" class="service-action-btn">
                                    <span class="dashicons dashicons-edit"></span>
                                </a>
                                <a href="<?php echo get_permalink($service->ID); ?>" class="service-action-btn" target="_blank">
                                    <span class="dashicons dashicons-visibility"></span>
                                </a>
                            </div>
                        </div>
                        <div class="service-details">
                            <div class="service-icon">
                                <span class="dashicons dashicons-<?php echo $icon ? $icon : 'admin-generic'; ?>"></span>
                            </div>
                            <h3><?php echo esc_html($service->post_title); ?></h3>
                            <p><?php echo esc_html(wp_trim_words($service->post_content, 15)); ?></p>
                            <?php if ($features && is_array($features)) : ?>
                            <div class="service-features-count">
                                <span class="dashicons dashicons-yes-alt"></span> <?php echo count($features); ?> Features
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <div class="puchong-empty-state">
                    <span class="dashicons dashicons-hammer"></span>
                    <h3>No Services Yet</h3>
                    <p>Start by adding your first service</p>
                    <a href="<?php echo admin_url('post-new.php?post_type=service'); ?>" class="puchong-btn puchong-btn-primary">Add Service</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Projects Page
     */
    public function render_projects_page() {
        $projects = get_posts(array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        $categories = get_terms(array(
            'taxonomy' => 'project_category',
            'hide_empty' => false
        ));
        ?>
        <div class="puchong-admin-wrap">
            <div class="puchong-admin-header">
                <div class="puchong-header-content">
                    <h1><span class="dashicons dashicons-portfolio"></span> Manage Projects</h1>
                    <p>Showcase your completed projects</p>
                </div>
                <div class="puchong-header-actions">
                    <a href="<?php echo admin_url('post-new.php?post_type=project'); ?>" class="puchong-btn puchong-btn-primary">
                        <span class="dashicons dashicons-plus"></span> Add New Project
                    </a>
                </div>
            </div>
            
            <!-- Category Filter -->
            <?php if ($categories && !is_wp_error($categories)) : ?>
            <div class="puchong-filter-bar">
                <span class="filter-label">Filter by Category:</span>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <?php foreach ($categories as $cat) : ?>
                    <button class="filter-btn" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="puchong-section">
                <?php if ($projects) : ?>
                <div class="puchong-projects-grid">
                    <?php foreach ($projects as $project) : 
                        $image = get_the_post_thumbnail_url($project->ID, 'medium');
                        $location = get_post_meta($project->ID, 'location', true);
                        $date = get_post_meta($project->ID, 'project_date', true);
                        $cats = get_the_terms($project->ID, 'project_category');
                        $cat_slug = $cats && !is_wp_error($cats) ? $cats[0]->slug : '';
                        $cat_name = $cats && !is_wp_error($cats) ? $cats[0]->name : 'Uncategorized';
                    ?>
                    <div class="puchong-project-card" data-category="<?php echo esc_attr($cat_slug); ?>">
                        <div class="project-image" style="background-image: url('<?php echo $image ? $image : 'https://via.placeholder.com/400x300'; ?>')">
                            <span class="project-category"><?php echo esc_html($cat_name); ?></span>
                            <div class="project-overlay">
                                <a href="<?php echo get_edit_post_link($project->ID); ?>" class="project-action-btn">
                                    <span class="dashicons dashicons-edit"></span>
                                </a>
                                <a href="<?php echo get_permalink($project->ID); ?>" class="project-action-btn" target="_blank">
                                    <span class="dashicons dashicons-visibility"></span>
                                </a>
                                <a href="<?php echo get_delete_post_link($project->ID); ?>" class="project-action-btn delete" onclick="return confirm('Are you sure?')">
                                    <span class="dashicons dashicons-trash"></span>
                                </a>
                            </div>
                        </div>
                        <div class="project-details">
                            <h3><?php echo esc_html($project->post_title); ?></h3>
                            <div class="project-meta">
                                <?php if ($location) : ?>
                                <span><span class="dashicons dashicons-location"></span> <?php echo esc_html($location); ?></span>
                                <?php endif; ?>
                                <?php if ($date) : ?>
                                <span><span class="dashicons dashicons-calendar"></span> <?php echo esc_html($date); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <div class="puchong-empty-state">
                    <span class="dashicons dashicons-portfolio"></span>
                    <h3>No Projects Yet</h3>
                    <p>Start showcasing your work</p>
                    <a href="<?php echo admin_url('post-new.php?post_type=project'); ?>" class="puchong-btn puchong-btn-primary">Add Project</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Gallery Page
     */
    public function render_gallery_page() {
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_gallery';
        $images = $wpdb->get_results("SELECT * FROM $table ORDER BY display_order ASC, created_at DESC");
        ?>
        <div class="puchong-admin-wrap">
            <div class="puchong-admin-header">
                <div class="puchong-header-content">
                    <h1><span class="dashicons dashicons-format-gallery"></span> Photo Gallery</h1>
                    <p>Manage your gallery images</p>
                </div>
            </div>
            
            <!-- Upload Section -->
            <div class="puchong-section">
                <div class="puchong-upload-area" id="gallery-upload-area">
                    <div class="upload-content">
                        <span class="dashicons dashicons-cloud-upload"></span>
                        <h3>Upload Gallery Images</h3>
                        <p>Click to select images or drag and drop</p>
                        <button type="button" class="puchong-btn puchong-btn-primary" id="upload-gallery-btn">
                            <span class="dashicons dashicons-plus"></span> Select Images
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Gallery Grid -->
            <div class="puchong-section">
                <h2>Gallery Images (<?php echo count($images); ?>)</h2>
                
                <?php if ($images) : ?>
                <div class="puchong-gallery-grid" id="gallery-grid">
                    <?php foreach ($images as $img) : 
                        $image_url = wp_get_attachment_image_url($img->image_id, 'medium');
                        $full_url = wp_get_attachment_image_url($img->image_id, 'full');
                    ?>
                    <div class="puchong-gallery-item" data-id="<?php echo $img->id; ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($img->title); ?>">
                        <div class="gallery-item-overlay">
                            <input type="text" class="gallery-title-input" placeholder="Image title" value="<?php echo esc_attr($img->title); ?>">
                            <div class="gallery-actions">
                                <a href="<?php echo esc_url($full_url); ?>" target="_blank" class="gallery-action-btn view">
                                    <span class="dashicons dashicons-visibility"></span>
                                </a>
                                <button type="button" class="gallery-action-btn delete" data-id="<?php echo $img->id; ?>">
                                    <span class="dashicons dashicons-trash"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <div class="puchong-empty-state">
                    <span class="dashicons dashicons-format-gallery"></span>
                    <h3>No Gallery Images</h3>
                    <p>Upload some images to display in your gallery</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Why Choose Us Page
     */
    public function render_why_us_page() {
        $why_us_data = get_option('puchong_why_us', array(
            'tagline' => 'The Puchong Glass Standard',
            'title' => 'Why We Lead The Industry',
            'description' => 'We don\'t just build; we engineer solutions. With over 15 years of experience in Puchong, we combine traditional craftsmanship with modern technology.',
            'features' => array(
                array('title' => 'Direct Factory Fabrication', 'description' => 'No middle-men. We fabricate everything in our Puchong workshop.'),
                array('title' => 'Premium Material Guarantee', 'description' => 'We only use certified grade aluminium and impact-resistant tempered glass.'),
                array('title' => 'On-Time Delivery', 'description' => 'Your time is valuable. We stick to the schedule we promise.')
            ),
            'stats' => array(
                array('number' => '15+', 'label' => 'Years Experience'),
                array('number' => '500+', 'label' => 'Happy Homes')
            )
        ));
        ?>
        <div class="puchong-admin-wrap">
            <div class="puchong-admin-header">
                <div class="puchong-header-content">
                    <h1><span class="dashicons dashicons-star-filled"></span> Why Choose Us</h1>
                    <p>Customize your "Why Choose Us" section content</p>
                </div>
            </div>
            
            <form id="why-us-form" class="puchong-form">
                <?php wp_nonce_field('puchong_why_us_nonce', 'why_us_nonce'); ?>
                
                <div class="puchong-section">
                    <h2>Section Header</h2>
                    <div class="puchong-form-row">
                        <div class="puchong-form-group">
                            <label>Tagline</label>
                            <input type="text" name="tagline" value="<?php echo esc_attr($why_us_data['tagline']); ?>" placeholder="e.g., The Puchong Glass Standard">
                        </div>
                        <div class="puchong-form-group">
                            <label>Main Title</label>
                            <input type="text" name="title" value="<?php echo esc_attr($why_us_data['title']); ?>" placeholder="e.g., Why We Lead The Industry">
                        </div>
                    </div>
                    <div class="puchong-form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" placeholder="Enter description..."><?php echo esc_textarea($why_us_data['description']); ?></textarea>
                    </div>
                </div>
                
                <div class="puchong-section">
                    <h2>Key Features</h2>
                    <div id="features-container">
                        <?php foreach ($why_us_data['features'] as $i => $feature) : ?>
                        <div class="feature-row">
                            <div class="puchong-form-row">
                                <div class="puchong-form-group">
                                    <label>Feature Title</label>
                                    <input type="text" name="features[<?php echo $i; ?>][title]" value="<?php echo esc_attr($feature['title']); ?>">
                                </div>
                                <div class="puchong-form-group">
                                    <label>Description</label>
                                    <input type="text" name="features[<?php echo $i; ?>][description]" value="<?php echo esc_attr($feature['description']); ?>">
                                </div>
                                <button type="button" class="remove-feature-btn"><span class="dashicons dashicons-no-alt"></span></button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="puchong-btn puchong-btn-secondary" id="add-feature-btn">
                        <span class="dashicons dashicons-plus"></span> Add Feature
                    </button>
                </div>
                
                <div class="puchong-section">
                    <h2>Statistics</h2>
                    <div id="stats-container">
                        <?php foreach ($why_us_data['stats'] as $i => $stat) : ?>
                        <div class="stat-row">
                            <div class="puchong-form-row">
                                <div class="puchong-form-group" style="max-width: 150px;">
                                    <label>Number</label>
                                    <input type="text" name="stats[<?php echo $i; ?>][number]" value="<?php echo esc_attr($stat['number']); ?>" placeholder="e.g., 15+">
                                </div>
                                <div class="puchong-form-group">
                                    <label>Label</label>
                                    <input type="text" name="stats[<?php echo $i; ?>][label]" value="<?php echo esc_attr($stat['label']); ?>" placeholder="e.g., Years Experience">
                                </div>
                                <button type="button" class="remove-stat-btn"><span class="dashicons dashicons-no-alt"></span></button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="puchong-btn puchong-btn-secondary" id="add-stat-btn">
                        <span class="dashicons dashicons-plus"></span> Add Statistic
                    </button>
                </div>
                
                <div class="puchong-form-actions">
                    <button type="submit" class="puchong-btn puchong-btn-primary puchong-btn-large">
                        <span class="dashicons dashicons-saved"></span> Save Changes
                    </button>
                </div>
            </form>
        </div>
        <?php
    }
    
    /**
     * Render Contacts Page
     */
    public function render_contacts_page() {
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_contacts';
        $contacts = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
        $unread_count = $this->get_unread_count();
        ?>
        <div class="puchong-admin-wrap">
            <div class="puchong-admin-header">
                <div class="puchong-header-content">
                    <h1><span class="dashicons dashicons-email-alt"></span> Contact Messages</h1>
                    <p>View and manage customer inquiries</p>
                </div>
                <?php if ($unread_count > 0) : ?>
                <div class="puchong-header-badge">
                    <?php echo $unread_count; ?> Unread
                </div>
                <?php endif; ?>
            </div>
            
            <div class="puchong-section">
                <?php if ($contacts) : ?>
                <div class="puchong-contacts-table-wrap">
                    <table class="puchong-contacts-table">
                        <thead>
                            <tr>
                                <th width="5%">Status</th>
                                <th width="15%">Name</th>
                                <th width="12%">Phone</th>
                                <th width="15%">Service</th>
                                <th width="35%">Message</th>
                                <th width="10%">Date</th>
                                <th width="8%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact) : ?>
                            <tr class="<?php echo !$contact->is_read ? 'unread' : ''; ?>" data-id="<?php echo $contact->id; ?>">
                                <td>
                                    <?php if (!$contact->is_read) : ?>
                                    <span class="status-badge new">New</span>
                                    <?php else : ?>
                                    <span class="status-badge read">Read</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo esc_html($contact->name); ?></strong>
                                    <?php if ($contact->email) : ?>
                                    <br><small><?php echo esc_html($contact->email); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="tel:<?php echo esc_attr($contact->phone); ?>" class="phone-link">
                                        <?php echo esc_html($contact->phone); ?>
                                    </a>
                                </td>
                                <td><span class="service-tag"><?php echo esc_html($contact->service); ?></span></td>
                                <td>
                                    <div class="message-text"><?php echo esc_html($contact->message); ?></div>
                                </td>
                                <td>
                                    <span class="date-text"><?php echo date('M j, Y', strtotime($contact->created_at)); ?></span>
                                    <br><small><?php echo date('g:i A', strtotime($contact->created_at)); ?></small>
                                </td>
                                <td>
                                    <div class="contact-actions">
                                        <?php if (!$contact->is_read) : ?>
                                        <button type="button" class="contact-action-btn mark-read" data-id="<?php echo $contact->id; ?>" title="Mark as Read">
                                            <span class="dashicons dashicons-yes"></span>
                                        </button>
                                        <?php endif; ?>
                                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $contact->phone); ?>" target="_blank" class="contact-action-btn whatsapp" title="Reply via WhatsApp">
                                            <span class="dashicons dashicons-whatsapp"></span>
                                        </a>
                                        <button type="button" class="contact-action-btn delete" data-id="<?php echo $contact->id; ?>" title="Delete">
                                            <span class="dashicons dashicons-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else : ?>
                <div class="puchong-empty-state">
                    <span class="dashicons dashicons-email"></span>
                    <h3>No Messages Yet</h3>
                    <p>Contact form submissions will appear here</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * AJAX: Save contact submission
     */
    public function save_contact_submission() {
        // For public contact forms, we use a simple referer check instead of strict nonce
        // This allows non-logged-in users to submit the form
        $referer = wp_get_referer();
        if (!$referer || strpos($referer, home_url()) === false) {
            // Also check if nonce is provided (for logged-in users)
            if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'puchong_contact_nonce')) {
                wp_send_json_error('Invalid request source');
            }
        }
        
        // Validate required fields
        if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['message'])) {
            wp_send_json_error('Please fill in all required fields');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_contacts';
        
        $result = $wpdb->insert($table, array(
            'name' => sanitize_text_field($_POST['name']),
            'phone' => sanitize_text_field($_POST['phone']),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'service' => sanitize_text_field($_POST['service'] ?? ''),
            'message' => sanitize_textarea_field($_POST['message']),
            'is_read' => 0,
            'created_at' => current_time('mysql')
        ));
        
        if ($result) {
            wp_send_json_success('Thank you! Your message has been sent successfully. We will contact you soon.');
        } else {
            wp_send_json_error('Failed to save message. Please try again.');
        }
    }
    
    /**
     * AJAX: Delete contact
     */
    public function delete_contact() {
        check_ajax_referer('puchong_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_contacts';
        $id = intval($_POST['id']);
        
        $result = $wpdb->delete($table, array('id' => $id));
        
        if ($result) {
            wp_send_json_success('Deleted successfully');
        } else {
            wp_send_json_error('Failed to delete');
        }
    }
    
    /**
     * AJAX: Mark contact as read
     */
    public function mark_contact_read() {
        check_ajax_referer('puchong_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_contacts';
        $id = intval($_POST['id']);
        
        $result = $wpdb->update($table, array('is_read' => 1), array('id' => $id));
        
        if ($result !== false) {
            wp_send_json_success('Marked as read');
        } else {
            wp_send_json_error('Failed to update');
        }
    }
    
    /**
     * AJAX: Save Why Us settings
     */
    public function save_why_us_settings() {
        check_ajax_referer('puchong_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        $data = array(
            'tagline' => sanitize_text_field($_POST['tagline']),
            'title' => sanitize_text_field($_POST['title']),
            'description' => sanitize_textarea_field($_POST['description']),
            'features' => array(),
            'stats' => array()
        );
        
        if (isset($_POST['features']) && is_array($_POST['features'])) {
            foreach ($_POST['features'] as $feature) {
                $data['features'][] = array(
                    'title' => sanitize_text_field($feature['title']),
                    'description' => sanitize_text_field($feature['description'])
                );
            }
        }
        
        if (isset($_POST['stats']) && is_array($_POST['stats'])) {
            foreach ($_POST['stats'] as $stat) {
                $data['stats'][] = array(
                    'number' => sanitize_text_field($stat['number']),
                    'label' => sanitize_text_field($stat['label'])
                );
            }
        }
        
        update_option('puchong_why_us', $data);
        
        wp_send_json_success('Settings saved successfully!');
    }
    
    /**
     * AJAX: Upload gallery image
     */
    public function upload_gallery_image() {
        check_ajax_referer('puchong_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        $image_id = intval($_POST['image_id']);
        $title = sanitize_text_field($_POST['title'] ?? '');
        $category = sanitize_text_field($_POST['category'] ?? 'general');
        
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_gallery';
        
        $result = $wpdb->insert($table, array(
            'image_id' => $image_id,
            'title' => $title,
            'category' => $category,
            'created_at' => current_time('mysql')
        ));
        
        if ($result) {
            wp_send_json_success(array(
                'id' => $wpdb->insert_id,
                'url' => wp_get_attachment_image_url($image_id, 'medium')
            ));
        } else {
            wp_send_json_error('Failed to add image');
        }
    }
    
    /**
     * AJAX: Delete gallery image
     */
    public function delete_gallery_image() {
        check_ajax_referer('puchong_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'puchong_gallery';
        $id = intval($_POST['id']);
        
        $result = $wpdb->delete($table, array('id' => $id));
        
        if ($result) {
            wp_send_json_success('Deleted successfully');
        } else {
            wp_send_json_error('Failed to delete');
        }
    }
}

// Initialize
Puchong_Glass_Admin::get_instance();
