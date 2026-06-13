import { useNavigate } from 'react-router-dom';

export function Home() {
  const navigate = useNavigate();

  const recentRequests = [
    { id: 1, title: 'Pérdida de agua en cocina', status: '3 respuestas', time: 'Hace 2 horas' },
    { id: 2, title: 'Corte de luz en living', status: '5 respuestas', time: 'Hace 5 horas' },
  ];

  return (
    <div className="min-h-screen bg-white">
      {/* Header */}
      <div className="bg-[#0066FF] text-white px-6 pt-12 pb-8">
        <div className="flex justify-between items-center mb-8">
          <h1 className="text-3xl font-bold">Fixaro</h1>
          <button onClick={() => navigate('/profile')} className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
            <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fillRule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clipRule="evenodd" />
            </svg>
          </button>
        </div>
        <p className="text-lg opacity-90">¿Qué necesitás arreglar hoy?</p>
      </div>

      {/* Main CTA */}
      <div className="px-6 -mt-6">
        <button
          onClick={() => navigate('/post-problem')}
          className="w-full bg-[#FF6B35] text-white rounded-2xl py-6 text-xl font-semibold shadow-lg active:scale-[0.98] transition-transform"
        >
          Publicar un problema
        </button>
      </div>

      {/* Recent Requests */}
      {recentRequests.length > 0 && (
        <div className="px-6 mt-10">
          <h2 className="text-lg font-semibold mb-4 text-gray-900">Tus solicitudes</h2>
          <div className="space-y-3">
            {recentRequests.map((request) => (
              <button
                key={request.id}
                onClick={() => navigate(`/responses/${request.id}`)}
                className="w-full bg-gray-50 rounded-xl p-5 text-left active:bg-gray-100 transition-colors"
              >
                <h3 className="font-semibold text-gray-900 mb-1">{request.title}</h3>
                <div className="flex items-center justify-between text-sm">
                  <span className="text-[#0066FF] font-medium">{request.status}</span>
                  <span className="text-gray-500">{request.time}</span>
                </div>
              </button>
            ))}
          </div>
        </div>
      )}

      {/* How it works */}
      <div className="px-6 mt-12 pb-8">
        <h2 className="text-lg font-semibold mb-6 text-gray-900">Cómo funciona</h2>
        <div className="space-y-6">
          <div className="flex gap-4">
            <div className="w-10 h-10 bg-[#0066FF] rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">1</div>
            <div>
              <h3 className="font-semibold text-gray-900">Describí tu problema</h3>
              <p className="text-gray-600 text-sm mt-1">En minutos, sin buscar</p>
            </div>
          </div>
          <div className="flex gap-4">
            <div className="w-10 h-10 bg-[#0066FF] rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">2</div>
            <div>
              <h3 className="font-semibold text-gray-900">Recibí propuestas</h3>
              <p className="text-gray-600 text-sm mt-1">Profesionales vienen a vos</p>
            </div>
          </div>
          <div className="flex gap-4">
            <div className="w-10 h-10 bg-[#0066FF] rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">3</div>
            <div>
              <h3 className="font-semibold text-gray-900">Elegí y listo</h3>
              <p className="text-gray-600 text-sm mt-1">El mejor precio y reputación</p>
            </div>
          </div>
        </div>
      </div>

      {/* Professional Switch */}
      <div className="px-6 pb-8">
        <button
          onClick={() => navigate('/professional')}
          className="w-full border-2 border-gray-200 rounded-xl py-4 text-gray-600 font-medium active:bg-gray-50 transition-colors"
        >
          ¿Sos profesional? Entrá acá
        </button>
      </div>
    </div>
  );
}
