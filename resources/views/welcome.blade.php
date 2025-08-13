@extends('layouts.app')

@section('content')

<style>
 .hero-video-section {
            height: 70vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            background: #101820;
        }
        
        /* Video de fondo - CENTRADO Y COMPLETO */
        .hero-video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%);
            z-index: 0;
            object-fit: contain; /* Cambiado de 'cover' a 'contain' para que se vea completo */
            opacity: 0.8; /* Más visible */
        }
        
        /* Overlay muy suave sobre el video */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            background: linear-gradient(135deg, 
                rgba(16, 24, 32, 0.3) 0%, 
                rgba(16, 24, 32, 0.2) 50%, 
                rgba(16, 24, 32, 0.4) 100%);
        }
        
        /* Contenido sobre el video */
        .hero-content {
            position: relative;
            z-index: 2;
            color: #FCFAF1;
            animation: fadeInUp 1.5s ease-out;
        }
        
        .hero-content h1 {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 30px;
            color: #FCFAF1;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        
        .hero-content .lead {
            font-size: 1.4rem;
            color: #FCFAF1;
            font-weight: 300;
            line-height: 1.6;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FCFAF1 0%, #F8F6ED 100%);
            color: #101820;
            border: 2px solid #00A9E0;
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.4s ease;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #00A9E0 0%, #00CFB4 100%);
            color: #FCFAF1;
            border-color: #FCFAF1;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 169, 224, 0.4);
            text-decoration: none;
        }
        
        /* Controles de video personalizados */
        .video-controls {
            position: absolute;
            bottom: 30px;
            right: 30px;
            z-index: 3;
        }
        
        .video-control-btn {
            background: rgba(16, 24, 32, 0.8);
            color: #FCFAF1;
            border: 2px solid rgba(0, 169, 224, 0.6);
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-left: 10px;
            backdrop-filter: blur(5px);
        }
        
        .video-control-btn:hover {
            background: linear-gradient(135deg, #00A9E0, #00CFB4);
            border-color: #FCFAF1;
            color: #101820;
            transform: scale(1.15);
            box-shadow: 0 5px 20px rgba(0, 169, 224, 0.4);
        }
        
        .position-relative {
            overflow: hidden;
        }

        /* Efecto de zoom en las imágenes de productos */
        .card-img-top {
            transition: all 0.4s ease-in-out;
            border-radius: 15px 15px 0 0;
        }

        .card-img-top:hover {
            transform: scale(1.08);
            filter: brightness(1.1) saturate(1.2);
        }

        /* Efectos adicionales para las tarjetas */
        .card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 207, 180, 0.1);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 169, 224, 0.2);
            border-color: rgba(0, 207, 180, 0.3);
        }

        /* Botón "Ver" mejorado */
        .btn-outline-dark {
            border-color: #00A9E0;
            color: #00A9E0;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-dark:hover {
            background: #00A9E0;
            border-color: #00A9E0;
            color: #FCFAF1;
            transform: translateY(-2px);
        }

        /* Botón "Agregar" mejorado */
        .btn-buy {
            background: linear-gradient(135deg, #00CFB4, #00A9E0);
            border: none;
            color: #FCFAF1;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-buy:hover {
            background: linear-gradient(135deg, #00A9E0, #00CFB4);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 207, 180, 0.4);
        }

        .btn-buy:disabled {
            background: #6c757d;
            opacity: 0.6;
        }

        /* Badges de stock mejorados */
        .badge.bg-success {
            background: linear-gradient(135deg, #00CFB4, #00A9E0) !important;
            color: #FCFAF1 !important;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
            color: #101820 !important;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545, #c82333) !important;
            color: #FCFAF1 !important;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
        }

        /* Precios destacados */
        .text-success {
            color: #00CFB4 !important;
            font-weight: 700;
        }

        /* Section badges mejorados */
        .section-badge {
            background: linear-gradient(135deg, #00A9E0, #00CFB4) !important;
            color: #FCFAF1 !important;
            border: none;
            font-weight: 600;
            padding: 8px 16px !important;
            border-radius: 20px !important;
            box-shadow: 0 3px 10px rgba(0, 169, 224, 0.2);
        }

        /* Secciones con backgrounds balanceados */
        .featured-section {
            background: #FCFAF1;
            position: relative;
        }

        .featured-section .text-white {
            color: #101820 !important;
        }

        .featured-section .text-light {
            color: #666 !important;
        }

        .cta-section {
            background: linear-gradient(135deg, #101820 0%, #1a252f 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 20%;
            height: 100%;
            background: linear-gradient(45deg, rgba(0, 169, 224, 0.1), transparent);
            z-index: 1;
        }

        .cta-section .container {
            position: relative;
            z-index: 2;
        }

        .category-section {
            background: linear-gradient(135deg, #F8F6ED 0%, #FCFAF1 100%);
            position: relative;
        }

        .category-section .text-white {
            color: #101820 !important;
        }

        .category-section .text-light {
            color: #666 !important;
        }

        /* Mejorar botones CTA */
        .btn-lg.btn-light {
            background: linear-gradient(135deg, #FCFAF1, #F8F6ED);
            border: 2px solid #00A9E0;
            color: #101820;
            font-weight: 700;
            padding: 15px 35px;
            border-radius: 8px;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-lg.btn-light:hover {
            background: linear-gradient(135deg, #00A9E0, #00CFB4);
            border-color: #00CFB4;
            color: #FCFAF1;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 169, 224, 0.3);
        }

        /* Divisores más sutiles */
        .section-divider {
            background: linear-gradient(90deg, #00A9E0, #00CFB4) !important;
            height: 3px !important;
            border-radius: 2px;
        }

        /* Animaciones mejoradas */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content h1 {
            animation: fadeInUp 1.5s ease-out;
        }
        
        /* Responsivo mejorado */
        @media (max-width: 768px) {
            .hero-video-section {
                height: 60vh;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content .lead {
                font-size: 1.2rem;
            }
            
            .video-controls {
                bottom: 20px;
                right: 20px;
            }

            .video-control-btn {
                width: 45px;
                height: 45px;
            }

            .btn-primary {
                padding: 12px 28px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-video-section {
                height: 50vh;
            }
            
            .hero-content h1 {
                font-size: 2rem;
                margin-bottom: 20px;
            }
            
            .hero-content .lead {
                font-size: 1.1rem;
                margin-bottom: 30px;
            }

            .btn-primary {
                padding: 10px 24px;
                font-size: 0.95rem;
            }
        }

        /* Si quieres que el video cubra todo sin deformarse, usa esta alternativa */
        @media (min-aspect-ratio: 16/9) {
            .hero-video {
                width: 100%;
                height: auto;
            }
        }

        @media (max-aspect-ratio: 16/9) {
            .hero-video {
                width: auto;
                height: 100%;
            }
        }
        
    </style>

<!-- Hero Section -->
<section id="inicio" class="hero-video-section">
    <!-- Video de fondo -->
    <video class="hero-video" autoplay muted loop playsinline>
        <source src="{{ asset('videos/electrodomesticos.mp4') }}" type="video/mp4">
        <!-- Imagen de fallback si el video no carga -->
        Tu navegador no soporta videos. 
    </video>
    
    <!-- Overlay -->
    <div class="hero-overlay"></div>
    
    <!-- Contenido principal -->
    <div class="hero-content container">
        <div class="row">
            <div class="col-lg-8 ps-lg-5">
                <h1>ELECTRODOMÉSTICOS DE CALIDAD PREMIUM</h1>
                <p class="lead mb-4">Descubre la mejor selección de electrodomésticos Oster con garantía oficial. Equipos duraderos, eficientes y diseñados para hacer tu vida más fácil en la cocina.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Ver Productos</a>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Productos Destacados -->
<section class="py-5 featured-section">
    <div class="container">
        <!-- Encabezado -->
        <div class="row mb-5 text-center text-white">
            <div class="col">
                <span class="section-badge px-3 py-1 rounded-pill">🔥 Selección del Mes</span>
                <h2 class="section-title text-white mt-3">Productos Destacados del Mes</h2>
                <p class="section-description text-light">
                    Electrodomésticos exclusivos seleccionados especialmente para tu hogar.
                </p>
                <div class="section-divider mx-auto" style="height: 4px; width: 80px;"></div>
            </div>
        </div>

        <!-- Productos -->
        <div class="row g-4 mb-5">
            @foreach($featuredProducts->take(6) as $index => $product)
            <div class="col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden" style="background-color: #fdfdfd;">
                    
                    <div class="position-relative">
                        <!-- Imagen del producto -->
                        <img src="{{ $product->images->first()?->image ? Storage::url($product->images->first()->image) : asset('images/placeholder.jpg') }}"
                             class="card-img-top" alt="{{ $product->name }}"
                             style="height: 320px; object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    </div>

                    <!-- Contenido -->
                    <div class="card-body p-4">
                        <h4 class="card-title fw-bold text-dark mb-2" style="font-family: 'Georgia', serif;">
                            {{ $product->name }}
                        </h4>

                        <p class="card-text text-muted">{{ Str::limit($product->description, 120) }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                @php
                                    $totalPrice = ($product->price ?? 0) + ($product->interest ?? 0);
                                @endphp
                                <span class="h5 text-success fw-bold">${{ number_format($totalPrice, 0, ',', '.') }}</span>
                                <small class="text-muted">c/u</small>

                                @if($product->stock <= 0)
                                    <span class="badge bg-danger ms-2">Agotado</span>
                                @elseif($product->stock <= 5)
                                    <span class="badge bg-warning text-dark ms-2">Pocas Unidades</span>
                                @else
                                    <span class="badge bg-success ms-2">Disponible</span>
                                @endif
                            </div>
                        </div>

                        <!-- Formulario para agregar al carrito -->
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="d-flex gap-2">
                              <a href="{{ route('product.show', $product) }}" class="btn btn-outline-dark btn-sm rounded-pill flex-fill">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <button type="submit" class="btn btn-buy btn-sm rounded-pill flex-fill" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart"></i> Agregar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
</section>

<!-- Call to Action: View All Products -->
<section class="py-5 text-white text-center cta-section">
    <div class="container">
        <h2 class="mb-4 fw-bold">¿Quieres explorar toda nuestra selección?</h2>
        <p class="lead text-light">Descubre todos nuestros electrodomésticos premium y encuentra la opción perfecta para tu hogar.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-lg btn-light fw-semibold mt-3 shadow-sm">
            <i class="fas fa-store me-2"></i> Ver Todos los Productos
        </a>
    </div>
</section>

<!-- Category Showcase -->
<section class="py-5 category-section">
    <div class="container">
        <div class="row text-center mb-5 text-white">
            <div class="col">
                <span class="section-badge px-3 py-1 rounded-pill">🧾 Categorías</span>
                <h2 class="section-title text-white mt-3">Explorar por Categoría</h2>
                <p class="section-description text-light">Selecciona el electrodoméstico perfecto según tus necesidades y preferencias.</p>
                <div class="section-divider mx-auto" style="height: 4px; width: 80px;"></div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($categories as $index => $category)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow border-0">
                    <img src="{{ $category->image ? Storage::url($category->image) : asset('images/category-placeholder.jpg') }}"
                         alt="{{ $category->name }}"
                         class="card-img-top" style="height: 220px; object-fit: cover;">

                    <div class="card-body bg-white rounded-bottom">
                        <h5 class="card-title fw-bold text-dark">{{ $category->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($category->description, 100) }}</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-dark mt-2">
                            Explorar Categoría
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection