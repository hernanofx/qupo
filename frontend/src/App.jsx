import React, { useState } from 'react'
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom'
import Register from './pages/Register'
import Login from './pages/Login'
import MerchantDashboard from './pages/MerchantDashboard'

export default function App(){
  const [auth, setAuth] = useState(null)

  return (
    <BrowserRouter>
      <div className="container">
        <nav>
          <Link to="/">Home</Link> | <Link to="/register">Register</Link> | <Link to="/login">Login</Link>
        </nav>
      </div>
      <Routes>
        <Route path="/" element={<div className="container"><h1>QUPO - PWA</h1><p>Mobile-first PWA en desarrollo.</p></div>} />
        <Route path="/register" element={<Register />} />
        <Route path="/login" element={<Login onLogin={(res)=>setAuth(res)} />} />
        <Route path="/dashboard" element={<MerchantDashboard user={auth?.user} token={auth?.token} />} />
      </Routes>
    </BrowserRouter>
  )
}
