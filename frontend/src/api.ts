const API_BASE: string = import.meta.env.VITE_API_URL || 'http://localhost:8000/api/v1';

async function postJson<T = any>(path: string, body: any, token?: string): Promise<T> {
  const res = await fetch(`${API_BASE}${path}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
    },
    body: JSON.stringify(body),
  });
  return res.json();
}

export async function registerMerchant(payload: any) {
  return postJson('/merchant/register', payload);
}

export async function login(payload: any) {
  return postJson('/merchant/login', payload);
}

export async function fetchMerchants() {
  const res = await fetch(`${API_BASE}/merchants`);
  return res.json();
}

export async function createMerchant(payload: any, token?: string) {
  return postJson('/merchants', payload, token);
}

export async function createService(payload: any, token?: string) {
  return postJson('/services', payload, token);
}

export async function createBooking(payload: any, token?: string) {
  return postJson('/bookings', payload, token);
}

export async function createCheckout(payload: any, token?: string) {
  return postJson('/payments/checkout', payload, token);
}

export default { registerMerchant, login, fetchMerchants, createMerchant, createService, createBooking, createCheckout };
