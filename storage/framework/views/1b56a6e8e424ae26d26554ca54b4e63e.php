<?php $__env->startSection('title', 'Plus | Product configuration'); ?>
<?php $__env->startSection('body_class', 'checkout-page'); ?>

<?php $__env->startSection('content'); ?>
<section class="checkout-shell" data-checkout>
    <aside class="checkout-summary-panel" aria-label="Configuration summary">
        <div class="checkout-plan">
            <h1>Plus</h1>
            <p class="checkout-price-line">From $3.99 a month <span>Was $14.99</span></p>
            <p class="checkout-plan-copy">Plus plan with: 2 websites, 30GB web space, Unlimited page views Includes FREE .com/.org/.net domain name in the first year. All discounts apply for the initial billing cycle.</p>
            <button class="checkout-link" type="button">Show more</button>
        </div>

        <div class="checkout-summary-card">
            <h2><span aria-hidden="true" class="checkout-bag-icon"></span>Configuration summary</h2>
            <dl>
                <div>
                    <dt>cPanel Shared Hosting</dt>
                    <dd>Plus</dd>
                </div>
                <div>
                    <dt>Server Location</dt>
                    <dd data-summary-location>Dallas, TX</dd>
                </div>
                <div>
                    <dt>Billing cycle</dt>
                    <dd data-summary-term>1-year</dd>
                </div>
            </dl>
        </div>

        <div class="checkout-total">
            <span>Total</span>
            <strong data-summary-total>$47.88</strong>
        </div>
    </aside>

    <div class="checkout-config" aria-label="Product configuration">
        <header class="checkout-config-header">
            <h2><span class="checkout-sliders-icon" aria-hidden="true"></span>Product configuration</h2>
            <button type="button" class="checkout-share"><span class="checkout-share-icon" aria-hidden="true"></span>Share</button>
        </header>

        <form class="checkout-form">
            <section class="checkout-section">
                <h3>Billing Term <span>*</span></h3>
                <div class="checkout-term-grid">
                    <label class="checkout-option checkout-term-card">
                        <input type="radio" name="billing_term" value="1-month" data-label="1-month" data-total="$16.99">
                        <span class="checkout-radio"></span>
                        <span class="checkout-term-title">1-month term</span>
                        <strong>$16.99</strong>
                    </label>

                    <label class="checkout-option checkout-term-card">
                        <input type="radio" name="billing_term" value="1-year" data-label="1-year" data-total="$47.88" checked>
                        <span class="checkout-radio"></span>
                        <span class="checkout-term-title">1-year term <em>Save 73%</em></span>
                        <span class="checkout-was">$14.99</span>
                        <span class="checkout-monthly"><strong>$3.99</strong> / mo</span>
                        <small>Pay $47.88 today.</small>
                    </label>

                    <label class="checkout-option checkout-term-card">
                        <input type="radio" name="billing_term" value="2-year" data-label="2-year" data-total="$251.83">
                        <span class="checkout-radio"></span>
                        <span class="checkout-term-title">2-year term <em>Save 30%</em></span>
                        <span class="checkout-was">$14.99</span>
                        <span class="checkout-monthly"><strong>$10.49</strong> / mo</span>
                        <small>Pay $251.83 today.</small>
                    </label>

                    <label class="checkout-option checkout-term-card">
                        <input type="radio" name="billing_term" value="3-year" data-label="3-year" data-total="$377.75">
                        <span class="checkout-radio"></span>
                        <span class="checkout-term-title">3-year term <em>Save 30%</em></span>
                        <span class="checkout-was">$14.99</span>
                        <span class="checkout-monthly"><strong>$10.49</strong> / mo</span>
                        <small>Pay $377.75 today.</small>
                    </label>
                </div>
            </section>

            <section class="checkout-section">
                <div class="checkout-section-row">
                    <h3>Server Location</h3>
                    <span>Optional</span>
                </div>
                <div class="checkout-location-grid">
                    <?php $__currentLoopData = [
                        ['Dallas, TX', 'us', true],
                        ['Toronto, CA', 'ca', false],
                        ['London, UK', 'uk', false],
                        ['Singapore, SG', 'sg', false],
                        ['Mexico, MX', 'mx', false],
                        ['Sydney, AU', 'au', false],
                        ['Mumbai, IN', 'in', false],
                        ['Frankfurt, DE', 'de', false],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$location, $flag, $checked]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="checkout-option checkout-location-card">
                            <input type="radio" name="server_location" value="<?php echo e($location); ?>" <?php if($checked): echo 'checked'; endif; ?>>
                            <span class="checkout-radio"></span>
                            <span class="flag flag-<?php echo e($flag); ?>" aria-hidden="true"><i></i></span>
                            <strong><?php echo e($location); ?></strong>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>

            <section class="checkout-section">
                <h3>Account Domain Name <span>*</span></h3>
                <div class="checkout-domain-box">
                    <label class="checkout-domain-choice">
                        <input type="radio" name="domain_mode" checked>
                        <span class="checkout-radio"></span>
                        <strong>Register a new domain</strong>
                    </label>
                    <label class="checkout-domain-search">
                        <input type="search" placeholder="Enter a domain to search" aria-label="Enter a domain to search">
                        <button type="button" aria-label="Search domain">-></button>
                    </label>
                    <label class="checkout-domain-choice">
                        <input type="radio" name="domain_mode">
                        <span class="checkout-radio"></span>
                        <strong>Use a domain I already own</strong>
                    </label>
                </div>
            </section>
        </form>
    </div>

    <div class="checkout-sticky-bar">
        <div><span>Total</span><strong data-sticky-total>$47.88</strong></div>
        <button type="button"><span class="checkout-bag-icon" aria-hidden="true"></span>Add to basket</button>
        <button type="button" class="checkout-help" aria-label="Help"></button>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Wia Studio\resources\views/checkout/index.blade.php ENDPATH**/ ?>