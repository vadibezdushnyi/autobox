<?php $__env->startSection('content'); ?>
<main class="page-content">


<div class="page-header-bg animate">
    <div class="page-header-bg__image" style="background-image: url('<?php echo e(url('/public/img/content/'.$brand->cover)); ?>')"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($brand->Name); ?></h2>
        </div>
    </div>
</div>

<!-- Section Brand -->
<section class="section section--content section-brand animate">
    <div class="page-wrapper">
        <div class="page-container">
            <div class="brand-info-container">
                <div class="aside">
                    <div class="logo-image"><img alt="" src="<?php echo e(url('/public/img/icons-general/car-logos/'.$brand->Logo)); ?>"></div>
                    <div class="parts-excerpt parts-excerpt--narrow animate">
                        <div class="parts-excerpt__header">
                            <div class="parts-excerpt__image" style="background-image: url('<?php echo e(url('/public/img/content/parts/why-us-parts-bg.jpg')); ?>')"></div>
                            <div class="parts-excerpt__overlay"></div>
                            <div class="parts-excerpt__header__container">
                                <h3 class="parts-excerpt__title"><?php echo e($_page->text_2); ?></h3>
                            </div>
                        </div>
                        <?php if($brand->directions): ?>
                        <div class="parts-excerpt__body">
                            <div class="parts-excerpt__list no-scrollbar">
                              <?php foreach($brand->directions as $dir): ?>
                                <div class="parts-excerpt__list__link"><a href="javascript:void(0)"><?php echo e($dir->name); ?></a></div>
                              <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="more-than" style="background-image: url('<?php echo e(url('/public/img/content/more-bg.jpg')); ?>')">
                        <?php echo e($_page->text_3); ?><span class="number"><span id="counter1" class="js_number-animate animate" data-counter-start="0" data-counter-end="<?php echo e($brand->products_amount); ?>">0</span></span><?php echo e($_page->text_4); ?>

                    </div>
                </div>
                <div class="main">
                    <ul class="breadcrumbs">
                        <li><a href="<?php echo e(url('/parts')); ?>"><?php echo e($_page->text_1); ?></a></li>
                        <li class="active"><span><?php echo e($brand->Name); ?></span></li>
                    </ul>

                    <div class="logo-image"><img alt="" src="<?php echo e(url('/public/img/icons-general/car-logos/'.$brand->Logo)); ?>"></div>

                    <div class="section-text">
                        <h3><?php echo e($brand->Name); ?></h3>
                        <div>
                          <?php echo $brand->description; ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>