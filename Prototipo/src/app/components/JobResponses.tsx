import { useNavigate, useParams } from 'react-router-dom';

export function JobResponses() {
  const navigate = useNavigate();
  const { id } = useParams();

  const responses = [
    {
      id: 1,
      name: 'Carlos Méndez',
      rating: 4.9,
      reviews: 127,
      price: '$3,500',
      time: '30 min',
      verified: true,
      photo: '👨‍🔧'
    },
    {
      id: 2,
      name: 'Roberto Silva',
      rating: 4.7,
      reviews: 89,
      price: '$4,000',
      time: '1 hora',
      verified: true,
      photo: '👷'
    },
    {
      id: 3,
      name: 'Matías López',
      rating: 4.8,
      reviews: 156,
      price: '$3,200',
      time: '45 min',
      verified: false,
      photo: '🔧'
    },
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-white border-b border-gray-200 px-6 py-4 flex items-center gap-4">
        <button onClick={() => navigate('/')} className="text-gray-600">
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <div className="flex-1">
          <h1 className="text-lg font-semibold text-gray-900">Pérdida de agua en cocina</h1>
          <p className="text-sm text-gray-500">{responses.length} profesionales respondieron</p>
        </div>
      </div>

      {/* Responses List */}
      <div className="p-4 space-y-3">
        {responses.map((response) => (
          <div key={response.id} className="bg-white rounded-2xl p-5 shadow-sm">
            <div className="flex gap-4 mb-4">
              <div className="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center text-2xl flex-shrink-0">
                {response.photo}
              </div>
              <div className="flex-1">
                <div className="flex items-center gap-2">
                  <h3 className="font-semibold text-gray-900">{response.name}</h3>
                  {response.verified && (
                    <svg className="w-5 h-5 text-[#0066FF]" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                    </svg>
                  )}
                </div>
                <div className="flex items-center gap-1 text-sm mt-1">
                  <span className="text-yellow-500">★</span>
                  <span className="font-semibold text-gray-900">{response.rating}</span>
                  <span className="text-gray-500">({response.reviews})</span>
                </div>
              </div>
            </div>

            <div className="flex items-center justify-between mb-4">
              <div>
                <p className="text-2xl font-bold text-gray-900">{response.price}</p>
                <p className="text-sm text-gray-500">Llega en {response.time}</p>
              </div>
            </div>

            <button
              onClick={() => navigate(`/chat/${response.id}`)}
              className="w-full bg-[#0066FF] text-white rounded-xl py-3 font-semibold active:bg-[#0052CC] transition-colors"
            >
              Chatear
            </button>
          </div>
        ))}
      </div>

      <div className="px-6 py-4 text-center text-sm text-gray-500">
        Los profesionales siguen viendo tu solicitud
      </div>
    </div>
  );
}
