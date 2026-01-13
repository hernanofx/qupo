import React, { useState } from 'react'
import api from '../api'

export default function Login({onLogin}){
  const [form, setForm] = useState({email:'', password:''})
  const [msg, setMsg] = useState(null)

  const submit = async (e)=>{
    e.preventDefault()
    const res = await api.login(form)
    setMsg(JSON.stringify(res))
    if(res.token){
      onLogin(res)
    }
  }

  return (
    <div className="container">
      <h2>Login</h2>
      <form onSubmit={submit}>
        <input placeholder="Email" value={form.email} onChange={e=>setForm({...form,email:e.target.value})} />
        <input placeholder="Password" type="password" value={form.password} onChange={e=>setForm({...form,password:e.target.value})} />
        <button type="submit">Login</button>
      </form>
      {msg && <pre>{msg}</pre>}
    </div>
  )
}
