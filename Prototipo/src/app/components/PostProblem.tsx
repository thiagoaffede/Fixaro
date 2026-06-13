import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

export function PostProblem() {
  const navigate = useNavigate();
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [photos, setPhotos] = useState<string[]>([]);

  const handleSubmit = () => {
    if (title && description) {
      navigate('/responses/3');
    }
  };

  return (
    <div className="min-h-screen bg-white">
      {/* Header */}
      <div className="bg-white border-b border-gray-200 px-6 py-4 flex items-center gap-4">
        <button onClick={() => navigate('/')} className="text-gray-600">
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <h1 className="text-xl font-semibold text-gray-900">Nuevo problema</h1>
      </div>

      <div className="px-6 py-8">
        {/* Title */}
        <div className="mb-6">
          <label className="block text-sm font-medium text-gray-700 mb-2">¿Qué necesitás?</label>
          <input
            type="text"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            placeholder="Ej: Pérdida de agua en cocina"
            className="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-[#0066FF] focus:outline-none text-base"
          />
        </div>

        {/* Description */}
        <div className="mb-6">
          <label className="block text-sm font-medium text-gray-700 mb-2">Contanos más</label>
          <textarea
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            placeholder="Describí el problema en detalle"
            rows={4}
            className="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-[#0066FF] focus:outline-none text-base resize-none"
          />
        </div>

        {/* Photo Upload */}
        <div className="mb-6">
          <label className="block text-sm font-medium text-gray-700 mb-2">Fotos (opcional)</label>
          <button className="w-full border-2 border-dashed border-gray-300 rounded-xl py-8 flex flex-col items-center gap-2 text-gray-500 active:bg-gray-50 transition-colors">
            <svg className="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span className="font-medium">Subir foto</span>
          </button>
        </div>

        {/* Location */}
        <div className="mb-8">
          <label className="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
          <button className="w-full px-4 py-4 border-2 border-gray-200 rounded-xl flex items-center gap-3 text-left active:bg-gray-50 transition-colors">
            <svg className="w-6 h-6 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span className="text-gray-900">Usar mi ubicación actual</span>
          </button>
        </div>

        {/* Submit Button */}
        <button
          onClick={handleSubmit}
          disabled={!title || !description}
          className="w-full bg-[#FF6B35] text-white rounded-2xl py-5 text-lg font-semibold shadow-lg disabled:opacity-40 disabled:cursor-not-allowed active:scale-[0.98] transition-transform"
        >
          Publicar problema
        </button>

        <p className="text-center text-sm text-gray-500 mt-4">
          Profesionales verificados van a ver tu solicitud
        </p>
      </div>
    </div>
  );
}
