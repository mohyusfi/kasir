<x-app-layout>
    <div class="text-center vw-100 h-[100vh] bg-slate-200 pt-10">
        <h1 class="text-9xl font-bold text-gray-950">{{ $statusCode }}</h1>
        <p class="text-xl text-gray-600 mt-4"><span class="font-bold">Message: </span>{{ $message }}</p>
        <a href="/" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</x-app-layout>