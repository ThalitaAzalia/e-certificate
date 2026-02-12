<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        .page {
            position: relative;
            width: 100%;
            height: 100%;
        }


        .bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .name-content {
            display: table-cell;
            vertical-align: middle;
        }


        .name-box {
            position: absolute;

            left: {{ $template->box_x }}%;
            top: {{ $template->box_y }}%;
            width: {{ $template->box_width }}%;
            height: {{ $template->box_height }}%;

            display: table;
            text-align: {{ $template->text_align ?? 'center' }};

            text-align: {{ $template->text_align ?? 'center' }};
            white-space: normal;
            word-break: break-word;
            overflow: hidden;

            font-family: {{ $template->font_family }};
            font-size: {{ $template->font_size }}px;
            color: {{ $template->font_color }};
            font-weight: {{ $template->font_weight }};
            font-style: {{ $template->font_style }};
            letter-spacing: {{ $template->letter_spacing ?? 0 }}px;
        }

        
    </style>
</head>
<body>

<div class="page">

    {{-- BACKGROUND TEMPLATE --}}
    <img
       src="data:{{ $imageMime }};base64,{{ $imageBase64 }}"
       class="bg"
    >

    {{-- NAMA PESERTA --}}
    <div class="name-box">
        <div class="name-content">   
        {{ $nama }}
        </div>
    </div>

</div>
</body>
</html>
