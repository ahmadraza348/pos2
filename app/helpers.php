<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// function used to check admin Auth
if (!function_exists('check_admin_auth')) {
    function check_admin_auth($routeName)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view($routeName);
    }
    if (!function_exists('buildCategorySlug')) {
        function buildCategorySlug($category)
        {
            $slug = $category->slug;
            $parent = $category->parent; // Assuming 'parent' relationship exists in your Category model
            while ($parent) {
                $slug = $parent->slug . '/' . $slug;
                $parent = $parent->parent;
            }
            return $slug;
        }
    }
}

if (!function_exists('activeStatus')) {
    function activeStatus($query)
    {
        return $query->where('status', 1);
    }
}
