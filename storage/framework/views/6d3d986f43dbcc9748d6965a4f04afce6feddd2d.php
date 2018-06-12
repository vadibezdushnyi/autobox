<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section Company Profile -->
<section class="section section--content animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <div class="section-text animatable-simple">
                <h3><?php echo e($_page->text_2); ?></h3>
                <div class="company-specialization">
                    <h3 class="title"><?php echo e($_page->text_3); ?></h3>
                    <div class="infographic-block">
                        <div class="lines animate-reverse">
                            <div class="line"><div class="line-content" style="min-width: 94%"><span><?php echo e($_page->text_4); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 91%"><span><?php echo e($_page->text_5); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 84%"><span><?php echo e($_page->text_6); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 78%"><span><?php echo e($_page->text_7); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 59%"><span><?php echo e($_page->text_8); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 78%"><span><?php echo e($_page->text_9); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 69%"><span><?php echo e($_page->text_10); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 78%"><span><?php echo e($_page->text_11); ?></span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 88%"><span><?php echo e($_page->text_12); ?></span><div class="line-bg"></div></div></div>
                        </div>
                        <img src="<?php echo e(url('/public/img/content/bike.png')); ?>" alt="" class="image-bike animate">
                    </div>
                </div>
                <div>
                  <?php echo $_page->text_13; ?>

                </div>
                <div class="company-specialization company-specialization--mobile">
                    <h3 class="title"><?php echo e($_page->text_3); ?></h3>
                    <div class="infographic-block">
                        <div class="lines animate-reverse">
                          <div class="line"><div class="line-content" style="min-width: 94%"><span><?php echo e($_page->text_4); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 91%"><span><?php echo e($_page->text_5); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 84%"><span><?php echo e($_page->text_6); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 78%"><span><?php echo e($_page->text_7); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 59%"><span><?php echo e($_page->text_8); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 78%"><span><?php echo e($_page->text_9); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 69%"><span><?php echo e($_page->text_10); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 78%"><span><?php echo e($_page->text_11); ?></span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 88%"><span><?php echo e($_page->text_12); ?></span><div class="line-bg"></div></div></div>
                        </div>
                        <img src="<?php echo e(url('/public/img/content/bike.png')); ?>" alt="" class="image-bike animate">
                    </div>
                </div>
                <div>
                  <?php echo $_page->text_14; ?>

                </div>
                <div class="excerpts-container animate">
                  <?php foreach($_page->list as $item): ?>
                    <div class="image-excerpt animate">
                        <div class="image-container">
                            <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/company-profile/', $item->cover)); ?>')">
                                <img src="<?php echo e(url('/public/img/content/company-profile/', $item->cover)); ?>" alt="<?php echo e($item->name); ?>">
                            </div>
                        </div>
                        <div class="text">
                            <h5 class="title"><?php echo e($item->name); ?></h5>
                        </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <div>
                  <?php echo $_page->text_15; ?>

                </div>
            </div>

        </div>
    </div>
</section>


</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>