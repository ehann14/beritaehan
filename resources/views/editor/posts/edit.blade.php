<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Edit Berita') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update artikel berita Anda.</p>
            </div>
            <a href="{{ route('editor.posts.index') }}"
               class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                <span class="mr-2">←</span> Batal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm sm:rounded-3xl overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('editor.posts.update', $post) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Judul Berita <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   required
                                   value="{{ old('title', $post->title) }}"
                                   placeholder="Masukkan judul berita yang menarik..."
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20" />
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Isi Berita -->
                        <div>
                            <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Isi Berita <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="8" 
                                      required
                                      placeholder="Tulis isi berita lengkap di sini..."
                                      class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <!-- Penulis -->
                            <div>
                                <label for="author" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Penulis
                                </label>
                                <input type="text" 
                                       name="author" 
                                       id="author"
                                       value="{{ old('author', $post->author ?? auth()->user()->name) }}"
                                       placeholder="Nama penulis"
                                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20" />
                                @error('author')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Kategori
                                </label>
                                <select name="category_id" 
                                        id="category_id"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-500/20">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tag -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Tag
                            </label>
                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($tags as $tag)
                                        <label class="inline-flex items-center cursor-pointer group">
                                            <input type="checkbox" 
                                                   name="tags[]" 
                                                   value="{{ $tag->id }}"
                                                   {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition" />
                                            <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900 dark:text-gray-300 dark:group-hover:text-white transition">
                                                {{ $tag->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('tags')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Thumbnail dengan Alpine.js -->
                        <div x-data="{ 
                            preview: null, 
                            fileName: '', 
                            fileSize: '',
                            hasFile: false,
                            
                            handleFile(input) {
                                if (input.files && input.files[0]) {
                                    const file = input.files[0];
                                    
                                    if (file.size > 10 * 1024 * 1024) {
                                        alert('Ukuran file terlalu besar! Maksimal 10MB.');
                                        input.value = '';
                                        return;
                                    }
                                    
                                    if (!file.type.startsWith('image/')) {
                                        alert('File harus berupa gambar!');
                                        input.value = '';
                                        return;
                                    }
                                    
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.preview = e.target.result;
                                        this.fileName = file.name;
                                        this.fileSize = this.formatSize(file.size);
                                        this.hasFile = true;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            },
                            
                            removeFile() {
                                this.preview = null;
                                this.fileName = '';
                                this.fileSize = '';
                                this.hasFile = false;
                                document.getElementById('thumbnail').value = '';
                            },
                            
                            formatSize(bytes) {
                                if (bytes === 0) return '0 Bytes';
                                const k = 1024;
                                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                                const i = Math.floor(Math.log(bytes) / Math.log(k));
                                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                            }
                        }">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Thumbnail
                            </label>
                            
                            @if($post->thumbnail)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Current thumbnail" class="h-32 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600" />
                                    <p class="text-xs text-gray-500 mt-2">Thumbnail saat ini. Upload gambar baru untuk mengganti.</p>
                                </div>
                            @endif
                            
                            <!-- Preview Gambar Baru -->
                            <div x-show="hasFile" x-transition class="mb-4">
                                <div class="relative inline-block">
                                    <img :src="preview" alt="Preview" class="h-48 rounded-lg object-cover border-2 border-blue-500 shadow-lg">
                                    <button type="button" @click="removeFile()" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" x-text="'File baru: ' + fileName + ' (' + fileSize + ')'"></p>
                            </div>

                            <!-- Upload Area -->
                            <div x-show="!hasFile" x-transition class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-gray-700 dark:bg-gray-800 transition hover:border-blue-400 dark:hover:border-blue-500 cursor-pointer"
                                 @click="$refs.fileInput.click()">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="mt-4">
                                    <p class="text-sm font-semibold text-blue-600 hover:text-blue-500">{{ $post->thumbnail ? 'Ganti thumbnail' : 'Upload thumbnail' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">PNG, JPG, GIF, WEBP up to 10MB</p>
                                </div>
                                <input x-ref="fileInput"
                                       id="thumbnail" 
                                       name="thumbnail" 
                                       type="file" 
                                       accept="image/*"
                                       class="hidden"
                                       @change="handleFile($event.target)" />
                            </div>
                            
                            @error('thumbnail')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Publikasi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Status Publikasi
                            </label>
                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" 
                                               name="status" 
                                               value="draft" 
                                               {{ old('status', $post->status) === 'draft' ? 'checked' : '' }}
                                               class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500 transition" />
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                            <span class="font-semibold">Draft</span>
                                            <span class="block text-xs text-gray-500 dark:text-gray-400">Belum dipublikasikan</span>
                                        </span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" 
                                               name="status" 
                                               value="published" 
                                               {{ old('status', $post->status) === 'published' ? 'checked' : '' }}
                                               class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500 transition" />
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                            <span class="font-semibold">Publish</span>
                                            <span class="block text-xs text-gray-500 dark:text-gray-400">Publikasikan berita</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-gray-700">
                            <a href="{{ route('editor.posts.index') }}"
                               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-gray-700 dark:bg-gray-800 dark:text-slate-200 dark:hover:bg-gray-700">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Berita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>