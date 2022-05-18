<a {{ $attributes->merge(['class' => 
'block px-4 py-2 text-m leading-5 
text-white
text-decoration-none
isBold
']) }}>
{{ $slot }}</a>

{{-- <a {{ $attributes->merge(['class' => 
    'block px-4 py-2 text-sm leading-5 
    text-gray-700 
    hover:bg-gray-100 
    focus:outline-none 
    focus:bg-gray-100 
    transition duration-150 
    background-image: linear-gradient(to left, #36d7b7, #2ecc71);
    ease-in-out']) }}>
    {{ $slot }}</a> --}}
