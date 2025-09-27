{{-- resources/views/admin/pages/edit-footer.blade.php --}}
@extends('layouts.app_admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Footer</h2>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.pages.update-footer') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Información General -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Información General</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" name="title" value="{{ $page->title }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="content" class="form-label">Descripción de la empresa</label>
                            <textarea class="form-control" name="content" rows="2">{{ $page->content }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($page->sections->isNotEmpty())
            @foreach($page->sections as $section)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h5>
                            @switch($section->name)
                                @case('contact_info')
                                    Información de Contacto
                                    @break
                                @case('social_links')
                                    Redes Sociales
                                    @break
                                @case('services_links')
                                    Enlaces y Categorías
                                    @break
                                @case('legal_info')
                                    Información Legal
                                    @break
                                @default
                                    {{ ucfirst(str_replace('_', ' ', $section->name)) }}
                            @endswitch
                        </h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   name="sections[{{ $section->id }}][is_active]" 
                                   {{ $section->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="sections[{{ $section->id }}][id]" value="{{ $section->id }}">
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Título de la sección</label>
                                <input type="text" class="form-control" 
                                       name="sections[{{ $section->id }}][title]" 
                                       value="{{ $section->title }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Orden</label>
                                <input type="number" class="form-control" 
                                       name="sections[{{ $section->id }}][order]" 
                                       value="{{ $section->order }}" min="1">
                            </div>
                        </div>

                        @switch($section->name)
                            @case('contact_info')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][contact_email]" 
                                                   value="{{ $section->getCustomData('contact_email', 'info@electrahome.com') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][contact_phone]" 
                                                   value="{{ $section->getCustomData('contact_phone', '+58 (412) 123-4567') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Dirección</label>
                                            <textarea class="form-control" rows="2" 
                                                      name="sections[{{ $section->id }}][custom_data][contact_address]">{{ $section->getCustomData('contact_address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Horarios</label>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Lunes-Viernes" 
                                                   name="sections[{{ $section->id }}][custom_data][hours_weekdays]" 
                                                   value="{{ $section->getCustomData('hours_weekdays', '8:00 AM - 6:00 PM') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Sábados" 
                                                   name="sections[{{ $section->id }}][custom_data][hours_saturday]" 
                                                   value="{{ $section->getCustomData('hours_saturday', '8:00 AM - 4:00 PM') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Domingos" 
                                                   name="sections[{{ $section->id }}][custom_data][hours_sunday]" 
                                                   value="{{ $section->getCustomData('hours_sunday', 'Cerrado') }}">
                                        </div>
                                    </div>
                                </div>
                                @break

                            @case('social_links')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre de la empresa</label>
                                            <input type="text" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][company_name]" 
                                                   value="{{ $section->getCustomData('company_name', 'ElectraHome') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email principal</label>
                                            <input type="email" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][main_email]" 
                                                   value="{{ $section->getCustomData('main_email', 'info@electrahome.com') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Facebook</label>
                                            <input type="url" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][facebook_url]" 
                                                   value="{{ $section->getCustomData('facebook_url') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Instagram</label>
                                            <input type="url" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][instagram_url]" 
                                                   value="{{ $section->getCustomData('instagram_url') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">WhatsApp</label>
                                            <input type="text" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][whatsapp_number]" 
                                                   value="{{ $section->getCustomData('whatsapp_number') }}">
                                        </div>
                                    </div>
                                </div>
                                @break

                            @case('services_links')
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Enlaces de Navegación</label>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Inicio" 
                                                   name="sections[{{ $section->id }}][custom_data][nav_inicio]" 
                                                   value="{{ $section->getCustomData('nav_inicio', 'Inicio') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Productos" 
                                                   name="sections[{{ $section->id }}][custom_data][nav_productos]" 
                                                   value="{{ $section->getCustomData('nav_productos', 'Productos') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Quiénes Somos" 
                                                   name="sections[{{ $section->id }}][custom_data][nav_about]" 
                                                   value="{{ $section->getCustomData('nav_about', 'Quiénes Somos') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Contacto" 
                                                   name="sections[{{ $section->id }}][custom_data][nav_contacto]" 
                                                   value="{{ $section->getCustomData('nav_contacto', 'Contacto') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Servicios" 
                                                   name="sections[{{ $section->id }}][custom_data][nav_servicios]" 
                                                   value="{{ $section->getCustomData('nav_servicios', 'Servicios') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Categorías de Productos</label>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Licuadoras" 
                                                   name="sections[{{ $section->id }}][custom_data][cat_licuadoras]" 
                                                   value="{{ $section->getCustomData('cat_licuadoras', 'Licuadoras') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Freidoras de Aire" 
                                                   name="sections[{{ $section->id }}][custom_data][cat_freidoras]" 
                                                   value="{{ $section->getCustomData('cat_freidoras', 'Freidoras de Aire') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Sanducheras" 
                                                   name="sections[{{ $section->id }}][custom_data][cat_sanducheras]" 
                                                   value="{{ $section->getCustomData('cat_sanducheras', 'Sanducheras') }}">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Pequeños Electrodomésticos" 
                                                   name="sections[{{ $section->id }}][custom_data][cat_pequenos]" 
                                                   value="{{ $section->getCustomData('cat_pequenos', 'Pequeños Electrodomésticos') }}">
                                        </div>
                                    </div>
                                </div>
                                @break

                            @case('legal_info')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Texto de Copyright</label>
                                            <input type="text" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][copyright_text]" 
                                                   value="{{ $section->getCustomData('copyright_text', 'ElectraHome. Todos los derechos reservados.') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Garantía</label>
                                            <input type="text" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][cert_warranty]" 
                                                   value="{{ $section->getCustomData('cert_warranty', 'Garantía Oficial') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Servicio Técnico</label>
                                            <input type="text" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][cert_service]" 
                                                   value="{{ $section->getCustomData('cert_service', 'Servicio Técnico') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Calidad</label>
                                            <input type="text" class="form-control" 
                                                   name="sections[{{ $section->id }}][custom_data][cert_quality]" 
                                                   value="{{ $section->getCustomData('cert_quality', 'Calidad Certificada') }}">
                                        </div>
                                    </div>
                                </div>
                                @break
                        @endswitch
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info">
                No hay secciones configuradas. Se crearán automáticamente al guardar.
            </div>
        @endif

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>
@endsection