@php
    $categoryPanelProjectUrl = $categoryPanelProjectUrl ?? route('projects.index');
    $categoryPanelServiceUrl = $categoryPanelServiceUrl ?? route('home').'#services';
@endphp

<div class="big-category-panel" id="categoryPanel">
    <div data-panel="architecture">
        <h2>+Architecture</h2>
        <a href="{{ $categoryPanelProjectUrl }}">View all</a>
        <a href="{{ $categoryPanelProjectUrl }}">Residential</a>
        <a href="{{ $categoryPanelProjectUrl }}">Education</a>
        <a href="{{ $categoryPanelProjectUrl }}">Commercial</a>
    </div>
    <div data-panel="interiors">
        <h2>+Interiors</h2>
        <a href="{{ $categoryPanelProjectUrl }}">View all</a>
        <a href="{{ $categoryPanelServiceUrl }}">Fit-outs</a>
        <a href="{{ $categoryPanelServiceUrl }}">Material palettes</a>
    </div>
    <div data-panel="landscape">
        <h2>+Landscape</h2>
        <a href="{{ $categoryPanelProjectUrl }}">Courtyards</a>
        <a href="{{ $categoryPanelProjectUrl }}">Gardens</a>
        <a href="{{ $categoryPanelProjectUrl }}">Terraces</a>
    </div>
    <div data-panel="planning">
        <h2>+Planning</h2>
        <a href="{{ $categoryPanelServiceUrl }}">Master planning</a>
        <a href="{{ $categoryPanelServiceUrl }}">Feasibility</a>
        <a href="{{ $categoryPanelServiceUrl }}">Approvals</a>
    </div>
    <div data-panel="products">
        <h2>+Furniture</h2>
        <a href="{{ $categoryPanelProjectUrl }}">Furniture</a>
        <a href="{{ $categoryPanelProjectUrl }}">Lighting</a>
        <a href="{{ $categoryPanelProjectUrl }}">Objects</a>
    </div>
</div>
