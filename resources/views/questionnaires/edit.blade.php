<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Questionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="questionnaireEditor(@js($questionnaire->questions))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status') === 'questionnaire-updated')
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">Questionnaire updated successfully.</span>
                </div>
            @endif

            <form action="{{ route('questionnaires.update', $questionnaire->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Questionnaire
                                Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $questionnaire->title) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <template x-for="(question, index) in questions" :key="question.id">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                            <div class="absolute top-4 right-4 flex space-x-2">
                                <button type="button" @click="moveUp(index)" class="text-gray-400 hover:text-gray-600"
                                    :disabled="index === 0">↑</button>
                                <button type="button" @click="moveDown(index)" class="text-gray-400 hover:text-gray-600"
                                    :disabled="index === questions.length - 1">↓</button>
                                <button type="button" @click="removeQuestion(index)"
                                    class="text-red-400 hover:text-red-600">×</button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Question Text</label>
                                    <input type="text" :name="`questions[${index}][text]`" x-model="question.text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type</label>
                                    <select :name="`questions[${index}][type]`" x-model="question.type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="rating">Rating (1-5)</option>
                                        <option value="text">Text Input</option>
                                        <option value="boolean">Yes/No</option>
                                    </select>
                                </div>

                                <div class="flex items-center mt-6">
                                    <input type="checkbox" :name="`questions[${index}][required]`"
                                        x-model="question.required" value="1"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label class="ml-2 block text-sm text-gray-900">Required</label>
                                </div>

                                <!-- Hidden Fields for Structure -->
                                <input type="hidden" :name="`questions[${index}][id]`" x-model="question.id">
                                <input type="hidden" :name="`questions[${index}][options]`"
                                    :value="JSON.stringify(question.options)">
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <button type="button" @click="addQuestion()"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition">
                        + Add Question
                    </button>

                    <button type="submit"
                        class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function questionnaireEditor(initialQuestions) {
            return {
                questions: initialQuestions,
                addQuestion() {
                    const id = 'q' + Math.random().toString(36).substr(2, 9);
                    this.questions.push({
                        id: id,
                        text: 'New Question',
                        type: 'rating',
                        options: [],
                        required: true
                    });
                },
                removeQuestion(index) {
                    if (this.questions.length > 1) {
                        this.questions.splice(index, 1);
                    } else {
                        alert('You must have at least one question.');
                    }
                },
                moveUp(index) {
                    if (index > 0) {
                        const temp = this.questions[index];
                        this.questions[index] = this.questions[index - 1];
                        this.questions[index - 1] = temp;
                    }
                },
                moveDown(index) {
                    if (index < this.questions.length - 1) {
                        const temp = this.questions[index];
                        this.questions[index] = this.questions[index + 1];
                        this.questions[index + 1] = temp;
                    }
                }
            }
        }
    </script>
</x-app-layout>