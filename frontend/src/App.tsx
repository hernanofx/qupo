import React, { useState } from 'react'
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom'
import Register from './pages/Register'
import Login from './pages/Login'
import MerchantDashboard from './pages/MerchantDashboard'

type Auth = { token?: string; user?: { name?: string } } | null

export default function App(){
  const [auth, setAuth] = useState<Auth>(() => {
    try{
      const t = localStorage.getItem('qupo_token')
      if(!t) return null
      const u = localStorage.getItem('qupo_user')
      return { token: t, user: u ? JSON.parse(u) : undefined }
    }catch(e){ return null }
  })

  return (
    <BrowserRouter>
      <div className="app-shell">
        <header className="header">
          <div className="brand">QUPO</div>
          <nav>
            <Link to="/">Home</Link> &nbsp;|&nbsp; <Link to="/register">Register</Link> &nbsp;|&nbsp; <Link to="/login">Login</Link>
          </nav>
        </header>
        <main className="container">
          <div className="card">
            <Routes>
              <Route path="/" element={<div><h1>QUPO</h1><p className="muted">Mobile-first PWA en desarrollo — minimal, fast, reliable.</p></div>} />
              <Route path="/register" element={<Register />} />
              <Route path="/login" element={<Login onLogin={(res)=>{ setAuth(res); if(res?.token) localStorage.setItem('qupo_token', res.token) }} />} />
              <Route path="/dashboard" element={<MerchantDashboard user={auth?.user} token={auth?.token || undefined} />} />
            </Routes>
          </div>
        </main>
        <footer className="footer">Made with ❤️ Minimal · Secure · PWA-ready</footer>
      </div>
    </BrowserRouter>
  )
}
