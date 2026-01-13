import React, { useState } from 'react'
import api from '../api'

interface ServiceForm { title: string; duration_min: number; price_cents: number }
interface MerchantDashboardProps { user?: { name?: string }; token?: string }

export default function MerchantDashboard({user, token}: MerchantDashboardProps){
  const [service, setService] = useState<ServiceForm>({title:'', duration_min:30, price_cents:0})
  const [msg, setMsg] = useState<string | null>(null)

  const submit = async (e: React.FormEvent) =>{
    e.preventDefault()
    const res = await api.createService(service, token)
    setMsg(JSON.stringify(res))
  }

  return (
    <div className="container">
      <h2>Merchant Dashboard</h2>
      <p>Welcome {user?.name}</p>
      <form onSubmit={submit}>
        <input placeholder="Service title" value={service.title} onChange={e=>setService({...service,title:e.currentTarget.value})} />
        <input placeholder="Duration (min)" value={service.duration_min} onChange={e=>setService({...service,duration_min:parseInt(e.currentTarget.value || '0')})} />
        <input placeholder="Price cents" value={service.price_cents} onChange={e=>setService({...service,price_cents:parseInt(e.currentTarget.value || '0')})} />
        <button type="submit">Create Service</button>
      </form>
      {msg && <pre>{msg}</pre>}
    </div>
  )
}
