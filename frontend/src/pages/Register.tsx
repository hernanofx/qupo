import React, { useState } from 'react'
import api from '../api'

interface RegisterForm { name: string; email: string; password: string; merchant_name: string }

export default function Register(){
  const [form, setForm] = useState<RegisterForm>({name:'', email:'', password:'', merchant_name:''})
  const [msg, setMsg] = useState<string | null>(null)

  const submit = async (e: React.FormEvent) =>{
    e.preventDefault()
    const res = await api.registerMerchant(form)
    setMsg(JSON.stringify(res))
  }

  return (
    <div className="container">
      <h2>Register Merchant</h2>
      <form onSubmit={submit}>
        <input placeholder="Your name" value={form.name} onChange={e=>setForm({...form,name:e.currentTarget.value})} />
        <input placeholder="Email" value={form.email} onChange={e=>setForm({...form,email:e.currentTarget.value})} />
        <input placeholder="Password" type="password" value={form.password} onChange={e=>setForm({...form,password:e.currentTarget.value})} />
        <input placeholder="Merchant name" value={form.merchant_name} onChange={e=>setForm({...form,merchant_name:e.currentTarget.value})} />
        <button type="submit">Register</button>
      </form>
      {msg && <pre>{msg}</pre>}
    </div>
  )
}
