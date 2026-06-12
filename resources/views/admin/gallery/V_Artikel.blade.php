@extends('layouts.V_Auth')

@section('title', $gallery->judul . ' - SIMBRO')

@section('header_title', 'Konten Gallery')
@section('header_desc', 'Temukan informasi menarik dari kami')
@section('header_back_url', url()->previous())
@section('header_back_text', 'Kembali ke Gallery')

@section('content')
<div class="flex-1 bg-white flex flex-col">

    <div class="w-full flex-1 grid grid-cols-1 md:grid-cols-2">
        <div class="relative w-full h-[280px] sm:h-[380px] md:h-auto min-h-[400px] md:min-h-screen bg-gray-50 overflow-hidden">
            <img src="{{ Storage::url($gallery->gambar) }}" alt="{{ $gallery->judul }}" class="absolute inset-0 w-full h-full object-cover block">
            <div class="hidden md:block absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-white pointer-events-none"></div>
            <div class="block md:hidden absolute inset-0 bg-gradient-to-t from-white via-white/40 to-transparent pointer-events-none"></div>
        </div>

        <div class="w-full bg-white flex flex-col justify-start px-6 py-8 sm:p-10 md:p-16 lg:p-20 overflow-y-auto">
            <div class="max-w-2xl w-full mx-auto">
                <div class="border-b border-gray-100 pb-6 mb-8">
                    <div class="flex items-center gap-2 text-[#FF7A1D] text-xs md:text-sm font-bold tracking-wider uppercase mb-3">
                        <i class="far fa-calendar-alt text-sm"></i>
                        <span>{{ $gallery->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 leading-tight tracking-tight">
                        {{ $gallery->judul }}
                    </h1>
                    @if($gallery->keterangan)
                        <p class="text-base text-gray-500 font-medium mt-4 border-l-4 border-orange-400 pl-4 italic bg-orange-50/40 py-2 pr-2 rounded-r-xl">
                            {{ $gallery->keterangan }}
                        </p>
                    @endif
                </div>

                <div class="ck-content prose prose-orange max-w-none text-gray-700 leading-relaxed text-sm md:text-base">
                    {!! $gallery->artikel !!}
                </div>

                @if(session('role') == 1)
                    <div class="mt-12 flex justify-end gap-4 border-t border-gray-100 pt-8">
                        <a href="{{ route('admin.gallery.V_Edit', $gallery->gallery_id) }}" class="inline-flex items-center justify-center gap-2.5 px-6 py-2.5 rounded-md border-2 border-[#FF7A1D] text-[#FF7A1D] bg-white hover:bg-orange-50 font-bold transition-all duration-200 min-w-[125px] shadow-sm">
                            <i class="fas fa-edit text-base"></i> Edit
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $gallery->gallery_id) }}" method="POST" id="deleteForm" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" id="deleteBtn" class="inline-flex items-center justify-center gap-2.5 px-6 py-2.5 rounded-md border-2 border-red-500 text-red-500 bg-white hover:bg-red-50 font-bold transition-all duration-200 min-w-[125px] shadow-sm cursor-pointer">
                                <i class="fas fa-trash-alt text-base"></i> Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .ck-content ul, .ck-content ol { list-style: revert !important; padding-left: 2rem !important; margin: 0.75rem 0 !important; }
    .ck-content h1, .ck-content h2, .ck-content h3 { font-size: revert; font-weight: bold; color: #1f2937; margin-top: 1.75rem; margin-bottom: 0.5rem; }
    .ck-content p { margin: 0 0 1.25rem 0; color: #4b5563; line-height: 1.8; }
    .ck-content img { border-radius: 1rem; margin: 1.5rem auto; box-shadow: 0 4px 12px rgba(0,0,0,0.05); max-width: 100%; height: auto; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtn = document.getElementById('deleteBtn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (typeof showConfirm === 'function') {
                    showConfirm('Apakah anda yakin ingin menghapus konten ini?', function() {
                        document.getElementById('deleteForm').submit();
                    });
                } else {
                    if (confirm('Apakah anda yakin ingin menghapus konten ini?')) {
                        document.getElementById('deleteForm').submit();
                    }
                }
            });
        }
    });
</script>
@endsection
