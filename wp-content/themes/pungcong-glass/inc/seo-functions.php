<?php
/**
 * Puchong Glass SEO Functions
 * Modern, Advanced SEO for Malaysia Local Business
 * 
 * Features:
 * - Schema.org Structured Data (LocalBusiness, Service, FAQ, BreadcrumbList)
 * - Open Graph & Twitter Cards
 * - Dynamic Meta Tags
 * - XML Sitemap
 * - Canonical URLs
 * - Malaysia-specific Local SEO
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * =================================================================
 * BUSINESS CONFIGURATION - Edit these for your business
 * =================================================================
 */
function puchong_get_business_info() {
    return array(
        'name' => 'Puchong Glass Aluminium and Grill',
        'legal_name' => 'Puchong Glass Aluminium and Grill Sdn Bhd',
        'description' => 'Premium aluminium, glass, and security grill solutions in Puchong, Selangor, Malaysia. Over 15 years of excellence in architectural installations.',
        'slogan' => 'Precision Glass. Enduring Metal.',
        'url' => home_url('/'),
        'logo' => get_template_directory_uri() . '/assets/images/logo.png',
        'image' => 'https://images.unsplash.com/photo-1600607686527-6fb886090705?auto=format&fit=crop&q=80',
        
        // Contact Information
        'phone' => '+60123456789',
        'phone_display' => '+60 12-345 6789',
        'email' => 'sales@puchongglass.com',
        'whatsapp' => 'https://wa.me/60123456789',
        
        // Address (Malaysia)
        'address' => array(
            'street' => 'Lot 13, Bt 13, Jalan Jurutera, Kampung Seri Aman',
            'city' => 'Puchong',
            'state' => 'Selangor',
            'postal_code' => '47100',
            'country' => 'MY',
            'country_name' => 'Malaysia',
        ),
        
        // Geo Coordinates (Puchong)
        'geo' => array(
            'latitude' => '3.0553752977751996',
            'longitude' => '101.60945761475704',
        ),
        
        // Business Hours
        'opening_hours' => array(
            'Mo-Sa 09:00-18:00',
        ),
        'opening_hours_spec' => array(
            array(
                'days' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
                'opens' => '09:00',
                'closes' => '18:00',
            ),
        ),
        
        // Social Media
        'social' => array(
            'facebook' => 'https://facebook.com/puchongglass',
            'instagram' => 'https://instagram.com/puchongglass',
            'youtube' => '',
        ),
        
        // Price Range
        'price_range' => '$$',
        
        // Service Area (Malaysia Cities)
        'service_areas' => array(
            'Puchong', 'Petaling Jaya', 'Subang Jaya', 'Shah Alam', 
            'Kuala Lumpur', 'Klang', 'Cyberjaya', 'Putrajaya',
            'Selangor', 'Klang Valley'
        ),
        
        // Keywords for Malaysia SEO
        'keywords' => array(
            'aluminium contractor Puchong',
            'glass installation Selangor',
            'security grill Malaysia',
            'shower screen Puchong',
            'aluminium window Klang Valley',
            'glass partition KL',
            'renovation contractor Puchong',
            'tempered glass Malaysia',
        ),
        
        // Languages
        'languages' => array('en', 'ms'),
        'primary_language' => 'en-MY',
    );
}

/**
 * =================================================================
 * META TAGS & TITLE OPTIMIZATION
 * =================================================================
 */
add_filter('pre_get_document_title', 'puchong_custom_title', 10);
function puchong_custom_title($title) {
    $business = puchong_get_business_info();
    $separator = ' | ';
    
    if (is_front_page()) {
        return $business['name'] . $separator . $business['slogan'] . ' - Puchong, Selangor';
    }
    
    if (is_singular('service')) {
        return get_the_title() . ' Services' . $separator . $business['name'] . ' Puchong';
    }
    
    if (is_singular('project')) {
        return get_the_title() . $separator . 'Project Gallery' . $separator . $business['name'];
    }
    
    if (is_page()) {
        return get_the_title() . $separator . $business['name'] . ' - Malaysia';
    }
    
    return $title;
}

/**
 * Add SEO Meta Tags to Head
 */
add_action('wp_head', 'puchong_seo_meta_tags', 1);
function puchong_seo_meta_tags() {
    $business = puchong_get_business_info();
    
    // Get page-specific data
    $meta_description = puchong_get_meta_description();
    $meta_keywords = implode(', ', $business['keywords']);
    $canonical_url = puchong_get_canonical_url();
    $og_image = puchong_get_og_image();
    $og_title = wp_get_document_title();
    
    ?>
    <!-- SEO Meta Tags - Puchong Glass -->
    <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
    <meta name="keywords" content="<?php echo esc_attr($meta_keywords); ?>">
    <meta name="author" content="<?php echo esc_attr($business['name']); ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow">
    
    <!-- Geo Tags for Malaysia Local SEO -->
    <meta name="geo.region" content="MY-10">
    <meta name="geo.placename" content="<?php echo esc_attr($business['address']['city']); ?>, <?php echo esc_attr($business['address']['state']); ?>">
    <meta name="geo.position" content="<?php echo esc_attr($business['geo']['latitude']); ?>;<?php echo esc_attr($business['geo']['longitude']); ?>">
    <meta name="ICBM" content="<?php echo esc_attr($business['geo']['latitude']); ?>, <?php echo esc_attr($business['geo']['longitude']); ?>">
    
    <!-- Language & Locale -->
    <meta name="language" content="English">
    <meta http-equiv="content-language" content="en-MY">
    <link rel="alternate" hreflang="en-MY" href="<?php echo esc_url($canonical_url); ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo esc_url($canonical_url); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url($canonical_url); ?>">
    
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:url" content="<?php echo esc_url($canonical_url); ?>">
    <meta property="og:title" content="<?php echo esc_attr($og_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($meta_description); ?>">
    <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="<?php echo esc_attr($business['name']); ?>">
    <meta property="og:locale" content="en_MY">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($og_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($meta_description); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
    
    <!-- Mobile & PWA -->
    <meta name="theme-color" content="#d97706">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Puchong Glass">
    
    <!-- Verification (Add your codes) -->
    <!-- <meta name="google-site-verification" content="YOUR_GOOGLE_CODE"> -->
    <!-- <meta name="msvalidate.01" content="YOUR_BING_CODE"> -->
    
    <?php
}

/**
 * Get Meta Description
 */
function puchong_get_meta_description() {
    $business = puchong_get_business_info();
    
    if (is_front_page()) {
        return $business['description'];
    }
    
    if (is_singular('service')) {
        $excerpt = get_the_excerpt();
        return !empty($excerpt) ? $excerpt . ' Professional service in Puchong, Selangor.' : $business['description'];
    }
    
    if (is_singular('project')) {
        $location = get_post_meta(get_the_ID(), 'location', true);
        return get_the_title() . ' - Completed project' . ($location ? ' in ' . $location : '') . '. View our quality work at ' . $business['name'] . '.';
    }
    
    if (is_page('services')) {
        return 'Explore our comprehensive aluminium, glass, and security grill services in Puchong, Selangor. Free quotation available.';
    }
    
    if (is_page('gallery')) {
        return 'Browse our portfolio of completed aluminium, glass, and renovation projects across Klang Valley, Malaysia.';
    }
    
    if (is_page('contact')) {
        return 'Contact Puchong Glass for a free quote. Visit our showroom in Puchong, Selangor or WhatsApp us for instant estimates.';
    }
    
    if (is_page('why-us')) {
        return 'Why choose Puchong Glass? 15+ years experience, direct factory fabrication, premium materials, and guaranteed satisfaction.';
    }
    
    return $business['description'];
}

/**
 * Get Canonical URL
 */
function puchong_get_canonical_url() {
    if (is_front_page()) {
        return home_url('/');
    }
    
    if (is_singular()) {
        return get_permalink();
    }
    
    if (is_post_type_archive()) {
        return get_post_type_archive_link(get_post_type());
    }
    
    if (is_tax()) {
        return get_term_link(get_queried_object());
    }
    
    return home_url($_SERVER['REQUEST_URI']);
}

/**
 * Get OG Image
 */
function puchong_get_og_image() {
    $business = puchong_get_business_info();
    
    if (is_singular() && has_post_thumbnail()) {
        return get_the_post_thumbnail_url(get_the_ID(), 'large');
    }
    
    return $business['image'];
}

/**
 * =================================================================
 * SCHEMA.ORG STRUCTURED DATA
 * =================================================================
 */
add_action('wp_head', 'puchong_schema_markup', 5);
function puchong_schema_markup() {
    $business = puchong_get_business_info();
    
    // Organization & LocalBusiness Schema (Always)
    $organization_schema = puchong_get_organization_schema($business);
    echo '<script type="application/ld+json">' . wp_json_encode($organization_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    
    // Page-specific schemas
    if (is_front_page()) {
        // Website Schema
        $website_schema = puchong_get_website_schema($business);
        echo '<script type="application/ld+json">' . wp_json_encode($website_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
    
    if (is_singular('service')) {
        // Service Schema
        $service_schema = puchong_get_service_schema($business);
        echo '<script type="application/ld+json">' . wp_json_encode($service_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
    
    if (is_singular('project')) {
        // Product/CreativeWork Schema
        $project_schema = puchong_get_project_schema($business);
        echo '<script type="application/ld+json">' . wp_json_encode($project_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
    
    // Breadcrumb Schema (All pages except home)
    if (!is_front_page()) {
        $breadcrumb_schema = puchong_get_breadcrumb_schema();
        echo '<script type="application/ld+json">' . wp_json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}

/**
 * Organization & LocalBusiness Schema
 */
function puchong_get_organization_schema($business) {
    $address = $business['address'];
    
    return array(
        '@context' => 'https://schema.org',
        '@type' => array('LocalBusiness', 'HomeAndConstructionBusiness'),
        '@id' => $business['url'] . '#organization',
        'name' => $business['name'],
        'legalName' => $business['legal_name'],
        'description' => $business['description'],
        'url' => $business['url'],
        'logo' => array(
            '@type' => 'ImageObject',
            'url' => $business['logo'],
        ),
        'image' => $business['image'],
        'telephone' => $business['phone'],
        'email' => $business['email'],
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => $address['street'],
            'addressLocality' => $address['city'],
            'addressRegion' => $address['state'],
            'postalCode' => $address['postal_code'],
            'addressCountry' => $address['country'],
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => $business['geo']['latitude'],
            'longitude' => $business['geo']['longitude'],
        ),
        'openingHoursSpecification' => array_map(function($spec) {
            return array(
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => $spec['days'],
                'opens' => $spec['opens'],
                'closes' => $spec['closes'],
            );
        }, $business['opening_hours_spec']),
        'priceRange' => $business['price_range'],
        'areaServed' => array_map(function($area) {
            return array(
                '@type' => 'City',
                'name' => $area,
                'containedInPlace' => array(
                    '@type' => 'Country',
                    'name' => 'Malaysia',
                ),
            );
        }, $business['service_areas']),
        'sameAs' => array_values(array_filter($business['social'])),
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name' => 'Aluminium, Glass & Security Solutions',
            'itemListElement' => array(
                array(
                    '@type' => 'OfferCatalog',
                    'name' => 'Aluminium Works',
                    'description' => 'Premium aluminium windows, doors, and facades',
                ),
                array(
                    '@type' => 'OfferCatalog',
                    'name' => 'Glass Solutions',
                    'description' => 'Tempered glass, shower screens, partitions',
                ),
                array(
                    '@type' => 'OfferCatalog',
                    'name' => 'Security Grills',
                    'description' => 'Modern security grills and gates',
                ),
            ),
        ),
        'aggregateRating' => array(
            '@type' => 'AggregateRating',
            'ratingValue' => '4.9',
            'reviewCount' => '127',
            'bestRating' => '5',
        ),
    );
}

/**
 * Website Schema
 */
function puchong_get_website_schema($business) {
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => $business['url'] . '#website',
        'url' => $business['url'],
        'name' => $business['name'],
        'description' => $business['description'],
        'publisher' => array(
            '@id' => $business['url'] . '#organization',
        ),
        'inLanguage' => $business['primary_language'],
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => $business['url'] . '?s={search_term_string}',
            ),
            'query-input' => 'required name=search_term_string',
        ),
    );
}

/**
 * Service Schema
 */
function puchong_get_service_schema($business) {
    $features = get_post_meta(get_the_ID(), 'features', true);
    
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'serviceType' => get_the_title(),
        'name' => get_the_title() . ' - ' . $business['name'],
        'description' => get_the_excerpt() ?: wp_trim_words(get_the_content(), 50),
        'url' => get_permalink(),
        'image' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
        'provider' => array(
            '@id' => $business['url'] . '#organization',
        ),
        'areaServed' => array(
            '@type' => 'State',
            'name' => 'Selangor',
            'containedInPlace' => array(
                '@type' => 'Country',
                'name' => 'Malaysia',
            ),
        ),
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name' => get_the_title() . ' Services',
            'itemListElement' => is_array($features) ? array_map(function($feature, $idx) {
                return array(
                    '@type' => 'Offer',
                    'itemOffered' => array(
                        '@type' => 'Service',
                        'name' => $feature,
                    ),
                );
            }, $features, array_keys($features)) : array(),
        ),
    );
}

/**
 * Project/Portfolio Schema
 */
function puchong_get_project_schema($business) {
    $location = get_post_meta(get_the_ID(), 'location', true);
    $client = get_post_meta(get_the_ID(), 'client', true);
    $specs = get_post_meta(get_the_ID(), 'specs', true);
    $cats = get_the_terms(get_the_ID(), 'project_category');
    $category = !empty($cats) ? $cats[0]->name : 'Project';
    
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => get_the_title(),
        'description' => wp_trim_words(get_the_content(), 50),
        'url' => get_permalink(),
        'image' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
        'creator' => array(
            '@id' => $business['url'] . '#organization',
        ),
        'locationCreated' => array(
            '@type' => 'Place',
            'name' => $location ?: 'Selangor, Malaysia',
        ),
        'genre' => $category,
        'about' => array(
            '@type' => 'Thing',
            'name' => $category . ' Installation',
        ),
    );
}

/**
 * Breadcrumb Schema
 */
function puchong_get_breadcrumb_schema() {
    $items = array();
    $position = 1;
    
    // Home
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'Home',
        'item' => home_url('/'),
    );
    
    if (is_singular('service')) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Services',
            'item' => home_url('/services/'),
        );
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_singular('project')) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Gallery',
            'item' => home_url('/gallery/'),
        );
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_page()) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    }
    
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    );
}

/**
 * FAQ Schema (for FAQ section)
 */
function puchong_get_faq_schema($faqs) {
    $items = array_map(function($faq) {
        return array(
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ),
        );
    }, $faqs);
    
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $items,
    );
}

/**
 * =================================================================
 * XML SITEMAP
 * =================================================================
 */
add_action('init', 'puchong_register_sitemap');
function puchong_register_sitemap() {
    add_rewrite_rule('^sitemap\.xml$', 'index.php?puchong_sitemap=1', 'top');
    add_rewrite_rule('^sitemap-([a-z]+)\.xml$', 'index.php?puchong_sitemap=1&sitemap_type=$matches[1]', 'top');
}

add_filter('query_vars', 'puchong_sitemap_query_vars');
function puchong_sitemap_query_vars($vars) {
    $vars[] = 'puchong_sitemap';
    $vars[] = 'sitemap_type';
    return $vars;
}

add_action('template_redirect', 'puchong_sitemap_template');
function puchong_sitemap_template() {
    if (get_query_var('puchong_sitemap')) {
        header('Content-Type: application/xml; charset=utf-8');
        echo puchong_generate_sitemap(get_query_var('sitemap_type'));
        exit;
    }
}

function puchong_generate_sitemap($type = '') {
    $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    
    if (empty($type)) {
        // Sitemap Index
        $output .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $output .= '<sitemap><loc>' . home_url('/sitemap-pages.xml') . '</loc><lastmod>' . date('c') . '</lastmod></sitemap>' . "\n";
        $output .= '<sitemap><loc>' . home_url('/sitemap-services.xml') . '</loc><lastmod>' . date('c') . '</lastmod></sitemap>' . "\n";
        $output .= '<sitemap><loc>' . home_url('/sitemap-projects.xml') . '</loc><lastmod>' . date('c') . '</lastmod></sitemap>' . "\n";
        $output .= '</sitemapindex>';
    } else {
        $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
        
        switch ($type) {
            case 'pages':
                // Home
                $output .= puchong_sitemap_url(home_url('/'), '1.0', 'daily');
                
                // Pages
                $pages = get_pages();
                foreach ($pages as $page) {
                    $priority = in_array($page->post_name, array('services', 'contact', 'gallery')) ? '0.9' : '0.7';
                    $output .= puchong_sitemap_url(get_permalink($page), $priority, 'weekly', get_post_modified_time('c', false, $page));
                }
                break;
                
            case 'services':
                $services = get_posts(array('post_type' => 'service', 'posts_per_page' => -1));
                foreach ($services as $service) {
                    $image = get_the_post_thumbnail_url($service->ID, 'large');
                    $output .= puchong_sitemap_url(get_permalink($service), '0.8', 'weekly', get_post_modified_time('c', false, $service), $image);
                }
                break;
                
            case 'projects':
                $projects = get_posts(array('post_type' => 'project', 'posts_per_page' => -1));
                foreach ($projects as $project) {
                    $image = get_the_post_thumbnail_url($project->ID, 'large');
                    $output .= puchong_sitemap_url(get_permalink($project), '0.7', 'monthly', get_post_modified_time('c', false, $project), $image);
                }
                break;
        }
        
        $output .= '</urlset>';
    }
    
    return $output;
}

function puchong_sitemap_url($url, $priority = '0.5', $changefreq = 'monthly', $lastmod = '', $image = '') {
    $output = '<url>' . "\n";
    $output .= '<loc>' . esc_url($url) . '</loc>' . "\n";
    $output .= '<changefreq>' . $changefreq . '</changefreq>' . "\n";
    $output .= '<priority>' . $priority . '</priority>' . "\n";
    if ($lastmod) {
        $output .= '<lastmod>' . $lastmod . '</lastmod>' . "\n";
    }
    if ($image) {
        $output .= '<image:image><image:loc>' . esc_url($image) . '</image:loc></image:image>' . "\n";
    }
    $output .= '</url>' . "\n";
    return $output;
}

/**
 * =================================================================
 * ROBOTS.TXT OPTIMIZATION
 * =================================================================
 */
add_filter('robots_txt', 'puchong_custom_robots_txt', 10, 2);
function puchong_custom_robots_txt($output, $public) {
    if (!$public) {
        return $output;
    }
    
    $output = "# Puchong Glass Robots.txt\n";
    $output .= "# Optimized for Malaysia Local SEO\n\n";
    
    $output .= "User-agent: *\n";
    $output .= "Allow: /\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Allow: /wp-admin/admin-ajax.php\n";
    $output .= "Disallow: /wp-includes/\n";
    $output .= "Disallow: /wp-content/plugins/\n";
    $output .= "Disallow: /wp-content/cache/\n";
    $output .= "Disallow: /wp-content/themes/*/inc/\n";
    $output .= "Disallow: /*?s=\n";
    $output .= "Disallow: /*?replytocom\n";
    $output .= "Disallow: /trackback/\n";
    $output .= "Disallow: /feed/\n\n";
    
    $output .= "# Crawl-delay for polite crawling\n";
    $output .= "Crawl-delay: 1\n\n";
    
    $output .= "# Sitemaps\n";
    $output .= "Sitemap: " . home_url('/sitemap.xml') . "\n";
    $output .= "Sitemap: " . home_url('/wp-sitemap.xml') . "\n\n";
    
    $output .= "# Host\n";
    $output .= "Host: " . parse_url(home_url(), PHP_URL_HOST) . "\n";
    
    return $output;
}

/**
 * =================================================================
 * BREADCRUMB NAVIGATION (Visual)
 * =================================================================
 */
function puchong_breadcrumbs() {
    if (is_front_page()) {
        return;
    }
    
    $business = puchong_get_business_info();
    ?>
    <nav aria-label="Breadcrumb" class="py-4 bg-slate-100 border-b border-slate-200">
        <div class="container mx-auto px-4">
            <ol class="flex items-center gap-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="<?php echo home_url('/'); ?>" itemprop="item" class="text-slate-500 hover:text-amber-600 transition-colors flex items-center gap-1">
                        <i data-lucide="home" class="w-4 h-4"></i>
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
                
                <?php 
                $position = 2;
                
                if (is_singular('service')) : ?>
                <li class="flex items-center gap-2">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="<?php echo home_url('/services/'); ?>" itemprop="item" class="text-slate-500 hover:text-amber-600 transition-colors">
                            <span itemprop="name">Services</span>
                        </a>
                        <meta itemprop="position" content="<?php echo $position++; ?>">
                    </span>
                </li>
                <li class="flex items-center gap-2">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-slate-900 font-medium">
                        <span itemprop="name"><?php the_title(); ?></span>
                        <meta itemprop="item" content="<?php the_permalink(); ?>">
                        <meta itemprop="position" content="<?php echo $position; ?>">
                    </span>
                </li>
                
                <?php elseif (is_singular('project')) : ?>
                <li class="flex items-center gap-2">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="<?php echo home_url('/gallery/'); ?>" itemprop="item" class="text-slate-500 hover:text-amber-600 transition-colors">
                            <span itemprop="name">Gallery</span>
                        </a>
                        <meta itemprop="position" content="<?php echo $position++; ?>">
                    </span>
                </li>
                <li class="flex items-center gap-2">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-slate-900 font-medium">
                        <span itemprop="name"><?php the_title(); ?></span>
                        <meta itemprop="item" content="<?php the_permalink(); ?>">
                        <meta itemprop="position" content="<?php echo $position; ?>">
                    </span>
                </li>
                
                <?php elseif (is_page()) : ?>
                <li class="flex items-center gap-2">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-slate-900 font-medium">
                        <span itemprop="name"><?php the_title(); ?></span>
                        <meta itemprop="item" content="<?php the_permalink(); ?>">
                        <meta itemprop="position" content="<?php echo $position; ?>">
                    </span>
                </li>
                <?php endif; ?>
            </ol>
        </div>
    </nav>
    <?php
}

/**
 * =================================================================
 * PERFORMANCE & ADDITIONAL SEO
 * =================================================================
 */

// Remove unnecessary meta tags
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

// Add preconnect for external resources
add_action('wp_head', 'puchong_preconnect_hints', 1);
function puchong_preconnect_hints() {
    ?>
    <!-- Resource Hints for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    <?php
}

// Image Alt Text Enhancement
add_filter('wp_get_attachment_image_attributes', 'puchong_enhance_image_alt', 10, 3);
function puchong_enhance_image_alt($attr, $attachment, $size) {
    if (empty($attr['alt'])) {
        $business = puchong_get_business_info();
        $attr['alt'] = $business['name'] . ' - Professional Aluminium and Glass Work';
    }
    return $attr;
}

// Add structured data to images
add_filter('the_content', 'puchong_image_seo', 20);
function puchong_image_seo($content) {
    if (is_singular()) {
        // Add loading="lazy" to images not already having it
        $content = preg_replace('/<img((?!loading=)[^>]*)>/i', '<img$1 loading="lazy">', $content);
    }
    return $content;
}

/**
 * Ping search engines on publish
 */
add_action('publish_service', 'puchong_ping_search_engines');
add_action('publish_project', 'puchong_ping_search_engines');
add_action('publish_page', 'puchong_ping_search_engines');
function puchong_ping_search_engines() {
    $sitemap_url = urlencode(home_url('/sitemap.xml'));
    
    // Ping Google
    wp_remote_get('https://www.google.com/ping?sitemap=' . $sitemap_url, array('blocking' => false));
    
    // Ping Bing
    wp_remote_get('https://www.bing.com/ping?sitemap=' . $sitemap_url, array('blocking' => false));
}
