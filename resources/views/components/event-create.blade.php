<div class="min-h-screen flex justify-center bg-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-900 bg-no-repeat bg-cover relative items-center">
    <div class="absolute bg-gray-900 opacity-60 inset-0 z-0"></div>
    <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
        <div class="grid gap-8 grid-cols-1">
            <div class="flex flex-col">
                <div class="flex flex-col sm:flex-row items-center">
                    <h2 class="font-semibold text-lg mr-auto">Event Info</h2>
                </div>
                <div class="mt-5">
                    @if (session('success'))
                        <div class="bg-green-100 text-green-900 p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-900 p-4 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form">
                            <!-- Image Upload -->
                            <div class="md:space-y-2 mb-3">
                                <label class="text-xs font-semibold text-gray-600 py-2">Event Picture</label>
                                <div class="flex items-center py-6">
                                    <div class="w-12 h-12 mr-4 flex-none rounded-xl border overflow-hidden">
                                        <img id="preview-image" class="w-12 h-12 mr-4 object-cover" src="https://via.placeholder.com/150" alt="Avatar Upload">
                                    </div>
                                    <label class="cursor-pointer">
                                        <span class="focus:outline-none text-white text-sm py-2 px-4 rounded-full bg-green-400 hover:bg-green-500 hover:shadow-lg">Browse</span>
                                        <input type="file" name="image" class="hidden" onchange="previewImage(event)">
                                    </label>
                                </div>
                            </div>

                            <script>
                                function previewImage(event) {
                                    const reader = new FileReader();
                                    reader.onload = function () {
                                        const output = document.getElementById('preview-image');
                                        output.src = reader.result;
                                    };
                                    reader.readAsDataURL(event.target.files[0]);
                                }
                            </script>

                            <!-- Event Title and Date -->
                            <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                                <div class="mb-3 space-y-2 w-full text-xs">
                                    <label class="font-semibold text-gray-600 py-2">Event Title</label>
                                    <input name="title" value="{{ old('title') }}" placeholder="Event Title" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required type="text">
                                </div>
                                <div class="mb-3 space-y-2 w-full text-xs">
                                    <label class="font-semibold text-gray-600 py-2">Event Date</label>
                                    <input name="event_date" value="{{ old('event_date') }}" type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required>
                                </div>
                            </div>

                            <!-- Address and Location -->
                            <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-semibold text-gray-600 py-2">Event Address</label>
                                    <input name="address" value="{{ old('address') }}" placeholder="Address" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" type="text">
                                </div>
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-semibold text-gray-600 py-2">Location</label>
                                    <select name="location" class="block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required>
                                        <option value="Glasgow" {{ old('location') == 'Glasgow' ? 'selected' : '' }}>Glasgow</option>
                                        <option value="Edinburgh" {{ old('location') == 'Edinburgh' ? 'selected' : '' }}>Edinburgh</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="flex-auto w-full mb-1 text-xs space-y-2">
                                <label class="font-semibold text-gray-600 py-2">Description</label>
                                <textarea name="description" class="w-full min-h-[100px] max-h-[300px] h-28 appearance-none block bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg py-4 px-4" placeholder="Give more information about the event" required>{{ old('description') }}</textarea>
                            </div>

                            <!-- Start Time and End Time -->
                            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-semibold text-gray-600 py-2">Start Time</label>
                                    <input name="start_time" value="{{ old('start_time') }}" type="time" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required>
                                </div>
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-semibold text-gray-600 py-2">End Time</label>
                                    <input name="end_time" value="{{ old('end_time') }}" type="time" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-5 text-right md:space-x-3">
                                <button type="submit" class="bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
