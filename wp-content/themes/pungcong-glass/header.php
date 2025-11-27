<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<?php 
// Check if current page is front page (home)
$is_front = is_front_page();
?>
<body <?php body_class('font-sans text-slate-800 bg-white selection:bg-amber-200 min-h-screen flex flex-col'); ?>>

<nav id="main-nav" class="fixed w-full z-50 transition-all duration-300 <?php echo $is_front ? 'bg-transparent py-6' : 'bg-white/95 backdrop-blur-md shadow-lg py-3'; ?>" data-is-front="<?php echo $is_front ? 'true' : 'false'; ?>">
    <div class="container mx-auto px-4 md:px-8 flex justify-between items-center">
        <a href="<?php echo home_url(); ?>" class="flex items-center gap-3 cursor-pointer group">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 text-white flex items-center justify-center font-bold text-xl rounded-sm shadow-lg group-hover:scale-110 transition-transform">P</div>
            <div>
                <h1 class="font-bold text-lg leading-none tracking-tight nav-text <?php echo $is_front ? 'text-white' : 'text-slate-900'; ?>">PUCHONG</h1>
                <p class="text-[10px] tracking-[0.2em] uppercase font-bold nav-subtext <?php echo $is_front ? 'text-slate-300' : 'text-amber-600'; ?>">Glass & Aluminium</p>
            </div>
        </a>

        <?php
        // Get current page slug for active state
        global $post;
        $current_slug = '';
        if (is_front_page()) {
            $current_slug = 'home';
        } elseif (is_page()) {
            $current_slug = $post->post_name;
        } elseif (is_singular('service')) {
            $current_slug = 'services';
        } elseif (is_singular('project') || is_post_type_archive('project')) {
            $current_slug = 'gallery';
        }
        
        // Define nav items
        $nav_items = array(
            array('slug' => 'home', 'url' => home_url('/'), 'label' => 'Home'),
            array('slug' => 'services', 'url' => home_url('/services/'), 'label' => 'Services'),
            array('slug' => 'gallery', 'url' => home_url('/gallery/'), 'label' => 'Gallery'),
            array('slug' => 'why-us', 'url' => home_url('/why-us/'), 'label' => 'Why Us'),
            array('slug' => 'contact', 'url' => home_url('/contact/'), 'label' => 'Contact'),
        );
        ?>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8">
            <?php foreach ($nav_items as $item) : 
                $is_active = ($current_slug === $item['slug']);
                
                if ($is_front) {
                    // On front page - white text, active = amber
                    $link_class = $is_active 
                        ? 'text-amber-400 border-b-2 border-amber-400 pb-1' 
                        : 'text-white/80 hover:text-white';
                } else {
                    // On other pages - dark text, active = amber
                    $link_class = $is_active 
                        ? 'text-amber-600 border-b-2 border-amber-600 pb-1' 
                        : 'text-slate-700 hover:text-amber-600';
                }
            ?>
            <a href="<?php echo esc_url($item['url']); ?>" 
               class="text-xs font-bold uppercase tracking-widest transition-all nav-link <?php echo $link_class; ?>"
               data-slug="<?php echo esc_attr($item['slug']); ?>">
                <?php echo esc_html($item['label']); ?>
            </a>
            <?php endforeach; ?>
            
            <a href="<?php echo home_url('/contact/'); ?>" class="px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 nav-btn <?php echo $is_front ? 'bg-white text-slate-900 hover:bg-slate-100' : 'bg-amber-600 text-white hover:bg-amber-700'; ?> border border-transparent hover:shadow-lg">
                Get Quote
            </a>
        </div>

        <!-- Mobile Toggle -->
        <button id="mobile-menu-btn" class="md:hidden nav-text <?php echo $is_front ? 'text-white' : 'text-slate-900'; ?>">
            <i data-lucide="menu" class="w-7 h-7"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden fixed top-0 left-0 w-full h-screen bg-white z-50 flex flex-col items-center justify-center gap-8">
        <button id="close-menu-btn" class="absolute top-6 right-6 text-slate-900">
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>
        <?php foreach ($nav_items as $item) : 
            $is_active = ($current_slug === $item['slug']);
            $mobile_class = $is_active ? 'text-amber-600' : 'text-slate-900';
        ?>
        <a href="<?php echo esc_url($item['url']); ?>" 
           class="mobile-link text-2xl font-bold uppercase tracking-wider <?php echo $mobile_class; ?>">
            <?php echo esc_html($item['label']); ?>
            <?php if ($is_active) : ?>
            <span class="block h-1 w-full bg-amber-600 mt-1 rounded"></span>
            <?php endif; ?>
        </a>
        <?php endforeach; ?>
        <a href="<?php echo home_url('/contact/'); ?>" class="px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30 w-3/4 mt-4">
            Get Free Quote
        </a>
    </div>
</nav>

<script>
    // Navigation Logic with Front Page Detection
    const nav = document.getElementById('main-nav');
    const isFrontPage = nav.dataset.isFront === 'true';
    const navTexts = document.querySelectorAll('.nav-text');
    const navSubtexts = document.querySelectorAll('.nav-subtext');
    const navLinks = document.querySelectorAll('.nav-link');
    const navBtn = document.querySelector('.nav-btn');
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('close-menu-btn');
    const mobileLinks = document.querySelectorAll('.mobile-link');

    function setScrolledState() {
        nav.classList.remove('bg-transparent', 'py-6');
        nav.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'py-3');
        
        navTexts.forEach(el => {
            el.classList.remove('text-white');
            el.classList.add('text-slate-900');
        });
        navSubtexts.forEach(el => {
            el.classList.remove('text-slate-300');
            el.classList.add('text-amber-600');
        });
        navLinks.forEach(el => {
            // Check if it's the active link
            const isActive = el.classList.contains('border-b-2');
            el.classList.remove('text-white/80', 'hover:text-white', 'text-amber-400', 'border-amber-400');
            if (isActive) {
                el.classList.add('text-amber-600', 'border-amber-600');
            } else {
                el.classList.add('text-slate-700', 'hover:text-amber-600');
            }
        });
        
        navBtn.classList.remove('bg-white', 'text-slate-900', 'hover:bg-slate-100');
        navBtn.classList.add('bg-amber-600', 'text-white', 'hover:bg-amber-700');
        
        mobileBtn.classList.remove('text-white');
        mobileBtn.classList.add('text-slate-900');
    }

    function setTransparentState() {
        nav.classList.add('bg-transparent', 'py-6');
        nav.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'py-3');

        navTexts.forEach(el => {
            el.classList.add('text-white');
            el.classList.remove('text-slate-900');
        });
        navSubtexts.forEach(el => {
            el.classList.add('text-slate-300');
            el.classList.remove('text-amber-600');
        });
        navLinks.forEach(el => {
            // Check if it's the active link
            const isActive = el.classList.contains('border-b-2');
            el.classList.remove('text-slate-700', 'hover:text-amber-600', 'text-amber-600', 'border-amber-600');
            if (isActive) {
                el.classList.add('text-amber-400', 'border-amber-400');
            } else {
                el.classList.add('text-white/80', 'hover:text-white');
            }
        });

        navBtn.classList.add('bg-white', 'text-slate-900', 'hover:bg-slate-100');
        navBtn.classList.remove('bg-amber-600', 'text-white', 'hover:bg-amber-700');
        
        mobileBtn.classList.add('text-white');
        mobileBtn.classList.remove('text-slate-900');
    }

    // Only apply scroll behavior on front page
    if (isFrontPage) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                setScrolledState();
            } else {
                setTransparentState();
            }
        });
    }
    // On other pages, header is already solid (set by PHP)

    mobileBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
    });

    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });
</script>

