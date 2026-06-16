<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'WIA Studio'); ?></title>
    <meta name="description" content="WIA Studio is a Nairobi-based architecture, interior design, and construction documentation practice.">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/app.css')); ?>?v=<?php echo e(filemtime(public_path('assets/css/app.css'))); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="<?php echo $__env->yieldContent('body_class'); ?>">
    <header class="site-header big-header" id="siteHeader">
        <details class="side-menu-dropdown" id="sideMenuDropdown">
            <summary class="menu-toggle" id="menuToggle" aria-label="Open menu">
                <span></span>
                <span></span>
                <span></span>
            </summary>
            <div class="side-menu" id="sideMenu" aria-label="Studio menu">
                <a href="<?php echo e(route('projects.index')); ?>">Projects</a>
                <a href="<?php echo e(route('news.index')); ?>">News</a>
                <a href="<?php echo e(route('about.index')); ?>">About</a>
                <a href="#">Careers</a>
                <a href="<?php echo e(route('contact.index')); ?>">Contact</a>
            </div>
        </details>
        <a class="brand" href="<?php echo e(route('home')); ?>" aria-label="WIA Studio home">
            <span class="brand-mark"><img src="<?php echo e(asset('assets/img/wia-logo.svg')); ?>" alt=""></span>
            <span>
                <strong>WIA Studio</strong>
                <small>Architecture / Design / Build</small>
            </span>
        </a>
        <nav class="site-nav" id="siteNav">
            <a href="<?php echo e(route('projects.index')); ?>" data-category-trigger="architecture" data-wia-filter-nav="architecture">Architecture</a>
            <a href="<?php echo e(route('projects.index')); ?>" data-category-trigger="interiors" data-wia-filter-nav="interiors">Interiors</a>
            <a href="<?php echo e(route('projects.index')); ?>" data-category-trigger="landscape" data-wia-filter-nav="landscape">Landscape</a>
            <a href="<?php echo e(route('projects.index')); ?>" data-category-trigger="planning" data-wia-filter-nav="planning">Planning</a>
            <a href="<?php echo e(route('projects.index')); ?>" data-category-trigger="products" data-wia-filter-nav="products">Furniture</a>
            <?php if(auth()->guard()->check()): ?>
                <a class="admin-nav-access" href="<?php echo e(route('admin.dashboard')); ?>">Admin</a>
            <?php else: ?>
                <a class="admin-nav-access" href="<?php echo e(route('admin.signup')); ?>">Admin sign up</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer">
        <div>
            <h2>WIA Studio</h2>
            <p>Nairobi-based architecture for homes, civic places, interiors, and thoughtful urban work.</p>
        </div>
        <div class="footer-grid">
            <div>
                <span>Contact</span>
                <a href="mailto:<?php echo e($siteProfile->contact_email ?? 'studio@wia.com'); ?>"><?php echo e($siteProfile->contact_email ?? 'studio@wia.com'); ?></a>
                <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $siteProfile->phone_number ?? '+254700000000')); ?>"><?php echo e($siteProfile->phone_number ?? '+254 700 000 000'); ?></a>
                <a href="https://www.wia.com">www.wia.com</a>
                <p>Nairobi, Kenya</p>
            </div>
            <div>
                <span>Routes</span>
                <a href="<?php echo e(route('projects.index')); ?>">Project archive</a>
                <a href="<?php echo e(route('about.index')); ?>">About</a>
            </div>
            <div>
                <span>Social</span>
                <a href="#">Instagram</a>
                <a href="#">LinkedIn</a>
            </div>
        </div>
    </footer>

    <script src="<?php echo e(asset('assets/js/app.js')); ?>?v=<?php echo e(filemtime(public_path('assets/js/app.js'))); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Wia Studio\resources\views/layouts/app.blade.php ENDPATH**/ ?>