<article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900">
    <footer class="flex justify-between items-center mb-2">
        <div class="flex items-center">
            <p class="text-sm text-gray-900 dark:text-white font-semibold">
                {{ $comment->user->name ?? 'Anonymous' }}
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400 ml-4">
                <time datetime="{{ $comment->created_at }}">{{ $comment->created_at->format('M d, Y') }}</time>
            </p>
        </div>

        <!-- Delete Button -->
        @auth
            @if (
                auth()->user()->role_id === 1 || 
                (auth()->user()->role_id === 2 && $comment->event->created_by === auth()->id()) ||
                auth()->id() === $comment->user_id
            )
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 text-sm hover:underline">
                        Delete
                    </button>
                </form>
            @endif
        @endauth
    </footer>
    <p class="text-gray-500 dark:text-gray-400">
        {{ $comment->content }}
    </p>
</article>
