<?php
// app/Http/Controllers/Admin/PageController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Section;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('slug')->get();
        return view('admin.pages.index', compact('pages'));
    }

    // === MÉTODOS ESPECÍFICOS PARA CADA PÁGINA ===

    // Página de INICIO
    public function editInicio()
    {
        $page = Page::where('slug', 'inicio')->firstOrFail();
        return view('admin.pages.edit-inicio', compact('page'));
    }

    public function updateInicio(Request $request)
    {
        $page = Page::where('slug', 'inicio')->firstOrFail();
        return $this->updatePage($request, $page, 'admin.pages.edit-inicio');
    }

  



    // === MÉTODO COMPARTIDO PARA ACTUALIZAR ===
    private function updatePage(Request $request, Page $page, $redirectRoute)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'section' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:2048',
            'video_urls' => 'nullable|string'
        ]);

        // Actualizar datos básicos
        $page->title = $request->title;
        $page->content = $request->content;
        $page->section = $request->section;

        // Manejar imágenes nuevas
        $currentImages = $page->getImagesArray();
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('pages', 'public');
                $currentImages[] = $path;
            }
        }
        
        $page->setImagesArray($currentImages);

        // Manejar videos
        $videos = [];
        if ($request->filled('video_urls')) {
            $videoLines = explode("\n", $request->video_urls);
            foreach ($videoLines as $line) {
                $url = trim($line);
                if (!empty($url)) {
                    $videos[] = $url;
                }
            }
        }
        $page->setVideosArray($videos);

        $page->save();

        return redirect()->route($redirectRoute)
            ->with('success', 'Página actualizada correctamente');
    }

    // === MÉTODO PARA ELIMINAR IMÁGENES ===
    public function deleteImage(Request $request, Page $page)
    {
        $imageIndex = $request->input('image_index');
        $images = $page->getImagesArray();

        if (isset($images[$imageIndex])) {
            \Storage::disk('public')->delete($images[$imageIndex]);
            
            unset($images[$imageIndex]);
            $images = array_values($images);
            
            $page->setImagesArray($images);
            $page->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    

   
  public function manageSections(Page $page)
    {
        $sections = $page->sections()->ordered()->get();
        return view('admin.pages.sections', compact('page', 'sections'));
    }

  public function updateSection(Request $request, $pageId, $sectionId)
{
    $page = Page::findOrFail($pageId);
    $section = Section::findOrFail($sectionId);
    
    // Verificar que la sección pertenece a la página
    if ($section->page_id !== $page->id) {
        abort(404, 'Sección no encontrada en esta página');
    }

    // ✅ VALIDACIÓN COMPLETA incluyendo video e imágenes
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'is_active' => 'nullable',
        'media_type' => 'nullable|in:video,images',
        'hero_video' => 'nullable|file|mimes:mp4,webm,mov|max:51200', // 50MB
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048' // 2MB por imagen
    ]);

    // ✅ Actualizar datos básicos
    $section->title = $request->title;
    $section->content = $request->content;
    $section->is_active = $request->has('is_active');

    // ✅ PROCESAR MEDIA PARA SECCIÓN HERO
    if ($section->name === 'hero') {
        $mediaType = $request->input('media_type', 'images');

        if ($mediaType === 'video') {
            // MANEJAR VIDEO
            if ($request->hasFile('hero_video')) {
                // Eliminar video anterior si existe
                $currentVideos = $section->getVideosArray();
                if (!empty($currentVideos)) {
                    foreach ($currentVideos as $oldVideo) {
                        \Storage::disk('public')->delete($oldVideo);
                    }
                }

                // Guardar nuevo video
                $videoPath = $request->file('hero_video')->store('sections/videos', 'public');
                $section->setVideosArray([$videoPath]);

                // Limpiar imágenes si había (porque ahora usa video)
                $currentImages = $section->getImagesArray();
                if (!empty($currentImages)) {
                    foreach ($currentImages as $oldImage) {
                        \Storage::disk('public')->delete($oldImage);
                    }
                    $section->setImagesArray([]);
                }
            }
        } else {
            // MANEJAR IMÁGENES
            if ($request->hasFile('images')) {
                // Eliminar video si existía (porque ahora usa imágenes)
                $currentVideos = $section->getVideosArray();
                if (!empty($currentVideos)) {
                    foreach ($currentVideos as $oldVideo) {
                        \Storage::disk('public')->delete($oldVideo);
                    }
                    $section->setVideosArray([]);
                }

                // Agregar nuevas imágenes a las existentes
                $currentImages = $section->getImagesArray();
                
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('sections/images', 'public');
                    $currentImages[] = $imagePath;
                }
                
                $section->setImagesArray($currentImages);
            }
        }
    }

    // ✅ GUARDAR CAMBIOS
    $section->save();

    return redirect()->route('admin.pages.edit-inicio')
        ->with('success', "Sección '{$section->name}' actualizada correctamente");
}

    // Método para eliminar video de Hero
    public function deleteSectionVideo(Request $request, Page $page, Section $section)
    {
        if ($section->name !== 'hero') {
            return response()->json(['success' => false, 'message' => 'Solo Hero puede tener videos'], 400);
        }

        $videos = $section->getVideosArray();
        
        if (!empty($videos)) {
            // Eliminar archivo físico
            foreach ($videos as $video) {
                \Storage::disk('public')->delete($video);
            }
            
            // Limpiar de la base de datos
            $section->setVideosArray([]);
            $section->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    // Método para eliminar imagen de una sección
    public function deleteSectionImage(Request $request, $pageId, $sectionId)
    {
        $page = Page::findOrFail($pageId);
        $section = Section::findOrFail($sectionId);
        
        // Verificar que la sección pertenece a la página
        if ($section->page_id !== $page->id) {
            return response()->json(['success' => false, 'message' => 'Sección no válida'], 404);
        }

        $imageIndex = $request->input('image_index');
        $images = $section->getImagesArray();

        if (isset($images[$imageIndex])) {
            \Storage::disk('public')->delete($images[$imageIndex]);
            
            unset($images[$imageIndex]);
            $images = array_values($images);
            
            $section->setImagesArray($images);
            $section->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }




    //About
    public function editQuienesSomos()
{
    $page = Page::where('slug', 'quienes-somos')->with(['sections' => function($query) {
        $query->orderBy('order');
    }])->first();
    
    // Si no existe la página, crearla con secciones por defecto
    if (!$page) {
        $page = Page::create([
            'slug' => 'quienes-somos',
            'title' => 'Quiénes Somos',
            'content' => 'Página sobre ElectraHome'
        ]);
        
        // Crear secciones por defecto
        $sectionsData = [
            ['name' => 'hero', 'title' => 'Acerca de ElectraHome', 'content' => 'Tradición en Electrodomésticos de Calidad', 'order' => 1],
            ['name' => 'legacy', 'title' => 'Tradición en Electrodomésticos de Calidad', 'content' => 'En ElectraHome, cada electrodoméstico que ofrecemos representa años de innovación...', 'order' => 2],
            ['name' => 'quality', 'title' => 'Garantía Oficial y Servicio Especializado', 'content' => 'Como distribuidores autorizados de Oster, ofrecemos garantía oficial...', 'order' => 3],
            ['name' => 'passion', 'title' => 'La Pasión Detrás del Servicio', 'content' => 'Nuestro equipo no son solo vendedores; somos entusiastas de la cocina...', 'order' => 4],
            ['name' => 'benefits', 'title' => 'Por Qué Elegir ElectraHome', 'content' => 'Elegir ElectraHome significa elegir productos que duran...', 'order' => 5],
            ['name' => 'cta', 'title' => 'Únete a la Familia ElectraHome', 'content' => 'Te invitamos a ser parte de esta historia...', 'order' => 6]
        ];
        
        foreach ($sectionsData as $sectionData) {
            $page->sections()->create([
                'name' => $sectionData['name'],
                'title' => $sectionData['title'],
                'content' => $sectionData['content'],
                'order' => $sectionData['order'],
                'is_active' => true
            ]);
        }
    }
    
    return view('admin.pages.edit-quienes-somos', compact('page'));
}

public function updateQuienesSomos(Request $request)
{
    $page = Page::where('slug', 'quienes-somos')->firstOrFail();
    return $this->updatePage($request, $page, 'admin.pages.edit-quienes-somos');
}



}