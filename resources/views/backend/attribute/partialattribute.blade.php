<?php $dash = isset($dash) ? $dash : '-- '; ?>

@if (isset($subcategory_data) && is_iterable($subcategory_data))
    @foreach ($subcategory_data as $item)
        <!-- Ensure current category is excluded and parent category is selected -->
        <option value="{{ $item->id }}" 
            {{ old('category_id', $attribute->category_id ?? '') == $item->id ? 'selected' : '' }}>
            {{ $dash }}{{ $item->name }}
        </option>
        
        @if (isset($item->subcategories) && count($item->subcategories))
            @include('backend.attribute.partialattribute', [
                'subcategory_data' => $item->subcategories,
                'dash' => $dash . '-- ',
                'attribute' => $attribute ?? null  // Pass the current category for preselection
            ])
        @endif
    @endforeach
@endif
