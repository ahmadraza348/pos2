<?php $dash = $dash ?? '-- '; ?>

@if (isset($subcategory_data) && is_iterable($subcategory_data))
    @foreach ($subcategory_data as $item)
        <option value="{{ $item->id }}" 
            {{ old('category_id') == $item->id ? 'selected' : '' }}>
            {{ $dash }}{{ $item->name }}
        </option>
        
        <!-- Recursive subcategory inclusion -->
        @if ($item->subcategories->isNotEmpty())
            @include('backend.category.partialcategory', [
                'subcategory_data' => $item->subcategories,
                'dash' => $dash . '-- ',
            ])
        @endif
    @endforeach
@endif
