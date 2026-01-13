import React, { useState } from 'react'
import api from '../api'

export default function Register(){
  const [form, setForm] = useState({name:'', email:'', password:'', merchant_name:''})
  const [msg, setMsg] = useState(null)

  const submit = async (e)=>{
    e.preventDefault()
    const res = await api.registerMerchant(form)
    setMsg(JSON.stringify(res))
  }

  return (
    <div className="container">
      <h2>Register Merchant</h2>
      <form onSubmit={submit}>
        <input placeholder="Your name" value={form.name} onChange={e=>setForm({...form,name:e.target.value})} />
        <input placeholder="Email" value={form.email} onChange={e=>setForm({...form,email:e.target.value})} />
        <input placeholder="Password" type="password" value={form.password} onChange={e=>setForm({...form,password:e.target.value})} />
        <input placeholder="Merchant name" value={form.merchant_name} onChange={e=>setForm({...form,merchant_name:e.target.value})} />
        <button type="submit">Register</button>
      </form>
      {msg && <pre>{msg}</pre>}
    </div>
  )
}
