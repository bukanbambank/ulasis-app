@props(['questions', 'preview' => false])

<form @if(!$preview) action="#" method="POST" @endif class="space-y-6">
    @csrf

    @foreach ($questions as $index => $question)
        <div class="space-y-2">
            <label class="block text-lg font-medium text-gray-900">
                {{ $question['text'] }}
                @if($question['required']) <span class="text-red-500">*</span> @endif
            </label>

            @if ($question['type'] === 'rating')
                <div class="flex items-center space-x-2 justify-center py-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button"
                            class="w-10 h-10 rounded-full border border-gray-300 hover:bg-yellow-100 focus:bg-yellow-200 transition text-xl">
                            ★
                        </button>
                    @endfor
                </div>

            @elseif ($question['type'] === 'boolean')
                <div class="flex space-x-4">
                    <button type="button"
                        class="flex-1 py-3 border border-gray-300 rounded-lg hover:bg-green-50 focus:ring-2 focus:ring-green-500">
                        Yes
                    </button>
                    <button type="button"
                        class="flex-1 py-3 border border-gray-300 rounded-lg hover:bg-red-50 focus:ring-2 focus:ring-red-500">
                        No
                    </button>
                </div>

            @elseif ($question['type'] === 'text')
                <textarea class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    rows="3" placeholder="Tulis masukan Anda..."></textarea>
            @endif
        </div>
    @endforeach

    <div class="pt-4">
        <button type="button" @if($preview) disabled @endif
            class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
            {{ $preview ? 'Submit Disabled (Preview)' : 'Kirim Masukan' }}
        </button>
    </div>
</form>