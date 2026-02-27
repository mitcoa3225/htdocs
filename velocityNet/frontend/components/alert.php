<?php
// alert file.


function renderAlert($type = 'info', $message = '', $dismissible = true) {
    $alertClasses = [
        'success' => 'alert alert-success',
        'error' => 'alert alert-error', 
        'warning' => 'alert alert-warning',
        'info' => 'alert alert-info'
    ];
    
    $icons = [
        'success' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
        'error' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'warning' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L12.732 3.5c-.77-.833-1.964-.833-2.732 0L1.732 17.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
        'info' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
    ];
    
    $alertClass = $alertClasses[$type] ?? $alertClasses['info'];
    $icon = $icons[$type] ?? $icons['info'];
    
    if (empty($message)) return '';
    
    echo '<div class="' . $alertClass . '">';
    echo $icon;
    echo '<div>';
    echo '<p class="text-sm">' . htmlspecialchars($message) . '</p>';
    echo '</div>';
    if ($dismissible) {
        echo '<button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 hover:bg-gray-700" onclick="this.parentElement.remove()">';
        echo '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        echo '</button>';
    }
    echo '</div>';
}
?>