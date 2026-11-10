<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NOIR AURUM | The Art of Fine Jewellery</title>
    <meta name="description" content="Exceptional gold, diamond and pearl jewellery designed to celebrate beauty, individuality and timeless moments.">
    <meta property="og:title" content="NOIR AURUM | The Art of Fine Jewellery">
    <meta property="og:type" content="website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@300;400;500&family=Manrope:wght@300;400;500&display=swap" rel="stylesheet">
    <script type="importmap">{"imports":{"three":"https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js","three/addons/":"https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"}}</script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lenis@1.1.14/dist/lenis.min.js"></script>
    <style>
        :root {
            --bg: #050505;
            --bg2: #101010;
            --gold: #C6A46A;
            --soft: #E5C995;
            --tx: #F5F1E9;
            --mu: #99948B;
            --serif: 'Cormorant Garamond', Georgia, serif;
            --sans: 'Manrope', system-ui, sans-serif;
            --pad: clamp(1.2rem, 5vw, 5rem)
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html.lenis {
            height: auto
        }

        body {
            background: var(--bg);
            color: var(--tx);
            font: 300 1rem/1.8 var(--sans);
            overflow-x: hidden
        }

        img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        a {
            color: inherit;
            text-decoration: none
        }

        button {
            font: inherit;
            color: inherit;
            background: none;
            border: 0;
            cursor: pointer
        }

        :focus-visible {
            outline: 1px solid var(--soft);
            outline-offset: 4px
        }

        h1,
        h2,
        h3 {
            font-family: var(--serif);
            font-weight: 300;
            line-height: 1.05
        }

        h1 {
            font-size: clamp(3rem, 7.4vw, 7.5rem)
        }

        h2 {
            font-size: clamp(2.4rem, 5vw, 5rem)
        }

        h3 {
            font-size: 1.7rem
        }

        .lbl {
            font-size: .72rem;
            letter-spacing: .32em;
            text-transform: uppercase;
            color: var(--gold)
        }

        .sec {
            position: relative;
            padding: clamp(6rem, 13vw, 12rem) var(--pad)
        }

        .ph {
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at 30% 30%, #2b2315, #0c0c0c)
        }

        .line {
            width: 70px;
            height: 1px;
            background: var(--gold);
            margin: 2rem 0
        }

        .cta {
            display: inline-block;
            padding: 1.05rem 2.4rem;
            border: 1px solid var(--gold);
            font-size: .75rem;
            letter-spacing: .3em;
            transition: .4s
        }

        .cta:hover {
            background: var(--gold);
            color: #050505
        }

        .ln {
            display: inline-block;
            font-size: .72rem;
            letter-spacing: .25em;
            text-transform: uppercase;
            border-bottom: 1px solid var(--gold);
            padding-bottom: 4px
        }

        #prog {
            position: fixed;
            top: 0;
            left: 0;
            height: 1px;
            width: 100%;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: 0;
            z-index: 300
        }

        #loader {
            position: fixed;
            inset: 0;
            z-index: 400;
            background: var(--bg);
            display: grid;
            place-content: center;
            justify-items: center;
            gap: 1.4rem
        }

        #loader b {
            font: 300 1.8rem var(--serif);
            letter-spacing: .5em;
            padding-left: .5em
        }

        #loader i {
            display: block;
            width: 160px;
            height: 1px;
            background: #222;
            position: relative;
            overflow: hidden
        }

        #loader i::after {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: translateX(-100%);
            animation: ld 1.4s ease-in-out infinite
        }

        @keyframes ld {
            to {
                transform: translateX(100%)
            }
        }

        /* header */
        header {
            position: fixed;
            inset: 0 0 auto;
            z-index: 200;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 1.5rem var(--pad);
            transition: background .5s, padding .5s
        }

        header.s {
            background: rgba(5, 5, 5, .72);
            backdrop-filter: blur(16px);
            padding-block: .9rem
        }

        .logo {
            font: 400 1.5rem var(--serif);
            letter-spacing: .4em
        }

        nav {
            display: flex;
            gap: 2.6rem
        }

        nav a {
            font-size: .72rem;
            letter-spacing: .25em;
            color: var(--tx);
            opacity: .75;
            transition: .3s
        }

        nav a:hover {
            opacity: 1;
            color: var(--soft)
        }

        .ic {
            display: flex;
            justify-content: flex-end;
            gap: .4rem
        }

        .ic button {
            position: relative;
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center
        }

        .ic svg {
            width: 19px;
            height: 19px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.2
        }

        #bc {
            position: absolute;
            top: 6px;
            right: 4px;
            font-size: .62rem;
            color: var(--gold)
        }

        .bg {
            display: none
        }

        /* hero */
        .hero {
            min-height: 100svh;
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            align-items: center
        }

        .hero-t {
            padding: 8rem 2rem 6rem var(--pad);
            position: relative;
            z-index: 2
        }

        .hero h1 .l {
            display: block;
            overflow: hidden;
            padding-bottom: .08em
        }

        .hero h1 .ch {
            display: inline-block
        }

        .hero p {
            max-width: 26rem;
            color: var(--mu);
            margin: 2rem 0 2.6rem
        }

        .hero-i {
            height: 100svh;
            clip-path: inset(0 0 0 0)
        }

        .hero-i img {
            transform-origin: center;
            scale: 1.04
        }

        .scr {
            position: absolute;
            left: var(--pad);
            bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: .65rem;
            letter-spacing: .3em;
            color: var(--mu)
        }

        .scr i {
            width: 1px;
            height: 50px;
            background: linear-gradient(var(--gold), transparent);
            animation: dr 2s infinite
        }

        @keyframes dr {
            0% {
                transform: scaleY(0);
                transform-origin: top
            }

            50% {
                transform: scaleY(1);
                transform-origin: top
            }

            51% {
                transform-origin: bottom
            }

            100% {
                transform: scaleY(0);
                transform-origin: bottom
            }
        }

        /* story */
        .story {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: clamp(2rem, 8vw, 9rem);
            align-items: center
        }

        .story .ph {
            aspect-ratio: 4/5
        }

        .story .ph img {
            height: 120%;
            margin-top: -10%
        }

        .story p {
            color: var(--mu);
            max-width: 28rem
        }

        /* collections */
        .col-g {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 2rem 1.5rem;
            margin-top: 5rem
        }

        .ci {
            position: relative;
            display: block
        }

        .ci .ph {
            height: 100%
        }

        .ci img {
            transition: scale 1.4s cubic-bezier(.2, .8, .2, 1)
        }

        .ci:hover img {
            scale: 1.08
        }

        .ci:nth-child(1) {
            grid-column: 1/6;
            aspect-ratio: 3/4
        }

        .ci:nth-child(2) {
            grid-column: 7/13;
            aspect-ratio: 4/3;
            margin-top: 8rem
        }

        .ci:nth-child(3) {
            grid-column: 2/7;
            aspect-ratio: 1;
            margin-top: -2rem
        }

        .ci:nth-child(4) {
            grid-column: 8/13;
            aspect-ratio: 3/4;
            margin-top: 4rem
        }

        .ci div.t {
            position: absolute;
            inset: auto 0 0;
            padding: 1.6rem;
            background: linear-gradient(transparent, rgba(5, 5, 5, .85));
            z-index: 2
        }

        .ci .n {
            font: italic 1.1rem var(--serif);
            color: var(--gold)
        }

        /* 3D */
        .scene {
            position: relative;
            height: 420vh
        }

        .stage {
            position: sticky;
            top: 0;
            height: 100svh;
            overflow: hidden
        }

        #gl {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%
        }

        #dark {
            position: absolute;
            inset: 0;
            background: var(--bg);
            pointer-events: none
        }

        .cap {
            position: absolute;
            left: var(--pad);
            bottom: 12%;
            max-width: 22rem;
            opacity: 0;
            pointer-events: none
        }

        .cap h3 {
            color: var(--soft);
            margin: .4rem 0
        }

        .cap p {
            color: var(--mu);
            font-size: .9rem
        }

        .fin {
            position: absolute;
            inset: auto 0 12%;
            text-align: center;
            opacity: 0;
            pointer-events: none
        }

        .fin .lbl {
            margin-bottom: 1rem
        }

        /* products */
        .pg {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-top: 5rem
        }

        .pr:nth-child(even) {
            margin-top: 4rem
        }

        .pr .ph {
            aspect-ratio: 3/4
        }

        .pr img {
            transition: scale 1.2s
        }

        .pr:hover img {
            scale: 1.06
        }

        .pr h3 {
            font-size: 1.4rem;
            margin-top: 1.2rem
        }

        .pr .pc {
            color: var(--gold);
            font: 400 1.05rem var(--serif);
            letter-spacing: .08em;
            margin: .2rem 0 .6rem
        }

        .pr .dt {
            font-size: .85rem;
            color: var(--mu);
            max-height: 0;
            overflow: hidden;
            transition: max-height .5s
        }

        .pr .dt.o {
            max-height: 5rem
        }

        .pa {
            display: flex;
            align-items: center;
            gap: 1.4rem;
            margin-top: .8rem
        }

        .hb {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            margin: -10px 0 -10px -10px
        }

        .hb svg {
            width: 19px;
            height: 19px;
            stroke: var(--tx);
            stroke-width: 1.2;
            fill: none
        }

        .hb.on svg {
            fill: var(--gold);
            stroke: var(--gold)
        }

        /* craft */
        .cr {
            background: var(--bg2)
        }

        .cr h2 {
            max-width: 55rem
        }

        .cr-g {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
            margin-top: 6rem
        }

        .cr-g>div:nth-child(2) {
            margin-top: 6rem
        }

        .cr-g>div:nth-child(3) {
            margin-top: 2rem
        }

        .cr-g .ph {
            aspect-ratio: 4/5;
            margin-bottom: 1.4rem
        }

        .cr-g p {
            color: var(--mu);
            font-size: .92rem
        }

        /* banner */
        .bn {
            position: relative;
            height: 100svh;
            display: grid;
            place-items: center;
            text-align: center;
            overflow: hidden
        }

        .bn .ph {
            position: absolute;
            inset: 0
        }

        .bn img {
            height: 125%;
            margin-top: -12%
        }

        .bn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(5, 5, 5, .55)
        }

        .bn div.c {
            position: relative;
            z-index: 2;
            padding: 0 1.5rem
        }

        .bn .cta {
            margin-top: 2.5rem
        }

        /* footer */
        footer {
            padding: 7rem var(--pad) 2rem;
            border-top: 1px solid #1d1d1d
        }

        .fg {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1.4fr;
            gap: 3rem
        }

        footer h4 {
            font: 400 .7rem var(--sans);
            letter-spacing: .28em;
            color: var(--gold);
            margin-bottom: 1.2rem
        }

        footer a {
            display: block;
            color: var(--mu);
            font-size: .92rem;
            transition: .3s
        }

        footer a:hover {
            color: var(--soft)
        }

        footer p {
            color: var(--mu);
            font-size: .92rem;
            margin-top: 1rem;
            max-width: 22rem
        }

        .nf {
            display: flex;
            border-bottom: 1px solid var(--gold);
            margin-top: .5rem
        }

        .nf input {
            flex: 1;
            min-width: 0;
            background: none;
            border: 0;
            color: var(--tx);
            padding: .8rem 0;
            font: inherit
        }

        .nf input:focus {
            outline: 0
        }

        .nf button {
            font-size: .7rem;
            letter-spacing: .25em;
            color: var(--soft);
            padding: 0 .5rem
        }

        #nm {
            min-height: 1.6rem;
            font-size: .8rem;
            color: var(--soft);
            margin-top: .5rem
        }

        .cp {
            margin-top: 5rem;
            font-size: .75rem;
            color: #5d5a54;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap
        }

        #toast {
            position: fixed;
            left: 50%;
            bottom: 2rem;
            translate: -50% 150%;
            background: var(--bg2);
            border: 1px solid var(--gold);
            padding: .8rem 1.6rem;
            font-size: .8rem;
            letter-spacing: .1em;
            z-index: 350;
            transition: translate .5s
        }

        #toast.on {
            translate: -50% 0
        }

        @media(max-width:900px) {
            header {
                grid-template-columns: 1fr auto
            }

            nav {
                position: fixed;
                inset: 0;
                background: var(--bg);
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 2rem;
                opacity: 0;
                pointer-events: none;
                transition: .4s
            }

            nav.o {
                opacity: 1;
                pointer-events: auto
            }

            nav a {
                font: 300 2.2rem var(--serif);
                letter-spacing: .05em
            }

            .bg {
                display: grid;
                place-items: center;
                width: 44px;
                height: 44px;
                z-index: 5;
                font-size: .7rem
            }

            .hero {
                grid-template-columns: 1fr;
                grid-template-rows: 55svh auto
            }

            .hero-i {
                order: -1;
                height: 55svh
            }

            .hero-t {
                padding: 2rem var(--pad) 6rem
            }

            .story {
                grid-template-columns: 1fr
            }

            .col-g {
                grid-template-columns: 1fr
            }

            .ci:nth-child(n) {
                grid-column: auto;
                margin-top: 0;
                aspect-ratio: 4/5
            }

            .pg {
                grid-template-columns: 1fr 1fr
            }

            .pr:nth-child(even) {
                margin-top: 2rem
            }

            .cr-g {
                grid-template-columns: 1fr
            }

            .cr-g>div:nth-child(n) {
                margin-top: 0
            }

            .fg {
                grid-template-columns: 1fr 1fr
            }

            .fg>div:first-child,
            .fg>div:last-child {
                grid-column: 1/-1
            }

            .cap {
                bottom: 18%;
                right: var(--pad)
            }
        }

        @media(max-width:480px) {
            .pg {
                grid-template-columns: 1fr
            }

            .pr:nth-child(even) {
                margin-top: 0
            }
        }

        @media(prefers-reduced-motion:reduce) {
            * {
                animation: none !important;
                transition: none !important
            }
        }
    </style>
</head>

<body>
    <div id="prog"></div>
    <div id="loader"><b>NOIR AURUM</b><i></i></div>
    <header id="hd">
        <a href="#home" class="logo">NOIR AURUM</a>
        <nav id="nv" aria-label="Main"><a href="#home">HOME</a><a href="#collection">COLLECTION</a><a href="#story">OUR STORY</a><a href="#craft">CRAFTSMANSHIP</a></nav>
        <div class="ic">
            <button aria-label="Search" id="sr"><svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7" />
                    <path d="M20 20l-4-4" />
                </svg></button>
            <button aria-label="Wishlist"><svg viewBox="0 0 24 24">
                    <path d="M12 20s-8-5-8-11a4.5 4.5 0 018-2.5A4.5 4.5 0 0120 9c0 6-8 11-8 11z" />
                </svg><span id="wc"></span></button>
            <button aria-label="Shopping bag"><svg viewBox="0 0 24 24">
                    <path d="M5 8h14l-1 12H6zM9 8V6a3 3 0 016 0v2" />
                </svg><span id="bc"></span></button>
            <button class="bg" id="bgr" aria-label="Menu" aria-expanded="false">MENU</button>
        </div>
    </header>
    <main>
        <section class="hero" id="home">
            <div class="hero-t">
                <p class="lbl" style="margin:0 0 2rem;max-width:none">THE ART OF FINE JEWELLERY</p>
                <h1 id="h1"><span class="l" data-split>Where Elegance</span><span class="l" data-split>Becomes Eternal.</span></h1>
                <p class="hp">Discover exceptional jewellery designed to celebrate beauty, individuality and timeless moments.</p>
                <a class="cta hp" href="#collection">EXPLORE COLLECTION</a>
            </div>
            <div class="hero-i ph" id="hi"><img data-k="hero" alt="Gold necklace in a luxury jewellery campaign" fetchpriority="high"></div>
            <div class="scr"><i></i>SCROLL</div>
        </section>

        <section class="sec story" id="story">
            <div class="ph" data-clip><img data-k="story" data-par alt="Close-up of fine gold jewellery" loading="lazy"></div>
            <div>
                <p class="lbl" data-r>OUR STORY</p>
                <h2 data-r style="margin-top:1.2rem">Beyond Jewellery.<br>A Legacy of Elegance.</h2>
                <div class="line" data-r></div>
                <p data-r>For three generations our artisans have shaped gold and set stones by hand. Each piece is made slowly, finished to the last detail, and meant to be worn, loved and passed on.</p>
            </div>
        </section>

        <section class="sec" id="collection">
            <p class="lbl" data-r>COLLECTIONS</p>
            <h2 data-r style="margin-top:1rem">Discover Our Collections</h2>
            <div class="col-g">
                <a class="ci" href="#shop" data-clip>
                    <div class="ph"><img data-k="c1" alt="Gold necklace collection" loading="lazy"></div>
                    <div class="t"><span class="n">01</span>
                        <h3>The Necklace Collection</h3>
                    </div>
                </a>
                <a class="ci" href="#shop" data-clip>
                    <div class="ph"><img data-k="c2" alt="Diamond rings collection" loading="lazy"></div>
                    <div class="t"><span class="n">02</span>
                        <h3>The Art of Rings</h3>
                    </div>
                </a>
                <a class="ci" href="#shop" data-clip>
                    <div class="ph"><img data-k="c3" alt="Earrings collection" loading="lazy"></div>
                    <div class="t"><span class="n">03</span>
                        <h3>Earrings &amp; Elegance</h3>
                    </div>
                </a>
                <a class="ci" href="#shop" data-clip>
                    <div class="ph"><img data-k="c4" alt="Bracelets collection" loading="lazy"></div>
                    <div class="t"><span class="n">04</span>
                        <h3>Signature Bracelets</h3>
                    </div>
                </a>
            </div>
        </section>

        <section class="scene" id="scene">
            <div class="stage">
                <canvas id="gl" aria-label="3D gold diamond ring that rotates as you scroll"></canvas>
                <div id="dark"></div>
                <div class="cap" id="c1">
                    <p class="lbl">THE BAND</p>
                    <h3>Polished by hand</h3>
                    <p>Warm champagne gold, finished until it holds the light.</p>
                </div>
                <div class="cap" id="c2">
                    <p class="lbl">THE STONE</p>
                    <h3>Brilliant cut</h3>
                    <p>Every facet is angled to return light to the eye.</p>
                </div>
                <div class="fin" id="fin">
                    <p class="lbl">THE SIGNATURE RING</p>
                    <h2>An Art Beyond Time</h2>
                </div>
            </div>
        </section>

        <section class="sec" id="shop">
            <p class="lbl" data-r>SIGNATURE COLLECTION</p>
            <h2 data-r style="margin-top:1rem">Made for Moments</h2>
            <div class="pg" id="pg"></div>
        </section>

        <section class="sec cr" id="craft">
            <p class="lbl" data-r>THE CRAFTSMANSHIP</p>
            <h2 data-r style="margin-top:1rem">Perfection Lives<br>in Every Detail.</h2>
            <div class="cr-g">
                <div data-r>
                    <div class="ph" data-clip><img data-k="m1" data-par alt="Macro of gold jewellery detail" loading="lazy"></div>
                    <h3>Hand finishing</h3>
                    <p>Each surface is polished by hand until it is flawless.</p>
                </div>
                <div data-r>
                    <div class="ph" data-clip><img data-k="m2" data-par alt="Diamond setting detail" loading="lazy"></div>
                    <h3>Precise settings</h3>
                    <p>Stones are set under magnification, one prong at a time.</p>
                </div>
                <div data-r>
                    <div class="ph" data-clip><img data-k="m3" data-par alt="Pearl and gold materials" loading="lazy"></div>
                    <h3>Honest materials</h3>
                    <p>Hallmarked gold, certified diamonds and selected pearls.</p>
                </div>
            </div>
        </section>

        <section class="bn">
            <div class="ph"><img data-k="bn" data-par alt="Jewellery editorial photograph" loading="lazy"></div>
            <div class="c">
                <h2 data-r>Made to Be Cherished.<br>Designed to Last.</h2><a class="cta" href="#shop" data-r>DISCOVER THE COLLECTION</a>
            </div>
        </section>



    </main>

    <footer id="contact">
        <div class="fg">
            <div>
                <div class="logo">NOIR AURUM</div>
                <p>Fine gold and diamond jewellery, made by hand and made to last.</p>
            </div>
            <div>
                <h4>COLLECTION</h4><a href="#shop">Necklaces</a><a href="#shop">Rings</a><a href="#shop">Earrings</a><a href="#shop">Bracelets</a>
            </div>
            <div>
                <h4>CONNECT</h4><a href="#story">About us</a><a href="mailto:hello@noiraurum.example">Contact us</a><a href="https://instagram.com" target="_blank" rel="noreferrer">Instagram</a><a href="https://wa.me/910000000000" target="_blank" rel="noreferrer">WhatsApp</a>
            </div>
            <div>
                <h4>NEWSLETTER</h4>
                <form class="nf" id="nf" novalidate><input id="em" type="email" placeholder="Your email" aria-label="Email"><button>JOIN</button></form>
                <div id="nm" role="status"></div>
            </div>
        </div>
        <div class="cp"><span>&copy; <span id="yr"></span> Noir Aurum. All rights reserved.</span><span>Demo content. Replace with your own details.</span></div>
    </footer>
    <div id="toast" role="status"></div>

    <script type="module">
        import * as THREE from 'three';
        import {
            GLTFLoader
        } from 'three/addons/loaders/GLTFLoader.js';
        import {
            RoomEnvironment
        } from 'three/addons/environments/RoomEnvironment.js';

        /* ====== EDIT HERE: your photographs (replace URLs) and 3D model ====== */
        const U = (id, w = 1400) => `https://images.unsplash.com/${id}?auto=format&fit=crop&w=${w}&q=75`;
        const IMAGES = {
            hero: U('photo-1515562141207-7a88fb7ce338', 1800),
            story: U('photo-1599643478518-a784e5dc4c8f'),
            c1: U('photo-1601121141461-9d6647bef0a0'),
            c2: U('photo-1605100804763-247f67b3557e'),
            c3: U('photo-1535632066927-ab7c9ab60908'),
            c4: U('photo-1611591437281-460bfbe1220a'),
            m1: U('photo-1573408301185-9146fe634ad0'),
            m2: U('photo-1603561591411-07134e71a2a9'),
            m3: U('photo-1630019852942-f89202989a59'),
            bn: U('photo-1602173574767-37ac01994b2a', 2000),
        };
        const PRODUCTS = [{
                name: 'Royal Diamond Ring',
                price: 148000,
                img: U('photo-1596944924616-7b38e7cfac36', 900),
                d: '18k gold, 0.5 ct round diamond.'
            },
            {
                name: 'Heritage Gold Necklace',
                price: 96500,
                img: U('photo-1599459183200-59c7687a0275', 900),
                d: '22k gold chain with a hand-polished clasp.'
            },
            {
                name: 'Pearl Statement Earrings',
                price: 38500,
                img: U('photo-1588444837495-c6cfeb53f32d', 900),
                d: 'Freshwater pearls on 18k gold.'
            },
            {
                name: 'Signature Bracelet',
                price: 64900,
                img: U('photo-1617038220319-276d3cfab638', 900),
                d: 'Flexible 18k gold with a hidden clasp.'
            },
        ];
        const MODEL_URL = ''; // e.g. 'models/ring.glb'. Leave empty to use the built-in procedural ring.
        /* ==================================================================== */

        const $ = (s, r = document) => r.querySelector(s),
            $$ = (s, r = document) => [...r.querySelectorAll(s)];
        const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches,
            mobile = innerWidth < 900;
        const inr = n => new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            maximumFractionDigits: 0
        }).format(n);
        const toast = m => {
            const t = $('#toast');
            t.textContent = m;
            t.classList.add('on');
            clearTimeout(t._t);
            t._t = setTimeout(() => t.classList.remove('on'), 2200);
        };

        /* images: set sources from the variables above, fall back to a dark gradient if one fails */
        const setImg = (img, src) => {
            img.src = src;
            img.onerror = () => {
                img.remove();
            };
        };
        $$('[data-k]').forEach(i => setImg(i, IMAGES[i.dataset.k]));

        /* products + demo bag/wishlist */
        let bag = 0,
            wish = 0;
        $('#pg').innerHTML = PRODUCTS.map((p, i) => `<article class="pr" data-r><div class="ph"><img src="${p.img}" alt="${p.name}" loading="lazy" onerror="this.remove()"></div>
<h3>${p.name}</h3><p class="pc">${inr(p.price)}</p><p class="dt">${p.d}</p>
<div class="pa"><button class="hb" aria-label="Wishlist ${p.name}" aria-pressed="false"><svg viewBox="0 0 24 24"><path d="M12 20s-8-5-8-11a4.5 4.5 0 018-2.5A4.5 4.5 0 0120 9c0 6-8 11-8 11z"/></svg></button>
<button class="ln add">Add to bag</button><button class="ln det" style="opacity:.6">Details</button></div></article>`).join('');
        $('#pg').addEventListener('click', e => {
            const art = e.target.closest('.pr');
            if (!art) return;
            const name = $('h3', art).textContent;
            if (e.target.closest('.hb')) {
                const b = e.target.closest('.hb'),
                    on = b.classList.toggle('on');
                b.setAttribute('aria-pressed', on);
                wish += on ? 1 : -1;
                $('#wc').textContent = wish || '';
                toast(on ? `${name} saved to wishlist` : 'Removed from wishlist');
            }
            if (e.target.closest('.add')) {
                bag++;
                $('#bc').textContent = bag;
                toast(`${name} added to bag`);
            }
            if (e.target.closest('.det')) $('.dt', art).classList.toggle('o');
        });
        $('#sr').onclick = () => toast('Search is a demo in this version');
        $('#yr').textContent = new Date().getFullYear();
        $('#nf').addEventListener('submit', e => {
            e.preventDefault();
            const v = $('#em').value.trim();
            const ok = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v);
            $('#nm').textContent = ok ? 'Thank you. You are subscribed.' : 'Enter a valid email address.';
            if (ok) $('#em').value = '';
        });

        /* header + mobile menu */
        const nv = $('#nv'),
            bgr = $('#bgr');
        bgr.onclick = () => {
            const o = nv.classList.toggle('o');
            bgr.setAttribute('aria-expanded', o);
            bgr.textContent = o ? 'CLOSE' : 'MENU';
        };
        addEventListener('scroll', () => $('#hd').classList.toggle('s', scrollY > 60), {
            passive: true
        });

        /* smooth scroll (Lenis) + GSAP */
        gsap.registerPlugin(ScrollTrigger);
        let lenis = null;
        if (!reduce) {
            lenis = new Lenis({
                lerp: 0.09
            });
            lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add(t => lenis.raf(t * 1000));
            gsap.ticker.lagSmoothing(0);
        }
        $$('a[href^="#"]').forEach(a => a.addEventListener('click', e => {
            const t = $(a.getAttribute('href'));
            if (!t) return;
            e.preventDefault();
            nv.classList.remove('o');
            bgr.textContent = 'MENU';
            lenis ? lenis.scrollTo(t, {
                offset: -40
            }) : t.scrollIntoView();
        }));

        /* character reveal markup */
        $$('[data-split]').forEach(l => {
            const t = l.textContent;
            l.innerHTML = [...t].map(c => `<span class="ch">${c === ' ' ? '&nbsp;' : c}</span>`).join('');
        });

        function intro() {
            if (reduce) return;
            gsap.timeline()
                .from('#hi', {
                    clipPath: 'inset(0 0 0 100%)',
                    duration: 1.6,
                    ease: 'power4.inOut'
                })
                .from('.hero .ch', {
                    yPercent: 115,
                    duration: 1.1,
                    ease: 'power4.out',
                    stagger: 0.025
                }, 0.5)
                .from('.lbl:first-child,.hp', {
                    opacity: 0,
                    y: 24,
                    duration: 1,
                    stagger: 0.15
                }, 1.2);
            gsap.to('#hi img', {
                scale: 1.16,
                duration: 24,
                ease: 'none'
            });
            if (!matchMedia('(pointer: coarse)').matches) $('.hero').addEventListener('mousemove', e => {
                const x = e.clientX / innerWidth - .5,
                    y = e.clientY / innerHeight - .5;
                gsap.to('#hi img', {
                    x: -x * 30,
                    y: -y * 20,
                    duration: 1.4,
                    ease: 'power2.out',
                    overwrite: 'auto'
                });
            });
            $$('[data-r]').forEach(el => gsap.from(el, {
                y: 50,
                opacity: 0,
                duration: 1.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 90%'
                }
            }));
            $$('[data-clip]').forEach(el => gsap.from(el, {
                clipPath: 'inset(100% 0 0 0)',
                duration: 1.5,
                ease: 'power4.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 88%'
                }
            }));
            $$('[data-par]').forEach(el => gsap.fromTo(el, {
                yPercent: -6
            }, {
                yPercent: 6,
                ease: 'none',
                scrollTrigger: {
                    trigger: el.parentElement,
                    scrub: true
                }
            }));
            gsap.to('#prog', {
                scaleX: 1,
                ease: 'none',
                scrollTrigger: {
                    scrub: .2,
                    start: 0,
                    end: 'max'
                }
            });
        }

        /* ================= WebGL: scroll-controlled jewellery ================= */
        function initGL() {
            const canvas = $('#gl');
            let renderer;
            try {
                renderer = new THREE.WebGLRenderer({
                    canvas,
                    antialias: !mobile,
                    powerPreference: 'high-performance'
                });
            } catch (e) {
                canvas.style.display = 'none';
                $('#fin').style.opacity = 1;
                return;
            }
            renderer.setPixelRatio(Math.min(devicePixelRatio, mobile ? 1.5 : 2));
            renderer.toneMapping = THREE.ACESFilmicToneMapping;
            renderer.toneMappingExposure = 1.05;
            renderer.outputColorSpace = THREE.SRGBColorSpace;
            renderer.shadowMap.enabled = !mobile;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
            const scene = new THREE.Scene();
            scene.background = new THREE.Color(0x050505);
            scene.environment = new THREE.PMREMGenerator(renderer).fromScene(new RoomEnvironment(), 0.04).texture;
            const cam = new THREE.PerspectiveCamera(32, 1, 0.1, 100);
            const key = new THREE.SpotLight(0xfff1d8, 90, 0, 0.5, 0.8);
            key.position.set(3, 7, 4);
            key.castShadow = true;
            key.shadow.mapSize.set(1024, 1024);
            scene.add(key);
            const rim = new THREE.DirectionalLight(0xE5C995, 1.4);
            rim.position.set(-5, 2, -4);
            scene.add(rim);
            const floor = new THREE.Mesh(new THREE.CircleGeometry(12, 64), new THREE.ShadowMaterial({
                opacity: .45
            }));
            floor.rotation.x = -Math.PI / 2;
            floor.position.y = -1.55;
            floor.receiveShadow = true;
            scene.add(floor);

            const holder = new THREE.Group();
            scene.add(holder);
            const goldM = new THREE.MeshStandardMaterial({
                color: 0xC6A46A,
                metalness: 1,
                roughness: .16,
                envMapIntensity: 1.5
            });
            const gemM = new THREE.MeshPhysicalMaterial({
                color: 0xffffff,
                metalness: 0,
                roughness: 0,
                clearcoat: 1,
                ior: 2.4,
                envMapIntensity: 4,
                flatShading: true
            });

            function buildRing() {
                /* procedural fallback ring */
                const g = new THREE.Group();
                const band = new THREE.Mesh(new THREE.TorusGeometry(1.2, .13, 48, 160), goldM);
                const seat = new THREE.Mesh(new THREE.CylinderGeometry(.34, .2, .26, 8), goldM);
                seat.position.y = 1.4;
                const top = new THREE.Mesh(new THREE.CylinderGeometry(.34, .5, .22, 16), gemM);
                top.position.y = 1.78;
                const bot = new THREE.Mesh(new THREE.ConeGeometry(.5, .5, 16), gemM);
                bot.rotation.x = Math.PI;
                bot.position.y = 1.42;
                [band, seat, top, bot].forEach(m => {
                    m.castShadow = true;
                    g.add(m);
                });
                g.rotation.x = .25;
                g.position.y = -.2;
                return g;
            }
            holder.add(buildRing());
            if (MODEL_URL) new GLTFLoader().load(MODEL_URL, gl => {
                /* real GLB replaces the procedural ring */
                const m = gl.scene,
                    box = new THREE.Box3().setFromObject(m),
                    size = box.getSize(new THREE.Vector3()).length();
                m.scale.setScalar(3.4 / size);
                box.setFromObject(m);
                m.position.sub(box.getCenter(new THREE.Vector3()));
                m.traverse(o => {
                    if (o.isMesh) {
                        o.castShadow = true;
                        o.material.envMapIntensity = 1.5;
                    }
                });
                holder.clear();
                holder.add(m);
            }, undefined, () => console.warn('GLB failed to load. Showing the procedural ring.'));

            const S = {
                    rot: 0,
                    z: 11,
                    y: .5,
                    look: 0,
                    dark: 1
                },
                mouse = {
                    x: 0,
                    y: 0
                };
            const resize = () => {
                const w = innerWidth,
                    h = innerHeight;
                renderer.setSize(w, h, false);
                cam.aspect = w / h;
                cam.fov = w < 700 ? 44 : 32;
                cam.updateProjectionMatrix();
            };
            resize();
            addEventListener('resize', resize);
            addEventListener('pointermove', e => {
                mouse.x = e.clientX / innerWidth - .5;
                mouse.y = e.clientY / innerHeight - .5;
            });

            if (!reduce) {
                const q = gsap.timeline({
                    scrollTrigger: {
                        trigger: '#scene',
                        start: 'top top',
                        end: 'bottom bottom',
                        scrub: 1
                    }
                });
                q.to(S, {
                        dark: 0,
                        duration: .8
                    }) /* 1 appears from darkness */
                    .to(S, {
                        z: 7,
                        rot: Math.PI * 1.2,
                        duration: 2
                    }, .3) /* 2-3 approach and rotate */
                    .to('#c1', {
                        opacity: 1,
                        duration: .4
                    }, 1).to('#c1', {
                        opacity: 0,
                        duration: .4
                    }, 2)
                    .to(S, {
                        z: 3.6,
                        y: 1.5,
                        look: 1,
                        rot: Math.PI * 2,
                        duration: 1.6
                    }, 2.4) /* 4 close-up on the stone */
                    .to('#c2', {
                        opacity: 1,
                        duration: .4
                    }, 3).to('#c2', {
                        opacity: 0,
                        duration: .4
                    }, 3.8)
                    .to(S, {
                        z: 9,
                        y: .6,
                        look: 0,
                        rot: Math.PI * 3,
                        duration: 1.6
                    }, 4.2) /* 5 pull back */
                    .to('#fin', {
                        opacity: 1,
                        duration: .8
                    }, 5); /* 6 headline */
            } else {
                S.z = 8;
                S.dark = 0;
                $('#fin').style.opacity = 1;
            }

            let vis = true;
            new IntersectionObserver(([e]) => vis = e.isIntersecting).observe($('#scene'));
            renderer.setAnimationLoop(t => {
                if (!vis) return;
                holder.rotation.y = S.rot + t * .0002 + mouse.x * .5;
                holder.rotation.x = mouse.y * .25;
                cam.position.set(0, S.y, S.z);
                cam.lookAt(0, S.look * 1.2 - .1, 0);
                $('#dark').style.opacity = S.dark;
                renderer.render(scene, cam);
            });
        }
        initGL();

        /* loading screen */
        const done = () => {
            $('#loader').remove();
            intro();
            ScrollTrigger.refresh();
        };
        let fired = false;
        const go = () => {
            if (fired) return;
            fired = true;
            if (reduce) {
                $('#loader').remove();
                return;
            }
            gsap.to('#loader', {
                opacity: 0,
                duration: .8,
                onComplete: done
            });
        };
        addEventListener('load', () => setTimeout(go, 500));
        setTimeout(go, 5000);
    </script>
</body>

</html>