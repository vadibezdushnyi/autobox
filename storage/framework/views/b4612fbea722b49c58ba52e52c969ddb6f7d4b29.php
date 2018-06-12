<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section Team -->
<section class="section section--content  section-team animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <h3 class="section-title-small animatable"><?php echo e($_page->text_2); ?></h3>
            <div class="section-text animatable">
                <?php echo e($_page->text_3); ?>

            </div>

            <div class="team-container">
                <h3 class="section-title-small section-title-small--red"><?php echo e($_page->text_4); ?></h3>

                <div class="tripple-container animate">
                  <?php foreach($teammates[0] as $member): ?>
                    <div class="excerpt team-member-excerpt animate">
                        <div class="team-member-excerpt__header">
                            <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/'.$member->cover)); ?>')"></div>
                            <div class="info">
                                <h4 class="title"><?php echo e($member->name); ?></h4>
                                <span class="position"><?php echo e($member->position); ?></span>
                            </div>
                        </div>
                        <div class="team-member-excerpt__contacts js_team-member-contacts">
                          <?php if(strlen($member->phone_1)): ?>
                            <a href="tel:<?php echo e($member->phone_1); ?>" class="person-contact"><span class="icon icon-telephone2"></span><?php echo e($member->phone_1); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->phone_2)): ?>
                            <a href="tel:<?php echo e($member->phone_2); ?>" class="person-contact"><span class="icon icon-telephone2"></span><?php echo e($member->phone_2); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->phone_3)): ?>
                            <a href="tel:<?php echo e($member->phone_3); ?>" class="person-contact"><span class="icon icon-telephone2"></span><?php echo e($member->phone_3); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->fax)): ?>
                            <a href="tel:<?php echo e($member->fax); ?>" class="person-contact"><span class="icon icon-fax"></span><?php echo e($member->fax); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->email)): ?>
                            <a href="mailto:<?php echo e($member->email); ?>" class="person-contact"><span class="icon icon-mail"></span><?php echo e($member->email); ?></a>
                          <?php endif; ?>
                        </div>
                        <div class="team-member-excerpt__socials">
                            <div class="social-links-simple">
                              <?php if(strlen(trim($member->fb_link))): ?>
                                <a href="<?php echo e($member->fb_link); ?>" class="social-link link-facebook">
                                    <span class="icon icon-facebook"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->tw_link))): ?>
                                <a href="<?php echo e($member->tw_link); ?>" class="social-link link-twitter">
                                    <span class="icon icon-twitter"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->ins_link))): ?>
                                <a href="<?php echo e($member->ins_link); ?>" class="social-link link-instagram">
                                    <span class="icon icon-instagram"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->sk_link))): ?>
                                <a href="skype:<?php echo e($member->sk_link); ?>?call" class="social-link link-skype">
                                    <span class="icon icon-skype"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->in_link))): ?>
                                <a href="<?php echo e($member->in_link); ?>" class="social-link link-linkedin">
                                    <span class="icon icon-linkedin"></span>
                                </a>
                              <?php endif; ?>
                            </div>
                        </div>
                        <div class="team-member-excerpt__languages">
                            <div class="contact-languages">
                              <?php foreach(json_decode($member->languages) as $language): ?>
                                <span class="language"><img src="<?php echo e(url('/public/img/icons-general/flags/', $language->logo)); ?>" alt="<?php echo e($language->name_s); ?>"><?php echo e($language->name); ?></span>
                              <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                  <?php endforeach; ?>
                </div>

            </div>


            <div class="team-container">
                <h3 class="section-title-small section-title-small--red"><?php echo e($_page->text_5); ?></h3>

                <div class="tripple-container animate">
                  <?php foreach($teammates[1] as $member): ?>
                    <div class="excerpt team-member-excerpt animate">
                        <div class="team-member-excerpt__header">
                            <div class="image" style="background-image: url('<?php echo e(url('/public/img/content/'.$member->cover)); ?>')"></div>
                            <div class="info">
                                <h4 class="title"><?php echo e($member->name); ?></h4>
                                <span class="position"><?php echo e($member->position); ?></span>
                            </div>
                        </div>
                        <div class="team-member-excerpt__contacts js_team-member-contacts">
                          <?php if(strlen($member->phone_1)): ?>
                            <a href="tel:<?php echo e($member->phone_1); ?>" class="person-contact"><span class="icon icon-telephone2"></span><?php echo e($member->phone_1); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->phone_2)): ?>
                            <a href="tel:<?php echo e($member->phone_2); ?>" class="person-contact"><span class="icon icon-telephone2"></span><?php echo e($member->phone_2); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->phone_3)): ?>
                            <a href="tel:<?php echo e($member->phone_3); ?>" class="person-contact"><span class="icon icon-telephone2"></span><?php echo e($member->phone_3); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->fax)): ?>
                            <a href="tel:<?php echo e($member->fax); ?>" class="person-contact"><span class="icon icon-fax"></span><?php echo e($member->fax); ?></a>
                          <?php endif; ?>
                          <?php if(strlen($member->email)): ?>
                            <a href="mailto:<?php echo e($member->email); ?>" class="person-contact"><span class="icon icon-mail"></span><?php echo e($member->email); ?></a>
                          <?php endif; ?>
                        </div>
                        <div class="team-member-excerpt__socials">
                            <div class="social-links-simple">
                              <?php if(strlen(trim($member->fb_link))): ?>
                                <a href="<?php echo e($member->fb_link); ?>" class="social-link link-facebook">
                                    <span class="icon icon-facebook"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->tw_link))): ?>
                                <a href="<?php echo e($member->tw_link); ?>" class="social-link link-twitter">
                                    <span class="icon icon-twitter"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->ins_link))): ?>
                                <a href="<?php echo e($member->ins_link); ?>" class="social-link link-instagram">
                                    <span class="icon icon-instagram"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->sk_link))): ?>
                                <a href="skype:<?php echo e($member->sk_link); ?>?call" class="social-link link-skype">
                                    <span class="icon icon-skype"></span>
                                </a>
                              <?php endif; ?>
                              <?php if(strlen(trim($member->in_link))): ?>
                                <a href="<?php echo e($member->in_link); ?>" class="social-link link-linkedin">
                                    <span class="icon icon-linkedin"></span>
                                </a>
                              <?php endif; ?>
                            </div>
                        </div>
                        <div class="team-member-excerpt__languages">
                            <div class="contact-languages">
                              <?php foreach(json_decode($member->languages) as $language): ?>
                                <span class="language"><img src="<?php echo e(url('/public/img/icons-general/flags/', $language->logo)); ?>" alt="<?php echo e($language->name_s); ?>"><?php echo e($language->name); ?></span>
                              <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                  <?php endforeach; ?>
                </div>

            </div>

        </div>
    </div>
</section>


</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>