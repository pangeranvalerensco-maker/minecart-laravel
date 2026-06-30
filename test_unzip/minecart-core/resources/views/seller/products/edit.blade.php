@extends('layouts.app')

@section('content')
<main class="main-content" style="background-color: var(--body-bg); padding: 40px 0;">
    <div class="container" style="max-width: 900px;">
        
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
            <a href="{{ route('seller.products.index') }}" style="text-decoration: none; color: var(--text-color); font-size: 1.2rem; background: var(--card-bg); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">&larr;</a>
            <h1 class="page-title" style="margin: 0; font-size: 1.8rem; font-weight: 700;">Edit Produk</h1>
        </div>

        <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Section: Informasi Produk -->
            <div style="background: var(--card-bg); padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid var(--subtle-border-color); margin-bottom: 25px;">
                <h2 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Informasi Produk</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin: 0;">
                        <label for="title_id" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Nama Produk (Indonesia) <span style="color: #e63946;">*</span></label>
                        <input type="text" id="title_id" name="title_id" class="form-control" value="{{ old('title_id', $product->title_id) }}" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px;">
                        @error('title_id') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label for="title_en" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Product Name (English) <span style="color: #e63946;">*</span></label>
                        <input type="text" id="title_en" name="title_en" class="form-control" value="{{ old('title_en', $product->title_en) }}" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px;">
                        @error('title_en') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="category_id" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Kategori <span style="color: #e63946;">*</span></label>
                    <select id="category_id" name="category_id" class="form-control" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 12px auto;">
                        <option value="">Pilih Kategori Produk...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name_id }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" style="margin: 0;">
                        <label for="description_id" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Deskripsi (Indonesia) <span style="color: #e63946;">*</span></label>
                        <textarea id="description_id" name="description_id" class="form-control" rows="5" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px; resize: vertical;">{{ old('description_id', $product->description_id) }}</textarea>
                        @error('description_id') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label for="description_en" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Description (English) <span style="color: #e63946;">*</span></label>
                        <textarea id="description_en" name="description_en" class="form-control" rows="5" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px; resize: vertical;">{{ old('description_en', $product->description_en) }}</textarea>
                        @error('description_en') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-top: 20px;">
                    <div class="form-group" style="margin: 0;">
                        <label for="condition" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Kondisi <span style="color: #e63946;">*</span></label>
                        <select id="condition" name="condition" class="form-control" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 12px auto;">
                            <option value="baru" {{ old('condition', $product->condition) == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="bekas" {{ old('condition', $product->condition) == 'bekas' ? 'selected' : '' }}>Bekas</option>
                        </select>
                        @error('condition') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label for="weight" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Berat (Gram) <span style="color: #e63946;">*</span></label>
                        <input type="number" id="weight" name="weight" class="form-control" min="1" value="{{ old('weight', $product->weight) }}" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px;">
                        @error('weight') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label for="sku" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">SKU (Opsional)</label>
                        <input type="text" id="sku" name="sku" class="form-control" placeholder="Kode Barang" value="{{ old('sku', $product->sku) }}" style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px;">
                        @error('sku') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Media -->
            <div style="background: var(--card-bg); padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid var(--subtle-border-color); margin-bottom: 25px;">
                <h2 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Media Produk</h2>
                
                <div class="form-group" style="margin: 0;">
                    <label for="image" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; display: block;">Foto Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                    <div style="border: 2px dashed #cbd5e1; border-radius: 12px; padding: 40px; text-align: center; background: var(--body-bg); cursor: pointer; transition: background 0.2s; position: relative; min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center; background-image: url('{{ $product->image_url }}'); background-size: contain; background-repeat: no-repeat; background-position: center;" id="image-dropzone" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        <div style="font-size: 2rem; color: var(--text-color); margin-bottom: 10px; display: none;" id="image-icon">📸</div>
                        <p style="margin: 0; font-size: 0.95rem; font-weight: 500; color: var(--heading-color); display: block; background-color: rgba(255,255,255,0.8); padding: 5px 10px; border-radius: 5px;" id="image-text">Klik untuk mengubah foto</p>
                        <p style="margin: 5px 0 0 0; font-size: 0.8rem; color: var(--text-color); display: none;" id="image-subtext">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                        <input type="file" id="image" name="images[]" multiple accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this)">
                    </div>
                    @error('images') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Section: Harga & Stok -->
            <div style="background: var(--card-bg); padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid var(--subtle-border-color); margin-bottom: 30px;">
                <h2 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Harga & Inventaris</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" style="margin: 0; position: relative;">
                        <label for="price" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Harga Satuan <span style="color: #e63946;">*</span></label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; font-weight: 600;">Rp</span>
                            <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px 12px 12px 45px; width: 100%;">
                        </div>
                        @error('price') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-group" style="margin: 0;">
                        <label for="stock" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Stok Tersedia <span style="color: #e63946;">*</span></label>
                        <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required style="border-radius: 8px; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); padding: 12px;">
                        @error('stock') <div style="color: #e63946; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 15px; padding-bottom: 50px;">
                <a href="{{ route('seller.products.index') }}" class="btn" style="padding: 14px 25px; background: transparent; border: 1px solid var(--subtle-border-color); background: var(--body-bg); color: var(--text-color); border-radius: 8px; font-weight: 600; color: var(--text-color); text-decoration: none;">Batal</a>
                <button type="submit" class="cta-button" style="padding: 14px 35px; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 12px rgba(61, 206, 196, 0.3);">Perbarui Produk</button>
            </div>
        </form>

    </div>
</main>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-dropzone').style.backgroundImage = 'url(' + e.target.result + ')';
            document.getElementById('image-dropzone').style.backgroundSize = 'contain';
            document.getElementById('image-dropzone').style.backgroundRepeat = 'no-repeat';
            document.getElementById('image-dropzone').style.backgroundPosition = 'center';
            document.getElementById('image-dropzone').style.border = 'none';
            document.getElementById('image-icon').style.display = 'none';
            
            var count = input.files.length;
            var text = count > 1 ? count + ' foto dipilih' : '';
            document.getElementById('image-text').innerText = text;
            document.getElementById('image-text').style.display = count > 1 ? 'block' : 'none';
            document.getElementById('image-text').style.backgroundColor = 'rgba(255,255,255,0.8)';
            document.getElementById('image-text').style.padding = '5px 10px';
            document.getElementById('image-text').style.borderRadius = '5px';
            
            document.getElementById('image-subtext').style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
