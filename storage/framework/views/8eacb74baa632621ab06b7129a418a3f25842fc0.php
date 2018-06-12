<?php $__env->startSection('content'); ?>

<main class="page-content">
<!-- Main top slider section -->
<section class="homeslider-section" id="homeslider">
  <?php foreach($banners as $index => $banner): ?>
    <div>
        <div class="sizer"></div>
        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/'.$banner->file)); ?>')"></div>
        <div class="image-mobile" style="background-image: url('<?php echo e(url('/public/img/content/'.$banner->file)); ?>')"></div>
        <div class="content">
            <div class="text">
                <div class="text-container">
                    <div class="counters-container">
                      <span class="number js_slider-count-current"><?php echo e($index + 1); ?></span>
                      <span class="dash">/</span>
                      <span class="number number--small js_slider-count-overall"><?php echo e(sizeof($banners)); ?></span>
                    </div>
                    <h2 class="title"><?php echo e($banner->data); ?></h2>
                    <hr>
                </div>
            </div>
        </div>
    </div>
  <?php endforeach; ?>
</section>

<?php if(SIGNEDIN): ?>
<!-- Section part code -->
<section class="section section-find-part-code">
    <div class="page-wrapper">
        <div class="page-container">

            <div class="code-field__container">
                <form action="<?php echo e(url('/products/')); ?>" method="get">
                    <div class="code-field__input">
                        <label>
                            <input type="text" placeholder="<?php echo e($_page->text_1); ?>" name="q">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-red code-field__btn icon icon-search"><?php echo e($_page->text_2); ?></button>
                </form>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>

<!-- Section home why -->
<section class="section section-home-why">
    <div class="page-wrapper">
        <div class="page-container">

            <div class="cta-register-block animate">
                <div class="strings-container">
                    <div class="block1">
                        <div class="string"><?php echo e($_page->text_4); ?></div>
                    </div>
                    <div class="block2">
                        <div class="string"><?php echo e($_page->text_3); ?></div>
                    </div>
                </div>
                <?php if(!SIGNEDIN): ?>
                <div class="btn-container-general">
                    <a href="<?php echo e(url('/about/profile')); ?>" class="btn btn-regular"><?php echo e($_page->text_31); ?></a>
                </div>
                <?php endif; ?>
            </div>

            <div class="info-block-two-cols animate">
                <div class="col-title">
                    <h3 class="section-title section-title--red"><?php echo e($_page->text_5); ?></h3>
                </div>
                <div class="col-text">
                    <div class="section-text"><?php echo $_page->text_6; ?></div>
                </div>
            </div>

            <div class="excerpts-container">
              <?php foreach($_page->whyus as $item): ?>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/', $item->cover)); ?>')">
                            <img src="<?php echo e(url('/public/img/content/', $item->cover)); ?>" alt="<?php echo e($item->name); ?>">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($item->name); ?></h5>
                    </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="btn-container-general">
                <a href="<?php echo e(url('/about/whyus')); ?>" class="btn btn-regular"><?php echo e($_page->text_7); ?></a>
            </div>

        </div>
    </div>
</section>


<!-- Section home why -->
<section class="section section-home-support">
    <div class="page-wrapper">
        <div class="page-container">

            <div class="two-cols animate">
                <div class="col-left">
                    <h3 class="section-title"><?php echo e($_page->text_8); ?></h3>
                    <div class="section-text">
                        <?php echo e($_page->text_9); ?>

                    </div>
                    <div class="btn-container-general">
                        <a href="<?php echo e(url('/about/benefits')); ?>" class="btn btn-regular btn-regular--red"><?php echo e($_page->text_10); ?></a>
                    </div>
                </div>
                <div class="col-right">
                    <div class="support-info-item support-info-item--1">
                        <div class="image">
                            <img src="<?php echo e(url('/public/img/icons-general/icon1.svg')); ?>" alt="<?php echo e($_page->text_11); ?>">
                        </div>
                        <h5 class="title"><?php echo e($_page->text_11); ?></h5>
                    </div>
                    <div class="support-info-item support-info-item--2">
                        <div class="image">
                            <img src="<?php echo e(url('/public/img/icons-general/icon2.svg')); ?>" alt="<?php echo e($_page->text_12); ?>">
                        </div>
                        <h5 class="title"><?php echo e($_page->text_12); ?></h5>
                    </div>
                    <div class="support-info-item support-info-item--3">
                        <div class="image">
                            <img src="<?php echo e(url('/public/img/icons-general/icon3.svg')); ?>" alt="<?php echo e($_page->text_13); ?>">
                        </div>
                        <h5 class="title"><?php echo e($_page->text_13); ?></h5>
                    </div>
                    <div class="support-info-item support-info-item--4">
                        <div class="image">
                            <img src="<?php echo e(url('/public/img/icons-general/icon4.svg')); ?>" alt="<?php echo e($_page->text_14); ?>">
                        </div>
                        <h5 class="title"><?php echo e($_page->text_14); ?></h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="section-bg"></div>
    <img src="<?php echo e(url('/public/img/content/image7.jpg')); ?>" alt="" class="image-bg">
</section>


<!-- Section home parts -->
<section class="section section-home-parts">
    <div class="page-wrapper">
        <div class="page-container">

            <h3 class="section-title"><?php echo e($_page->text_15); ?></h3>
            <div class="excerpts-small-container">
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_Engine&Transmission.jpg')); ?>')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_Engine&Transmission.jpg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_16); ?></h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_BodyWork&Lighting.jpg')); ?>')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_BodyWork&Lighting.jpg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_17); ?></h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_BrakeComponents.jpg')); ?>')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_BrakeComponents.jpg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_18); ?></h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_Suspension&Steering.jpg')); ?>')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_Suspension&Steering.jpg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_19); ?></h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_Wheels&Tires')); ?>.jpg')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_Wheels&Tires')); ?>.jpg" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_20); ?></h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_Electrics&Electronics.jpg')); ?>')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_Electrics&Electronics.jpg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_21); ?></h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_Accessories.jpg')); ?>')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_Accessories.jpg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_22); ?></h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/All-GP_Interior.jpg')); ?>')">
                            <img src="<?php echo e(url('/public/img/content/All-GP_Interior.jpg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title"><?php echo e($_page->text_23); ?></h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Section home welcome -->
<section class="section section-home-welcome">
    <div class="page-wrapper">
        <div class="page-container">

        <div class="two-cols animate">
            <div class="col-left">
                <h3 class="section-title section-title--red"><?php echo e($_page->text_24); ?></h3>
                <div class="section-text">
                     <?php echo $_page->text_25; ?>

                </div>
            </div>
            <div class="col-right">
                <h3 class="section-title"><?php echo e($_page->text_26); ?></h3>
                <div class="section-text">
                  <?php echo $_page->text_27; ?>

                </div>
            </div>
        </div>

        </div>
    </div>
</section>


<!-- Section home automodels -->
<section class="section section-home-clients">
    <div class="page-wrapper">
        <div class="page-container">
            <h3 class="section-title section-title--red"><?php echo e($_page->text_28); ?></h3>
            <div class="text">
                <?php echo e($_page->text_29); ?>

            </div>

            <div class="clients-slider carousel animate">
              <?php foreach($producers as $chunk): ?>
                <div class="slide">
                  <?php foreach($chunk as $producer): ?>
                    <a href="<?php echo e(url('/parts', $producer->Id)); ?>" class="client-logo bmw"><div class="image"><img src="<?php echo e(url('/public/img/icons-general/car-logos/', $producer->Logo)); ?>" alt=""></div><div class="text"><h5 class="title"><?php echo e($producer->Name); ?></h5></div></a>
                  <?php endforeach; ?>
                </div>
              <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>


<!-- Section Latest news -->
<?php if(!empty($posts)): ?>
<section class="section section-latest-news">
    <div class="bg-image-container bg-image-container--1 animate">
        <img src="<?php echo e(url('/public/img/content/image6.jpg')); ?>" class="bg-image bg-image--1">
    </div>
    <div class="bg-image-container bg-image-container--2 animate">
        <img src="<?php echo e(url('/public/img/content/image7.jpg')); ?>" class="bg-image bg-image--1">
    </div>
    <div class="page-wrapper">
        <div class="page-container">
            <h3 class="section-title section-title"><?php echo e($_page->text_30); ?></h3>

            <div class="excerpts-carousel carousel js_excerpts-carousel js_slider-height-equalize animate">
              <?php foreach($posts as $post): ?>
                <div class="slide">
                    <div class="slide-container">
                        <div class="post-excerpt js_excerpt">
                            <a href="<?php echo e(url('/news/'.$post->alias)); ?>" class="post-excerpt__image">
                                <span class="image-wrapper">
                                    <span class="image-container" style="background-image: url('<?php echo e(url('/public/img/content/'.$post->filename)); ?>')">
                                      <img src="<?php echo e(url('/public/img/content/'.$post->filename)); ?>" alt="<?php echo e($post->img_alt); ?>" title="<?php echo e($post->img_title); ?>">
                                    </span>
                                </span>
                            </a>
                            <div class="post-excerpt__info">
                                <div class="post-excerpt__meta">
                                    <span class="post-excerpt__label"><?php echo e($post->category); ?></span>
                                    <span class="post-excerpt__date"><?php echo e(date('d', strtotime($post->created))); ?><span> / </span><?php echo e(date('M', strtotime($post->created))); ?><span> / </span><?php echo e(date('Y', strtotime($post->created))); ?></span>
                                </div>
                                <a href="<?php echo e(url('/news/'.$post->alias)); ?>" class="post-excerpt__title">
                                    <?php echo e($post->name); ?>

                                </a>
                                <div class="post-excerpt__description">
                                    <?php echo e(substr(strip_tags($post->content), 0, 150).'...'); ?>

                                </div>
                                <div class="post-excerpt__tags">
                                  <?php foreach($post->tagnames as $tag): ?>
                                    <span class="tag"><?php echo e($tag); ?></span>
                                  <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>
</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>