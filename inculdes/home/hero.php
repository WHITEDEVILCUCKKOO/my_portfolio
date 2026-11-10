
<!-- ============================================
     ABHI PORTFOLIO
     CINEMATIC HERO + ABOUT SCROLL ANIMATION
============================================ -->

<section class="abh-scroll-scene" id="home">

    <div class="abh-scroll-track">

        <div class="abh-sticky-stage">

            <!-- BACKGROUND -->
            <div class="abh-scene-glow"></div>
            <div class="abh-scene-ring"></div>
            <div class="abh-scene-grid"></div>


            <!-- HERO LEFT CONTENT -->

            <div class="abh-hero-copy">

                <p class="abh-role">
                    <span class="abh-live-dot"></span>
                    <?= $v('title') ?>
                </p>

                <h1 class="abh-h1">
                    <?= $v('hero_heading') ?>
                </h1>

                <p class="abh-sub">
                    <?= $v('hero_sub') ?>
                </p>

                <div class="abh-actions">

                    <a class="abh-btn abh-btn-pri"
                       href="#projects">
                        View My Work <span>↗</span>
                    </a>

                    <a class="abh-btn abh-btn-sec"
                       href="#contact">
                        Contact Me <span>→</span>
                    </a>

                    <?php if ($cv): ?>
                        <a class="abh-btn abh-btn-sec"
                           href="<?= abh_e($cv) ?>"
                           download>
                            Download CV ↓
                        </a>
                    <?php endif; ?>

                </div>

                <div class="abh-scroll-hint">
                    <span>SCROLL TO EXPLORE</span>
                    <span class="abh-hint-line"></span>
                </div>

            </div>


            <!-- CENTER PROFILE IMAGE -->

            <div class="abh-scroll-image">

                <div class="abh-image-halo"></div>

                <img
                    src="assets/images/abh-profile.png"
                    alt="Abhi - Full Stack Developer">

            </div>


            <!-- RIGHT EXPERTISE -->

            <div class="abh-expertise-card">

                <div class="abh-expertise-heading">
                    <span>✳</span>
                    MY EXPERTISE
                </div>

                <ul>
                    <?php foreach ($stack as $s): ?>
                        <li>
                            <span class="abh-tech-square"></span>
                            <span class="abh-tech-dot"></span>
                            <?= abh_e($s) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>


            <!-- CREATIVE CARD -->

            <div class="abh-creative-card">

                <strong>01</strong>

                <span>
                    CREATIVE<br>
                    DEVELOPER
                </span>

            </div>


            <!-- AVAILABILITY -->

            <div class="abh-availability">

                <span>AVAILABLE FOR PROJECTS</span>
                <i></i>

            </div>


            <!-- =================================
                 ABOUT CONTENT
            ================================== -->

            <div class="abh-about-copy">

                <p class="abh-about-label">
                    <span></span>
                    GET TO KNOW ME
                </p>

                <h2 class="abh-about-title">
                    About <span>Me.</span>
                </h2>

                <p class="abh-about-description">
                    <?= $v('about') ?>
                </p>

                <div class="abh-about-details">

                    <div class="abh-about-detail">
                        <span class="abh-detail-number">01</span>
                        <span>Creative Thinking</span>
                    </div>

                    <div class="abh-about-detail">
                        <span class="abh-detail-number">02</span>
                        <span>Clean Development</span>
                    </div>

                    <div class="abh-about-detail">
                        <span class="abh-detail-number">03</span>
                        <span>Modern Web Solutions</span>
                    </div>

                </div>

                <a href="#contact" class="abh-about-link">
                    Let's Work Together
                    <span>↗</span>
                </a>

            </div>


            <!-- ABOUT CAPTION -->

            <div class="abh-about-caption">
                <span>CREATIVE MIND. CLEAN CODE.</span>
                <i></i>
            </div>

        </div>

    </div>

</section>


<style>

/* ============================================
   01. MAIN SECTION
============================================ */

.abh-scroll-scene {
    position: relative;
    width: 100%;
    overflow: clip;
    background: #090909;
    color: #fff;
}

.abh-scroll-track {
    height: 500vh;
    position: relative;
}

.abh-sticky-stage {
    --scroll-progress: 0;
    --about-progress: 0;

    position: sticky;
    top: 0;

    width: 100%;
    height: 100vh;
    height: 100svh;

    min-height: 650px;

    overflow: hidden;
    isolation: isolate;

    background: #090909;
}


/* ============================================
   02. BACKGROUND
============================================ */

.abh-scene-glow {
    position: absolute;
    z-index: -2;

    width: 750px;
    height: 750px;

    top: 50%;
    left: 60%;

    transform: translate(-50%, -50%);

    border-radius: 50%;

    background: #b76b30;
    filter: blur(180px);

    opacity: calc(.16 * (1 - var(--about-progress)));

    pointer-events: none;
}

.abh-scene-ring {
    position: absolute;
    z-index: -1;

    width: 590px;
    height: 590px;

    top: 50%;
    left: 57%;

    transform: translate(-50%, -50%);

    border: 1px solid #d99b5e24;
    border-radius: 50%;

    opacity: calc(1 - var(--about-progress));

    pointer-events: none;
}

.abh-scene-ring::before,
.abh-scene-ring::after {
    content: "";

    position: absolute;
    inset: 35px;

    border: 1px solid #d99b5e17;
    border-radius: 50%;
}

.abh-scene-ring::after {
    inset: -35px;
    border-style: dashed;
}

.abh-scene-grid {
    position: absolute;
    z-index: -2;
    inset: 0;

    opacity: .12;

    background-image:
        linear-gradient(#ffffff0a 1px, transparent 1px),
        linear-gradient(90deg, #ffffff0a 1px, transparent 1px);

    background-size: 75px 75px;

    mask-image:
        linear-gradient(to right, transparent, #000 30%, transparent);
}


/* ============================================
   03. HERO LEFT
============================================ */

.abh-hero-copy {
    position: absolute;
    z-index: 5;

    top: 50%;
    left: max(5vw, calc((100vw - 1320px) / 2));

    width: min(43vw, 680px);

    transform: translateY(-50%);

    will-change: transform, opacity;
}

.abh-role {
    display: flex;
    align-items: center;
    gap: 12px;

    color: #d99b5e;

    font-size: 12px;
    font-weight: 650;
    letter-spacing: 3px;
    text-transform: uppercase;

    margin: 0 0 23px;
}

.abh-live-dot {
    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: #d99b5e;
    box-shadow: 0 0 14px #d99b5e;
}

.abh-hero-copy .abh-h1 {
    max-width: 750px;

    color: #fff;

    font-size: clamp(48px, 5.15vw, 84px);
    font-weight: 750;
    line-height: 1.08;
    letter-spacing: -3.5px;

    margin: 0 0 27px;
}

.abh-hero-copy .abh-sub {
    max-width: 570px;

    color: #999;

    font-size: 17px;
    line-height: 1.95;

    margin: 0 0 32px;
}


/* BUTTONS */

.abh-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 13px;
}

.abh-btn {
    min-height: 54px;
    padding: 0 23px;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 13px;

    border-radius: 6px;

    font-size: 13px;
    font-weight: 650;

    text-decoration: none;

    transition: .3s ease;
}

.abh-btn-pri {
    background: #d99b5e;
    color: #111;
}

.abh-btn-sec {
    color: #fff;
    background: transparent;
    border: 1px solid #373737;
}

.abh-btn:hover {
    transform: translateY(-4px);
    border-color: #d99b5e;
}

.abh-btn-pri:hover {
    background: #fff;
}


/* SCROLL HINT */

.abh-scroll-hint {
    display: flex;
    align-items: center;
    gap: 15px;

    margin-top: 55px;

    color: #777;

    font-size: 9px;
    letter-spacing: 3px;
}

.abh-hint-line {
    width: 65px;
    height: 1px;

    background: #d99b5e;

    transform-origin: left;

    animation: abhHint 1.8s infinite;
}

@keyframes abhHint {
    0%, 100% {
        transform: scaleX(.35);
    }

    50% {
        transform: scaleX(1);
    }
}


/* ============================================
   04. PROFILE IMAGE
============================================ */

.abh-scroll-image {
    position: absolute;
    z-index: 3;

    top: 50%;
    left: 57%;

    width: clamp(300px, 30vw, 450px);

    transform:
        translate(-50%, -50%)
        translateX(var(--image-x, 0px))
        rotate(var(--image-rotation, 0deg))
        scale(var(--image-scale, .85));

    transform-origin: center center;

    will-change: transform;
}

.abh-scroll-image img {
    position: relative;
    z-index: 2;

    display: block;

    width: 100%;
    height: auto;

    object-fit: contain;

    /* ORIGINAL IMAGE - NO FILTER */
    filter: none !important;
}

.abh-image-halo {
    position: absolute;

    width: 90%;
    height: 75%;

    top: 15%;
    left: 5%;

    border-radius: 50%;

    background: #d99b5e;

    filter: blur(100px);
    opacity: .23;
}


/* ============================================
   05. EXPERTISE
============================================ */

.abh-expertise-card {
    position: absolute;
    z-index: 6;

    top: 50%;
    right: max(5vw, calc((100vw - 1320px) / 2));

    width: 225px;

    padding: 24px 22px;

    transform: translateY(-50%);

    background: rgba(23, 23, 23, .94);

    border: 1px solid #ffffff17;
    border-radius: 13px;

    backdrop-filter: blur(20px);
}

.abh-expertise-heading {
    display: flex;
    align-items: center;
    gap: 11px;

    color: #c58b54;

    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;

    margin-bottom: 18px;
}

.abh-expertise-heading span {
    font-size: 18px;
}

.abh-expertise-card ul {
    padding: 0;
    margin: 0;
    list-style: none;
}

.abh-expertise-card li {
    min-height: 49px;

    display: flex;
    align-items: center;
    gap: 12px;

    color: #c6c6c6;

    font-size: 13px;

    border-bottom: 1px solid #ffffff0c;
}

.abh-tech-square {
    width: 9px;
    height: 9px;

    border-radius: 2px;
    background: #5579ff;
}

.abh-tech-dot {
    width: 5px;
    height: 5px;

    border-radius: 50%;
    background: #d99b5e;
}


/* ============================================
   06. CREATIVE CARD
============================================ */

.abh-creative-card {
    position: absolute;
    z-index: 6;

    top: 16%;
    right: max(6vw, calc((100vw - 1300px) / 2));

    display: flex;
    align-items: center;
    gap: 14px;

    padding: 18px 22px;

    background: #171717;

    border: 1px solid #ffffff18;
    border-radius: 12px;
}

.abh-creative-card strong {
    color: #d99b5e;
    font-size: 35px;
}

.abh-creative-card span {
    color: #aaa;

    font-size: 9px;
    line-height: 1.8;
    letter-spacing: 2px;
}


/* AVAILABILITY */

.abh-availability {
    position: absolute;
    z-index: 6;

    right: 8%;
    bottom: 8%;

    display: flex;
    align-items: center;
    gap: 13px;

    color: #777;

    font-size: 9px;
    letter-spacing: 2px;
}

.abh-availability i,
.abh-about-caption i {
    width: 9px;
    height: 9px;

    border-radius: 50%;

    background: #d99b5e;
    box-shadow: 0 0 15px #d99b5e;
}


/* ============================================
   07. ABOUT CONTENT
============================================ */

.abh-about-copy {
    position: absolute;
    z-index: 5;

    top: 50%;
    left: max(5vw, calc((100vw - 1320px) / 2));

    width: min(43vw, 620px);

    opacity: 0;
    visibility: hidden;

    transform: translate(-65px, -50%);

    pointer-events: none;

    will-change: transform, opacity;
}

.abh-about-label {
    display: flex;
    align-items: center;
    gap: 12px;

    color: #d99b5e;

    font-size: 11px;
    font-weight: 600;
    letter-spacing: 3px;

    margin: 0 0 25px;
}

.abh-about-label span {
    width: 27px;
    height: 2px;

    background: #d99b5e;
}

.abh-about-title {
    color: #fff;

    font-size: clamp(55px, 6vw, 85px);
    font-weight: 750;
    line-height: 1.05;
    letter-spacing: -3px;

    margin: 0 0 25px;
}

.abh-about-title span {
    color: #d99b5e;
}

.abh-about-description {
    max-width: 560px;

    color: #a3a3a3;

    font-size: 17px;
    line-height: 2;

    margin: 0 0 27px;
}


/* ABOUT DETAILS */

.abh-about-details {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;

    margin: 25px 0;
}

.abh-about-detail {
    display: flex;
    align-items: center;
    gap: 8px;

    padding: 11px 13px;

    color: #bbb;
    font-size: 10px;

    background: #ffffff08;

    border: 1px solid #ffffff12;
    border-radius: 5px;
}

.abh-detail-number {
    color: #d99b5e;
    font-weight: 700;
}

.abh-about-link {
    display: inline-flex;
    align-items: center;
    gap: 15px;

    color: #d99b5e;

    font-size: 14px;
    font-weight: 600;

    text-decoration: none;

    border-bottom: 1px solid #d99b5e55;
    padding-bottom: 10px;
}

.abh-about-link span {
    transition: transform .3s ease;
}

.abh-about-link:hover span {
    transform: translate(5px, -3px);
}


/* ABOUT CAPTION */

.abh-about-caption {
    position: absolute;
    z-index: 5;

    right: 8%;
    bottom: 8%;

    display: flex;
    align-items: center;
    gap: 13px;

    color: #888;

    font-size: 9px;
    letter-spacing: 2px;

    opacity: 0;
    visibility: hidden;
}


/* ============================================
   08. TABLET
============================================ */

@media (max-width: 1100px) {

    .abh-hero-copy {
        width: 43vw;
    }

    .abh-hero-copy .abh-h1 {
        font-size: 53px;
    }

    .abh-scroll-image {
        left: 58%;
        width: 34vw;
    }

    .abh-expertise-card {
        right: 3%;
        width: 185px;
    }

    .abh-about-copy {
        width: 43vw;
    }

    .abh-about-description {
        font-size: 15px;
    }

}


/* ============================================
   09. MOBILE
============================================ */

@media (max-width: 760px) {

    .abh-scroll-track {
        height: auto;
    }

    .abh-sticky-stage {
        position: relative;

        height: auto;
        min-height: auto;

        padding: 120px 20px 50px;

        display: flex;
        flex-direction: column;
        align-items: center;

        overflow: hidden;
    }

    .abh-hero-copy,
    .abh-scroll-image,
    .abh-expertise-card,
    .abh-creative-card,
    .abh-availability,
    .abh-about-copy,
    .abh-about-caption {

        position: relative;

        inset: auto;
        top: auto;
        left: auto;
        right: auto;
        bottom: auto;

        width: 100%;

        transform: none;

        opacity: 1;
        visibility: visible;
    }

    .abh-hero-copy {
        order: 1;
    }

    .abh-hero-copy .abh-h1 {
        font-size: clamp(43px, 11vw, 65px);
        letter-spacing: -2px;
    }

    .abh-hero-copy .abh-sub {
        font-size: 14px;
    }

    .abh-scroll-image {
        order: 2;

        width: min(100%, 370px);

        margin: 35px auto;

        transform: none !important;
    }

    .abh-expertise-card {
        order: 3;

        width: min(100%, 350px);

        margin: 15px 0;
    }

    .abh-creative-card {
        display: none;
    }

    .abh-availability {
        order: 4;

        justify-content: center;
        margin-top: 20px;
    }

    .abh-about-copy {
        order: 5;

        margin-top: 65px;

        pointer-events: auto;
    }

    .abh-about-title {
        font-size: 50px;
    }

    .abh-about-description {
        font-size: 14px;
    }

    .abh-about-details {
        gap: 7px;
    }

    .abh-about-detail {
        font-size: 9px;
    }

    .abh-about-caption {
        order: 6;

        justify-content: center;
        margin-top: 25px;
    }

    .abh-scene-ring {
        width: 340px;
        height: 340px;

        top: 55%;
        left: 50%;
    }

}


/* ============================================
   10. REDUCED MOTION
============================================ */

@media (prefers-reduced-motion: reduce) {

    .abh-scroll-scene *,
    .abh-scroll-scene *::before,
    .abh-scroll-scene *::after {

        animation: none !important;
        transition: none !important;

    }

}

</style>


<script>

/* ============================================
   ABHI CINEMATIC SCROLL ENGINE
============================================ */

(() => {

    const track = document.querySelector('.abh-scroll-track');
    const stage = document.querySelector('.abh-sticky-stage');

    const image = document.querySelector('.abh-scroll-image');
    const hero = document.querySelector('.abh-hero-copy');
    const about = document.querySelector('.abh-about-copy');

    const expertise = document.querySelector('.abh-expertise-card');
    const creative = document.querySelector('.abh-creative-card');
    const availability = document.querySelector('.abh-availability');

    const caption = document.querySelector('.abh-about-caption');

    if (!track || !stage || !image || !hero || !about) {
        return;
    }


    /* HELPERS */

    let ticking = false;

    const clamp = (value, min = 0, max = 1) => {
        return Math.max(min, Math.min(max, value));
    };

    const ease = (value) => {
        return value * value * (3 - 2 * value);
    };


    /* =================================
       MAIN SCROLL UPDATE
    ================================= */

    function updateAnimation() {

        ticking = false;

        /* MOBILE NORMAL LAYOUT */

        if (window.innerWidth <= 760) {
            return;
        }


        /* SCROLL PROGRESS */

        const rect = track.getBoundingClientRect();

        const maxScroll =
            track.offsetHeight - window.innerHeight;

        if (maxScroll <= 0) return;

        const progress = clamp(
            -rect.top / maxScroll
        );


        /* =================================
           PHASE 1 - HERO HIDE
        ================================= */

        const heroProgress = ease(
            clamp(progress / 0.40)
        );

        hero.style.opacity =
            1 - heroProgress;

        hero.style.transform =
            `translate(${heroProgress * -65}px, -50%)`;


        /* =================================
           PHASE 2 - IMAGE ZOOM
        ================================= */

        const zoomProgress = ease(
            clamp(progress / 0.58)
        );

        const imageScale =
            0.85 + (zoomProgress * 0.48);


        /* =================================
           PHASE 3 - IMAGE ROTATION
        ================================= */

        const rotation =
            zoomProgress * 360;


        /* =================================
           PHASE 4 - IMAGE MOVE RIGHT
        ================================= */

        const moveProgress = ease(
            clamp((progress - 0.35) / 0.65)
        );

        const moveX =
            window.innerWidth * 0.24 * moveProgress;

        const finalScale =
            imageScale - (moveProgress * 0.35);


        image.style.setProperty(
            '--image-scale',
            finalScale
        );

        image.style.setProperty(
            '--image-rotation',
            rotation + 'deg'
        );

        image.style.setProperty(
            '--image-x',
            moveX + 'px'
        );


        /* =================================
           PHASE 5 - ABOUT REVEAL
        ================================= */

        const aboutProgress = ease(
            clamp((progress - 0.72) / 0.35)
        );

        stage.style.setProperty(
            '--about-progress',
            aboutProgress
        );

        about.style.opacity =
            aboutProgress;

        about.style.visibility =
            aboutProgress > 0.01 ? 'visible' : 'hidden';

        about.style.transform =
            `translate(${(1 - aboutProgress) * -65}px, -50%)`;

        about.style.pointerEvents =
            aboutProgress > 0.95 ? 'auto' : 'none';


        /* =================================
           PHASE 6 - ORIGINAL IMAGE
           NO BLUE FILTER
           NO FADE OUT
        ================================= */

        image.style.opacity = 1;

        image.style.filter = 'none';


        /* =================================
           PHASE 7 - REMOVE GOLD CIRCLES
        ================================= */

        /* CSS variable controls both circles and glow */
        stage.style.setProperty(
            '--about-progress',
            aboutProgress
        );


        /* =================================
           PHASE 8 - HIDE HERO CARDS
        ================================= */

        const cardProgress = ease(
            clamp((progress - 0.38) / 0.25)
        );

        const cardOpacity =
            1 - cardProgress;

        [expertise, creative, availability].forEach(card => {

            if (!card) return;

            card.style.opacity = cardOpacity;

            card.style.visibility =
                cardOpacity > 0.01 ? 'visible' : 'hidden';

            card.style.pointerEvents = 'none';

        });


        /* =================================
           PHASE 9 - ABOUT CAPTION
        ================================= */

        if (caption) {

            caption.style.opacity =
                aboutProgress;

            caption.style.visibility =
                aboutProgress > 0.01 ? 'visible' : 'hidden';

        }

    }


    /* =================================
       PERFORMANCE
    ================================= */

    function requestUpdate() {

        if (!ticking) {

            requestAnimationFrame(updateAnimation);

            ticking = true;

        }

    }


    /* EVENTS */

    window.addEventListener(
        'scroll',
        requestUpdate,
        { passive: true }
    );

    window.addEventListener(
        'resize',
        requestUpdate
    );


    /* INITIAL UPDATE */

    updateAnimation();

})();

</script>
