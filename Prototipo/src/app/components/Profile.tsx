import { useNavigate } from 'react-router-dom';

export function Profile() {
  const navigate = useNavigate();

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-white border-b border-gray-200 px-6 py-4 flex items-center gap-4">
        <button onClick={() => navigate('/')} className="text-gray-600">
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <h1 className="text-xl font-semibold text-gray-900">Perfil</h1>
      </div>

      {/* Profile Info */}
      <div className="bg-white px-6 py-8 mb-6">
        <div className="flex items-center gap-4 mb-6">
          <div className="w-20 h-20 bg-[#0066FF] rounded-full flex items-center justify-center text-white text-3xl">
            M
          </div>
          <div className="flex-1">
            <h2 className="text-xl font-semibold text-gray-900">María González</h2>
            <p className="text-gray-500">maria@email.com</p>
          </div>
        </div>

        {/* Verification Badge */}
        <div className="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
          <svg className="w-6 h-6 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fillRule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
          </svg>
          <div>
            <p className="font-semibold text-green-900">Identidad verificada</p>
            <p className="text-sm text-green-700">DNI confirmado</p>
          </div>
        </div>
      </div>

      {/* Stats */}
      <div className="bg-white px-6 py-6 mb-6">
        <h3 className="font-semibold text-gray-900 mb-4">Tu actividad</h3>
        <div className="grid grid-cols-3 gap-4">
          <div className="text-center">
            <p className="text-2xl font-bold text-gray-900">12</p>
            <p className="text-sm text-gray-500">Solicitudes</p>
          </div>
          <div className="text-center">
            <p className="text-2xl font-bold text-gray-900">4.8</p>
            <p className="text-sm text-gray-500">Rating</p>
          </div>
          <div className="text-center">
            <p className="text-2xl font-bold text-gray-900">8</p>
            <p className="text-sm text-gray-500">Reseñas</p>
          </div>
        </div>
      </div>

      {/* Reviews */}
      <div className="bg-white px-6 py-6 mb-6">
        <h3 className="font-semibold text-gray-900 mb-4">Reseñas recientes</h3>
        <div className="space-y-4">
          <div className="border-b border-gray-100 pb-4">
            <div className="flex items-center gap-2 mb-2">
              <span className="text-yellow-500">★★★★★</span>
              <span className="text-sm text-gray-500">Carlos Méndez</span>
            </div>
            <p className="text-gray-600 text-sm">"Excelente cliente, muy clara la descripción del problema"</p>
          </div>
          <div className="border-b border-gray-100 pb-4">
            <div className="flex items-center gap-2 mb-2">
              <span className="text-yellow-500">★★★★★</span>
              <span className="text-sm text-gray-500">Roberto Silva</span>
            </div>
            <p className="text-gray-600 text-sm">"Pago puntual y amable"</p>
          </div>
        </div>
      </div>

      {/* Settings */}
      <div className="px-6 pb-8 space-y-3">
        <button className="w-full bg-white rounded-xl py-4 px-5 text-left flex items-center justify-between active:bg-gray-50 transition-colors">
          <span className="text-gray-900 font-medium">Configuración</span>
          <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
          </svg>
        </button>
        <button className="w-full bg-white rounded-xl py-4 px-5 text-left flex items-center justify-between active:bg-gray-50 transition-colors">
          <span className="text-gray-900 font-medium">Ayuda y soporte</span>
          <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
          </svg>
        </button>
        <button className="w-full bg-white rounded-xl py-4 px-5 text-red-600 font-medium active:bg-gray-50 transition-colors">
          Cerrar sesión
        </button>
      </div>
    </div>
  );
}
