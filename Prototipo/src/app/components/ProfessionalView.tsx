import { useNavigate } from 'react-router-dom';

export function ProfessionalView() {
  const navigate = useNavigate();

  const availableJobs = [
    {
      id: 1,
      title: 'Pérdida de agua en cocina',
      location: 'Palermo',
      distance: '2.3 km',
      time: 'Hace 15 min',
      description: 'Canilla de la cocina perdiendo agua, necesito solución urgente'
    },
    {
      id: 2,
      title: 'Instalación de aire acondicionado',
      location: 'Recoleta',
      distance: '3.8 km',
      time: 'Hace 1 hora',
      description: 'Necesito instalar un split en el living'
    },
    {
      id: 3,
      title: 'Problema eléctrico',
      location: 'Belgrano',
      distance: '5.1 km',
      time: 'Hace 2 horas',
      description: 'Se cortó la luz en dos habitaciones'
    },
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-[#0066FF] text-white px-6 pt-12 pb-8">
        <div className="flex justify-between items-center mb-6">
          <div>
            <h1 className="text-3xl font-bold">Vista Pro</h1>
            <p className="text-blue-100 mt-1">Carlos Méndez</p>
          </div>
          <button onClick={() => navigate('/')} className="text-sm bg-white/20 px-4 py-2 rounded-full">
            Cliente
          </button>
        </div>
        <div className="bg-white/10 rounded-xl p-4 flex justify-around">
          <div className="text-center">
            <p className="text-2xl font-bold">4.9</p>
            <p className="text-sm text-blue-100">Rating</p>
          </div>
          <div className="text-center">
            <p className="text-2xl font-bold">127</p>
            <p className="text-sm text-blue-100">Trabajos</p>
          </div>
          <div className="text-center">
            <p className="text-2xl font-bold">98%</p>
            <p className="text-sm text-blue-100">Aceptación</p>
          </div>
        </div>
      </div>

      {/* Jobs List */}
      <div className="px-4 py-6">
        <h2 className="text-lg font-semibold mb-4 px-2 text-gray-900">Trabajos disponibles cerca tuyo</h2>
        <div className="space-y-3">
          {availableJobs.map((job) => (
            <div key={job.id} className="bg-white rounded-2xl p-5 shadow-sm">
              <div className="flex items-start justify-between mb-3">
                <div className="flex-1">
                  <h3 className="font-semibold text-gray-900 mb-1">{job.title}</h3>
                  <div className="flex items-center gap-3 text-sm text-gray-500">
                    <span className="flex items-center gap-1">
                      <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clipRule="evenodd" />
                      </svg>
                      {job.location}
                    </span>
                    <span>•</span>
                    <span>{job.distance}</span>
                  </div>
                </div>
                <span className="text-xs text-gray-400 whitespace-nowrap ml-2">{job.time}</span>
              </div>

              <p className="text-gray-600 text-sm mb-4">{job.description}</p>

              <button className="w-full bg-[#FF6B35] text-white rounded-xl py-3 font-semibold active:bg-[#E55A28] transition-colors">
                Ofertar trabajo
              </button>
            </div>
          ))}
        </div>
      </div>

      {/* Bottom Info */}
      <div className="px-6 pb-8 text-center text-sm text-gray-500">
        Actualizamos trabajos en tiempo real
      </div>
    </div>
  );
}
