type _IM = { env: { VITE_API_URL?: string } }
const API_BASE: string = ((import.meta as unknown) as _IM).env.VITE_API_URL || '/api/v1';

async function postJson<T = unknown>(path: string, body: unknown, token?: string): Promise<T> {
  const res = await fetch(`${API_BASE}${path}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
    },
    body: JSON.stringify(body),
  });
  return res.json() as Promise<T>;
}

export async function registerMerchant(payload: unknown) {
  return postJson('/merchant/register', payload);
}

export async function login(payload: unknown) {
  return postJson('/merchant/login', payload);
}

export async function fetchMerchants() {
  const res = await fetch(`${API_BASE}/merchants`);
  return res.json();
}

export async function createMerchant(payload: unknown, token?: string) {
  return postJson('/merchants', payload, token);
}

export async function createService(payload: unknown, token?: string) {
  return postJson('/services', payload, token);
}

export async function createBooking(payload: unknown, token?: string) {
  return postJson('/bookings', payload, token);
}

export async function createCheckout(payload: unknown, token?: string) {
  return postJson('/payments/checkout', payload, token);
}

export default { registerMerchant, login, fetchMerchants, createMerchant, createService, createBooking, createCheckout };
