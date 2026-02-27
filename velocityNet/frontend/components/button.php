<?php
// button file.


function renderButton($type = 'primary', $text = 'Button', $buttonType = 'button', $attributes = []) {
    $buttonClasses = [
        'primary' => 'btn btn-primary',
        'secondary' => 'btn btn-secondary',
        'outline' => 'btn btn-outline',
        'success' => 'btn btn-primary',
        'danger' => 'btn btn-secondary'
    ];
    
    $class = $buttonClasses[$type] ?? $buttonClasses['primary'];
    
    // Handle size variations
    if (isset($attributes['size'])) {
        $class .= ' btn-' . $attributes['size'];
        unset($attributes['size']);
    }
    
    $attributeString = '';
    foreach ($attributes as $key => $value) {
        $attributeString .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
    }
    
    echo '<button type="' . $buttonType . '" class="' . $class . '"' . $attributeString . '>';
    echo htmlspecialchars($text);
    echo '</button>';
}

//run render link
function renderLink($text, $href, $type = 'primary', $attributes = []) {
    $buttonClasses = [
        'primary' => 'btn btn-primary',
        'secondary' => 'btn btn-secondary', 
        'outline' => 'btn btn-outline'
    ];
    
    $class = $buttonClasses[$type] ?? $buttonClasses['primary'];
    
    if (isset($attributes['size'])) {
        $class .= ' btn-' . $attributes['size'];
        unset($attributes['size']);
    }
    
    $attributeString = '';
    foreach ($attributes as $key => $value) {
        $attributeString .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
    }
    
    echo '<a href="' . htmlspecialchars($href) . '" class="' . $class . '"' . $attributeString . '>';
    echo htmlspecialchars($text);
    echo '</a>';
}
?>