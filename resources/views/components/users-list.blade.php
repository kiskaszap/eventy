<div class="text-gray-900 bg-gray-200">
    <div class="p-4 flex">
        <h1 class="text-3xl">Users</h1>
    </div>
    <div class="px-3 py-4 flex justify-center">
        <table class="w-full text-md bg-white shadow-md rounded mb-4">
            <thead>
                <tr class="border-b">
                    <th class="text-left p-3 px-5">Name</th>
                    <th class="text-left p-3 px-5">Email</th>
                    <th class="text-left p-3 px-5">Role</th>
                    <th class="text-left p-3 px-5">Actions</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                @foreach (\App\Models\User::with('role')->get() as $user)
                    <tr class="border-b hover:bg-orange-100 {{ $loop->index % 2 === 0 ? 'bg-gray-100' : '' }}" data-id="{{ $user->id }}">
                        <td class="p-3 px-5">
                            <input type="text" value="{{ $user->name }}" class="bg-transparent border-b-2 border-gray-300 w-full" data-field="name">
                        </td>
                        <td class="p-3 px-5">
                            <input type="email" value="{{ $user->email }}" class="bg-transparent border-b-2 border-gray-300 w-full" data-field="email">
                        </td>
                        <td class="p-3 px-5">
                            <select class="bg-transparent border-b-2 border-gray-300 w-full" data-field="role_id">
                                @foreach (\App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-3 px-5 flex justify-end">
                            <button onclick="updateUser({{ $user->id }})" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">
                                Save
                            </button>
                            <button onclick="deleteUser({{ $user->id }})" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
   function updateUser(userId) {
    const row = document.querySelector(`[data-id="${userId}"]`);
    const formData = new FormData();

    row.querySelectorAll('[data-field]').forEach(field => {
        formData.append(field.dataset.field, field.value);
    });

    fetch(`/update-user/${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => alert(data.message))
    .catch(error => console.error('Error:', error));
}

    

function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) return;

    fetch(`/delete-user/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message); // Success message
            // Remove the user row from the table
            document.querySelector(`[data-id="${userId}"]`).remove();
        } else {
            alert('Failed to delete user.');
        }
    })
    .catch(error => console.error('Error:', error));
}

</script>
