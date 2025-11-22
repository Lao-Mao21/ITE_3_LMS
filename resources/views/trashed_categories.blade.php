<x-layouts.app :title="__('Recycle Bin - Categories ')">
    <script src="https://kit.fontawesome.com/9d6a4b8185.js" crossorigin="anonymous"></script>

    {{-- content categories --}}
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Trashed Categories</h1>
            <div class="space-x-2">
                <a href="{{ route('categories.index') }}" 
                class="bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
                    Back to Active Categories
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead>
                        <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Description</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y border-r border-l border-n border-neutral-200 dark:border-neutral-700 divide-neutral-200 dark:divide-neutral-700">
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $category->description }}</td>
                                <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">
                                    {{ $category->updated_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-sm space-x-2">
                                    <form action="{{ route('categories.restore', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-700 transition-colors"
                                                onclick="return confirm('Restore this category?')">
                                            Restore
                                        </button>
                                    </form>
                                    <span class="text-neutral-400">|</span>
                                    <form action="{{ route('categories.force-delete', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-700 transition-colors"
                                                onclick="return confirm('Permanently delete this category? This action cannot be undone.')">
                                            Delete Permanently
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>