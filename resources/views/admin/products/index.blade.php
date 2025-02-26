<x-admin-layout.app title="Manage Products">
    <div class="container mt-4">
        <h2>🛍️ Products Management</h2>
        <a href="" class="btn btn-primary mb-3">➕ Add New Product</a>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Categories</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- loop in the products array to display it --}}
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            {{-- check if product image is exist --}}
                        </td>
                        <td>
                            {{-- display related product categories --}}
                        </td>
                        <td>
                            <a href="" class="btn btn-sm btn-warning">✏
                                Edit</a>
                            <form action="" method="POST"
                                  class="d-inline delete-form">
                                @csrf
                                {{-- DELETE method is here --}}
                                <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
                            </form>
                        </td>
                    </tr>
                    {{-- end of foreach --}}
                    </tbody>
                </table>
            </div>
            <div class="mx-2"></div>
        </div>
    </div>
</x-admin-layout.app>