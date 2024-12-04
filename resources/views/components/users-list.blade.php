<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="p-6">
        <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">User Management</h1>
    </div>
    <div class=" flex justify-center bg-gray-800">
        <table style="border-collapse: collapse;" class="w-full bg-white rounded-lg shadow dark:border dark:bg-gray-700 dark:border-gray-700">
            <thead>
                <tr class="border-0  text-white">
                    <th class="text-left p-3 px-5">Name</th>
                    <th class="text-left p-3 px-5">Email</th>
                    <th class="text-left p-3 px-5">Role</th>
                    <th class="text-left p-3 px-5">Actions</th>
                </tr>
            </thead>
            <tbody id="user-table-body border-0">
                @foreach (\App\Models\User::with('role')->get() as $user)
                    <tr class=" dark:border-gray-6000 dark:bg-gray-700' bg-gray-800' " data-id="{{ $user->id }}">
                        <td class="p-3 px-5">
                            <input type="text" value="{{ $user->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" data-field="name">
                        </td>
                        <td class="p-3 px-5">
                            <input type="email" value="{{ $user->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" data-field="email">
                        </td>
                        <td class="p-3 px-5">
                            <select class="bg-gray-50 border border-gray-00 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" data-field="role_id">
                                @foreach (\App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-3 px-5 flex ">
                            <button onclick="updateUser({{ $user->id }})" class="mr-3 text-sm bg-blue-700 hover:bg-blue-800 text-white py-1 px-4 rounded-lg">
                                Save
                            </button>
                            <button onclick="deleteUser({{ $user->id }})" class="text-sm bg-red-600 hover:bg-red-700 text-white py-1 px-4 rounded-lg">
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
                document.querySelector(`[data-id="${userId}"]`).remove(); // Remove the user row
            } else {
                alert('Failed to delete user.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
