<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Calificar Trabajo') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">¡Trabajo Terminado! 🎉</h3>
                    <p class="text-gray-600">Por favor, tomate un momento para calificar al profesional. Esto ayuda a otros usuarios en el futuro.</p>
                </div>

                <form wire:submit.prevent="submit" class="space-y-6 max-w-lg mx-auto">
                    
                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 text-center">Calificación (Estrellas)</label>
                        <div class="flex items-center justify-center space-x-4">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transition-colors">
                                    <svg class="w-10 h-10 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        @error('rating') <span class="text-xs text-red-600 block text-center mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Comment -->
                    <div>
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Comentario / Reseña (Opcional)</label>
                        <div class="mt-2">
                            <textarea wire:model="comment" id="comment" rows="4" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="¿Cómo fue la experiencia? ¿Recomendarías a este profesional?"></textarea>
                            @error('comment') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Enviar Calificación
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
