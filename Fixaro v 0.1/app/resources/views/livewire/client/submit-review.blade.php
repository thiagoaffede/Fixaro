<div class="mx-auto max-w-lg px-4 pt-5 sm:px-6 sm:pt-10">
    <div class="card p-6 text-center sm:p-8">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-ok-50 text-ok-600">
            <x-icon name="check-circle" class="h-8 w-8" />
        </span>
        <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-ink-900">¡Trabajo terminado!</h1>
        <p class="mt-1 text-sm text-ink-500">Tu calificación ayuda a que otros vecinos elijan bien.</p>

        <form wire:submit.prevent="submit" class="mt-6 space-y-5 text-left">
            <div>
                <div class="flex items-center justify-center gap-1.5">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})" class="rounded-lg p-0.5 focus:outline-none focus-visible:ring-4 focus-visible:ring-amber-100" aria-label="{{ $i }} estrellas">
                            <svg class="h-11 w-11 {{ $rating >= $i ? 'text-amber-400' : 'text-ink-200' }} transition hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </button>
                    @endfor
                </div>
                @error('rating') <span class="mt-1 block text-center text-xs font-medium text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="comment" class="label">Comentario <span class="font-normal text-ink-400">(opcional)</span></label>
                <textarea wire:model="comment" id="comment" rows="4" class="field resize-none" placeholder="¿Llegó a tiempo? ¿Lo recomendarías?"></textarea>
                @error('comment') <span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-full">Enviar calificación</button>
        </form>
    </div>
</div>
