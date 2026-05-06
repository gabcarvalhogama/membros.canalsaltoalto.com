<?php
	$buy_link = "https://invoice.infinitepay.io/tatiserafim/yQsW7IRCt/";
	$instagram = "https://instagram.com/tatiserafim.oficial";
	$whatsapp_link = "https://api.whatsapp.com/send?phone=5527998047775&text=Ol%C3%A1,%20quero%20entrar%20na%20Lista%20VIP%20da%20Mentoria%20Embaixadora%20da%20minha%20Marca";
?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Mentoria Embaixadora da minha Marca | Tatiane Serafim</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Mentoria Embaixadora da minha Marca com Tatiane Serafim. Inscrições abertas, vagas limitadas. 4 encontros online + encontro individual. Posicionamento de marca para empreendedoras.">

		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

		<?=Template::render(null, "head-tags")?>

		<style>
			:root{
				--bg-primary: #0A0A0A;
				--bg-secondary: #141414;
				--bg-card: #1a1a1a;
				--gold: #C9A961;
				--gold-dark: #8B6F2A;
				--gold-light: #E0C77F;
				--off-white: #F5F2EC;
				--warm-beige: #E8DDC9;
				--text-primary: #EDE6D6;
				--text-muted: #9A8B6E;
				--border-gold: rgba(201, 169, 97, .25);
			}

			*{ box-sizing: border-box; }

			body.tati-lp{
				background: var(--bg-primary);
				color: var(--text-primary);
				font-family: 'Montserrat', sans-serif;
				font-weight: 300;
				line-height: 1.7;
				margin: 0;
				padding: 0;
				overflow-x: hidden;
			}

			.tati-lp h1, .tati-lp h2, .tati-lp h3, .tati-lp h4, .tati-lp h5{
				font-family: 'Cormorant Garamond', serif;
				font-weight: 600;
				letter-spacing: .02em;
				color: var(--off-white);
			}

			.tati-lp h1{ font-size: clamp(2.2rem, 5vw, 4rem); line-height: 1.1; }
			.tati-lp h2{ font-size: clamp(1.8rem, 4vw, 3rem); line-height: 1.15; }
			.tati-lp h3{ font-size: clamp(1.4rem, 2.5vw, 2rem); }
			.tati-lp p{ font-size: 1.05rem; color: var(--text-primary); }

			.tati-lp .gold{ color: var(--gold); }
			.tati-lp .gold-light{ color: var(--gold-light); }
			.tati-lp .text-muted-gold{ color: var(--text-muted); }

			.tati-lp .eyebrow{
				font-family: 'Montserrat', sans-serif;
				text-transform: uppercase;
				letter-spacing: .35em;
				font-size: .8rem;
				color: var(--gold);
				font-weight: 500;
				margin-bottom: 1rem;
				display: inline-block;
			}
			@media (min-width: 992px){
				.tati-lp .hero__eyebrow{
					margin-left: -.18em;
				}
			}

			.tati-lp .section{
				padding: 6rem 0;
				position: relative;
			}
			.tati-lp .section--light{
				background: var(--off-white);
				color: #2a2a2a;
			}
			.tati-lp .section--light h1, .tati-lp .section--light h2, .tati-lp .section--light h3{
				color: #1a1a1a;
			}
			.tati-lp .section--light p{ color: #444; }

			.tati-lp .btn-gold{
				background: linear-gradient(135deg, #E0C77F 0%, #C9A961 50%, #8B6F2A 100%);
				color: #0a0a0a !important;
				border: none;
				padding: 16px 36px;
				border-radius: 100px;
				font-family: 'Montserrat', sans-serif;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: .15em;
				font-size: .9rem;
				display: inline-flex;
				align-items: center;
				gap: 10px;
				text-decoration: none;
				box-shadow: 0 8px 30px rgba(201, 169, 97, .25);
				transition: all .3s ease;
				cursor: pointer;
			}
			.tati-lp .btn-gold:hover{
				transform: translateY(-2px);
				box-shadow: 0 12px 40px rgba(201, 169, 97, .45);
				color: #0a0a0a !important;
			}
			.tati-lp .btn-outline-gold{
				background: transparent;
				color: var(--gold) !important;
				border: 1px solid var(--gold);
				padding: 14px 32px;
				border-radius: 100px;
				font-family: 'Montserrat', sans-serif;
				font-weight: 500;
				text-transform: uppercase;
				letter-spacing: .15em;
				font-size: .85rem;
				display: inline-flex;
				align-items: center;
				gap: 10px;
				text-decoration: none;
				transition: all .3s ease;
			}
			.tati-lp .btn-outline-gold:hover{
				background: var(--gold);
				color: #0a0a0a !important;
			}

			.tati-lp .divider-triade{
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 1rem;
				margin: 2rem 0;
			}
			.tati-lp .divider-triade::before,
			.tati-lp .divider-triade::after{
				content: '';
				flex: 1;
				max-width: 100px;
				height: 1px;
				background: linear-gradient(90deg, transparent, var(--gold), transparent);
			}
			.tati-lp .triade-symbol{
				width: 36px;
				height: 36px;
				display: inline-block;
				object-fit: contain;
			}

			.tati-lp .countdown-bar{
				position: relative;
				background: linear-gradient(90deg, #0a0a0a 0%, #1a1611 50%, #0a0a0a 100%);
				border-bottom: 1px solid var(--border-gold);
				color: var(--gold);
				padding: 12px 0;
				z-index: 10;
				overflow: hidden;
			}
			.tati-lp .countdown-bar::before{
				content: '';
				position: absolute;
				inset: 0;
				background: linear-gradient(90deg, transparent, rgba(201,169,97,.06), transparent);
				pointer-events: none;
			}
			.tati-lp .countdown-bar__inner{
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 1.5rem;
				flex-wrap: wrap;
				position: relative;
				z-index: 1;
			}
			.tati-lp .countdown-bar__label{
				font-family: 'Montserrat', sans-serif;
				text-transform: uppercase;
				letter-spacing: .2em;
				font-size: .75rem;
				color: var(--gold-light);
				font-weight: 500;
			}
			.tati-lp .countdown-bar__label i{
				margin-right: 6px;
				color: var(--gold);
			}
			.tati-lp .countdown-bar__timer{
				display: inline-flex;
				align-items: baseline;
				gap: 8px;
			}
			.tati-lp .cd-block{
				display: inline-flex;
				flex-direction: column;
				align-items: center;
				background: rgba(201,169,97,.08);
				border: 1px solid var(--border-gold);
				border-radius: 4px;
				padding: 4px 10px;
				min-width: 52px;
			}
			.tati-lp .cd-num{
				font-family: 'Cormorant Garamond', serif;
				font-size: 1.4rem;
				font-weight: 700;
				color: var(--gold);
				line-height: 1;
			}
			.tati-lp .cd-lbl{
				font-size: .6rem;
				letter-spacing: .15em;
				text-transform: uppercase;
				color: var(--text-muted);
				margin-top: 2px;
			}
			.tati-lp .cd-sep{
				color: var(--gold-dark);
				font-weight: 700;
				font-size: 1.2rem;
			}
			.tati-lp .countdown-bar__cta{
				color: var(--gold);
				text-decoration: none;
				font-size: .8rem;
				text-transform: uppercase;
				letter-spacing: .2em;
				font-weight: 500;
				padding: 6px 14px;
				border: 1px solid var(--gold);
				border-radius: 100px;
				transition: all .3s ease;
				white-space: nowrap;
			}
			.tati-lp .countdown-bar__cta:hover{
				background: var(--gold);
				color: #0a0a0a;
			}
			.tati-lp .countdown-bar.is-ended .countdown-bar__timer{ opacity: .5; }
			@media (max-width: 768px){
				.tati-lp .countdown-bar{ padding: 10px 0; }
				.tati-lp .countdown-bar__inner{ gap: .75rem; }
				.tati-lp .countdown-bar__label{ font-size: .65rem; letter-spacing: .15em; flex-basis: 100%; text-align: center; }
				.tati-lp .cd-block{ min-width: 44px; padding: 3px 8px; }
				.tati-lp .cd-num{ font-size: 1.1rem; }
				.tati-lp .cd-sep{ font-size: 1rem; }
				.tati-lp .countdown-bar__cta{ display: none; }
			}

			.tati-lp .hero{
				min-height: 90vh;
				display: flex;
				align-items: center;
				background:
					linear-gradient(180deg, rgba(10,10,10,.78) 0%, rgba(10,10,10,.65) 50%, rgba(10,10,10,.92) 100%),
					url('<?=PATH?>assets/images/HERO-BACKGROUND.jpg') center/cover no-repeat,
					var(--bg-primary);
				position: relative;
				padding: 6rem 0 4rem;
			}
			@media (max-width: 768px){
				.tati-lp .hero{
					background:
						linear-gradient(180deg, rgba(10,10,10,.72) 0%, rgba(10,10,10,.55) 45%, rgba(10,10,10,.95) 100%),
						url('<?=PATH?>assets/images/HERO-BACKGROUND-MOBILE.jpg') center/cover no-repeat,
						var(--bg-primary);
				}
			}
			.tati-lp .hero::before{
				content: '';
				position: absolute;
				inset: 0;
				background-image:
					radial-gradient(circle at 20% 30%, rgba(201,169,97,.10) 0%, transparent 35%),
					radial-gradient(circle at 80% 70%, rgba(139,111,42,.10) 0%, transparent 40%);
				pointer-events: none;
			}

			.tati-lp .hero__badge{
				display: inline-block;
				border: 1px solid var(--gold);
				padding: 4px 18px;
				border-radius: 100px;
				color: var(--gold);
				font-size: .6rem;
				letter-spacing: .25em;
				text-transform: uppercase;
				margin-bottom: 1.5rem;
			}

			.tati-lp .hero__title{
				font-style: italic;
				font-weight: 500;
			}
			.tati-lp .hero__title em{
				font-style: italic;
				color: var(--gold);
				/*font-weight: 600;*/
			}

			.tati-lp .hero__date-pill{
				display: inline-flex;
				align-items: center;
				gap: 12px;
				background: rgba(201,169,97,.08);
				border: 1px solid var(--border-gold);
				padding: 12px 24px;
				border-radius: 100px;
				margin: 1.5rem 0;
			}
			.tati-lp .hero__date-pill .day{
				font-family: 'Cormorant Garamond', serif;
				font-size: 2rem;
				color: var(--gold);
				line-height: 1;
				font-weight: 700;
			}
			.tati-lp .hero__date-pill .label{
				font-size: .7rem;
				letter-spacing: .25em;
				text-transform: uppercase;
				color: var(--text-muted);
			}

			.tati-lp .pillar-card{
				background: var(--bg-card);
				border: 1px solid var(--border-gold);
				border-radius: 4px;
				padding: 3rem 2rem;
				height: 100%;
				text-align: center;
				transition: all .4s ease;
				position: relative;
				overflow: hidden;
			}
			.tati-lp .pillar-card::before{
				content: '';
				position: absolute;
				top: 0; left: 0; right: 0;
				height: 1px;
				background: linear-gradient(90deg, transparent, var(--gold), transparent);
			}
			.tati-lp .pillar-card:hover{
				transform: translateY(-6px);
				border-color: var(--gold);
				box-shadow: 0 20px 60px rgba(201,169,97,.15);
			}
			.tati-lp .pillar-card .number{
				font-family: 'Cormorant Garamond', serif;
				font-size: 4rem;
				color: var(--gold);
				line-height: 1;
				font-style: italic;
				font-weight: 500;
				margin-bottom: 1rem;
				display: block;
			}
			.tati-lp .pillar-card .punchline{
				font-family: 'Cormorant Garamond', serif;
				font-style: italic;
				font-size: 1.5rem;
				color: var(--gold-light);
				margin-top: 1rem;
				display: block;
			}

			.tati-lp .vs-block{
				background: var(--bg-card);
				border: 1px solid var(--border-gold);
				border-radius: 6px;
				padding: 3rem 2.5rem;
				height: 100%;
			}
			.tati-lp .vs-block h3{
				display: flex;
				align-items: center;
				gap: 12px;
				margin-bottom: 2rem;
				padding-bottom: 1rem;
				border-bottom: 1px solid var(--border-gold);
			}
			.tati-lp .vs-block ul{
				list-style: none;
				padding: 0;
				margin: 0;
			}
			.tati-lp .vs-block ul li{
				padding-left: 1.8rem;
				position: relative;
				margin-bottom: 1rem;
				font-size: 1rem;
				line-height: 1.6;
			}
			.tati-lp .vs-block ul li::before{
				position: absolute;
				left: 0;
				top: 2px;
				font-family: 'Font Awesome 6 Free';
				font-weight: 900;
			}
			.tati-lp .vs-block--problem ul li::before{
				content: '\f00d';
				color: #B85C5C;
			}
			.tati-lp .vs-block--benefit ul li::before{
				content: '\f00c';
				color: var(--gold);
			}

			.tati-lp .testimonial-card{
				background: var(--bg-card);
				border: 1px solid var(--border-gold);
				border-radius: 8px;
				padding: 3rem 2.5rem 2rem;
				height: 100%;
				position: relative;
				margin: 0;
				transition: all .3s ease;
			}
			.tati-lp .testimonial-card:hover{
				border-color: var(--gold);
				box-shadow: 0 20px 50px rgba(201,169,97,.12);
			}
			.tati-lp .testimonial-card__quote{
				position: absolute;
				top: -18px;
				left: 30px;
				width: 50px; height: 50px;
				border-radius: 50%;
				background: linear-gradient(135deg, #E0C77F, #C9A961);
				color: #0a0a0a;
				display: flex;
				align-items: center;
				justify-content: center;
				font-size: 1.1rem;
			}
			.tati-lp .testimonial-card blockquote{
				margin: 0;
				padding: 0;
			}
			.tati-lp .testimonial-card blockquote p{
				font-family: 'Cormorant Garamond', serif;
				font-style: italic;
				font-size: 1.15rem;
				line-height: 1.6;
				color: var(--text-primary);
				margin-bottom: 1rem;
			}
			.tati-lp .testimonial-card blockquote p:last-child{ margin-bottom: 0; }
			.tati-lp .testimonial-card__author{
				display: flex;
				align-items: center;
				gap: 14px;
				margin-top: 2rem;
				padding-top: 1.5rem;
				border-top: 1px solid var(--border-gold);
			}
			.tati-lp .testimonial-card__avatar{
				width: 56px;
				height: 56px;
				border-radius: 50%;
				background: linear-gradient(135deg, var(--gold-dark), var(--gold));
				color: #0a0a0a;
				display: flex;
				align-items: center;
				justify-content: center;
				font-family: 'Cormorant Garamond', serif;
				font-weight: 700;
				font-size: 1.1rem;
				letter-spacing: .05em;
				flex-shrink: 0;
				object-fit: cover;
				border: 2px solid var(--gold);
			}
			.tati-lp .testimonial-card__name{
				font-family: 'Cormorant Garamond', serif;
				font-size: 1.2rem;
				color: var(--off-white);
				font-weight: 600;
			}
			.tati-lp .testimonial-card__role{
				font-size: .75rem;
				letter-spacing: .2em;
				text-transform: uppercase;
				color: var(--gold);
			}

			.tati-lp .lote-card{
				background: var(--bg-card);
				border: 1px solid var(--border-gold);
				border-radius: 6px;
				padding: 2.5rem 2rem;
				height: 100%;
				text-align: center;
				position: relative;
				transition: all .3s ease;
			}
			.tati-lp .lote-card--featured{
				border-color: var(--gold);
				background: linear-gradient(180deg, rgba(201,169,97,.08) 0%, var(--bg-card) 100%);
				transform: scale(1.04);
			}
			.tati-lp .lote-card .badge-featured{
				position: absolute;
				top: -14px;
				left: 50%;
				transform: translateX(-50%);
				background: linear-gradient(135deg, #E0C77F, #C9A961);
				color: #0a0a0a;
				padding: 6px 18px;
				border-radius: 100px;
				font-size: .7rem;
				letter-spacing: .2em;
				text-transform: uppercase;
				font-weight: 700;
				white-space: nowrap;
			}
			.tati-lp .lote-card .lote-name{
				font-family: 'Montserrat', sans-serif;
				text-transform: uppercase;
				letter-spacing: .25em;
				font-size: .85rem;
				color: var(--text-muted);
				margin-bottom: .5rem;
			}
			.tati-lp .lote-card .lote-date{
				font-family: 'Cormorant Garamond', serif;
				font-style: italic;
				font-size: 1.1rem;
				color: var(--gold-light);
				margin-bottom: 1.5rem;
			}
			.tati-lp .lote-card .lote-price{
				font-family: 'Cormorant Garamond', serif;
				font-size: 3rem;
				color: var(--gold);
				font-weight: 700;
				line-height: 1;
				margin-bottom: .5rem;
			}
			.tati-lp .lote-card .lote-price small{
				font-size: 1rem;
				font-weight: 400;
			}
			.tati-lp .lote-card .lote-installments{
				color: var(--text-muted);
				font-size: .9rem;
				margin-bottom: 1.5rem;
			}
			.tati-lp .lote-card--passed{
				opacity: .45;
				border-color: rgba(201,169,97,.25);
			}
			.tati-lp .lote-card--passed .lote-price,
			.tati-lp .lote-card--passed .lote-name,
			.tati-lp .lote-card--passed .lote-date{
				text-decoration: line-through;
				text-decoration-color: rgba(201,169,97,.6);
			}
			.tati-lp .lote-card .badge-passed{
				position: absolute;
				top: -14px;
				left: 50%;
				transform: translateX(-50%);
				background: rgba(255,255,255,.08);
				color: var(--text-muted);
				padding: 6px 18px;
				border-radius: 100px;
				font-size: .7rem;
				letter-spacing: .2em;
				text-transform: uppercase;
				font-weight: 700;
				white-space: nowrap;
				border: 1px solid rgba(201,169,97,.25);
			}
			.tati-lp .lote-card--passed-text{
				display: inline-block;
				padding: .65rem 1rem;
				color: var(--text-muted);
				font-size: .85rem;
				font-style: italic;
				border: 1px dashed rgba(201,169,97,.3);
				border-radius: 4px;
				width: 100%;
				text-align: center;
			}

			.tati-lp .promo-banner{
				background: linear-gradient(135deg, rgba(201,169,97,.15) 0%, rgba(139,111,42,.08) 100%);
				border: 1px solid var(--gold);
				border-radius: 8px;
				padding: 3rem 2.5rem;
				text-align: center;
				position: relative;
				overflow: hidden;
			}
			.tati-lp .promo-banner::before,
			.tati-lp .promo-banner::after{
				content: '';
				position: absolute;
				width: 200px; height: 200px;
				border-radius: 50%;
				background: radial-gradient(circle, rgba(201,169,97,.2) 0%, transparent 70%);
			}
			.tati-lp .promo-banner::before{ top: -100px; left: -100px; }
			.tati-lp .promo-banner::after{ bottom: -100px; right: -100px; }
			.tati-lp .promo-banner > *{ position: relative; z-index: 1; }
			.tati-lp .promo-banner .promo-price{
				font-family: 'Cormorant Garamond', serif;
				font-size: clamp(3rem, 7vw, 5rem);
				color: var(--gold);
				font-weight: 700;
				line-height: 1;
				margin: 1rem 0;
			}
			.tati-lp .promo-banner .promo-deadline{
				color: var(--gold-light);
				font-size: 1.1rem;
				font-style: italic;
				margin-bottom: 2rem;
			}

			.tati-lp .mentor-photo-wrap{
				position: relative;
				border-radius: 8px;
				overflow: hidden;
				aspect-ratio: 3/4;
				background: linear-gradient(135deg, #1a1a1a, #2a2418);
				border: 1px solid var(--border-gold);
				box-shadow: 0 30px 80px rgba(0,0,0,.6), 0 0 0 1px var(--border-gold);
			}
			.tati-lp .mentor-photo-wrap::before{
				content: '';
				position: absolute;
				inset: 0;
				background: radial-gradient(circle at 50% 30%, rgba(201,169,97,.18) 0%, transparent 65%);
				z-index: 2;
				pointer-events: none;
			}
			.tati-lp .mentor-photo-wrap::after{
				content: '';
				position: absolute;
				inset: 0;
				background: linear-gradient(180deg, transparent 60%, rgba(10,10,10,.45) 100%);
				z-index: 2;
				pointer-events: none;
			}
			.tati-lp .mentor-photo-wrap img{
				position: absolute;
				inset: 0;
				width: 100%;
				height: 100%;
				object-fit: cover;
				object-position: center top;
				z-index: 1;
			}

			.tati-lp .stat-pill{
				display: inline-flex;
				align-items: baseline;
				gap: 8px;
				background: rgba(201,169,97,.08);
				border: 1px solid var(--border-gold);
				padding: 10px 20px;
				border-radius: 100px;
				margin: 4px;
			}
			.tati-lp .stat-pill .num{
				font-family: 'Cormorant Garamond', serif;
				font-size: 1.6rem;
				color: var(--gold);
				font-weight: 700;
			}
			.tati-lp .stat-pill .lbl{
				font-size: .8rem;
				color: var(--text-primary);
				text-transform: uppercase;
				letter-spacing: .15em;
			}

			.tati-lp .schedule-item{
				display: flex;
				gap: 1.5rem;
				align-items: flex-start;
				padding: 1.5rem 0;
				border-bottom: 1px solid var(--border-gold);
			}
			.tati-lp .schedule-item:last-child{ border-bottom: none; }
			.tati-lp .schedule-item .icon{
				width: 50px; height: 50px;
				border-radius: 50%;
				border: 1px solid var(--gold);
				display: flex;
				align-items: center;
				justify-content: center;
				color: var(--gold);
				font-size: 1.2rem;
				flex-shrink: 0;
			}
			.tati-lp .schedule-item .label{
				font-size: .75rem;
				color: var(--text-muted);
				text-transform: uppercase;
				letter-spacing: .25em;
				margin-bottom: .25rem;
			}
			.tati-lp .schedule-item .value{
				font-family: 'Cormorant Garamond', serif;
				font-size: 1.4rem;
				color: var(--off-white);
				font-weight: 500;
			}

			.tati-lp .faq-item{
				border-bottom: 1px solid var(--border-gold);
				padding: 1.5rem 0;
			}
			.tati-lp .faq-item summary{
				list-style: none;
				cursor: pointer;
				display: flex;
				justify-content: space-between;
				align-items: center;
				font-family: 'Cormorant Garamond', serif;
				font-size: 1.3rem;
				color: var(--off-white);
				font-weight: 500;
			}
			.tati-lp .faq-item summary::-webkit-details-marker{ display: none; }
			.tati-lp .faq-item summary::after{
				content: '+';
				color: var(--gold);
				font-size: 1.8rem;
				font-weight: 300;
				transition: transform .3s;
			}
			.tati-lp .faq-item[open] summary::after{
				content: '−';
			}
			.tati-lp .faq-item p{
				margin-top: 1rem;
				color: var(--text-muted);
			}

			.tati-lp .footer-tati{
				background: var(--bg-secondary);
				padding: 3rem 0 2rem;
				text-align: center;
				border-top: 1px solid var(--border-gold);
			}
			.tati-lp .footer-tati .social a{
				color: var(--gold);
				font-size: 1.4rem;
				margin: 0 12px;
				text-decoration: none;
			}

			.tati-lp .leaf-decor{
				position: absolute;
				opacity: .15;
				pointer-events: none;
				font-size: 8rem;
				color: var(--gold-dark);
			}

			@media (max-width: 768px){
				.tati-lp .section{ padding: 4rem 0; }
				.tati-lp .lote-card--featured{ transform: none; }
				.tati-lp .hero{ min-height: auto; padding-top: 4rem; }
			}
		</style>
	</head>
	<body class="tati-lp">

		<!-- COUNTDOWN BAR -->
		<div class="countdown-bar" id="countdownBar">
			<div class="container">
				<div class="countdown-bar__inner">
					<span class="countdown-bar__label" id="countdownLabel">
						<i class="fa-solid fa-hourglass-half"></i> 1º Lote (R$ 1.297) termina em
					</span>
					<div class="countdown-bar__timer" id="countdownTimer">
						<div class="cd-block"><span class="cd-num" id="cdDays">--</span><span class="cd-lbl">dias</span></div>
						<span class="cd-sep">:</span>
						<div class="cd-block"><span class="cd-num" id="cdHours">--</span><span class="cd-lbl">horas</span></div>
						<span class="cd-sep">:</span>
						<div class="cd-block"><span class="cd-num" id="cdMins">--</span><span class="cd-lbl">min</span></div>
						<span class="cd-sep">:</span>
						<div class="cd-block"><span class="cd-num" id="cdSecs">--</span><span class="cd-lbl">seg</span></div>
					</div>
					<a href="#oferta" class="countdown-bar__cta">Ver lotes <i class="fa-solid fa-arrow-right"></i></a>
				</div>
			</div>
		</div>

		<!-- HERO -->
		<section class="hero">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-7 text-center text-lg-start">
						<div class="hero__badge"><i class="fa-solid fa-fire me-2"></i>Inscrições abertas — vagas limitadas</div>
						<p class="eyebrow hero__eyebrow" style="font-size: .65rem;margin-left: 10px">Mentoria com Tatiane Serafim</p>
						<h1 class="hero__title mb-4">
							Cansada de ver profissionais piores <em>brilhando mais que você</em>?
						</h1>
						<p class="lead mb-4" style="max-width: 560px; color: var(--text-muted);">
							Em 4 encontros você vira a <strong class="gold">primeira escolha</strong> do seu cliente. Mentoria <em class="gold-light" style="font-family: 'Cormorant Garamond', serif;font-size: 1.5rem">"Embaixadora da minha Marca"</em> com Tatiane Serafim.
						</p>
						<div class="hero__date-pill">
							<div class="day">1º<br><span style="font-size:.55em;letter-spacing:.1em;">LOTE</span></div>
							<div>
								<div class="label">R$ 1.297 em até 12x</div>
								<div style="font-size: .9rem;">Valor especial válido até <strong class="gold">17/05</strong></div>
							</div>
						</div>
						<div class="d-flex flex-column flex-sm-row gap-3 align-items-center align-items-lg-start mt-3">
							<a href="<?=$buy_link?>" target="_blank" class="btn-gold">
								<i class="fa-solid fa-crown"></i> Garantir minha vaga
							</a>
							<a href="<?=$whatsapp_link?>" target="_blank" class="btn-outline-gold">
								<i class="fa-brands fa-whatsapp"></i> Lista VIP
							</a>
						</div>
					</div>
					<div class="col-lg-5 mt-5 mt-lg-0">
						<div class="mentor-photo-wrap">
							<img src="<?=PATH?>assets/images/Hero-lp-embaixadora.png" alt="Tatiane Serafim - Mentoria Embaixadora da minha Marca" />
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- DESTRAVE DA MARCA -->
		<section class="section">
			<div class="container">
				<div class="text-center mb-5">
					<p class="eyebrow">A chave</p>
					<h2>Quando você se torna embaixadora,<br/><em class="gold-light" style="font-style: italic;">sua marca destrava.</em></h2>
					<div class="divider-triade">
						<img src="<?=PATH?>assets/images/icon-diamond-gold.svg" alt="" class="triade-symbol" />
					</div>
				</div>

				<div class="row g-4">
					<div class="col-md-4">
						<div class="pillar-card">
							<span class="number">01</span>
							<h3>Você é o diferencial</h3>
							<p class="text-muted-gold">Quando você entende que o diferencial da sua marca é <strong class="gold">você</strong>...</p>
							<span class="punchline">sua marca destrava.</span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="pillar-card">
							<span class="number">02</span>
							<h3>Cliente certo, comunicação certa</h3>
							<p class="text-muted-gold">Quando você entende quem é o seu cliente e como deve se <strong class="gold">comunicar</strong> com ele...</p>
							<span class="punchline">o caminho abre.</span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="pillar-card">
							<span class="number">03</span>
							<h3>Protagonismo da marca</h3>
							<p class="text-muted-gold">Quando você assume o <strong class="gold">protagonismo</strong> da sua marca e desperta seu potencial...</p>
							<span class="punchline">tudo decola.</span>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- PROBLEMAS X BENEFÍCIOS -->
		<section class="section" style="background: var(--bg-secondary);">
			<div class="container">
				<div class="text-center mb-5">
					<p class="eyebrow">Antes & Depois</p>
					<h2>Você reconhece esses sinais?</h2>
				</div>
				<div class="row g-4">
					<div class="col-md-6">
						<div class="vs-block vs-block--problem">
							<h3><i class="fa-solid fa-circle-exclamation gold"></i> Se você...</h3>
							<ul>
								<li>Sente que profissionais piores se destacam mais que você</li>
								<li>Não sabe como se comunicar com o cliente certo</li>
								<li>Tem medo da câmera e trava na hora de gravar vídeos</li>
								<li>Investe em marketing sem entender os fundamentos</li>
								<li>Sua marca não reflete quem você é de verdade</li>
								<li>Não consegue se posicionar como autoridade</li>
							</ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="vs-block vs-block--benefit">
							<h3><i class="fa-solid fa-trophy gold"></i> Com a Mentoria você...</h3>
							<ul>
								<li>Domina os fundamentos do verdadeiro marketing</li>
								<li>Comunica-se com clareza e atrai o cliente ideal</li>
								<li>Aprende os segredos para gravar vídeos com confiança</li>
								<li>Assume o protagonismo da sua marca</li>
								<li>Posiciona-se como embaixadora autêntica</li>
								<li>Desperta o potencial que o mercado já reconhece</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- METODOLOGIA / SOBRE TATI -->
		<section class="section">
			<div class="container">
				<div class="row align-items-center g-5">
					<div class="col-lg-5">
						<div class="mentor-photo-wrap">
							<img src="<?=PATH?>assets/images/Hero-lp-embaixadora.png" alt="Tatiane Serafim" />
						</div>
					</div>
					<div class="col-lg-7">
						<p class="eyebrow">Sobre a mentora</p>
						<h2 style="font-style: italic;">Tatiane <span class="gold">Serafim</span></h2>
						<p style="font-size: 1.15rem; color: var(--text-primary);">
							Após <strong class="gold">18 anos atuando na área de comunicação e marketing</strong> e <strong class="gold">11 anos mentorando empreendedoras</strong>, eu desenvolvi uma metodologia exclusiva para você se tornar <em class="gold-light" style="font-family: 'Cormorant Garamond', serif;">embaixadora da sua própria marca</em>.
						</p>
						<p style="color: var(--text-muted);">
							Vou te ensinar desde os fundamentos do verdadeiro marketing, até os segredos para você gravar vídeos que conectam, vendem e posicionam sua marca como referência no mercado.
						</p>
						<div class="d-flex flex-wrap gap-2 mt-4">
							<div class="stat-pill"><span class="num">18</span><span class="lbl">anos de marketing</span></div>
							<div class="stat-pill"><span class="num">11</span><span class="lbl">anos mentorando</span></div>
							<div class="stat-pill"><span class="num">+</span><span class="lbl">metodologia exclusiva</span></div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- ESTRUTURA -->
		<section class="section section--light">
			<div class="container">
				<div class="text-center mb-5">
					<p class="eyebrow" style="color: var(--gold-dark);">Como funciona</p>
					<h2>Estrutura da Mentoria</h2>
					<p style="max-width: 600px; margin: 0 auto;">4 encontros online em grupo + 1 encontro individual exclusivo para quem atingir as metas propostas.</p>
				</div>

				<div class="row g-4 align-items-center">
					<div class="col-lg-6">
						<div style="background: #fff; border: 1px solid #d8cfba; border-radius: 8px; padding: 2.5rem;">
							<div class="schedule-item" style="border-color: #e8dec5;">
								<div class="icon" style="border-color: var(--gold-dark); color: var(--gold-dark);">
									<i class="fa-solid fa-video"></i>
								</div>
								<div>
									<div class="label" style="color: var(--gold-dark);">Encontros</div>
									<div class="value" style="color: #1a1a1a;">4 encontros online em grupo</div>
								</div>
							</div>
							<div class="schedule-item" style="border-color: #e8dec5;">
								<div class="icon" style="border-color: var(--gold-dark); color: var(--gold-dark);">
									<i class="fa-solid fa-calendar-days"></i>
								</div>
								<div>
									<div class="label" style="color: var(--gold-dark);">Datas</div>
									<div class="value" style="color: #1a1a1a;">Segundas-feiras<br/>De 01 a 22 de Junho</div>
								</div>
							</div>
							<div class="schedule-item" style="border-color: #e8dec5;">
								<div class="icon" style="border-color: var(--gold-dark); color: var(--gold-dark);">
									<i class="fa-solid fa-clock"></i>
								</div>
								<div>
									<div class="label" style="color: var(--gold-dark);">Horário</div>
									<div class="value" style="color: #1a1a1a;">19h30</div>
								</div>
							</div>
							<div class="schedule-item" style="border-color: #e8dec5;">
								<div class="icon" style="border-color: var(--gold-dark); color: var(--gold-dark);">
									<i class="fa-solid fa-user-check"></i>
								</div>
								<div>
									<div class="label" style="color: var(--gold-dark);">Bônus</div>
									<div class="value" style="color: #1a1a1a;">+ 1 encontro individual<br/><small style="font-family: 'Montserrat', sans-serif; font-size: .85rem; color: #666;">para quem atingir as metas propostas</small></div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<h3 style="color: #1a1a1a;">O que você vai dominar</h3>
						<ul style="list-style: none; padding: 0; font-size: 1.05rem;">
							<li style="padding: 12px 0; padding-left: 2rem; position: relative; color: #333;">
								<i class="fa-solid fa-check" style="position: absolute; left: 0; top: 16px; color: var(--gold-dark);"></i>
								Fundamentos do <strong>verdadeiro marketing</strong>
							</li>
							<li style="padding: 12px 0; padding-left: 2rem; position: relative; color: #333;">
								<i class="fa-solid fa-check" style="position: absolute; left: 0; top: 16px; color: var(--gold-dark);"></i>
								Posicionamento de marca como <strong>embaixadora</strong>
							</li>
							<li style="padding: 12px 0; padding-left: 2rem; position: relative; color: #333;">
								<i class="fa-solid fa-check" style="position: absolute; left: 0; top: 16px; color: var(--gold-dark);"></i>
								Como identificar e se comunicar com seu <strong>cliente ideal</strong>
							</li>
							<li style="padding: 12px 0; padding-left: 2rem; position: relative; color: #333;">
								<i class="fa-solid fa-check" style="position: absolute; left: 0; top: 16px; color: var(--gold-dark);"></i>
								Segredos para <strong>gravar vídeos</strong> que conectam e vendem
							</li>
							<li style="padding: 12px 0; padding-left: 2rem; position: relative; color: #333;">
								<i class="fa-solid fa-check" style="position: absolute; left: 0; top: 16px; color: var(--gold-dark);"></i>
								Metodologia exclusiva da <strong>Tatiane Serafim</strong>
							</li>
							<li style="padding: 12px 0; padding-left: 2rem; position: relative; color: #333;">
								<i class="fa-solid fa-check" style="position: absolute; left: 0; top: 16px; color: var(--gold-dark);"></i>
								Despertar o <strong>protagonismo</strong> da sua marca
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>

		<!-- DEPOIMENTOS -->
		<section class="section">
			<div class="container">
				<div class="text-center mb-5">
					<p class="eyebrow">Quem viveu, conta</p>
					<h2>Resultados <em class="gold-light" style="font-style: italic;">reais</em></h2>
					<p class="text-muted-gold" style="max-width: 600px; margin: 0 auto;">Empreendedoras que passaram pela mentoria com Tatiane Serafim.</p>
					<div class="divider-triade">
						<img src="<?=PATH?>assets/images/icon-diamond-gold.svg" alt="" class="triade-symbol" />
					</div>
				</div>

				<div class="row g-4 justify-content-center">
					<div class="col-lg-6">
						<figure class="testimonial-card">
							<div class="testimonial-card__quote">
								<i class="fa-solid fa-quote-left"></i>
							</div>
							<blockquote>
								<p>A mentoria com Tati Serafim foi um verdadeiro <strong class="gold">divisor de águas</strong> na Lincoln Imóveis. Antes, tínhamos metas vagas e processos que dependiam apenas do dia a dia.</p>
								<p>Com a orientação recebida, conseguimos <strong class="gold">padronizar nossa marca</strong>, estabelecemos metas e a visão estratégica com muito mais organização. Além disso, a mentoria nos deu a clareza necessária para enxergar nossa visão de futuro com muito mais confiança, traçando metas reais para chegarmos onde planejamos nos próximos 5 anos.</p>
								<p>Recomendo para qualquer profissional que busque subir degraus na carreira com <strong class="gold">segurança, clareza, alinhamento estratégico e propósito</strong>.</p>
							</blockquote>
							<figcaption class="testimonial-card__author">
								<img src="<?=PATH?>assets/images/jamara-magalhaes.jpg" alt="Jamara Magalhães" class="testimonial-card__avatar" />
								<div>
									<div class="testimonial-card__name">Jamara Magalhães</div>
									<div class="testimonial-card__role">Lincoln Imóveis</div>
								</div>
							</figcaption>
						</figure>
					</div>
					<div class="col-lg-6">
						<figure class="testimonial-card">
							<div class="testimonial-card__quote">
								<i class="fa-solid fa-quote-left"></i>
							</div>
							<blockquote>
								<p>Depois de uma mentoria com Tati Serafim, a minha <strong class="gold">transformação é contínua</strong>. Através da mentoria eu me encorajei a não ter medo de errar.</p>
								<p>Posso afirmar que <strong class="gold">tudo mudou no meu posicionamento</strong> e com a clareza de saber, eu entendi que a minha voz representava a minha empresa.</p>
								<p>Obrigada, Tati.</p>
							</blockquote>
							<figcaption class="testimonial-card__author">
								<img src="<?=PATH?>assets/images/rosangela-capucho.jpg" alt="Rosangela Piol Capucho" class="testimonial-card__avatar" />
								<div>
									<div class="testimonial-card__name">Rosangela Piol Capucho</div>
									<div class="testimonial-card__role">Empreendedora</div>
								</div>
							</figcaption>
						</figure>
					</div>
				</div>
			</div>
		</section>

		<!-- OFERTA / LOTES -->
		<section class="section" id="oferta">
			<div class="container">
				<div class="text-center mb-5">
					<p class="eyebrow">Investimento</p>
					<h2>Garanta sua vaga</h2>
					<p class="text-muted-gold" style="max-width: 600px; margin: 0 auto;">Quanto antes você se inscrever, menor o investimento. Vagas limitadas.</p>
					<div class="divider-triade">
						<img src="<?=PATH?>assets/images/icon-diamond-gold.svg" alt="" class="triade-symbol" />
					</div>
				</div>

				<!-- Promo Banner -->
				<div class="promo-banner mb-5">
					<p class="eyebrow">1º Lote — Lote Atual</p>
					<h3 style="font-style: italic; margin-bottom: .5rem;">Vagas com <span class="gold">valor reduzido</span> até <span class="gold">17/05</span></h3>
					<div class="promo-price">R$ 1.297<small>,00</small></div>
					<p class="promo-deadline">Em até 12x no cartão. Após 17/05, valor sobe para R$ 1.497 (2º lote).</p>
					<a href="<?=$buy_link?>" target="_blank" class="btn-gold">
						<i class="fa-solid fa-crown"></i> Quero garantir o 1º lote
					</a>
				</div>

				<!-- Lotes -->
				<div class="row g-4">
					<div class="col-md-4">
						<div class="lote-card lote-card--passed">
							<div class="badge-passed">Encerrado</div>
							<div class="lote-name">Dia do Lançamento</div>
							<div class="lote-date">02/05 até 23h29</div>
							<div class="lote-price">R$ 997<small>,00</small></div>
							<div class="lote-installments">em até 12x no cartão</div>
							<span class="lote-card--passed-text">
								<i class="fa-solid fa-circle-check me-1"></i> Lote encerrado
							</span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="lote-card lote-card--featured">
							<div class="badge-featured">Lote Atual</div>
							<div class="lote-name">1º Lote</div>
							<div class="lote-date">até 17/05</div>
							<div class="lote-price">R$ 1.297<small>,00</small></div>
							<div class="lote-installments">em até 12x no cartão</div>
							<a href="<?=$buy_link?>" target="_blank" class="btn-gold w-100 justify-content-center">
								Inscrever
							</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="lote-card">
							<div class="lote-name">2º Lote</div>
							<div class="lote-date">18/05 a 29/05</div>
							<div class="lote-price">R$ 1.497<small>,00</small></div>
							<div class="lote-installments">em até 12x no cartão</div>
							<a href="<?=$buy_link?>" target="_blank" class="btn-outline-gold w-100 justify-content-center">
								Inscrever
							</a>
						</div>
					</div>
				</div>

				<p class="text-center mt-4" style="color: var(--text-muted); font-style: italic;">
					<i class="fa-solid fa-circle-exclamation gold me-2"></i>
					Inscrições encerram em <strong class="gold">29/05</strong>
				</p>
			</div>
		</section>

		<!-- CHEGA -->
		<section class="section" style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1611 100%);">
			<div class="container text-center">
				<h2 style="font-style: italic; max-width: 800px; margin: 0 auto;">
					Chega de ver profissionais ruins se destacando
					mais do que <span class="gold" style="text-decoration: underline; text-decoration-color: var(--gold-dark); text-underline-offset: 8px;">você</span>.
				</h2>
				<p class="mt-4 mb-4" style="max-width: 600px; margin: 0 auto; color: var(--text-muted);">
					Sua marca merece o protagonismo que só você pode dar. Hora de se tornar a embaixadora autêntica do seu negócio.
				</p>
				<a href="<?=$buy_link?>" target="_blank" class="btn-gold mt-3">
					<i class="fa-solid fa-crown"></i> Quero ser embaixadora da minha marca
				</a>
			</div>
		</section>

		<!-- FAQ -->
		<section class="section" id="faq">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<p class="eyebrow">Dúvidas</p>
						<h2>Perguntas Frequentes</h2>
						<p class="text-muted-gold mt-4">Não encontrou sua resposta? Fale com a gente no WhatsApp.</p>
						<a href="<?=$whatsapp_link?>" target="_blank" class="btn-outline-gold mt-3">
							<i class="fa-brands fa-whatsapp"></i> Falar no WhatsApp
						</a>
					</div>
					<div class="col-lg-8 mt-5 mt-lg-0">
						<details class="faq-item" open>
							<summary>Quando começam os encontros?</summary>
							<p>Os 4 encontros online acontecem às segundas-feiras, de 01 a 22 de Junho, sempre às 19h30.</p>
						</details>
						<details class="faq-item">
							<summary>Como funciona o encontro individual?</summary>
							<p>Quem atingir as metas propostas durante a mentoria ganha um encontro individual exclusivo com a Tatiane Serafim para aprofundar a estratégia da sua marca.</p>
						</details>
						<details class="faq-item">
							<summary>Por que o preço muda?</summary>
							<p>O 1º lote sai por R$ 1.297 (válido até 17/05) e o 2º lote por R$ 1.497 (de 18/05 a 29/05). Quanto antes você se inscrever, menor o investimento.</p>
						</details>
						<details class="faq-item">
							<summary>Posso parcelar?</summary>
							<p>Sim, em até 12x no cartão. O pagamento é processado via InfinitePay com segurança total.</p>
						</details>
						<details class="faq-item">
							<summary>É online ou presencial?</summary>
							<p>100% online. Você participa de qualquer lugar, basta ter internet.</p>
						</details>
						<details class="faq-item">
							<summary>Para quem é essa mentoria?</summary>
							<p>Para empreendedoras que querem assumir o protagonismo da própria marca, dominar marketing de verdade, aprender a gravar vídeos com confiança e se posicionar como autoridade no seu mercado.</p>
						</details>
						<details class="faq-item">
							<summary>Até quando posso me inscrever?</summary>
							<p>As inscrições encerram em 29/05. Após essa data, novas turmas só no próximo lançamento.</p>
						</details>
					</div>
				</div>
			</div>
		</section>

		<!-- FINAL CTA -->
		<section class="section" style="background: var(--bg-secondary);">
			<div class="container text-center">
				<p class="eyebrow">Última chamada</p>
				<h2>Pronta para virar o jogo?</h2>
				<p class="mt-4 mb-4" style="max-width: 600px; margin: 0 auto; color: var(--text-muted);">
					Garanta sua vaga agora pelo valor especial de lançamento e dê o primeiro passo para se tornar embaixadora da sua própria marca.
				</p>
				<div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-3">
					<a href="<?=$buy_link?>" target="_blank" class="btn-gold">
						<i class="fa-solid fa-crown"></i> Garantir minha vaga
					</a>
					<a href="<?=$whatsapp_link?>" target="_blank" class="btn-outline-gold">
						<i class="fa-brands fa-whatsapp"></i> Lista VIP
					</a>
				</div>
			</div>
		</section>

		<footer class="footer-tati">
			<div class="container">
				<div class="divider-triade">
					<img src="<?=PATH?>assets/images/icon-diamond-gold.svg" alt="" class="triade-symbol" />
				</div>
				<h3 style="font-style: italic; font-size: 1.5rem;">Tatiane <span class="gold">Serafim</span></h3>
				<div class="social mt-3">
					<a href="<?=$instagram?>" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
					<a href="<?=$whatsapp_link?>" target="_blank" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
				</div>
				<p class="mt-4" style="color: var(--text-muted); font-size: .85rem;">
					&copy; <?=date('Y')?> Tatiane Serafim. Mentoria "Embaixadora da minha Marca". Todos os direitos reservados.
				</p>
			</div>
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
		<script>
			(function(){
				var year = new Date().getFullYear();
				var stages = [
					{ label: '1º Lote (R$ 1.297) termina em', deadline: new Date(year, 4, 17, 23, 59, 59) },
					{ label: '2º Lote (R$ 1.497) termina em', deadline: new Date(year, 4, 29, 23, 59, 59) }
				];
				var bar     = document.getElementById('countdownBar');
				var labelEl = document.getElementById('countdownLabel');
				var dEl = document.getElementById('cdDays');
				var hEl = document.getElementById('cdHours');
				var mEl = document.getElementById('cdMins');
				var sEl = document.getElementById('cdSecs');
				var pad = function(n){ return n < 10 ? '0' + n : '' + n; };

				function tick(){
					var now = new Date();
					var stage = null;
					for (var i = 0; i < stages.length; i++){
						if (now < stages[i].deadline){ stage = stages[i]; break; }
					}
					if (!stage){
						bar.classList.add('is-ended');
						labelEl.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Inscrições encerradas';
						dEl.textContent = hEl.textContent = mEl.textContent = sEl.textContent = '00';
						return false;
					}
					labelEl.innerHTML = '<i class="fa-solid fa-hourglass-half"></i> ' + stage.label;
					var diff = Math.max(0, stage.deadline - now);
					var d = Math.floor(diff / 86400000);
					var h = Math.floor((diff % 86400000) / 3600000);
					var m = Math.floor((diff % 3600000) / 60000);
					var s = Math.floor((diff % 60000) / 1000);
					dEl.textContent = pad(d);
					hEl.textContent = pad(h);
					mEl.textContent = pad(m);
					sEl.textContent = pad(s);
					return true;
				}

				if (tick()){
					setInterval(tick, 1000);
				}
			})();
		</script>
	</body>
</html>
