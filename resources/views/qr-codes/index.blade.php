<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My QR Codes') }}
            </h2>
            <a href="{{ route('qr-codes.create') }}"
                class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                + Generate New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    QR Preview</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Label</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Questionnaire</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($qrCodes as $qr)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-16 w-16">
                                            @if(Storage::disk('public')->exists($qr->image_path))
                                                <img src="{{ Storage::url($qr->image_path) }}" alt="QR"
                                                    class="h-full w-full object-contain">
                                            @else
                                                <span class="text-xs text-red-500">File missing</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $qr->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $qr->unique_code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $qr->questionnaire->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        {{-- Use direct static link for reliable download, bypassing Controller issues --}}
                                        <a href="{{ route('qr-codes.download', $qr->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-3 py-1 rounded hover:bg-indigo-50">
                                            Download
                                        </a>

                                        <form action="{{ route('qr-codes.destroy', $qr->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $qrCodes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>