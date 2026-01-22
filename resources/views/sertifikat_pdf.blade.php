<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
        size: 1920px 1080px;
        margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 1920px;
            height: 1080px;
        }

        .page {
            position: relative;
            width: 1920px;
            height: 1080px;
            overflow: hidden;
        }

        .bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        }


        .name-box {
        position: absolute;

        /* POSISI & UKURAN KOTAK */
        left: {{ $template->box_x }}%;
        top: {{ $template->box_y }}%;
        width: {{ $template->box_width }}%;
        height: {{ $template->box_height }}%;

        /* CENTER TEKS */
        display: flex;
        align-items: center;
        justify-content: center;

        /* TEXT BEHAVIOR */
        text-align: center;
        white-space: normal;
        word-break: break-word;
        overflow: hidden;

        /* FONT */
        font-family: {{ $template->font_family }};
        font-size: {{ $template->font_size }}px;
        color: {{ $template->font_color }};
        font-weight: {{ $template->font_weight }};
        font-style: {{ $template->font_style }};
        letter-spacing: {{ $template->letter_spacing ?? 0 }}px;
        }

        .no {
            position: absolute;
            left: {{ $template->pos_x }}%;
            top: {{ $template->pos_y + 6 }}%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
            font-size: 14px;
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

</div>


<div class="name-box">
    {{ $nama }}
</div>

</body>
</html>
