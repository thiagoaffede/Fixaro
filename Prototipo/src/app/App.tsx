import { BrowserRouter, Routes, Route, useNavigate } from 'react-router-dom';
import { Home } from './components/Home';
import { PostProblem } from './components/PostProblem';
import { JobResponses } from './components/JobResponses';
import { Chat } from './components/Chat';
import { ProfessionalView } from './components/ProfessionalView';
import { Profile } from './components/Profile';

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/post-problem" element={<PostProblem />} />
        <Route path="/responses/:id" element={<JobResponses />} />
        <Route path="/chat/:id" element={<Chat />} />
        <Route path="/professional" element={<ProfessionalView />} />
        <Route path="/profile" element={<Profile />} />
      </Routes>
    </BrowserRouter>
  );
}
