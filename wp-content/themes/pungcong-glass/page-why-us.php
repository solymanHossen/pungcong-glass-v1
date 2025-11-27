<?php
/* Template Name: Why Us Page */
get_header(); 
?>

<div class="pt-24 pb-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="mb-16 text-center">
            <span class="font-bold tracking-[0.2em] text-xs uppercase mb-3 block text-amber-600">
                Why Choose Us
            </span>
            <h2 class="text-3xl md:text-5xl font-bold leading-tight text-slate-900">
                The Puchong Glass Standard
            </h2>
            <div class="h-1 w-20 bg-amber-600 mt-6 mx-auto"></div>
        </div>
      
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <?php
            $features = [
                ['icon' => 'pen-tool', 'title' => "Custom Fabrication", 'desc' => "We don't just install; we fabricate to fit your exact measurements in our local Puchong factory."],
                ['icon' => 'shield-check', 'title' => "Safety First", 'desc' => "All glass and grill works meet strict safety standards. We use certified tempered glass and high-grade metals."],
                ['icon' => 'clock', 'title' => "On-Time Delivery", 'desc' => "We respect your renovation timeline. Our team prides itself on punctuality and efficient installation."],
                ['icon' => 'star', 'title' => "Experienced Team", 'desc' => "Over 15 years serving the Klang Valley. Our technicians are skilled, polite, and clean up after work."],
                ['icon' => 'layers', 'title' => "Material Warranty", 'desc' => "Peace of mind with warranties on mechanisms, powder coating, and leakage protection."],
                ['icon' => 'phone', 'title' => "Responsive Support", 'desc' => "We are always a phone call away. No disappearing acts after the deposit is paid."]
            ];

            foreach ($features as $feature) :
            ?>
            <div class="bg-slate-50 p-8 shadow-sm border-t-4 border-amber-600 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-white shadow-md rounded-full flex items-center justify-center mb-6">
                    <i data-lucide="<?php echo $feature['icon']; ?>" class="w-7 h-7 text-amber-600"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3"><?php echo $feature['title']; ?></h3>
                <p class="text-slate-600 text-sm leading-relaxed"><?php echo $feature['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
