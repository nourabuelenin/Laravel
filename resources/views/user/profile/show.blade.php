<x-layout.app title="profile">
    <div class="container">
        <h1>Profile</h1>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
        <p><strong>Address:</strong> {{ $user->address ?? 'Not provided' }}</p>
        <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
    </div>
</x-layout.app>