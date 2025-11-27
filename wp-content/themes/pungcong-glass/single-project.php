<?php get_header(); ?>

<div class="pt-32 pb-24 container mx-auto px-4 animate-fade-in-up">
    <?php while (have_posts()) : the_post(); 
        $location = get_post_meta(get_the_ID(), 'location', true);
        $date = get_post_meta(get_the_ID(), 'project_date', true);
        $client = get_post_meta(get_the_ID(), 'client', true);
        $specs = get_post_meta(get_the_ID(), 'specs', true);
        $cats = get_the_terms(get_the_ID(), 'project_category');
        $cat_name = !empty($cats) ? $cats[0]->name : 'Project';
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    ?>

    <a href="<?php echo home_url('/#gallery'); ?>" class="mb-8 pl-0 hover:bg-transparent hover:text-amber-600 inline-flex items-center text-slate-600 transition-colors">
        <i data-lucide="arrow-left" class="mr-2 w-5 h-5"></i> Back to Gallery
    </a>

    <div class="grid lg:grid-cols-2 gap-12 items-start">
        <div class="rounded-2xl shadow-2xl overflow-hidden relative group">
            <?php if ($image_url) : ?>
                <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>" class="w-full h-auto object-cover" />
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white">
                <span class="bg-amber-600 px-3 py-1 text-xs font-bold uppercase rounded mb-2 inline-block"><?php echo $cat_name; ?></span>
            </div>
        </div>

        <div class="lg:sticky lg:top-32">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight"><?php the_title(); ?></h1>
            
            <div class="flex flex-col gap-4 mb-8 bg-slate-50 p-6 rounded-xl border border-slate-100">
                <?php if ($location) : ?>
                <div class="flex items-center gap-3">
                    <i data-lucide="map-pin" class="w-[18px] h-[18px] text-amber-600"></i>
                    <span class="text-slate-700 font-medium"><?php echo $location; ?></span>
                </div>
                <?php endif; ?>
                <?php if ($date) : ?>
                <div class="flex items-center gap-3">
                    <i data-lucide="calendar" class="w-[18px] h-[18px] text-amber-600"></i>
                    <span class="text-slate-700 font-medium"><?php echo $date; ?></span>
                </div>
                <?php endif; ?>
                <?php if ($client) : ?>
                <div class="flex items-center gap-3">
                    <i data-lucide="user" class="w-[18px] h-[18px] text-amber-600"></i>
                    <span class="text-slate-700 font-medium"><?php echo $client; ?></span>
                </div>
                <?php endif; ?>
            </div>

            <h3 class="text-lg font-bold text-slate-900 mb-3 uppercase tracking-wider">Project Overview</h3>
            <div class="text-slate-600 leading-relaxed mb-8 text-lg">
                <?php the_content(); ?>
            </div>

            <?php if (!empty($specs) && is_array($specs)) : ?>
            <h3 class="text-lg font-bold text-slate-900 mb-4 uppercase tracking-wider">Specifications</h3>
            <ul class="space-y-3 mb-10">
                <?php foreach ($specs as $spec) : ?>
                <li class="flex items-center gap-3 p-4 bg-white border border-slate-100 rounded-lg shadow-sm hover:border-amber-200 transition-colors">
                    <i data-lucide="box" class="w-5 h-5 text-amber-600"></i>
                    <span class="text-slate-700 font-medium"><?php echo $spec; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <div class="bg-slate-900 text-white p-8 rounded-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-bold text-2xl mb-2">Inspired by this project?</h4>
                    <p class="text-slate-300 mb-6">We can customize a similar solution for your property.</p>
                    <a href="<?php echo home_url('/#contact'); ?>" class="w-full block text-center px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30">Get a Quote for This Design</a>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10">
                    <i data-lucide="star" class="w-[150px] h-[150px]"></i>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
