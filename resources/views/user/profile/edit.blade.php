<x-layout.app>
    <div class="container">
        <h1>Edit Profile</h1>
        <form action="{{ route('user.profile.update', $user) }}" method="POST">
            @csrf
            @method('PUT') <!-- Simulate a PUT request -->
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name', 'ayhaga')}}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ route('user.profile', $user) }}" class="btn btn-secondary">Cancel</a>        
        </form>
    </div>
</x-layout.app>