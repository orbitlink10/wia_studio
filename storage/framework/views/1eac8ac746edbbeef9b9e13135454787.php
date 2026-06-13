<?php $__env->startSection('title', 'Contact | WIA Studio'); ?>
<?php $__env->startSection('body_class', 'big-white-page contact-page'); ?>

<?php $__env->startSection('content'); ?>
<section class="contact-index">
    <h1>CONTACT</h1>

    <div class="contact-index-grid">
        <article>
            <span>Email</span>
            <a href="mailto:<?php echo e($studioProfile->contact_email ?: 'studio@wia.com'); ?>">
                <?php echo e($studioProfile->contact_email ?: 'studio@wia.com'); ?>

            </a>
        </article>
        <article>
            <span>Phone</span>
            <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $studioProfile->phone_number ?: '+254700000000')); ?>">
                <?php echo e($studioProfile->phone_number ?: '+254 700 000 000'); ?>

            </a>
        </article>
        <article>
            <span>Studio</span>
            <p>Nairobi, Kenya</p>
        </article>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Wia Studio\resources\views/contact/index.blade.php ENDPATH**/ ?>