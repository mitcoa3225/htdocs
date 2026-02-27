<?php
// badge file.


function renderBadge($type = 'info', $text = '') {
    $badgeClasses = [
        'success' => 'badge badge-success',
        'warning' => 'badge badge-warning',
        'error' => 'badge badge-error',
        'info' => 'badge badge-info'
    ];
    
    $class = $badgeClasses[$type] ?? $badgeClasses['info'];
    
    echo '<span class="' . $class . '">';
    echo htmlspecialchars($text);
    echo '</span>';
}

//run render status badge
function renderStatusBadge($count, $label = '') {
    $type = 'success';
    if ($count > 0 && $count <= 3) {
        $type = 'warning';
    } else if ($count > 3) {
        $type = 'error';
    }
    
    $text = $count . ($label ? ' ' . $label : '');
    renderBadge($type, $text);
}

//run render priority badge
function renderPriorityBadge($priority) {
    $priorities = [
        'low' => ['type' => 'success', 'text' => 'Low Priority'],
        'medium' => ['type' => 'warning', 'text' => 'Medium Priority'],
        'high' => ['type' => 'error', 'text' => 'High Priority'],
        'urgent' => ['type' => 'error', 'text' => '🚨 Urgent']
    ];
    
    $config = $priorities[strtolower($priority)] ?? $priorities['low'];
    renderBadge($config['type'], $config['text']);
}
?>