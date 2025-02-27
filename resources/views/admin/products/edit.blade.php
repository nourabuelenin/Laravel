<x-admin-layout.app title="Edit Product">
    <div class="container mt-4">
        <h2>✏ Edit Product</h2>
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $product->name) }}" 
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" id="price" 
                               value="{{ old('price', $product->price) }}" 
                               class="form-control @error('price') is-invalid @enderror">
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" name="stock" id="stock" 
                               value="{{ old('stock', $product->stock) }}" 
                               class="form-control @error('stock') is-invalid @enderror">
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" name="image" id="image" 
                               class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                 class="img-fluid mt-2" style="max-height: 150px;">
                        @endif
                    </div>

                    <!-- Categories -->
                    <div class="mb-3">
                        <label for="categories" class="form-label">Categories</label>
                        <select name="categories[]" id="categories" class="form-control" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout.app>