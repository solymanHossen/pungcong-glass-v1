<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-sans text-slate-800 bg-white selection:bg-amber-200 min-h-screen flex flex-col'); ?>>

<nav id="main-nav" class="fixed w-full z-50 transition-all duration-300 bg-transparent py-6">
    <div class="container mx-auto px-4 md:px-8 flex justify-between items-center">
        <a href="<?php echo home_url(); ?>" class="flex items-center gap-3 cursor-pointer group">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 text-white flex items-center justify-center font-bold text-xl rounded-sm shadow-lg group-hover:scale-110 transition-transform">P</div>
            <div>
                <h1 class="font-bold text-lg leading-none tracking-tight text-slate-900 md:text-white nav-text">PUCHONG</h1>
                <p class="text-[10px] tracking-[0.2em] uppercase font-bold text-slate-300 nav-subtext">Glass & Aluminium</p>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8">
            <a href="<?php echo home_url(); ?>" class="text-xs font-bold uppercase tracking-widest transition-all text-white/80 hover:text-white nav-link">Home</a>
            <a href="<?php echo home_url('/services'); ?>" class="text-xs font-bold uppercase tracking-widest transition-all text-white/80 hover:text-white nav-link">Services</a>
            <a href="<?php echo home_url('/gallery'); ?>" class="text-xs font-bold uppercase tracking-widest transition-all text-white/80 hover:text-white nav-link">Gallery</a>
            <a href="<?php echo home_url('/why-us'); ?>" class="text-xs font-bold uppercase tracking-widest transition-all text-white/80 hover:text-white nav-link">Why Us</a>
            <a href="<?php echo home_url('/contact'); ?>" class="text-xs font-bold uppercase tracking-widest transition-all text-white/80 hover:text-white nav-link">Contact</a>
            
            <a href="<?php echo home_url('/contact'); ?>" class="px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-slate-100 border border-transparent hover:shadow-lg nav-btn">
                Get Quote
            </a>
        </div>

        <!-- Mobile Toggle -->
        <button id="mobile-menu-btn" class="md:hidden text-white nav-text">
            <i data-lucide="menu" class="w-7 h-7"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden fixed top-0 left-0 w-full h-screen bg-white z-50 flex flex-col items-center justify-center gap-8">
        <button id="close-menu-btn" class="absolute top-6 right-6 text-slate-900">
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>
        <a href="<?php echo home_url(); ?>" class="mobile-link text-2xl font-bold uppercase tracking-wider text-slate-900">Home</a>
        <a href="<?php echo home_url('/services'); ?>" class="mobile-link text-2xl font-bold uppercase tracking-wider text-slate-900">Services</a>
        <a href="<?php echo home_url('/gallery'); ?>" class="mobile-link text-2xl font-bold uppercase tracking-wider text-slate-900">Gallery</a>
        <a href="<?php echo home_url('/why-us'); ?>" class="mobile-link text-2xl font-bold uppercase tracking-wider text-slate-900">Why Us</a>
        <a href="<?php echo home_url('/contact'); ?>" class="mobile-link text-2xl font-bold uppercase tracking-wider text-slate-900">Contact</a>
        <a href="<?php echo home_url('/contact'); ?>" class="px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30 w-3/4 mt-4">
            Get Free Quote
        </a>
    </div>
</nav>

<script>
    // Simple Navigation Logic
    const nav = document.getElementById('main-nav');
    const navTexts = document.querySelectorAll('.nav-text');
    const navSubtexts = document.querySelectorAll('.nav-subtext');
    const navLinks = document.querySelectorAll('.nav-link');
    const navBtn = document.querySelector('.nav-btn');
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('close-menu-btn');
    const mobileLinks = document.querySelectorAll('.mobile-link');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.classList.remove('bg-transparent', 'py-6');
            nav.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'py-3');
            
            navTexts.forEach(el => {
                el.classList.remove('md:text-white', 'text-white');
                el.classList.add('text-slate-900');
            });
            navSubtexts.forEach(el => {
                el.classList.remove('text-slate-300');
                el.classList.add('text-amber-600');
            });
            navLinks.forEach(el => {
                el.classList.remove('text-white/80', 'hover:text-white');
                el.classList.add('text-slate-800', 'hover:text-amber-600');
            });
            
            navBtn.classList.remove('bg-white', 'text-slate-900', 'hover:bg-slate-100');
            navBtn.classList.add('bg-amber-600', 'text-white', 'hover:bg-amber-700');
        } else {
            nav.classList.add('bg-transparent', 'py-6');
            nav.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'py-3');

            navTexts.forEach(el => {
                el.classList.add('md:text-white', 'text-white');
                el.classList.remove('text-slate-900');
            });
            navSubtexts.forEach(el => {
                el.classList.add('text-slate-300');
                el.classList.remove('text-amber-600');
            });
            navLinks.forEach(el => {
                el.classList.add('text-white/80', 'hover:text-white');
                el.classList.remove('text-slate-800', 'hover:text-amber-600');
            });

            navBtn.classList.add('bg-white', 'text-slate-900', 'hover:bg-slate-100');
            navBtn.classList.remove('bg-amber-600', 'text-white', 'hover:bg-amber-700');
        }
    });

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
