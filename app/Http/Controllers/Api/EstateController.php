<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstateResource;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class EstateController extends Controller
{
    public function index(Request $request)
    {
        $query = Estate::query();
        
        // Apply filters
        $this->applyFilters($query, $request);
        
        // Apply sorting
        $this->applySorting($query, $request);
        
        // Get results with pagination
        $perPage = $request->get('per_page', 15);
        $estates = $query->with(['country', 'media', 'properties'])->paginate($perPage);
        
        return EstateResource::collection($estates);
    }
    
    public function show($id)
    {
        $estate = Estate::with(['country', 'media', 'properties'])->findOrFail($id);
        return new EstateResource($estate);
    }
    
    private function applyFilters(Builder $query, Request $request)
    {
        // Price filters
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('is_vip')) {
            $query->where('is_vip', $request->is_vip);
        }
        
        if ($request->has('price_range')) {
            $priceRange = explode('-', $request->price_range);
            if (count($priceRange) == 2) {
                $query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
            }
        }
        
        // Area filters
        if ($request->has('min_area')) {
            $query->where('area', '>=', $request->min_area);
        }
        
        if ($request->has('max_area')) {
            $query->where('area', '<=', $request->max_area);
        }
        
        if ($request->has('area_range')) {
            $areaRange = explode('-', $request->area_range);
            if (count($areaRange) == 2) {
                $query->whereBetween('area', [$areaRange[0], $areaRange[1]]);
            }
        }
        
        // Rooms filter
        if ($request->has('rooms')) {
            if (is_array($request->rooms)) {
                $query->whereIn('rooms', $request->rooms);
            } else {
                $query->where('rooms', $request->rooms);
            }
        }
        
        if ($request->has('min_rooms')) {
            $query->where('rooms', '>=', $request->min_rooms);
        }
        
        if ($request->has('max_rooms')) {
            $query->where('rooms', '<=', $request->max_rooms);
        }
        
        // Floor filters
        if ($request->has('floor')) {
            if (is_array($request->floor)) {
                $query->whereIn('floor', $request->floor);
            } else {
                $query->where('floor', $request->floor);
            }
        }

         if ($request->has('room')) {
            if (is_array($request->room)) {
                $query->whereIn('rooms', $request->room);
            } else {
                $query->where('rooms', $request->room);
            }
        }
        
        if ($request->has('min_floor')) {
            $query->where('floor', '>=', $request->min_floor);
        }
        
        if ($request->has('max_floor')) {
            $query->where('floor', '<=', $request->max_floor);
        }
        
        // Total floors filter
        if ($request->has('total_floors')) {
            if (is_array($request->total_floors)) {
                $query->whereIn('total_floors', $request->total_floors);
            } else {
                $query->where('total_floors', $request->total_floors);
            }
        }
        
        if ($request->has('min_total_floors')) {
            $query->where('total_floors', '>=', $request->min_total_floors);
        }
        
        if ($request->has('max_total_floors')) {
            $query->where('total_floors', '<=', $request->max_total_floors);
        }
        
        // // Status type filter
        // if ($request->has('status_type')) {
        //     if (is_array($request->status_type)) {
        //         $query->whereIn('status_type', $request->status_type);
        //     } else {
        //         $query->where('status_type', $request->status_type);
        //     }
        // }
        
        // Estate type filter
        if ($request->has('type_estate_id')) {
            if (is_array($request->type_estate_id)) {
                $query->whereIn('type_estate_id', $request->type_estate_id);
            } else {
                $query->where('type_estate_id', $request->type_estate_id);
            }
        }
        if ($request->has('type_purchase_id')) {
            if (is_array($request->type_purchase_id)) {
                $query->whereIn('type_purchase_id', $request->type_purchase_id);
            } else {
                $query->where('type_purchase_id', $request->type_purchase_id);
            }
        }
        
        // Status filter (active/inactive)
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Country filter
        if ($request->has('country_id')) {
            if (is_array($request->country_id)) {
                $query->whereIn('country_id', $request->country_id);
            } else {
                $query->where('country_id', $request->country_id);
            }
        }
        
        // City filter
        if ($request->has('city_id')) {
            if (is_array($request->city_id)) {
                $query->whereIn('city_id', $request->city_id);
            } else {
                $query->where('city_id', $request->city_id);
            }
        }
        
        // New/Used filter
        if ($request->has('is_new')) {
            $query->where('is_new', $request->is_new);
        }
        
        // Mortgage filter
        if ($request->has('mortgage')) {
            $query->where('mortgage', $request->mortgage);
        }
        
        // Has extract filter
        if ($request->has('has_extract')) {
            $query->where('has_extract', $request->has_extract);
        }
        
        // Contact filters
        if ($request->has('has_call_number')) {
            if ($request->has_call_number) {
                $query->whereNotNull('call_number');
            } else {
                $query->whereNull('call_number');
            }
        }
        
        if ($request->has('has_whatsapp')) {
            if ($request->has_whatsapp) {
                $query->whereNotNull('whatsapp_number');
            } else {
                $query->whereNull('whatsapp_number');
            }
        }
        
        // Has image filter
        if ($request->has('has_image')) {
            if ($request->has_image) {
                $query->whereNotNull('image');
            } else {
                $query->whereNull('image');
            }
        }
        
        // Has map filter
        if ($request->has('has_map')) {
            if ($request->has_map) {
                $query->whereNotNull('map');
            } else {
                $query->whereNull('map');
            }
        }
        
        // Date filters
        if ($request->has('created_from')) {
            $query->where('created_at', '>=', $request->created_from);
        }
        
        if ($request->has('created_to')) {
            $query->where('created_at', '<=', $request->created_to);
        }
        
        if ($request->has('updated_from')) {
            $query->where('updated_at', '>=', $request->updated_from);
        }
        
        if ($request->has('updated_to')) {
            $query->where('updated_at', '<=', $request->updated_to);
        }

        
         if (request()->has('foreign') && request('foreign')!='') {
            $query->whereHas('country',function($qq){
                $qq->where('foreign', request('foreign'));
            });
        }
        
        // Search in translated attributes (title, description, address, etc.)
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereTranslationLike('title', "%{$searchTerm}%")
                //   ->orWhereTranslationLike('description', "%{$searchTerm}%")
                  ->orWhereTranslationLike('address', "%{$searchTerm}%")
                  ->orWhereTranslationLike('location', "%{$searchTerm}%")
                  ->orWhereTranslationLike('district', "%{$searchTerm}%");
            });
        }
        
        // Properties filter (if estate has specific properties)
        if ($request->has('properties')) {
            $properties = is_array($request->properties) ? $request->properties : [$request->properties];
            $query->whereHas('properties', function($q) use ($properties) {
                $q->whereIn('properties.id', $properties);
            });
        }
        
        // Featured/Premium filter (if you have such field)
        if ($request->has('featured')) {
            // Assuming you might add this field later
            $query->where('featured', $request->featured);
        }
        
        // Only with images
        if ($request->has('with_images_only') && $request->with_images_only) {
            $query->whereHas('media');
        }
        
        // Exclude specific IDs
        if ($request->has('exclude_ids')) {
            $excludeIds = is_array($request->exclude_ids) ? $request->exclude_ids : explode(',', $request->exclude_ids);
            $query->whereNotIn('id', $excludeIds);
        }
        
        // Include only specific IDs
        if ($request->has('include_ids')) {
            $includeIds = is_array($request->include_ids) ? $request->include_ids : explode(',', $request->include_ids);
            $query->whereIn('id', $includeIds);
        }



     

    }
    
    private function applySorting(Builder $query, Request $request)
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }
        
        // Define allowed sort fields
        $allowedSortFields = [
            'id', 'price', 'area', 'rooms', 'floor', 'total_floors',
            'status', 'created_at', 'updated_at', 'is_new'
        ];
        
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }
        
        // Additional sorting options
        if ($request->has('sort_by_price_per_area')) {
            $query->orderByRaw('(price / NULLIF(area, 0)) ' . $sortOrder);
        }
    }
   
}