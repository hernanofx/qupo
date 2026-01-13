import React, { useState } from 'react'
import api from '../api'

interface LoginProps { onLogin?: (res: { token?: string; user?: { name?: string } }) => void }
interface LoginForm { email: string; password: string }

import { useNavigate } from 'react-router-dom'

export default function Login({onLogin}: LoginProps){
  const navigate = useNavigate()
  const [form, setForm] = useState<LoginForm>({email:'', password:''})
  const [msg, setMsg] = useState<string | null>(null)

  const submit = async (e: React.FormEvent) =>{
    e.preventDefault()
    const res = await api.login(form)
    setMsg(JSON.stringify(res))
    if(res.token){
      localStorage.setItem('qupo_token', res.token)
      localStorage.setItem('qupo_user', JSON.stringify(res.user || {}))
      onLogin?.(res)
      navigate('/dashboard')
    }
  }

  return (
    <div className="container">
      <h2>Login</h2>
      <form onSubmit={submit}>
        <input placeholder="Email" value={form.email} onChange={e=>setForm({...form,email:e.currentTarget.value})} />
        <input placeholder="Password" type="password" value={form.password} onChange={e=>setForm({...form,password:e.currentTarget.value})} />
        <button type="submit">Login</button>
      </form>
      {msg && <pre>{msg}</pre>}
    </div>
  )
}
