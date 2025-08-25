{{-- resources/views/admin/pages/edit-servicios.blade.php --}}
@extends('layouts.app_admin')

@section('content')
<style>
    body, .container { background: #101820 !important; color: #FCFAF1; }
    .main-content { background: #1a252f; padding: 20px; border-radius: 8px; border: 1px solid #00A9E0; }
    .section-card { background: #2a3441; border: 1px solid #00A9E0; border-radius: 8px; margin-bottom: 25px; }
    .section-header { background: #1a252f; padding: 15px; border-bottom: 1px solid rgba(0, 169, 224, 0.3); }
    .section-body { padding: 20px; }
    .form-control, .form-select, .form-control:focus { background: #101820; border: 1px solid #00A9E0; color: #FCFAF1; }
    .form-control:focus { border-color: #f7a831; box-shadow: 0 0 0 0.2rem rgba(247, 168, 49, 0.25); }
    .btn-success { background-color: #00A9E0; border-color: #00A9E0; }
    .btn-danger { background-color: #dc3545; border-color: #dc3545; }
    .btn-secondary { background-color: #6c757d; border-color: #6c757d; }
    h2, h4 { color: #00A9E0 !important; }
    .alert-success { background-color: rgba(0, 169, 224, 0.2); color: #FCFAF1; border: 1px solid #00A9E0; }
    .form-check-input:checked { background-color: #00A9E0; border-color: #00A9E0; }
    .badge-hero { background-color: #f7a831; }
    .badge-intro { background-color: #28a745; }
    .badge-services { background-color: #17a2b8; }
    .badge-process { background-color: #fd7e14; }
    .badge-why { background-color: #6f42c1; }
    .badge-cta { background-color: #dc3545; }
    .image-preview { height: 120px; width: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #00A9E0; }
    .field-group { background: rgba(0, 169, 224, 0.05); border: 1px solid rgba(0, 169, 224, 0.2); border-radius: 8px; padding: 15px; margin-bottom: 20px; }
    .field-group h6 { color: #00A9E0; margin-bottom: 15px; }
    .service-preview { background: rgba(23, 162, 184, 0.1); border: 1px solid #17a2b8; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
    .process-preview { background: rgba(253, 126, 20, 0.1); border: 1px solid #fd7e14; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
    .reason-preview { background: rgba(111, 66, 193, 0.1); border: 1px solid #6f42c1; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
</style>

<div class="main-content">
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><i class="fas fa-tools"></i> Editar Página "Servicios"</h2>
                <p class="text-light mb-0">Gestiona toda la información de servicios y reparaciones</p>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @foreach($page->sections()->ordered()->get() as $section)

            {{-- SECCIÓN HERO - Banner de Servicios --}}
            @if($section->name === 'hero')
            <div class="section-card">
                <div class="section-header">
                    <h4><i class="fas fa-flag me-2"></i> Banner Principal <span class="badge badge-hero ms-2">Hero</span></h4>
                </div>
                <div class="section-body">
                    <form action="{{ route('admin.pages.sections.update', [$page->id, $section->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="field-group">
                            <h6><i class="fas fa-heading"></i> Títulos del Banner</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Título Principal</label>
                                    <input type="text" name="title" class="form-control" 
                                           value="{{ $section->title ?: 'Nuestros Servicios' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subtítulo</label>
                                    <input type="text" name="content" class="form-control" 
                                           value="{{ $section->content ?: 'Servicios especializados en electrodomésticos' }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="field-group">
                            <h6><i class="fas fa-image"></i> Imagen de Fondo</h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="file" name="images[]" class="form-control" accept="image/*">
                                    <small class="text-muted">Recomendado: 1920x600px. Imagen relacionada con servicios técnicos.</small>
                                </div>
                                <div class="col-md-4">
                                    @if($section->getImagesArray())
                                        <img src="{{ Storage::url($section->getImagesArray()[0]) }}" class="image-preview mb-2">
                                        <br>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="deleteImage('hero', {{ $section->id }}, 0)">
                                            <i class="fas fa-trash"></i> Cambiar
                                        </button>
                                    @else
                                        <div class="text-center p-3 border rounded" style="border-color: #00A9E0;">
                                            <i class="fas fa-image fa-2x text-muted"></i><br>
                                            <small class="text-muted">Sin imagen</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i> Guardar Banner
                        </button>
                    </form>
                </div>
            </div>

            {{-- SECCIÓN INTRO - Introducción --}}
            @elseif($section->name === 'intro')
            <div class="section-card">
                <div class="section-header">
                    <h4><i class="fas fa-info-circle me-2"></i> Introducción <span class="badge badge-intro ms-2">Intro</span></h4>
                </div>
                <div class="section-body">
                    <form action="{{ route('admin.pages.sections.update', [$page->id, $section->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="field-group">
                            <h6><i class="fas fa-heading"></i> Título</h6>
                            <input type="text" name="title" class="form-control mb-3" 
                                   value="{{ $section->title ?: 'Expertos en Electrodomésticos' }}" required>
                        </div>

                        <div class="field-group">
                            <h6><i class="fas fa-align-left"></i> Descripción</h6>
                            <textarea name="content" class="form-control" rows="4" 
                                      placeholder="Descripción introductoria sobre tus servicios, experiencia y compromiso...">{{ $section->content }}</textarea>
                        </div>

                        <div class="field-group">
                            <h6><i class="fas fa-image"></i> Imagen Representativa</h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="file" name="images[]" class="form-control" accept="image/*">
                                    <small class="text-muted">Imagen del equipo o taller de trabajo</small>
                                </div>
                                <div class="col-md-4">
                                    @if($section->getImagesArray())
                                        <img src="{{ Storage::url($section->getImagesArray()[0]) }}" class="image-preview">
                                        <button type="button" class="btn btn-danger btn-sm mt-1" 
                                                onclick="deleteImage('intro', {{ $section->id }}, 0)">Cambiar</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i> Guardar Introducción
                        </button>
                    </form>
                </div>
            </div>

            {{-- SECCIÓN SERVICES LIST - Lista de Servicios --}}
            @elseif($section->name === 'services_list')
            <div class="section-card">
                <div class="section-header">
                    <h4><i class="fas fa-list me-2"></i> Lista de Servicios <span class="badge badge-services ms-2">Services</span></h4>
                </div>
                <div class="section-body">
                    <form action="{{ route('admin.pages.sections.update', [$page->id, $section->id]) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="field-group">
                            <h6><i class="fas fa-heading"></i> Título de Sección</h6>
                            <input type="text" name="title" class="form-control mb-3" 
                                   value="{{ $section->title ?: 'Servicios Disponibles' }}" required>
                            <textarea name="content" class="form-control" rows="2" 
                                      placeholder="Descripción breve de los servicios">{{ $section->content }}</textarea>
                        </div>

                        <div class="field-group">
                            <h6><i class="fas fa-cogs"></i> 6 Servicios Principales</h6>
                            
                            <!-- Servicio 1 -->
                            <div class="service-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 1</label>
                                        <input type="text" name="service_1_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('service_1_icon', '🔧') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Servicio 1</label>
                                        <input type="text" name="service_1_title" class="form-control" 
                                               value="{{ $section->getCustomData('service_1_title', 'Reparación de Lavadoras') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 1</label>
                                        <input type="text" name="service_1_desc" class="form-control" 
                                               value="{{ $section->getCustomData('service_1_desc', 'Diagnóstico y reparación de todo tipo de lavadoras') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Servicio 2 -->
                            <div class="service-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 2</label>
                                        <input type="text" name="service_2_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('service_2_icon', '❄️') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Servicio 2</label>
                                        <input type="text" name="service_2_title" class="form-control" 
                                               value="{{ $section->getCustomData('service_2_title', 'Reparación de Refrigeradoras') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 2</label>
                                        <input type="text" name="service_2_desc" class="form-control" 
                                               value="{{ $section->getCustomData('service_2_desc', 'Servicio técnico especializado en refrigeración') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Servicio 3 -->
                            <div class="service-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 3</label>
                                        <input type="text" name="service_3_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('service_3_icon', '🍳') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Servicio 3</label>
                                        <input type="text" name="service_3_title" class="form-control" 
                                               value="{{ $section->getCustomData('service_3_title', 'Reparación de Cocinas') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 3</label>
                                        <input type="text" name="service_3_desc" class="form-control" 
                                               value="{{ $section->getCustomData('service_3_desc', 'Mantenimiento y reparación de cocinas eléctricas y gas') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Servicio 4 -->
                            <div class="service-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 4</label>
                                        <input type="text" name="service_4_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('service_4_icon', '🌀') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Servicio 4</label>
                                        <input type="text" name="service_4_title" class="form-control" 
                                               value="{{ $section->getCustomData('service_4_title', 'Reparación de Secadoras') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 4</label>
                                        <input type="text" name="service_4_desc" class="form-control" 
                                               value="{{ $section->getCustomData('service_4_desc', 'Servicio completo para secadoras de ropa') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Servicio 5 -->
                            <div class="service-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 5</label>
                                        <input type="text" name="service_5_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('service_5_icon', '⚡') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Servicio 5</label>
                                        <input type="text" name="service_5_title" class="form-control" 
                                               value="{{ $section->getCustomData('service_5_title', 'Electrodomésticos Oster') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 5</label>
                                        <input type="text" name="service_5_desc" class="form-control" 
                                               value="{{ $section->getCustomData('service_5_desc', 'Reparación especializada en productos Oster') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Servicio 6 -->
                            <div class="service-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 6</label>
                                        <input type="text" name="service_6_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('service_6_icon', '🏠') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Servicio 6</label>
                                        <input type="text" name="service_6_title" class="form-control" 
                                               value="{{ $section->getCustomData('service_6_title', 'Servicio a Domicilio') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 6</label>
                                        <input type="text" name="service_6_desc" class="form-control" 
                                               value="{{ $section->getCustomData('service_6_desc', 'Atendemos en tu hogar u oficina') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i> Guardar Lista de Servicios
                        </button>
                    </form>
                </div>
            </div>

            {{-- SECCIÓN PROCESS - Proceso de Trabajo --}}
            @elseif($section->name === 'process')
            <div class="section-card">
                <div class="section-header">
                    <h4><i class="fas fa-tasks me-2"></i> Proceso de Trabajo <span class="badge badge-process ms-2">Process</span></h4>
                </div>
                <div class="section-body">
                    <form action="{{ route('admin.pages.sections.update', [$page->id, $section->id]) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="field-group">
                            <h6><i class="fas fa-heading"></i> Título</h6>
                            <input type="text" name="title" class="form-control mb-3" 
                                   value="{{ $section->title ?: 'Nuestro Proceso de Trabajo' }}" required>
                            <textarea name="content" class="form-control" rows="2" 
                                      placeholder="Descripción del proceso">{{ $section->content }}</textarea>
                        </div>

                        <div class="field-group">
                            <h6><i class="fas fa-list-ol"></i> 4 Pasos del Proceso</h6>
                            
                            <!-- Paso 1 -->
                            <div class="process-preview">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="form-label">Paso</label>
                                        <input type="text" name="step_1_number" class="form-control text-center" 
                                               value="{{ $section->getCustomData('step_1_number', '1') }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Título Paso 1</label>
                                        <input type="text" name="step_1_title" class="form-control" 
                                               value="{{ $section->getCustomData('step_1_title', 'Diagnóstico') }}">
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">Descripción Paso 1</label>
                                        <input type="text" name="step_1_desc" class="form-control" 
                                               value="{{ $section->getCustomData('step_1_desc', 'Evaluamos el problema y identificamos la solución') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 2 -->
                            <div class="process-preview">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="form-label">Paso</label>
                                        <input type="text" name="step_2_number" class="form-control text-center" 
                                               value="{{ $section->getCustomData('step_2_number', '2') }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Título Paso 2</label>
                                        <input type="text" name="step_2_title" class="form-control" 
                                               value="{{ $section->getCustomData('step_2_title', 'Presupuesto') }}">
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">Descripción Paso 2</label>
                                        <input type="text" name="step_2_desc" class="form-control" 
                                               value="{{ $section->getCustomData('step_2_desc', 'Te damos un presupuesto claro y sin sorpresas') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 3 -->
                            <div class="process-preview">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="form-label">Paso</label>
                                        <input type="text" name="step_3_number" class="form-control text-center" 
                                               value="{{ $section->getCustomData('step_3_number', '3') }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Título Paso 3</label>
                                        <input type="text" name="step_3_title" class="form-control" 
                                               value="{{ $section->getCustomData('step_3_title', 'Reparación') }}">
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">Descripción Paso 3</label>
                                        <input type="text" name="step_3_desc" class="form-control" 
                                               value="{{ $section->getCustomData('step_3_desc', 'Realizamos la reparación con repuestos originales') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 4 -->
                            <div class="process-preview">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="form-label">Paso</label>
                                        <input type="text" name="step_4_number" class="form-control text-center" 
                                               value="{{ $section->getCustomData('step_4_number', '4') }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Título Paso 4</label>
                                        <input type="text" name="step_4_title" class="form-control" 
                                               value="{{ $section->getCustomData('step_4_title', 'Garantía') }}">
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">Descripción Paso 4</label>
                                        <input type="text" name="step_4_desc" class="form-control" 
                                               value="{{ $section->getCustomData('step_4_desc', 'Tu electrodoméstico queda con garantía de servicio') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i> Guardar Proceso
                        </button>
                    </form>
                </div>
            </div>

            {{-- SECCIÓN WHY CHOOSE - Por Qué Elegir --}}
            @elseif($section->name === 'why_choose')
            <div class="section-card">
                <div class="section-header">
                    <h4><i class="fas fa-star me-2"></i> Por Qué Elegirnos <span class="badge badge-why ms-2">Why</span></h4>
                </div>
                <div class="section-body">
                    <form action="{{ route('admin.pages.sections.update', [$page->id, $section->id]) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="field-group">
                            <h6><i class="fas fa-heading"></i> Título</h6>
                            <input type="text" name="title" class="form-control mb-3" 
                                   value="{{ $section->title ?: 'Por Qué Elegir ElectraHome' }}" required>
                            <textarea name="content" class="form-control" rows="2" 
                                      placeholder="Descripción de las ventajas">{{ $section->content }}</textarea>
                        </div>

                        <div class="field-group">
                            <h6><i class="fas fa-thumbs-up"></i> 4 Razones Principales</h6>
                            
                            <!-- Razón 1 -->
                            <div class="reason-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 1</label>
                                        <input type="text" name="reason_1_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('reason_1_icon', '⭐') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Razón 1</label>
                                        <input type="text" name="reason_1_title" class="form-control" 
                                               value="{{ $section->getCustomData('reason_1_title', 'Experiencia Comprobada') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 1</label>
                                        <input type="text" name="reason_1_desc" class="form-control" 
                                               value="{{ $section->getCustomData('reason_1_desc', 'Más de 10 años reparando electrodomésticos') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Razón 2 -->
                            <div class="reason-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 2</label>
                                        <input type="text" name="reason_2_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('reason_2_icon', '🛡️') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Razón 2</label>
                                        <input type="text" name="reason_2_title" class="form-control" 
                                               value="{{ $section->getCustomData('reason_2_title', 'Garantía Completa') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 2</label>
                                        <input type="text" name="reason_2_desc" class="form-control" 
                                               value="{{ $section->getCustomData('reason_2_desc', 'Todos nuestros trabajos incluyen garantía') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Razón 3 -->
                            <div class="reason-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 3</label>
                                        <input type="text" name="reason_3_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('reason_3_icon', '⚡') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Razón 3</label>
                                        <input type="text" name="reason_3_title" class="form-control" 
                                               value="{{ $section->getCustomData('reason_3_title', 'Servicio Rápido') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 3</label>
                                        <input type="text" name="reason_3_desc" class="form-control" 
                                               value="{{ $section->getCustomData('reason_3_desc', 'Atención inmediata y respuesta en 24h') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Razón 4 -->
                            <div class="reason-preview">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Icono 4</label>
                                        <input type="text" name="reason_4_icon" class="form-control text-center" 
                                               value="{{ $section->getCustomData('reason_4_icon', '💰') }}" style="font-size: 1.5rem;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Razón 4</label>
                                        <input type="text" name="reason_4_title" class="form-control" 
                                               value="{{ $section->getCustomData('reason_4_title', 'Precios Justos') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descripción 4</label>
                                        <input type="text" name="reason_4_desc" class="form-control" 
                                               value="{{ $section->getCustomData('reason_4_desc', 'Presupuestos transparentes sin costos ocultos') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i> Guardar Razones
                        </button>
                    </form>
                </div>
            </div>

            {{-- SECCIÓN CTA - Llamada a la Acción --}}
            @elseif($section->name === 'cta')
            <div class="section-card">
                <div class="section-header">
                    <h4><i class="fas fa-rocket me-2"></i> Llamada a la Acción <span class="badge badge-cta ms-2">CTA</span></h4>
                </div>
                <div class="section-body">
                    <form action="{{ route('admin.pages.sections.update', [$page->id, $section->id]) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="field-group">
                            <h6><i class="fas fa-bullhorn"></i> CTA Final</h6>
                            <div class="mb-3">
                                <label class="form-label">Título de CTA</label>
                                <input type="text" name="title" class="form-control" 
                                       value="{{ $section->title ?: 'Solicita tu Servicio Hoy' }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="content" class="form-control" rows="3" 
                                          placeholder="Texto motivacional para que contacten...">{{ $section->content }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto del Botón Principal</label>
                                <input type="text" name="button_primary_text" class="form-control" 
                                       value="{{ $section->getCustomData('button_primary_text', 'Contactar Ahora') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto del Botón Secundario</label>
                                <input type="text" name="button_secondary_text" class="form-control" 
                                       value="{{ $section->getCustomData('button_secondary_text', 'Ver Más Servicios') }}">
                            </div>
                        </div>

                        <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i> Guardar CTA
                        </button>
                    </form>
                </div>
            </div>
            @endif

        @endforeach

        @if($page->sections->count() == 0)
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h4 class="text-warning">No hay secciones configuradas</h4>
            <p class="text-light">Las secciones se crearán automáticamente al acceder por primera vez.</p>
        </div>
        @endif

    </div>
</div>

<script>
// Función para eliminar imagen
function deleteImage(sectionName, sectionId, imageIndex) {
    if (confirm(`¿Estás seguro de eliminar esta imagen?`)) {
        fetch(`/admin/pages/{{ $page->id }}/sections/${sectionId}/images`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ image_index: imageIndex })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar la imagen');
            }
        });
    }
}

// Prevenir submit múltiple
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Guardando...';
    });
});
</script>
@endsection