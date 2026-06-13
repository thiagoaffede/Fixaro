<x-guest-layout>
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">¿Cómo deseas registrarte?</h2>
        
        <div class="space-y-4">
            <a href="{{ route('register.client') }}" class="block w-full py-3 px-4 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 font-semibold transition">
                Soy Cliente (Necesito un servicio)
            </a>
            
            <a href="{{ route('register.professional') }}" class="block w-full py-3 px-4 bg-white border border-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-50 font-semibold transition">
                Soy Profesional (Quiero ofrecer mis servicios)
            </a>
        </div>
        
        <p class="mt-6 text-sm text-gray-600">
            ¿Ya tienes una cuenta? 
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Ingresa aquí</a>
        </p>
    </div>
</x-guest-layout>
