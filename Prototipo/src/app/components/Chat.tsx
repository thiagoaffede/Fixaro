import { useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

export function Chat() {
  const navigate = useNavigate();
  const { id } = useParams();
  const [message, setMessage] = useState('');

  const messages = [
    { id: 1, from: 'professional', text: 'Hola! Vi tu solicitud. Puedo ir hoy a la tarde.', time: '14:23' },
    { id: 2, from: 'user', text: 'Perfecto! ¿A qué hora podés?', time: '14:25' },
    { id: 3, from: 'professional', text: 'Puedo estar a las 16hs. Te confirmo cuando salgo.', time: '14:26' },
  ];

  return (
    <div className="h-screen flex flex-col bg-white">
      {/* Header */}
      <div className="bg-white border-b border-gray-200 px-6 py-4 flex items-center gap-4">
        <button onClick={() => navigate(-1)} className="text-gray-600">
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <div className="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-xl">
          👨‍🔧
        </div>
        <div className="flex-1">
          <h1 className="font-semibold text-gray-900">Carlos Méndez</h1>
          <p className="text-sm text-gray-500">En línea</p>
        </div>
        <button className="text-[#0066FF] text-sm font-medium">
          WhatsApp
        </button>
      </div>

      {/* Messages */}
      <div className="flex-1 overflow-y-auto px-6 py-4 space-y-4">
        {messages.map((msg) => (
          <div
            key={msg.id}
            className={`flex ${msg.from === 'user' ? 'justify-end' : 'justify-start'}`}
          >
            <div
              className={`max-w-[75%] rounded-2xl px-4 py-3 ${
                msg.from === 'user'
                  ? 'bg-[#0066FF] text-white'
                  : 'bg-gray-100 text-gray-900'
              }`}
            >
              <p className="text-base">{msg.text}</p>
              <p className={`text-xs mt-1 ${msg.from === 'user' ? 'text-blue-100' : 'text-gray-500'}`}>
                {msg.time}
              </p>
            </div>
          </div>
        ))}
      </div>

      {/* Input */}
      <div className="border-t border-gray-200 px-4 py-3 bg-white">
        <div className="flex gap-2">
          <input
            type="text"
            value={message}
            onChange={(e) => setMessage(e.target.value)}
            placeholder="Escribí un mensaje..."
            className="flex-1 px-4 py-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-[#0066FF]"
          />
          <button
            disabled={!message}
            className="w-12 h-12 bg-[#0066FF] text-white rounded-full flex items-center justify-center disabled:opacity-40 disabled:cursor-not-allowed active:scale-95 transition-transform"
          >
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  );
}
