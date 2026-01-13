import React, { useState } from 'react'
import api from '../api'

export default function MerchantDashboard({user, token}){
  const [service, setService] = useState({title:'', duration_min:30, price_cents:0})
  const [msg, setMsg] = useState(null)

  const submit = async e=>{
    e.preventDefault()
    const res = await api.createService(service, token)
    setMsg(JSON.stringify(res))
  }

  return (
    <div className="container">
      <h2>Merchant Dashboard</h2>
      <p>Welcome {user?.name}</p>
      <form onSubmit={submit}>
        <input placeholder="Service title" value={service.title} onChange={e=>setService({...service,title:e.target.value})} />
        <input placeholder="Duration (min)" value={service.duration_min} onChange={e=>setService({...service,duration_min:e.target.value})} />
        <input placeholder="Price cents" value={service.price_cents} onChange={e=>setService({...service,price_cents:e.target.value})} />
        <button type="submit">Create Service</button>
      </form>
      {msg && <pre>{msg}</pre>}
    </div>
  )
}
