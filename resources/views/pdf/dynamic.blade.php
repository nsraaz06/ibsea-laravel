<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: {{ $width }}pt {{ $height }}pt;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            width: {{ $width }}px;
            height: {{ $height }}px;
            overflow: hidden;
            background-color: #ffffff;
        }
        .canvas-container {
            position: relative;
            width: {{ $width }}px;
            height: {{ $height }}px;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: {{ $width }}px;
            height: {{ $height }}px;
            z-index: 0;
        }
        .element {
            position: absolute;
            z-index: 10;
            white-space: pre-wrap;
            line-height: normal;
        }
        .element img {
            display: block;
        }
    </style>
</head>
<body>
    <div class="canvas-container">
        @if($background)
            <img src="{{ $background }}" class="background">
        @endif

        @foreach($elements as $element)
            @php
                $type = $element['type'] ?? '';
                $text = $element['text'] ?? '';
                
                // Helper to replace both @{{tag}} and {{tag}}
                $replace = function($tag, $value, $subject) {
                    $subject = str_replace('@{{'.$tag.'}}', $value, $subject);
                    $subject = str_replace('{{'.$tag.'}}', $value, $subject);
                    return $subject;
                };

                $text = $replace('name', $user->name ?? '', $text);
                $text = $replace('id', $user->id ?? '', $text);
                $text = $replace('date', $date ?? '', $text);
                $text = $replace('serial_id', $serial_id ?? '', $text);
                $text = $replace('certificate_no', $certificateNo ?? $certificate_no ?? '', $text);
                $text = $replace('membership_type', $membership_type ?? '', $text);
                $text = $replace('start_date', $start_date ?? '', $text);
                $text = $replace('end_date', $end_date ?? '', $text);
                $text = $replace('event_name', (isset($event->title) ? $event->title : ($event->name ?? '')), $text);
                $text = $replace('event_venue', $event_venue ?? '', $text);
                $text = $replace('event_time', $event_time ?? '', $text);
                $text = $replace('ticket_type', $ticket_type ?? '', $text);
                $text = $replace('ticket_no', $ticket_no ?? '', $text);
                $text = $replace('ticket_id', $ticket_no ?? '', $text);
                $text = $replace('transaction_id', $transaction_id ?? '', $text);
            @endphp

            @if($type == 'i-text' || $type == 'text' || $type == 'textbox')
                @php
                    $scaleX = $element['scaleX'] ?? 1;
                    $scaleY = $element['scaleY'] ?? 1;
                    $fontSize = ($element['fontSize'] ?? 20) * $scaleY;
                    $textAlign = $element['textAlign'] ?? 'left';
                    $originX = $element['originX'] ?? 'left';
                    $originY = $element['originY'] ?? 'top';
                    
                    $left = $element['left'];
                    $top = $element['top'];
                    $widthHtml = "white-space: nowrap;";

                    if ($originX == 'center') {
                        $hackWidth = 2000;
                        $left = $left - ($hackWidth / 2);
                        $widthHtml = "width: {$hackWidth}px;";
                    } elseif ($originX == 'right') {
                        $hackWidth = 2000;
                        $left = $left - $hackWidth;
                        $widthHtml = "width: {$hackWidth}px;";
                    } else {
                        if ($textAlign == 'center' || $textAlign == 'right') {
                            $hackWidth = ($element['width'] ?? 200) * $scaleX;
                            $widthHtml = "width: {$hackWidth}px;";
                        }
                    }

                    if ($originY == 'center') {
                        $top = $top - ($fontSize / 2);
                    } elseif ($originY == 'bottom') {
                        $top = $top - $fontSize;
                    }
                @endphp
                <div class="element" style="
                    position: absolute;
                    left: {{ $left }}px; 
                    top: {{ $top }}px; 
                    font-size: {{ $fontSize }}px; 
                    color: {{ $element['fill'] }};
                    font-weight: {{ $element['fontWeight'] }};
                    text-align: {{ $originX == 'center' ? 'center' : ($originX == 'right' ? 'right' : $textAlign) }};
                    {{ $widthHtml }}
                ">
                    {!! nl2br(e($text)) !!}
                </div>
            @elseif(in_array($type, ['group', 'image', 'rect']) && ( 
                str_contains($element['name'] ?? '', 'qr_code') || 
                str_contains($element['name'] ?? '', 'QR_CODE') ||
                (isset($element['objects']) && is_array($element['objects']) && count(array_filter($element['objects'], function($o) { return str_contains(strtoupper($o['text'] ?? ''), 'QR CODE'); })) > 0)
            ) )
                @php
                    $scaleX = $element['scaleX'] ?? 1;
                    $scaleY = $element['scaleY'] ?? 1;
                    $width = ($element['width'] ?? 100) * $scaleX;
                    $height = ($element['height'] ?? 100) * $scaleY;
                @endphp
                <div class="element" style="
                    left: {{ $element['left'] }}px; 
                    top: {{ $element['top'] }}px;
                    width: {{ $width }}px;
                    height: {{ $height }}px;
                ">
                    @if(isset($qrCode) && $qrCode)
                        <img src="{{ $qrCode }}" width="{{ $width }}" height="{{ $height }}">
                    @endif
                </div>
            @elseif(in_array($type, ['group', 'image', 'rect']) && ( 
                str_contains($element['name'] ?? '', 'event_image') || 
                str_contains($element['name'] ?? '', 'EVENT_IMAGE') ||
                (isset($element['objects']) && is_array($element['objects']) && count(array_filter($element['objects'], function($o) { return str_contains(strtoupper($o['text'] ?? ''), 'EVENT_IMAGE'); })) > 0)
            ) )
                @php
                    $scaleX = $element['scaleX'] ?? 1;
                    $scaleY = $element['scaleY'] ?? 1;
                    $width = ($element['width'] ?? 200) * $scaleX;
                    $height = ($element['height'] ?? 120) * $scaleY;
                @endphp
                <div class="element" style="
                    left: {{ $element['left'] }}px; 
                    top: {{ $element['top'] }}px;
                    width: {{ $width }}px;
                    height: {{ $height }}px;
                ">
                    @if(isset($event_image) && $event_image)
                        <img src="{{ $event_image }}" width="{{ $width }}" height="{{ $height }}" style="object-fit: cover;">
                    @endif
                </div>
            @elseif(in_array($type, ['group', 'image', 'rect']) && ( 
                str_contains($element['name'] ?? '', 'profile_image') || 
                str_contains($element['name'] ?? '', 'PROFILE_IMAGE') ||
                (isset($element['objects']) && is_array($element['objects']) && count(array_filter($element['objects'], function($o) { return str_contains(str_replace(' ', '_', strtoupper($o['text'] ?? '')), 'PROFILE_IMAGE'); })) > 0)
            ) )
                @php
                    $scaleX = $element['scaleX'] ?? 1;
                    $scaleY = $element['scaleY'] ?? 1;
                    $size = min(($element['width'] ?? 100) * $scaleX, ($element['height'] ?? 100) * $scaleY);
                    $width = $size;
                    $height = $size;
                @endphp
                <div class="element" style="
                    left: {{ $element['left'] }}px; 
                    top: {{ $element['top'] }}px;
                    width: {{ $width }}px;
                    height: {{ $height }}px;
                    overflow: hidden;
                    border-radius: 50%;
                ">
                    @if(isset($profile_image) && $profile_image)
                        <img src="{{ $profile_image }}" width="{{ $width }}" height="{{ $height }}" style="object-fit: cover; border-radius: 50%;">
                    @else
                        <div style="width: 100%; height: 100%; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">NO PHOTO</div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</body>
</html>
