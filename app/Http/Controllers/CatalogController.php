<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\CatalogImage;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Display all catalogs
    public function showAll()
    {
        $catalogs = Catalog::with('images')->get();
        return view('Admin.adminCatalog', compact('catalogs'));
    }

    // Display a specific catalog with its images
    public function show($id)
    {
        $catalog = Catalog::with('images')->findOrFail($id);
        $images = $catalog->images; // Retrieve images associated with the catalog

        return view('Admin.carousel', compact('catalog', 'images'));
    }

    // Store new catalog
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $catalog = Catalog::create([
            'title' => $request->title,
            'date' => $request->date,
        ]);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $filename = time() . '_catalog_' . $catalog->id . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $catalog->image_path = 'images/' . $filename;
            $catalog->save();
        }

        return redirect()->route('catalogs.index')->with('success', 'Catalog created successfully!');
    }


    // Store new image for a catalog


    // Show form to add images to carousel
    public function showCarouselForm($id)
    {
        $catalog = Catalog::with('images')->findOrFail($id);
        return view('catalogs.carousel_form', compact('catalog'));
    }

    // Store images in carousel
    public function storeCarouselImages(Request $request, $catalogId)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $catalog = Catalog::findOrFail($catalogId);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_catalog_c' . $catalogId . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('public/carousel_images/' . $catalogId, $filename);

                // Log the catalogId and path
                \Log::info('Catalog ID: ' . $catalogId);
                \Log::info('Image Path: ' . 'carousel_images/' . $catalogId . '/' . $filename);

                // Save each image path to the database
                CatalogImage::create([
                    'catalog_id' => $catalogId, // Ensure the catalog_id field is set
                    'image_path' => 'carousel_images/' . $catalogId . '/' . $filename,
                ]);
            }

            return redirect()->route('catalogs.show', $catalogId)
                ->with('success', 'Images added to carousel successfully!');
        }

        return back()->withErrors(['images' => 'Failed to upload images.']);
    }



    public function deleteImage($id)
    {
        // Logic to delete the image
        $image = CatalogImage::findOrFail($id);
        $imagePath = $image->image_path;

        if (\Storage::exists($imagePath)) {
            \Storage::delete($imagePath);
        }

        $image->delete();

        // Redirect or return response as needed
        return back()->with('success', 'Image deleted successfully.');
    }
    public function deleteImageCatalog($id)
    {
        // Find the image by ID
        $image = Catalog::findOrFail($id);
        $imagePath = $image->image_path;

        // Check if the image exists and delete it
        if (\Storage::exists($imagePath)) {
            \Storage::delete($imagePath);
        }

        // Delete the image record from the database
        $image->delete();

        // Redirect or return response as needed
        return back()->with('success', 'Image deleted successfully.');
    }

}
