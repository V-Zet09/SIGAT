<div class="flex justify-center">
  <div class="max-w-[1150px] bg-white rounded-lg overflow-hidden shadow-md">
    <img class="w-full h-auto" src="{{ asset($imagen) }}" alt="{{ $titulo }}" loading="lazy" decoding="async">
    <div class="p-4 text-center">
      <p class="text-gray-600 text-sm mb-1">{{ $fecha }}</p>
      <p class="text-[#00713D] text-lg font-semibold mb-3">{{ $titulo }}</p>
      <a href="{{ $url }}" class="inline-block bg-[#00713D] hover:bg-[#005c30] text-white font-semibold px-5 py-2 rounded-full transition">
        MÁS DETALLES
      </a>
    </div>
  </div>
</div>
