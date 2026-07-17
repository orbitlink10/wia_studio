const header = document.getElementById("siteHeader");
const menuToggle = document.getElementById("menuToggle");
const sideMenu = document.getElementById("sideMenu");
const sideMenuDropdown = document.getElementById("sideMenuDropdown");
const wiaSplash = document.getElementById("wiaSplash");

if (wiaSplash) {
    const runSplashIntro = () => {
        setTimeout(() => {
            wiaSplash.classList.add("is-settling");
        }, 650);

        setTimeout(() => {
            wiaSplash.classList.add("is-hidden");
            document.body.classList.remove("wia-intro-active");
            setTimeout(() => wiaSplash.remove(), 900);
        }, 1650);
    };

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", runSplashIntro, { once: true });
    } else {
        runSplashIntro();
    }
}

window.addEventListener("scroll", () => {
    header.classList.toggle("is-scrolled", window.scrollY > 40);
});

const closeSideMenu = () => {
    if (sideMenuDropdown) sideMenuDropdown.open = false;
    header?.classList.remove("is-menu-open");
};

sideMenuDropdown?.addEventListener("toggle", () => {
    header?.classList.toggle("is-menu-open", sideMenuDropdown.open);
});

sideMenu?.addEventListener("click", (event) => {
    if (event.target.closest("a")) closeSideMenu();
});

document.addEventListener("click", (event) => {
    if (!sideMenuDropdown || event.target.closest("#sideMenuDropdown")) return;
    closeSideMenu();
});

document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeSideMenu();
});

if (document.body.classList.contains("wia-index-page") && header && !window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    const peekBrand = () => {
        if (sideMenuDropdown?.open) return;

        header.classList.add("is-brand-peek");
        window.setTimeout(() => header.classList.remove("is-brand-peek"), 1250);
    };

    window.setTimeout(peekBrand, 2600);
    window.setInterval(peekBrand, 6800);
}

const categoryPanel = document.getElementById("categoryPanel");
const categoryTriggers = document.querySelectorAll("[data-category-trigger]");
const categoryPanels = document.querySelectorAll("[data-panel]");

categoryTriggers.forEach((trigger) => {
    const activate = () => {
        if (!categoryPanel) return;

        const key = trigger.dataset.categoryTrigger;
        categoryPanel.classList.add("is-open");
        categoryPanels.forEach((panel) => {
            panel.classList.toggle("is-active", panel.dataset.panel === key);
        });
    };

    trigger.addEventListener("mouseenter", activate);
    trigger.addEventListener("focus", activate);
    trigger.addEventListener("click", (event) => {
        const canOpenPanel = categoryPanel && window.innerWidth > 920;
        const canFilterProjects = projectRows.length > 0;

        if (canOpenPanel && !canFilterProjects) {
            event.preventDefault();
            activate();
        }
    });
});

categoryPanel?.addEventListener("mouseleave", () => {
    categoryPanel.classList.remove("is-open");
});

document.addEventListener("click", (event) => {
    if (!categoryPanel || event.target.closest("[data-category-trigger]") || event.target.closest("#categoryPanel")) {
        return;
    }

    categoryPanel.classList.remove("is-open");
});

const projectRows = document.querySelectorAll(".pl-row");
const projectFilterLinks = document.querySelectorAll("[data-wia-filter-nav]");
const projectFilterBar = document.getElementById("filterBar");
const projectFilterLabel = document.getElementById("filterLabel");
const projectFilterClear = document.querySelector("[data-wia-filter-clear]");
const projectSubnav = document.getElementById("subnav");
const projectEmpty = document.getElementById("plEmpty");
let activeProjectDetail = null;
let savedScrollY = 0;

const lockPageScroll = () => {
    savedScrollY = window.scrollY;
    document.body.classList.add("pl-detail-active");
};

const unlockPageScroll = () => {
    document.body.classList.remove("pl-detail-active");
    window.scrollTo({ top: savedScrollY, behavior: "instant" });
};

const projectSubcategoriesFor = (category) => {
    const labels = new Map();

    projectRows.forEach((row) => {
        if (row.dataset.category !== category) return;
        labels.set(row.dataset.sub, row.dataset.subLabel || row.dataset.sub);
    });

    return ["All", ...labels.entries()].map((item) => {
        if (typeof item === "string") return { key: "all", label: item };
        return { key: item[0], label: item[1] };
    });
};

const applyProjectFilter = (category = "all", subcategory = "all", scroll = true) => {
    if (!projectRows.length) return;

    if (activeProjectDetail) {
        closeInlineProject(null, { animate: false });
    }

    let visibleCount = 0;

    projectRows.forEach((row) => {
        const categoryMatch = category === "all" || row.dataset.category === category;
        const subMatch = subcategory === "all" || row.dataset.sub === subcategory;
        const isVisible = categoryMatch && subMatch;
        row.classList.toggle("hidden", !isVisible);
        if (isVisible) visibleCount += 1;
    });

    projectFilterLinks.forEach((link) => {
        link.classList.toggle("active", category !== "all" && link.dataset.wiaFilterNav === category);
    });

    projectFilterBar?.classList.toggle("visible", category !== "all");
    if (projectFilterLabel) {
        projectFilterLabel.textContent = category === "all" ? "All" : category.charAt(0).toUpperCase() + category.slice(1);
    }

    if (projectSubnav) {
        const subs = projectSubcategoriesFor(category);
        if (category === "all" || subs.length <= 1) {
            projectSubnav.innerHTML = "";
            projectSubnav.classList.remove("visible");
        } else {
            projectSubnav.innerHTML = subs.map((sub) => `<a href="#" data-wia-sub-filter="${sub.key}">${sub.label}</a>`).join("");
            projectSubnav.classList.add("visible");
            projectSubnav.querySelectorAll("[data-wia-sub-filter]").forEach((link) => {
                link.classList.toggle("active", link.dataset.wiaSubFilter === subcategory);
            });
        }
    }

    projectEmpty?.classList.toggle("visible", visibleCount === 0);

    if (scroll) {
        document.getElementById("projects")?.scrollIntoView({ behavior: "smooth", block: "start" });
    }
};

projectFilterLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
        if (!projectRows.length) return;
        event.preventDefault();
        closeSideMenu();
        applyProjectFilter(link.dataset.wiaFilterNav);
    });
});

projectFilterClear?.addEventListener("click", (event) => {
    event.preventDefault();
    applyProjectFilter("all");
});

projectSubnav?.addEventListener("click", (event) => {
    const link = event.target.closest("[data-wia-sub-filter]");
    if (!link) return;

    event.preventDefault();
    const activeCategory = document.querySelector("[data-wia-filter-nav].active")?.dataset.wiaFilterNav || "all";
    applyProjectFilter(activeCategory, link.dataset.wiaSubFilter);
});

document.querySelector("[data-wia-contact-link]")?.addEventListener("click", (event) => {
    if (!document.getElementById("contact")) return;

    event.preventDefault();
    closeSideMenu();
    document.getElementById("contact").scrollIntoView({ behavior: "smooth" });
});

const readDetailImages = (row) => {
    try {
        return JSON.parse(row.dataset.detailImages || "[]");
    } catch {
        return [];
    }
};

const readDetailChapters = (row) => {
    try {
        return JSON.parse(row.dataset.detailChapters || "[]");
    } catch {
        return [];
    }
};

const escapeHtml = (value = "") => String(value)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");

const optimizedImage = (url = "", width = 1400) => {
    if (!url || !url.includes("images.unsplash.com")) return url;
    const joiner = url.includes("?") ? "&" : "?";
    return `${url}${joiner}auto=format&fit=crop&w=${width}&q=78`;
};

const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

const glideHorizontalTrack = (track, options = {}) => {
    const speed = options.speed || 1;
    const wheelMode = options.wheelMode || "intentional";
    let target = track.scrollLeft;
    let frame = null;
    let lastWheelAt = 0;
    let drag = {
        active: false,
        startX: 0,
        startScroll: 0,
    };

    const maxScroll = () => Math.max(0, track.scrollWidth - track.clientWidth);
    const clamp = (value) => Math.max(0, Math.min(maxScroll(), value));

    const animate = () => {
        const delta = target - track.scrollLeft;
        if (Math.abs(delta) < 0.5 || prefersReducedMotion) {
            track.scrollLeft = target;
            frame = null;
            return;
        }

        track.scrollLeft += delta * 0.16;
        frame = requestAnimationFrame(animate);
    };

    const glideTo = (value, instant = false) => {
        target = clamp(value);

        if (instant || prefersReducedMotion) {
            track.scrollLeft = target;
            if (frame) cancelAnimationFrame(frame);
            frame = null;
            return;
        }

        if (!frame) frame = requestAnimationFrame(animate);
    };

    track.addEventListener("scroll", () => {
        if (!frame) target = track.scrollLeft;
    }, { passive: true });

    track.addEventListener("wheel", (event) => {
        if (window.innerWidth <= 700) return;

        const horizontalIntent = Math.abs(event.deltaX) > Math.abs(event.deltaY) * 0.72;
        const recentRailIntent = Date.now() - lastWheelAt < 420;
        const verticalToHorizontal = wheelMode === "gallery" && (event.shiftKey || recentRailIntent);
        const railDelta = horizontalIntent ? event.deltaX : (verticalToHorizontal ? event.deltaY : 0);

        if (!railDelta) return;

        const next = clamp(target + railDelta * speed);
        const canMove = Math.abs(next - target) > 0.5;

        if (!canMove) {
            lastWheelAt = 0;
            return;
        }

        event.preventDefault();
        lastWheelAt = Date.now();
        glideTo(next);
    }, { passive: false });

    track.addEventListener("pointerdown", (event) => {
        if (event.button !== 0 || event.target.closest("a,button,input,select,textarea,summary")) return;

        drag = {
            active: true,
            startX: event.clientX,
            startScroll: track.scrollLeft,
        };
        if (frame) cancelAnimationFrame(frame);
        frame = null;
        track.classList.add("is-dragging");
        track.setPointerCapture?.(event.pointerId);
    });

    track.addEventListener("pointermove", (event) => {
        if (!drag.active) return;

        event.preventDefault();
        target = clamp(drag.startScroll + drag.startX - event.clientX);
        track.scrollLeft = target;
    });

    const stopDrag = (event) => {
        if (!drag.active) return;

        drag.active = false;
        track.classList.remove("is-dragging");
        track.releasePointerCapture?.(event.pointerId);
    };

    track.addEventListener("pointerup", stopDrag);
    track.addEventListener("pointercancel", stopDrag);
    track.addEventListener("lostpointercapture", () => {
        drag.active = false;
        track.classList.remove("is-dragging");
    });

    track.addEventListener("keydown", (event) => {
        if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) return;

        event.preventDefault();
        const nudge = Math.max(280, track.clientWidth * 0.72);
        if (event.key === "Home") glideTo(0);
        if (event.key === "End") glideTo(maxScroll());
        if (event.key === "ArrowLeft") glideTo(target - nudge);
        if (event.key === "ArrowRight") glideTo(target + nudge);
    });

    window.addEventListener("resize", () => glideTo(track.scrollLeft, true));

    return { glideTo };
};

document.querySelectorAll(".admin-slide-strip").forEach((track) => {
    glideHorizontalTrack(track, { speed: 1.05, wheelMode: "gallery" });
});

const buildInlineSlides = (row, images, chapters) => {
    const title = row.dataset.title || "Project";
    const hero = images[0] || row.querySelector(".pl-img img")?.src || "";
    const summary = row.dataset.summary || "A WIA Studio project reference with planning, material, and delivery notes.";
    const chapterSlides = chapters.slice(0, 5);

    if (!chapterSlides.length) {
        chapterSlides.push({
            label: "Design Intent",
            body: summary,
            image: hero,
        });
    }

    const slides = [
        { type: "hero", label: title, body: row.dataset.location || "", image: hero },
        { type: "copy", label: "Overview", body: summary, image: row.dataset.overviewImage || hero },
        { type: "facts", label: "Project Facts", body: summary, image: hero },
        ...chapterSlides.map((chapter) => ({
            type: "story",
            label: chapter.label || "Project Detail",
            body: chapter.body || summary,
            image: chapter.image || hero,
        })),
    ];

    const supportImages = [chapters[0]?.image, chapters[1]?.image, chapters[2]?.image, hero].filter(Boolean);
    slides.push(
        {
            type: "copy",
            label: "Spatial Strategy",
            body: "A consistent slide sequence keeps the project easy to scan, share, and review across devices.",
            image: row.dataset.spatialImage || supportImages[0] || hero,
        },
        {
            type: "story",
            label: "Material And Atmosphere",
            body: "Media is lazy loaded and sized for the deck so the presentation remains quick without losing the studio tone.",
            image: row.dataset.materialImage || supportImages[1] || hero,
        },
        {
            type: "copy",
            label: "Delivery Notes",
            body: `${row.dataset.status || "Project"} / ${row.dataset.size || ""} / ${row.dataset.typology || ""}`,
            image: row.dataset.deliveryImage || supportImages[2] || hero,
        },
    );

    return slides.slice(0, 10);
};

const getHeaderOffset = () => document.getElementById("siteHeader")?.offsetHeight || 72;

const scrollToElement = (element, behavior = "smooth") => {
    const rect = element.getBoundingClientRect();
    const viewportHeight = window.innerHeight;
    const elementHeight = rect.height;
    const top = element.getBoundingClientRect().top + window.scrollY
        - Math.max(getHeaderOffset(), (viewportHeight - elementHeight) / 2);

    window.scrollTo({ top: Math.max(0, top), behavior });
};

const unbindExpandedScrollHandlers = () => {
    document.removeEventListener("wheel", onExpandedWheel);
    document.removeEventListener("touchstart", onExpandedTouchStart);
    document.removeEventListener("touchmove", onExpandedTouchMove);
};

let expandedTouchStartY = 0;

const onExpandedTouchStart = (event) => {
    expandedTouchStartY = event.touches[0]?.clientY ?? 0;
};

const onExpandedTouchMove = (event) => {
    if (!activeProjectDetail) return;

    const touchY = event.touches[0]?.clientY ?? expandedTouchStartY;
    const deltaY = expandedTouchStartY - touchY;

    if (deltaY <= 8) return;

    const { panel } = activeProjectDetail;
    const track = panel.querySelector("[data-inline-track]");
    const maxScroll = track ? track.scrollWidth - track.clientWidth - 2 : 0;

    if (track && track.scrollLeft < maxScroll - 2 && track.scrollLeft > 2) return;

    event.preventDefault();
    closeInlineProject(() => {
        window.scrollBy({ top: deltaY, behavior: "auto" });
    });
};

const onExpandedWheel = (event) => {
    if (!activeProjectDetail) return;

    const { panel } = activeProjectDetail;
    const track = panel.querySelector("[data-inline-track]");

    if (Math.abs(event.deltaX) > Math.abs(event.deltaY)) {
        if (!track) return;
        event.preventDefault();
        track.scrollLeft += event.deltaX;
        return;
    }

    if (event.deltaY < 0) {
        if (track && track.scrollLeft > 2) {
            event.preventDefault();
            track.scrollLeft += event.deltaY;
        }
        return;
    }

    if (event.deltaY > 0) {
        const maxScroll = track ? track.scrollWidth - track.clientWidth - 2 : 0;
        const inTrack = track?.contains(event.target);

        if (inTrack && track.scrollLeft < maxScroll - 2 && track.scrollLeft > 2) {
            event.preventDefault();
            track.scrollLeft += event.deltaY;
            return;
        }

        event.preventDefault();
        const delta = event.deltaY;
        closeInlineProject(() => {
            window.scrollBy({ top: delta, behavior: "auto" });
        });
    }
};

const bindExpandedScrollHandlers = () => {
    document.addEventListener("wheel", onExpandedWheel, { passive: false });
    document.addEventListener("touchstart", onExpandedTouchStart, { passive: true });
    document.addEventListener("touchmove", onExpandedTouchMove, { passive: false });
};

const closeInlineProject = (onClosed, { animate = true } = {}) => {
    if (!activeProjectDetail) {
        onClosed?.();
        return;
    }

    const { trigger, panel } = activeProjectDetail;
    activeProjectDetail = null;
    unbindExpandedScrollHandlers();
    trigger.classList.remove("is-expanded");

    if (!animate) {
        panel.remove();
        onClosed?.();
        return;
    }

    panel.classList.remove("is-open");
    panel.classList.add("is-closing");

    let finished = false;
    const finish = () => {
        if (finished) return;
        finished = true;
        panel.remove();
        onClosed?.();
    };

    panel.addEventListener("transitionend", (event) => {
        if (event.propertyName === "clip-path" || event.propertyName === "transform") {
            finish();
        }
    }, { once: true });

    window.setTimeout(finish, 780);
};

const openInlineProject = (row) => {
    if (activeProjectDetail?.trigger === row) {
        closeInlineProject();
        return;
    }

    if (activeProjectDetail) {
        closeInlineProject(null, { animate: false });
    }

    const images = readDetailImages(row);
    const chapters = readDetailChapters(row);
    const title = row.dataset.title || "Project";
    const slides = buildInlineSlides(row, images, chapters);
    const projectUrl = row.dataset.projectUrl || row.href || "#";
    const panel = document.createElement("article");
    panel.className = "pl-detail";
    panel.innerHTML = `
        <div class="pl-detail-main" data-inline-track tabindex="0" aria-label="${title} details">
            ${slides.map((item, index) => {
                const eyebrow = item.label || "Project";
                if (index === 0) {
                    return `
                        <section class="pl-detail-panel pl-detail-panel-hero">
                            <aside class="pl-detail-side">
                                <span class="pl-mark"><img src="/assets/img/wia-logo.svg" alt=""></span>
                                <h2>${escapeHtml(title)}</h2>
                                <p>${escapeHtml(row.dataset.location || "")}</p>
                                <dl>
                                    <dt>Client</dt><dd>${escapeHtml(row.dataset.client || "WIA Studio")}</dd>
                                    <dt>Typology</dt><dd>${escapeHtml(row.dataset.typology || "")}</dd>
                                    <dt>Size m2/ft2</dt><dd>${escapeHtml(row.dataset.size || "")}</dd>
                                    <dt>Status</dt><dd>${escapeHtml(row.dataset.status || "")}</dd>
                                </dl>
                                <div class="pl-detail-actions">
                                    <span>Share</span>
                                    <button type="button" data-inline-close>Close</button>
                                    <a href="${escapeHtml(projectUrl)}">Open page</a>
                                    <button type="button" data-inline-copy="${escapeHtml(projectUrl)}">Copy link</button>
                                </div>
                            </aside>
                            <figure class="pl-detail-hero">
                                <img src="${escapeHtml(optimizedImage(item.image, 1500))}" alt="${escapeHtml(title)}" loading="lazy" decoding="async">
                            </figure>
                            <article class="pl-detail-copy">
                                <span>${eyebrow}</span>
                                <p>${escapeHtml(row.dataset.summary || item.body)}</p>
                            </article>
                        </section>`;
                }

                if (item.type === "facts") {
                    return `
                        <section class="pl-detail-panel pl-detail-story">
                            <article>
                                <span>${eyebrow}</span>
                                <p>${escapeHtml(item.label)}</p>
                            </article>
                            <article class="pl-detail-copy">
                                <dl class="project-facts-slide">
                                    <dt>Client</dt><dd>${escapeHtml(row.dataset.client || "WIA Studio")}</dd>
                                    <dt>Typology</dt><dd>${escapeHtml(row.dataset.typology || "")}</dd>
                                    <dt>Size</dt><dd>${escapeHtml(row.dataset.size || "")}</dd>
                                    <dt>Status</dt><dd>${escapeHtml(row.dataset.status || "")}</dd>
                                    <dt>URL</dt><dd>${escapeHtml(projectUrl)}</dd>
                                </dl>
                            </article>
                        </section>`;
                }

                return `
                    <section class="pl-detail-panel pl-detail-story">
                        <article>
                            <span>${eyebrow}</span>
                            <p>${escapeHtml(item.label)}</p>
                            <p>${escapeHtml(item.body || "")}</p>
                        </article>
                        <figure class="pl-detail-image">
                            <img src="${escapeHtml(optimizedImage(item.image, 1300))}" alt="${escapeHtml(`${title} ${item.label}`)}" loading="lazy" decoding="async">
                        </figure>
                    </section>`;
            }).join("")}
        </div>
    `;

    row.classList.add("is-expanded");
    row.after(panel);

    const track = panel.querySelector("[data-inline-track]");
    const inlineGlide = track ? glideHorizontalTrack(track, { speed: 1.15, wheelMode: "gallery" }) : null;

    activeProjectDetail = { trigger: row, panel };

    panel.querySelector("[data-inline-copy]")?.addEventListener("click", async (event) => {
        const button = event.currentTarget;
        await navigator.clipboard.writeText(button.dataset.inlineCopy);
        button.textContent = "Copied";
    });

    panel.querySelector("[data-inline-close]")?.addEventListener("click", () => closeInlineProject());

    window.setTimeout(() => {
        requestAnimationFrame(() => {
            panel.classList.add("is-open");
            inlineGlide?.glideTo(0, true);
            scrollToElement(panel, prefersReducedMotion ? "auto" : "smooth");
            panel.scrollIntoView({
                behavior: prefersReducedMotion ? "auto" : "smooth",
                block: "nearest",
                inline: "center",
            });
        });
    }, 80);
};

document.querySelectorAll("[data-pl-expand]").forEach((row) => {
    row.addEventListener("click", (event) => {
        event.preventDefault();
        openInlineProject(row);
    });
});

document.querySelector("[data-share]")?.addEventListener("click", async () => {
    const payload = {
        title: document.title,
        url: window.location.href,
    };

    if (navigator.share) {
        await navigator.share(payload);
        return;
    }

    await navigator.clipboard.writeText(payload.url);
    document.querySelector("[data-share]").textContent = "Copied";
});

document.querySelector("[data-print]")?.addEventListener("click", () => {
    window.print();
});

document.querySelectorAll("[data-project-slide-track]").forEach((track) => {
    const slides = [...track.querySelectorAll(".project-slide")];
    const previous = document.querySelector("[data-slide-prev]");
    const next = document.querySelector("[data-slide-next]");

    if (!slides.length) return;

    const setActiveSlide = () => {
        const center = window.scrollY + window.innerHeight / 2;
        let activeIndex = 0;
        let activeDistance = Number.POSITIVE_INFINITY;

        slides.forEach((slide, index) => {
            const rect = slide.getBoundingClientRect();
            const slideCenter = window.scrollY + rect.top + rect.height / 2;
            const distance = Math.abs(center - slideCenter);
            if (distance < activeDistance) {
                activeIndex = index;
                activeDistance = distance;
            }
        });

        slides.forEach((slide, index) => slide.classList.toggle("is-active", index === activeIndex));
    };

    const scrollBySlide = (direction) => {
        const activeIndex = slides.findIndex((slide) => slide.classList.contains("is-active"));
        const nextIndex = Math.max(0, Math.min(slides.length - 1, activeIndex + direction));
        const nextSlide = slides[nextIndex];
        nextSlide?.scrollIntoView({ behavior: prefersReducedMotion ? "auto" : "smooth", block: "center" });
    };

    window.addEventListener("scroll", () => requestAnimationFrame(setActiveSlide), { passive: true });

    previous?.addEventListener("click", () => scrollBySlide(-1));
    next?.addEventListener("click", () => scrollBySlide(1));

    setActiveSlide();
});

const galleryDialog = document.getElementById("galleryDialog");
const galleryDialogImage = document.getElementById("galleryDialogImage");
const galleryDialogTitle = document.getElementById("galleryDialogTitle");

document.querySelectorAll("[data-gallery-image]").forEach((button) => {
    button.addEventListener("click", () => {
        if (!galleryDialog || !galleryDialogImage || !galleryDialogTitle) return;

        galleryDialogImage.src = button.dataset.galleryImage;
        galleryDialogImage.alt = button.dataset.galleryTitle || "Project image";
        galleryDialogTitle.textContent = button.dataset.galleryTitle || "";
        galleryDialog.showModal();
    });
});

document.querySelector("[data-gallery-close]")?.addEventListener("click", () => {
    galleryDialog?.close();
});

galleryDialog?.addEventListener("click", (event) => {
    if (event.target === galleryDialog) {
        galleryDialog.close();
    }
});

const filterButtons = document.querySelectorAll("[data-filter]");
const archiveRows = document.querySelectorAll("[data-project-type]");

filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const filter = button.dataset.filter;
        filterButtons.forEach((item) => item.classList.toggle("is-active", item === button));
        archiveRows.forEach((row) => {
            row.hidden = filter !== "all" && row.dataset.projectType !== filter;
        });
    });
});

filterButtons[0]?.classList.add("is-active");

document.querySelectorAll("[data-horizontal-track]").forEach((track) => {
    track.addEventListener("wheel", (event) => {
        if (window.innerWidth <= 920 || Math.abs(event.deltaX) > Math.abs(event.deltaY)) {
            return;
        }

        const movingRight = event.deltaY > 0;
        const movingLeft = event.deltaY < 0;
        const maxScroll = track.scrollWidth - track.clientWidth - 2;
        const canMoveRight = movingRight && track.scrollLeft < maxScroll;
        const canMoveLeft = movingLeft && track.scrollLeft > 2;

        if (!canMoveRight && !canMoveLeft) {
            return;
        }

        event.preventDefault();
        track.scrollLeft += event.deltaY;
    }, { passive: false });
});

const wiaProjectsApp = document.getElementById("wiaProjectsApp");

if (wiaProjectsApp && Array.isArray(window.WIA_PROJECTS)) {
    const projects = window.WIA_PROJECTS;
    const listView = document.getElementById("list-view");
    const detailView = document.getElementById("detail-view");
    const rows = [...document.querySelectorAll(".row")];
    const hTrack = document.getElementById("h-track");
    const hScroll = document.getElementById("d-hscroll");
    const progress = document.getElementById("h-prog");
    const leftArrow = document.querySelector("[data-wia-nudge='-1']");
    const rightArrow = document.querySelector("[data-wia-nudge='1']");
    const dragHint = document.getElementById("drag-hint");
    let activeProject = null;
    let scrollX = 0;
    let maxScrollX = 0;
    let hintTimer = null;
    let drag = { on: false, startX: 0, startScroll: 0 };

    const findProject = (id) => projects.find((project) => String(project.id) === String(id));

    const clampX = (value) => {
        maxScrollX = Math.max(0, hTrack.scrollWidth - hScroll.clientWidth);
        return Math.max(0, Math.min(maxScrollX, value));
    };

    const setTrackX = (value, animate = true) => {
        scrollX = clampX(value);
        hTrack.style.transition = animate ? "transform .45s cubic-bezier(.77,0,.175,1)" : "none";
        hTrack.style.transform = `translateX(${-scrollX}px)`;
        updateProjectControls();
    };

    const updateProjectControls = () => {
        maxScrollX = Math.max(0, hTrack.scrollWidth - hScroll.clientWidth);
        const percent = maxScrollX > 0 ? (scrollX / maxScrollX) * 100 : 0;
        progress.style.width = `${percent}%`;
        leftArrow.classList.toggle("gone", scrollX <= 2);
        rightArrow.classList.toggle("gone", scrollX >= maxScrollX - 2);
    };

    const showDragHint = () => {
        dragHint.classList.remove("fade");
        clearTimeout(hintTimer);
        hintTimer = setTimeout(() => dragHint.classList.add("fade"), 3200);
    };

    const panel = (className, width) => {
        const element = document.createElement("article");
        element.className = `h-panel ${className}`;
        element.style.width = `${width}px`;
        return element;
    };

    const buildProjectPanels = (project) => {
        hTrack.innerHTML = "";
        const visibleWidth = hScroll.clientWidth || 900;
        const hero = panel("h-panel-hero", Math.max(680, Math.min(visibleWidth * 0.9, 980)));
        hero.innerHTML = `<img src="${project.hero_image}" alt="${project.title}"><span class="panel-caption">${project.title} / ${project.location}</span>`;
        hTrack.appendChild(hero);

        const overview = panel("h-panel-text", 360);
        overview.innerHTML = `<span class="panel-eyebrow">Overview</span><h2>${project.title}</h2><p>${project.summary}</p>`;
        hTrack.appendChild(overview);

        project.chapters.forEach((chapter) => {
            const chapterPanel = panel("h-panel-chapter", Math.max(680, Math.min(visibleWidth * 0.76, 820)));
            chapterPanel.innerHTML = `
                <figure><img src="${chapter.image}" alt="${chapter.label}"></figure>
                <div>
                    <span class="panel-eyebrow">${String(chapter.position).padStart(2, "0")}</span>
                    <h3>${chapter.label}</h3>
                    <p>${chapter.body}</p>
                </div>`;
            hTrack.appendChild(chapterPanel);
        });

        const credits = panel("h-panel-credits", 420);
        credits.innerHTML = `
            <span class="panel-eyebrow">Project Credits</span>
            <h2>Team and collaborators</h2>
            ${project.credits.map((credit) => `<p><strong>${credit.role}</strong>${credit.name}</p>`).join("")}
            <p><strong>Contact</strong>hiuhu@wia.com / studio@wia.com</p>`;
        hTrack.appendChild(credits);

        requestAnimationFrame(() => setTrackX(0, false));
    };

    const openProject = (id) => {
        const project = findProject(id);
        if (!project) return;

        if (activeProject && String(activeProject.id) === String(id)) {
            closeProject();
            return;
        }

        activeProject = project;
        rows.forEach((row) => row.classList.toggle("active", String(row.dataset.id) === String(id)));
        listView.classList.add("shrunk");
        detailView.classList.add("open");

        document.getElementById("sb-name").textContent = project.title;
        document.getElementById("sb-loc").textContent = project.location;
        document.getElementById("sb-factsheet").href = project.factsheet_url;
        document.getElementById("sb-meta").innerHTML = `
            <div class="meta-row"><span class="meta-lbl">Year</span><span class="meta-val">${project.year}</span></div>
            <div class="meta-row"><span class="meta-lbl">Client</span><span class="meta-val">${project.client}</span></div>
            <div class="meta-row"><span class="meta-lbl">Typology</span><span class="meta-val">${project.typology}</span></div>
            <div class="meta-row"><span class="meta-lbl">Size</span><span class="meta-val">${project.size} m2 / ft2</span></div>
            <div class="meta-row"><span class="meta-lbl">Status</span><span class="meta-val">${project.status}</span></div>`;

        setTimeout(() => {
            buildProjectPanels(project);
            showDragHint();
        }, 260);
    };

    const closeProject = () => {
        activeProject = null;
        rows.forEach((row) => row.classList.remove("active"));
        listView.classList.remove("shrunk");
        detailView.classList.remove("open");
        setTimeout(() => {
            hTrack.innerHTML = "";
            scrollX = 0;
            updateProjectControls();
        }, 550);
    };

    rows.forEach((row) => {
        row.addEventListener("click", () => openProject(row.dataset.id));
    });

    document.querySelector("[data-wia-close]")?.addEventListener("click", closeProject);

    document.querySelectorAll("[data-wia-nudge]").forEach((button) => {
        button.addEventListener("click", () => {
            const direction = Number(button.dataset.wiaNudge);
            setTrackX(scrollX + direction * hScroll.clientWidth * 0.82);
            dragHint.classList.add("fade");
        });
    });

    hScroll.addEventListener("wheel", (event) => {
        if (!activeProject || Math.abs(event.deltaX) > Math.abs(event.deltaY)) return;
        event.preventDefault();
        setTrackX(scrollX + event.deltaY * 1.1, false);
        dragHint.classList.add("fade");
    }, { passive: false });

    hScroll.addEventListener("mousedown", (event) => {
        if (!activeProject || event.target.closest("button,a")) return;
        drag = { on: true, startX: event.clientX, startScroll: scrollX };
        hTrack.classList.add("dragging");
        dragHint.classList.add("fade");
    });

    document.addEventListener("mousemove", (event) => {
        if (!drag.on) return;
        setTrackX(drag.startScroll + drag.startX - event.clientX, false);
    });

    document.addEventListener("mouseup", () => {
        if (!drag.on) return;
        drag.on = false;
        hTrack.classList.remove("dragging");
        setTrackX(scrollX);
    });

    hScroll.addEventListener("touchstart", (event) => {
        if (!activeProject) return;
        drag = { on: true, startX: event.touches[0].clientX, startScroll: scrollX };
        hTrack.classList.add("dragging");
    }, { passive: true });

    hScroll.addEventListener("touchmove", (event) => {
        if (!drag.on) return;
        setTrackX(drag.startScroll + drag.startX - event.touches[0].clientX, false);
    }, { passive: true });

    hScroll.addEventListener("touchend", () => {
        drag.on = false;
        hTrack.classList.remove("dragging");
        setTrackX(scrollX);
    }, { passive: true });

    document.addEventListener("keydown", (event) => {
        if (!activeProject) return;
        if (event.key === "Escape") closeProject();
        if (event.key === "ArrowRight") setTrackX(scrollX + hScroll.clientWidth * 0.82);
        if (event.key === "ArrowLeft") setTrackX(scrollX - hScroll.clientWidth * 0.82);
    });

    document.querySelectorAll("[data-wia-filter]").forEach((button) => {
        button.addEventListener("click", () => {
            const filter = button.dataset.wiaFilter;
            document.querySelectorAll("[data-wia-filter]").forEach((item) => item.classList.toggle("on", item === button));
            let count = 0;
            rows.forEach((row) => {
                const visible = filter === "all" || row.dataset.t === filter;
                row.hidden = !visible;
                if (visible) count += 1;
            });
            document.getElementById("pcount").textContent = `${count} PROJECT${count === 1 ? "" : "S"}`;
            if (activeProject) closeProject();
        });
    });

    window.addEventListener("resize", () => {
        if (activeProject) buildProjectPanels(activeProject);
    });
}
